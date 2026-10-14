<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

/**
 * MLG Finedge - One-Click Git Webhook & Browser Deployment Script
 *
 * Usage in Browser:
 *   https://yourdomain.com/deploy.php?key=mlg_deploy_secret_2026
 *
 * Usage as GitHub Webhook:
 *   Payload URL: https://yourdomain.com/deploy.php
 *   Secret: mlg_deploy_secret_2026
 */

// Deployment Secret Key (Change this or set DEPLOY_KEY in your .env file)
$secretKey = getenv('DEPLOY_KEY') ?: 'mlg_deploy_secret_2026';

// Detect if triggered via GitHub Webhook or Browser
$isWebhook = false;
$headers = function_exists('getallheaders') ? getallheaders() : [];

// Verify Authentication
$providedKey = $_GET['key'] ?? $_POST['key'] ?? '';

// Check GitHub Signature if sent via Webhook
if (isset($headers['X-Hub-Signature-256'])) {
    $isWebhook = true;
    $payload = file_get_contents('php://input');
    $hash = 'sha256=' . hash_hmac('sha256', $payload, $secretKey, false);
    if (!hash_equals($hash, $headers['X-Hub-Signature-256'])) {
        http_response_code(403);
        die("Invalid GitHub Webhook Signature.");
    }
} elseif (!empty($secretKey) && $providedKey !== $secretKey) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MLG Finedge - Deploy Authentication</title>
        <style>
            body { background: #070c0d; color: #fff; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
            .auth-card { background: #0e1718; border: 1px solid #1a2c2e; padding: 2.5rem; border-radius: 12px; width: 100%; max-width: 420px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); text-align: center; }
            h2 { color: #5ccbb3; margin-top: 0; font-size: 1.5rem; }
            p { color: #8a999a; font-size: 0.9rem; margin-bottom: 1.5rem; line-height: 1.5; }
            input[type="password"] { width: 100%; box-sizing: border-box; background: #070c0d; border: 1px solid #1a2c2e; padding: 0.8rem; border-radius: 6px; color: #fff; font-size: 1rem; margin-bottom: 1.25rem; outline: none; }
            input[type="password"]:focus { border-color: #5ccbb3; }
            button { width: 100%; background: #5ccbb3; color: #070c0d; font-weight: 700; border: none; padding: 0.85rem; border-radius: 6px; cursor: pointer; font-size: 1rem; transition: opacity 0.2s; }
            button:hover { opacity: 0.9; }
            .err { color: #ef4444; font-size: 0.85rem; margin-bottom: 1rem; }
        </style>
    </head>
    <body>
        <div class="auth-card">
            <h2>🚀 MLG Finedge Deployer</h2>
            <p>Enter your secret deployment key to pull the latest git code and run database migrations.</p>
            <?php if (!empty($providedKey)): ?>
                <div class="err">Invalid deployment key. Please try again.</div>
            <?php endif; ?>
            <form method="GET">
                <input type="password" name="key" placeholder="Enter Secret Deployment Key" required autofocus>
                <button type="submit">Unlock & Deploy Live</button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Disable time limits for large deployments
@set_time_limit(600);
@ini_set('memory_limit', '512M');

// Navigate to project root (one level above public)
$projectRoot = dirname(__DIR__);
chdir($projectRoot);

// Ensure HOME and COMPOSER_HOME are set for web server environments
@putenv('HOME=' . $projectRoot);
@putenv('COMPOSER_HOME=' . $projectRoot . '/storage/framework/composer');
if (!is_dir($projectRoot . '/storage/framework/composer')) {
    @mkdir($projectRoot . '/storage/framework/composer', 0755, true);
}

// Detect PHP 8.4+ CLI binary (especially for Hostinger CloudLinux / cPanel environments)
$phpCli = 'php';
$testBinaries = [
    '/opt/alt/php84/usr/bin/php',
    '/usr/bin/php8.4',
    '/usr/bin/php84',
    '/usr/local/bin/ea-php84',
    '/usr/local/bin/php84',
    'php8.4',
    'php84',
    'php',
];
foreach ($testBinaries as $bin) {
    $ver = @shell_exec($bin . ' -r "echo PHP_VERSION;" 2>/dev/null');
    if ($ver && version_compare(trim($ver), '8.3.0', '>=')) {
        $phpCli = $bin;
        break;
    }
}

// Execution helper
function runCommand($cmd, $desc) {
    echo "<div class='step-title'>➤ {$desc}</div>";
    echo "<div class='cmd-text'>$ {$cmd}</div>";
    
    $output = [];
    $returnVar = 0;
    exec($cmd . ' 2>&1', $output, $returnVar);
    
    echo "<pre class='terminal-box " . ($returnVar === 0 ? "success" : "warning") . "'>";
    echo htmlspecialchars(implode("\n", $output));
    echo "</pre>";
    
    flush();
    @ob_flush();
    
    return $returnVar === 0;
}

if (!$isWebhook):
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MLG Finedge - Live Deployment Output</title>
    <style>
        body { background: #070c0d; color: #e2e8f0; font-family: "SF Mono", Monaco, Menlo, Consolas, monospace; margin: 0; padding: 2rem; line-height: 1.5; }
        .container { max-width: 900px; margin: 0 auto; background: #0e1718; border: 1px solid #1a2c2e; border-radius: 12px; padding: 2rem; box-shadow: 0 10px 40px rgba(0,0,0,0.6); }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #1a2c2e; padding-bottom: 1.5rem; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 10px; }
        .brand { font-size: 1.4rem; font-weight: 700; color: #5ccbb3; }
        .status-badge { background: rgba(92, 203, 179, 0.15); color: #5ccbb3; border: 1px solid rgba(92, 203, 179, 0.3); padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; }
        .step-title { color: #5ccbb3; font-weight: 700; margin-top: 1.5rem; font-size: 0.95rem; }
        .cmd-text { color: #8a999a; font-size: 0.82rem; margin-bottom: 0.3rem; }
        .terminal-box { background: #050809; border: 1px solid #142022; padding: 1rem; border-radius: 6px; font-size: 0.82rem; overflow-x: auto; color: #94a3b8; white-space: pre-wrap; word-break: break-all; margin: 0; }
        .terminal-box.success { border-left: 3px solid #5ccbb3; }
        .terminal-box.warning { border-left: 3px solid #e85c24; color: #fed7aa; }
        .summary-card { margin-top: 2rem; background: rgba(92, 203, 179, 0.08); border: 1px solid rgba(92, 203, 179, 0.2); padding: 1.5rem; border-radius: 8px; text-align: center; }
        .btn-visit { display: inline-block; background: #5ccbb3; color: #070c0d; font-weight: 700; padding: 0.75rem 2rem; border-radius: 6px; text-decoration: none; margin-top: 1rem; }
        .btn-visit:hover { opacity: 0.9; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="brand">🚀 MLG Finedge Deployment Console</div>
            <div class="status-badge">PHP CLI: <?= htmlspecialchars($phpCli) ?></div>
        </div>
<?php
endif;

$startTime = microtime(true);

// 1. Pull Latest Code from Git
runCommand('git fetch origin main && git reset --hard origin/main', '1. Pulling Latest Code from Git (origin/main)');

// 2. Install / Update Composer Dependencies
if (file_exists($projectRoot . '/composer.lock')) {
    runCommand('composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --ignore-platform-reqs', '2. Optimizing Composer Dependencies');
}

// 3. Run Database Migrations
runCommand("{$phpCli} artisan migrate --force", '3. Running Database Migrations (Page SEO, Services, Blogs)');

// 4. Clear and Rebuild Optimized Caches
runCommand("{$phpCli} artisan optimize:clear", '4. Clearing Compiled Views, Routes & Config Caches');
runCommand("{$phpCli} artisan config:cache && {$phpCli} artisan route:cache && {$phpCli} artisan view:cache", '5. Recompiling High-Performance Application Caches');

// 5. Ensure Storage Symlink
runCommand("{$phpCli} artisan storage:link", '6. Verifying Storage Symlink');

$duration = round(microtime(true) - $startTime, 2);

if (!$isWebhook):
?>
        <div class="summary-card">
            <h3 style="color: #5ccbb3; margin: 0 0 0.5rem 0;">🎉 Deployment Completed Successfully!</h3>
            <p style="margin: 0; color: #94a3b8; font-size: 0.9rem;">
                All latest changes, database migrations, and cached assets are live on your server in <strong><?= $duration ?>s</strong>.
            </p>
            <div style="display: flex; justify-content: center; gap: 15px; margin-top: 1.25rem;">
                <a href="/" target="_blank" class="btn-visit">Open Live Website</a>
                <a href="/admin" target="_blank" class="btn-visit" style="background: #e85c24; color: #fff;">Open Admin Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php
else:
    echo json_encode([
        'status' => 'success',
        'message' => 'Deployment executed successfully via webhook',
        'duration_seconds' => $duration,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
endif;
