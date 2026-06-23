# MLG Finedge Local Web Server
# Run this script using PowerShell to serve the website locally.

$listener = New-Object System.Net.HttpListener
$listener.Prefixes.Add("http://localhost:8000/")
$listener.Start()
Write-Host "Local web server started at http://localhost:8000/"
Write-Host "Press Ctrl+C in terminal to stop the server."

while ($listener.IsListening) {
    try {
        $context = $listener.GetContext()
        $request = $context.Request
        $response = $context.Response

        $rawUrl = $request.RawUrl
        if ($rawUrl.Contains("?")) {
            $rawUrl = $rawUrl.SubString(0, $rawUrl.IndexOf("?"))
        }

        # Default document
        if ($rawUrl -eq "/" -or $rawUrl -eq "") {
            $urlPath = "/index.html"
        } else {
            $urlPath = $rawUrl
        }

        # Map to physical file
        $filePath = Join-Path (Get-Location) $urlPath.Replace("/", "\")
        
        # If it matches a directory, look for index.html inside
        if (Test-Path $filePath -PathType Container) {
            $filePath = Join-Path $filePath "index.html"
        }

        if (Test-Path $filePath -PathType Leaf) {
            $ext = [System.IO.Path]::GetExtension($filePath).ToLower()
            $contentType = switch ($ext) {
                ".html" { "text/html; charset=utf-8" }
                ".css"  { "text/css; charset=utf-8" }
                ".js"   { "application/javascript; charset=utf-8" }
                ".png"  { "image/png" }
                ".jpg"  { "image/jpeg" }
                ".jpeg" { "image/jpeg" }
                ".svg"  { "image/svg+xml" }
                default { "application/octet-stream" }
            }

            $bytes = [System.IO.File]::ReadAllBytes($filePath)
            $response.ContentType = $contentType
            $response.ContentLength64 = $bytes.Length
            $response.OutputStream.Write($bytes, 0, $bytes.Length)
        } else {
            $response.StatusCode = 404
            $errBytes = [System.Text.Encoding]::UTF8.GetBytes("404 Not Found: $rawUrl")
            $response.ContentType = "text/plain"
            $response.ContentLength64 = $errBytes.Length
            $response.OutputStream.Write($errBytes, 0, $errBytes.Length)
        }
    } catch {
        # Silent ignore or log
    } finally {
        if ($response) {
            $response.Close()
        }
    }
}
