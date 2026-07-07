<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Admin Dashboard | MLG Finedge</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Outfit Font -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --admin-sidebar-w: 260px;
            --admin-dark-bg: #111b1c;
            --admin-dark-sidebar: #0a1112;
            --admin-border: rgba(255,255,255,0.08);
            --admin-text-muted: rgba(255,255,255,0.5);
            --admin-input-bg: rgba(255,255,255,0.04);
        }
        
        body {
            background-color: var(--admin-dark-bg);
            color: #ffffff;
            font-family: 'Outfit', sans-serif;
            margin: 0;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--admin-sidebar-w);
            background-color: var(--admin-dark-sidebar);
            border-right: 1px solid var(--admin-border);
            display: flex;
            flex-direction: column;
            padding: 1.5rem 0;
            flex-shrink: 0;
        }

        .sidebar-brand {
            padding: 0 1.5rem;
            margin-bottom: 2.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-brand svg {
            width: 36px;
            height: 36px;
        }

        .sidebar-brand span {
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: 0.5px;
            color: #ffffff;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }

        .menu-item button {
            width: 100%;
            background: none;
            border: none;
            color: var(--admin-text-muted);
            padding: 1rem 1.5rem;
            text-align: left;
            font-family: 'Outfit', sans-serif;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .menu-item button:hover, .menu-item button.active {
            color: var(--mint-green);
            background-color: rgba(92, 203, 179, 0.05);
            border-left-color: var(--mint-green);
        }

        .sidebar-footer {
            padding: 0 1.5rem;
        }

        .btn-logout {
            width: 100%;
            background-color: rgba(232, 92, 36, 0.1);
            color: #ff6b6b;
            border: 1px solid rgba(255, 107, 107, 0.2);
            padding: 0.75rem;
            border-radius: var(--radius-md);
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-family: 'Outfit', sans-serif;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background-color: rgba(255, 107, 107, 0.2);
        }

        /* Main Content Panel */
        .main-panel {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .admin-header {
            height: 70px;
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            flex-shrink: 0;
        }

        .admin-header h1 {
            font-size: 1.5rem;
            margin: 0;
            font-weight: 600;
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
        }

        .admin-user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: var(--primary-teal);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .admin-content {
            padding: 2rem;
            overflow-y: auto;
            flex-grow: 1;
        }

        /* Tab Content Panel */
        .tab-panel {
            display: none;
        }

        .tab-panel.active {
            display: block;
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Cards & Forms */
        .admin-card {
            background: rgba(255,255,255,0.02);
            border: 1px solid var(--admin-border);
            border-radius: var(--radius-lg);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .admin-card h2 {
            font-size: 1.25rem;
            margin-top: 0;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid var(--admin-border);
            padding-bottom: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
            color: rgba(255,255,255,0.7);
            font-weight: 500;
        }

        .form-control {
            background-color: var(--admin-input-bg);
            border: 1px solid var(--admin-border);
            color: #ffffff;
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: var(--radius-md);
            font-family: 'Outfit', sans-serif;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--mint-green);
            background-color: rgba(255,255,255,0.06);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .btn-submit {
            background-color: var(--mint-green);
            color: var(--primary-teal-dark);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: var(--radius-md);
            font-weight: 600;
            cursor: pointer;
            font-family: 'Outfit', sans-serif;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #4ebfa7;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(92, 203, 179, 0.3);
        }

        /* Tables & Action Styles */
        .admin-table-wrap {
            overflow-x: auto;
            border-radius: var(--radius-md);
            border: 1px solid var(--admin-border);
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.9rem;
        }

        .admin-table th {
            background-color: rgba(255,255,255,0.03);
            padding: 1rem;
            border-bottom: 1px solid var(--admin-border);
            font-weight: 600;
            color: var(--mint-green);
        }

        .admin-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--admin-border);
            vertical-align: middle;
        }

        .admin-table tr:last-child td {
            border-bottom: none;
        }

        .action-btns {
            display: flex;
            gap: 10px;
        }

        .btn-action {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .btn-action.edit {
            color: #5ccbb3;
            background-color: rgba(92, 203, 179, 0.1);
        }

        .btn-action.edit:hover {
            background-color: rgba(92, 203, 179, 0.25);
        }

        .btn-action.delete {
            color: #ff6b6b;
            background-color: rgba(255, 107, 107, 0.1);
        }

        .btn-action.delete:hover {
            background-color: rgba(255, 107, 107, 0.25);
        }

        /* Success Banner */
        .alert-success {
            background-color: rgba(92, 203, 179, 0.1);
            border: 1px solid rgba(92, 203, 179, 0.3);
            color: var(--mint-green);
            padding: 1rem 1.5rem;
            border-radius: var(--radius-md);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Image upload helpers */
        .image-preview-container {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 5px;
        }

        .image-preview {
            width: 60px;
            height: 60px;
            border-radius: 6px;
            border: 1px solid var(--admin-border);
            background-color: rgba(255,255,255,0.02);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .badge-webp {
            font-size: 0.75rem;
            background-color: var(--primary-teal);
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 600;
        }
        .badge {
            font-size: 0.8rem;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 600;
            display: inline-block;
        }

        /* Force all headings and instructions in backend to be white/visible */
        h1, h2, h3, h4, h5, h6,
        .admin-header h1, .sidebar-brand span, 
        .admin-card h2, .admin-card h3, .admin-card h4,
        .admin-content h1, .admin-content h2, .admin-content h3, .admin-content h4, .admin-content h5, .admin-content h6,
        #service-form-title-text, #blog-form-title-text {
            color: #ffffff !important;
        }
        
        .admin-content p:not(.ck-editor *):not(.badge):not(.badge *), 
        .admin-content span:not(.ck-editor *):not(.badge):not(.badge *), 
        .admin-content label:not(.ck-editor *):not(.badge):not(.badge *), 
        .admin-content li:not(.ck-editor *):not(.badge):not(.badge *), 
        .admin-content small:not(.ck-editor *):not(.badge):not(.badge *), 
        .admin-content legend:not(.ck-editor *):not(.badge):not(.badge *),
        .admin-card p:not(.ck-editor *):not(.badge):not(.badge *), 
        .admin-card span:not(.ck-editor *):not(.badge):not(.badge *), 
        .admin-card label:not(.ck-editor *):not(.badge):not(.badge *), 
        .admin-card li:not(.ck-editor *):not(.badge):not(.badge *), 
        .admin-card small:not(.ck-editor *):not(.badge):not(.badge *),
        .admin-table td:not(.badge):not(.badge *), 
        .admin-table th,
        .admin-table strong:not(.badge):not(.badge *) {
            color: rgba(255, 255, 255, 0.85) !important;
        }

        .admin-content code, .admin-card code {
            color: #5ccbb3 !important;
            background-color: rgba(92, 203, 179, 0.1) !important;
            padding: 2px 6px !important;
            border-radius: 4px !important;
        }

        .admin-table td, .admin-table th {
            color: #ffffff !important;
        }

        .admin-table th {
            color: var(--mint-green) !important;
        }

        .admin-table small, .admin-table td small {
            color: rgba(255, 255, 255, 0.6) !important;
        }

        .admin-card a {
            color: var(--mint-green) !important;
        }
        .admin-card a:hover {
            color: #4ebfa7 !important;
        }

        /* Toast Notification Styles */
        .ai-toast {
            background-color: #0d1718;
            border: 1px solid rgba(168, 85, 247, 0.3);
            box-shadow: 0 4px 20px rgba(168, 85, 247, 0.2);
            border-radius: var(--radius-md);
            color: #ffffff;
            padding: 1rem;
            width: 320px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            animation: toastSlideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        @keyframes toastSlideIn {
            from { transform: translateX(120%) translateY(20px); opacity: 0; }
            to { transform: translateX(0) translateY(0); opacity: 1; }
        }
        .ai-toast-close {
            position: absolute;
            top: 8px;
            right: 8px;
            background: none;
            border: none;
            color: var(--admin-text-muted);
            cursor: pointer;
            font-size: 1.1rem;
            line-height: 1;
        }
        .ai-toast-close:hover {
            color: #ff6b6b;
        }
        .ai-toast-spinner {
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-top-color: #a855f7;
            border-bottom-color: #6366f1;
            border-radius: 50%;
            animation: aiSpin 1s linear infinite;
            flex-shrink: 0;
            margin-top: 3px;
        }
        .ai-toast-success-icon {
            color: var(--mint-green);
            flex-shrink: 0;
            margin-top: 3px;
            display: flex;
            align-items: center;
        }
        .ai-toast-error-icon {
            color: #ff6b6b;
            flex-shrink: 0;
            margin-top: 3px;
            display: flex;
            align-items: center;
        }
        .ai-toast-content {
            flex-grow: 1;
            padding-right: 15px;
        }
        .ai-toast-title {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 2px;
            color: #ffffff !important;
        }
        .ai-toast-message {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.7) !important;
            margin: 0;
            line-height: 1.4;
        }

        /* Keep CKEditor text dark so users can see what they type in the editor box! */
        .ck-editor__editable, .ck-editor__editable * {
            color: #111111 !important;
        }

        /* AI Generator styles */
        .btn-ai-sparkle {
            background: linear-gradient(135deg, #a855f7, #6366f1) !important;
            color: #ffffff !important;
            border: none !important;
            padding: 0.5rem 1rem !important;
            border-radius: var(--radius-md) !important;
            font-weight: 600 !important;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(168, 85, 247, 0.2);
        }
        .btn-ai-sparkle:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(168, 85, 247, 0.4);
            filter: brightness(1.1);
        }
        .ai-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(8px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 99999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .ai-modal-overlay.show {
            display: flex;
            opacity: 1;
        }
        .ai-modal-card {
            background-color: #0d1718;
            border: 1px solid rgba(168, 85, 247, 0.3);
            box-shadow: 0 10px 30px rgba(168, 85, 247, 0.15), 0 0 40px rgba(99, 102, 241, 0.05);
            border-radius: var(--radius-lg);
            width: 90%;
            max-width: 550px;
            padding: 2rem;
            animation: aiSlideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }
        @keyframes aiSlideIn {
            from { transform: translateY(-30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .ai-modal-card h3 {
            margin-top: 0;
            font-size: 1.35rem;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1px solid var(--admin-border);
            padding-bottom: 0.75rem;
            margin-bottom: 1.5rem;
        }
        .ai-modal-card h3 i {
            color: #a855f7;
        }
        .ai-modal-close {
            position: absolute;
            right: 1.5rem;
            top: 1.5rem;
            background: none;
            border: none;
            color: var(--admin-text-muted);
            font-size: 1.5rem;
            cursor: pointer;
            transition: color 0.2s;
        }
        .ai-modal-close:hover {
            color: #ff6b6b;
        }
        .ai-loader-container {
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1rem;
            text-align: center;
        }
        .ai-sparkle-loader {
            width: 60px;
            height: 60px;
            position: relative;
            margin-bottom: 1.5rem;
        }
        .ai-sparkle-loader::before, .ai-sparkle-loader::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #a855f7;
            border-bottom-color: #6366f1;
            animation: aiSpin 1.5s linear infinite;
        }
        .ai-sparkle-loader::after {
            width: 40px;
            height: 40px;
            top: 10px;
            left: 10px;
            border-top-color: #5ccbb3;
            border-bottom-color: #e85c24;
            animation: aiSpinReverse 1s linear infinite;
        }
        @keyframes aiSpin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @keyframes aiSpinReverse {
            0% { transform: rotate(360deg); }
            100% { transform: rotate(0deg); }
        }
        .ai-loader-text {
            font-size: 1.05rem;
            font-weight: 500;
            color: #ffffff;
            margin: 0;
        }
        .ai-loader-subtext {
            font-size: 0.85rem;
            color: var(--admin-text-muted);
            margin: 5px 0 0 0;
        }
        .ai-img-preview-box {
            margin-top: 1rem;
            border: 1px solid var(--admin-border);
            border-radius: var(--radius-md);
            overflow: hidden;
            display: none;
            flex-direction: column;
            background: rgba(0,0,0,0.2);
        }
        .ai-img-preview-box img {
            width: 100%;
            max-height: 300px;
            object-fit: contain;
            background: #000;
        }
        .ai-img-preview-box .info {
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid var(--admin-border);
        }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="25" y="45" width="12" height="30" rx="3" fill="#ffffff" />
                <rect x="44" y="30" width="12" height="45" rx="3" fill="#ffffff" />
                <rect x="63" y="15" width="12" height="60" rx="3" fill="#5ccbb3" />
                <path d="M15 80 L35 60 L50 70 L85 35" stroke="#e85c24" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M72 35 H85 V48" stroke="#e85c24" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <span>MLG FINEDGE</span>
        </div>
        
        <ul class="sidebar-menu">
            <li class="menu-item"><button onclick="switchTab('general')" class="tab-btn" id="btn-general"><i data-lucide="settings"></i> General Settings</button></li>
            <li class="menu-item"><button onclick="switchTab('leads')" class="tab-btn active" id="btn-leads"><i data-lucide="inbox"></i> Leads Manager</button></li>
            <li class="menu-item"><button onclick="switchTab('branding')" class="tab-btn" id="btn-branding"><i data-lucide="image"></i> Branding & Logos</button></li>
            <li class="menu-item"><button onclick="switchTab('slider')" class="tab-btn" id="btn-slider"><i data-lucide="sliders"></i> Homepage Slider</button></li>
            <li class="menu-item"><button onclick="switchTab('testimonials')" class="tab-btn" id="btn-testimonials"><i data-lucide="users"></i> Testimonials</button></li>
            <li class="menu-item"><button onclick="switchTab('styling')" class="tab-btn" id="btn-styling"><i data-lucide="palette"></i> Section Backgrounds</button></li>
            <li class="menu-item"><button onclick="switchTab('pagecontents')" class="tab-btn" id="btn-pagecontents"><i data-lucide="file-text"></i> Page Editor</button></li>
            <li class="menu-item"><button onclick="switchTab('services')" class="tab-btn" id="btn-services"><i data-lucide="layers"></i> Services Manager</button></li>
            <li class="menu-item"><button onclick="switchTab('banks')" class="tab-btn" id="btn-banks"><i data-lucide="landmark"></i> Bank Comparison</button></li>
            <li class="menu-item"><button onclick="switchTab('blogs')" class="tab-btn" id="btn-blogs"><i data-lucide="book-open"></i> Blog Manager</button></li>
            <li class="menu-item"><button onclick="switchTab('media')" class="tab-btn" id="btn-media"><i data-lucide="hard-drive"></i> Media Manager</button></li>
            <li class="menu-item"><button onclick="switchTab('analytics')" class="tab-btn" id="btn-analytics"><i data-lucide="bar-chart-2"></i> Web Analytics</button></li>
        </ul>
        
        <div class="sidebar-footer">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout" onclick="localStorage.removeItem('active_tab')">
                    <i data-lucide="log-out"></i> Log Out
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content Panel -->
    <div class="main-panel">
        <div class="admin-header">
            <h1>CMS Control Panel</h1>
            <div style="display: flex; gap: 1.5rem; align-items: center;">
                <form action="{{ route('admin.sync-database') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-submit" style="background-color: var(--accent-orange) !important; font-size: 0.85rem; padding: 0.5rem 1rem; border-radius: 4px; display: flex; align-items: center; gap: 6px; border: none; color: #ffffff; cursor: pointer; margin: 0; line-height: 1; height: auto; width: auto;">
                        <i data-lucide="refresh-cw" style="width: 14px; height: 14px;"></i> Sync Content from DB
                    </button>
                </form>
                <div class="admin-user">
                    <span>{{ Auth::user()->name }}</span>
                    <div class="admin-user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                </div>
            </div>
        </div>

        <div class="admin-content">
            <!-- Success Banner -->
            @if(session('success'))
                <div class="alert-success">
                    <i data-lucide="check-circle-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="alert-success" style="background-color: rgba(255,107,107,0.1); border-color: rgba(255,107,107,0.3); color: #ff6b6b;">
                    <i data-lucide="alert-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- 1. GENERAL & CONTACT SETTINGS TAB -->
            <div class="tab-panel" id="tab-general">
                <form action="{{ route('admin.parameters.update') }}" method="POST">
                    @csrf
                    
                    <div class="admin-card">
                        <h2>Contact Information</h2>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="text" id="phone" name="phone" class="form-control" value="{{ $site['phone'] ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ $site['email'] ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label for="whatsapp_number">WhatsApp Number (with country code, no +)</label>
                                <input type="text" id="whatsapp_number" name="whatsapp_number" class="form-control" value="{{ $site['whatsapp_number'] ?? '' }}" required>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 1.25rem;">
                            <label for="address">Physical Address</label>
                            <input type="text" id="address" name="address" class="form-control" value="{{ $site['address'] ?? '' }}" required>
                        </div>
                    </div>

                    <div class="admin-card">
                        <h2>Active Starting Interest Rates</h2>
                        <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.5rem; margin-top: -1rem;">These rates automatically populate the homepage cards and the comparison parameters.</p>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="home_loan_rate">Home Loan Rate</label>
                                <input type="text" id="home_loan_rate" name="home_loan_rate" class="form-control" value="{{ $site['home_loan_rate'] ?? '' }}" placeholder="8.4%">
                            </div>
                            <div class="form-group">
                                <label for="personal_loan_rate">Personal Loan Rate</label>
                                <input type="text" id="personal_loan_rate" name="personal_loan_rate" class="form-control" value="{{ $site['personal_loan_rate'] ?? '' }}" placeholder="10.5%">
                            </div>
                            <div class="form-group">
                                <label for="business_loan_rate">Business Loan Rate</label>
                                <input type="text" id="business_loan_rate" name="business_loan_rate" class="form-control" value="{{ $site['business_loan_rate'] ?? '' }}" placeholder="12.0%">
                            </div>
                            <div class="form-group">
                                <label for="car_loan_rate">Car Loan Rate</label>
                                <input type="text" id="car_loan_rate" name="car_loan_rate" class="form-control" value="{{ $site['car_loan_rate'] ?? '' }}" placeholder="8.7%">
                            </div>
                            <div class="form-group">
                                <label for="lap_rate">Loan Against Property (LAP) Rate</label>
                                <input type="text" id="lap_rate" name="lap_rate" class="form-control" value="{{ $site['lap_rate'] ?? '' }}" placeholder="9.0%">
                            </div>
                        </div>
                    </div>
                    <div class="admin-card">
                        <h2>SEO & Tracking Codes</h2>
                        <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.5rem; margin-top: -1rem;">Configure global tracking and verification tags.</p>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="google_tag_id">Google Tag ID / GTM ID / GA4 Measurement ID</label>
                                <input type="text" id="google_tag_id" name="google_tag_id" class="form-control" value="{{ $site['google_tag_id'] ?? '' }}" placeholder="e.g., G-XXXXXXXXXX or GTM-XXXXXXX">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 1.25rem;">
                            <label for="header_scripts">Custom Tracking Scripts (inserted before &lt;/head&gt;)</label>
                            <textarea id="header_scripts" name="header_scripts" class="form-control" rows="4" placeholder="<!-- Paste Facebook Pixel, custom GTM script tags, etc. -->">{{ $site['header_scripts'] ?? '' }}</textarea>
                        </div>
                    </div>

                    <div class="admin-card">
                        <h2>Google reCAPTCHA v2 Settings</h2>
                        <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.5rem; margin-top: -1rem;">
                            Protects all contact and inquiry forms on the website from automated spam. 
                            <a href="https://www.google.com/recaptcha/admin" target="_blank" style="color: var(--accent-orange); text-decoration: underline; font-weight: 500;">
                                Learn how to generate Google reCAPTCHA v2 checkbox keys &rarr;
                            </a>
                        </p>
                        
                        <div class="form-grid">
                            <div class="form-group" style="grid-column: span 2;">
                                <label for="recaptcha_enabled" style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                    <input type="checkbox" id="recaptcha_enabled" name="recaptcha_enabled" value="1" @checked(($site['recaptcha_enabled'] ?? '0') == '1') style="width: 18px; height: 18px; cursor: pointer;">
                                    <strong>Enable Google reCAPTCHA Checkbox on Forms</strong>
                                </label>
                            </div>
                            
                            <div class="form-group">
                                <label for="recaptcha_site_key">reCAPTCHA Site Key</label>
                                <input type="text" id="recaptcha_site_key" name="recaptcha_site_key" class="form-control" value="{{ $site['recaptcha_site_key'] ?? '' }}" placeholder="Paste Google Site Key (e.g. 6Ld...)">
                            </div>
                            
                            <div class="form-group">
                                <label for="recaptcha_secret_key">reCAPTCHA Secret Key</label>
                                <input type="text" id="recaptcha_secret_key" name="recaptcha_secret_key" class="form-control" value="{{ $site['recaptcha_secret_key'] ?? '' }}" placeholder="Paste Google Secret Key">
                            </div>
                        </div>
                    </div>

                    <div class="admin-card">
                        <h2>Google Gemini AI Settings</h2>
                        <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.5rem; margin-top: -1rem;">
                            Provide a Google Gemini API Key from Google AI Studio. This key is used to generate blog articles, pictures, and new service pages using prompts.
                        </p>
                        <div class="form-grid">
                            <div class="form-group" style="grid-column: span 2;">
                                <label for="gemini_api_key">Gemini API Key</label>
                                <input type="password" id="gemini_api_key" name="gemini_api_key" class="form-control" value="{{ $site['gemini_api_key'] ?? '' }}" placeholder="Paste your Gemini API Key here...">
                                <span style="font-size: 0.75rem; color: var(--admin-text-muted); display: block; margin-top: 5px;">
                                    Get an API Key from the <a href="https://aistudio.google.com/" target="_blank" style="color: var(--mint-green); text-decoration: underline;">Google AI Studio Console</a>.
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="admin-card">
                        <h2>Cloudflare Web Analytics Settings</h2>
                        <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.5rem; margin-top: -1rem;">
                            Enable Cloudflare Web Analytics to monitor pageviews, requests, and bandwidth inside this dashboard.
                        </p>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="cloudflare_analytics_token">Cloudflare Web Analytics Token</label>
                                <input type="text" id="cloudflare_analytics_token" name="cloudflare_analytics_token" class="form-control" value="{{ $site['cloudflare_analytics_token'] ?? '' }}" placeholder="e.g. 66a2e4fb8...">
                                <span style="font-size: 0.75rem; color: var(--admin-text-muted); display: block; margin-top: 5px;">
                                    Get the JS beacon token from the <a href="https://developers.cloudflare.com/analytics/web-analytics/" target="_blank" style="color: var(--mint-green); text-decoration: underline;">Cloudflare Web Analytics Guide</a>.
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="cloudflare_zone_id">Cloudflare Zone ID</label>
                                <input type="text" id="cloudflare_zone_id" name="cloudflare_zone_id" class="form-control" value="{{ $site['cloudflare_zone_id'] ?? '' }}" placeholder="e.g., d3b07384...">
                            </div>
                            <div class="form-group" style="grid-column: span 2;">
                                <label for="cloudflare_api_token">Cloudflare API Token (Analytics Read)</label>
                                <input type="password" id="cloudflare_api_token" name="cloudflare_api_token" class="form-control" value="{{ $site['cloudflare_api_token'] ?? '' }}" placeholder="Paste API Token here...">
                                <span style="font-size: 0.75rem; color: var(--admin-text-muted); display: block; margin-top: 5px;">
                                    Generate a token with <strong>Zone.Analytics Read</strong> permission from your <a href="https://dash.cloudflare.com/profile/api-tokens" target="_blank" style="color: var(--mint-green); text-decoration: underline;">Cloudflare API Tokens settings</a>.
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="admin-card">
                        <h2>Cloudflare R2 Object Storage</h2>
                        <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.5rem; margin-top: -1rem;">
                            Replace FTP with Cloudflare R2 S3-compatible storage. Use Cloudflare's 10 GB free tier for media files.
                        </p>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="cloudflare_r2_account_id">Cloudflare Account ID</label>
                                <input type="text" id="cloudflare_r2_account_id" name="cloudflare_r2_account_id" class="form-control" value="{{ $site['cloudflare_r2_account_id'] ?? '' }}" placeholder="Account ID from Cloudflare dashboard">
                            </div>
                            <div class="form-group">
                                <label for="cloudflare_r2_bucket_name">Cloudflare R2 Bucket Name</label>
                                <input type="text" id="cloudflare_r2_bucket_name" name="cloudflare_r2_bucket_name" class="form-control" value="{{ $site['cloudflare_r2_bucket_name'] ?? '' }}" placeholder="e.g., mlg-finedge-assets">
                            </div>
                            <div class="form-group">
                                <label for="cloudflare_r2_access_key_id">R2 Access Key ID</label>
                                <input type="text" id="cloudflare_r2_access_key_id" name="cloudflare_r2_access_key_id" class="form-control" value="{{ $site['cloudflare_r2_access_key_id'] ?? '' }}" placeholder="Access Key ID">
                            </div>
                            <div class="form-group">
                                <label for="cloudflare_r2_secret_access_key">R2 Secret Access Key</label>
                                <input type="password" id="cloudflare_r2_secret_access_key" name="cloudflare_r2_secret_access_key" class="form-control" value="{{ $site['cloudflare_r2_secret_access_key'] ?? '' }}" placeholder="Secret Access Key">
                            </div>
                            <div class="form-group" style="grid-column: span 2;">
                                <label for="cloudflare_r2_public_url">R2 Public Custom Domain URL</label>
                                <input type="text" id="cloudflare_r2_public_url" name="cloudflare_r2_public_url" class="form-control" value="{{ $site['cloudflare_r2_public_url'] ?? '' }}" placeholder="e.g., https://assets.mlgfinedge.com">
                                <span style="font-size: 0.75rem; color: var(--admin-text-muted); display: block; margin-top: 5px;">
                                    Create R2 credentials & connect a custom domain by following the <a href="https://developers.cloudflare.com/r2/" target="_blank" style="color: var(--mint-green); text-decoration: underline;">Cloudflare R2 Storage Guide</a>.
                                </span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Save Parameters</button>
                </form>
            </div>

            <!-- LEADS MANAGER TAB -->
            <div class="tab-panel active" id="tab-leads">
                <!-- Stats Overview Grid -->
                <div class="form-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); margin-bottom: 2rem;">
                    <div class="admin-card text-center" style="padding: 1.25rem; margin-bottom: 0;">
                        <h4 style="margin: 0; font-size: 0.85rem; color: var(--admin-text-muted); text-transform: uppercase;">Total Leads</h4>
                        <p style="font-size: 2.25rem; font-weight: 800; color: var(--primary-teal-dark); margin: 0.5rem 0 0 0;">{{ $leads->count() }}</p>
                    </div>
                    <div class="admin-card text-center" style="padding: 1.25rem; margin-bottom: 0; border-left: 4px solid #3b82f6;">
                        <h4 style="margin: 0; font-size: 0.85rem; color: var(--admin-text-muted); text-transform: uppercase;">New</h4>
                        <p style="font-size: 2.25rem; font-weight: 800; color: #3b82f6; margin: 0.5rem 0 0 0;">{{ $leads->where('status', 'New')->count() }}</p>
                    </div>
                    <div class="admin-card text-center" style="padding: 1.25rem; margin-bottom: 0; border-left: 4px solid #eab308;">
                        <h4 style="margin: 0; font-size: 0.85rem; color: var(--admin-text-muted); text-transform: uppercase;">Contacted</h4>
                        <p style="font-size: 2.25rem; font-weight: 800; color: #eab308; margin: 0.5rem 0 0 0;">{{ $leads->where('status', 'Contacted')->count() }}</p>
                    </div>
                    <div class="admin-card text-center" style="padding: 1.25rem; margin-bottom: 0; border-left: 4px solid #f97316;">
                        <h4 style="margin: 0; font-size: 0.85rem; color: var(--admin-text-muted); text-transform: uppercase;">In Progress</h4>
                        <p style="font-size: 2.25rem; font-weight: 800; color: #f97316; margin: 0.5rem 0 0 0;">{{ $leads->where('status', 'In Progress')->count() }}</p>
                    </div>
                    <div class="admin-card text-center" style="padding: 1.25rem; margin-bottom: 0; border-left: 4px solid #22c55e;">
                        <h4 style="margin: 0; font-size: 0.85rem; color: var(--admin-text-muted); text-transform: uppercase;">Closed</h4>
                        <p style="font-size: 2.25rem; font-weight: 800; color: #22c55e; margin: 0.5rem 0 0 0;">{{ $leads->where('status', 'Closed')->count() }}</p>
                    </div>
                </div>

                <!-- Leads Table Card -->
                <div class="admin-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h2>Lead Records</h2>
                        <span style="font-size: 0.85rem; color: var(--admin-text-muted);">Showing all lead submissions</span>
                    </div>

                    @if($leads->isEmpty())
                        <div style="text-align: center; padding: 3rem 1.5rem; color: var(--admin-text-muted);">
                            <i data-lucide="inbox" style="width: 48px; height: 48px; stroke-width: 1.5; margin-bottom: 1rem; color: #cbd5e1;"></i>
                            <p style="font-size: 1.1rem; margin-bottom: 0.25rem;">No leads found</p>
                            <p style="font-size: 0.85rem;">When clients submit a form on the website, they will appear here.</p>
                        </div>
                    @else
                        <div style="overflow-x: auto;">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Date & Time</th>
                                        <th>Client Information</th>
                                        <th>Source</th>
                                        <th>Status</th>
                                        <th style="text-align: right;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leads as $lead)
                                        <!-- Main Info Row -->
                                        <tr id="lead-row-{{ $lead->id }}">
                                            <td style="font-size: 0.85rem; color: var(--admin-text-muted); white-space: nowrap;">
                                                {{ $lead->created_at->format('d M Y, h:i A') }}<br>
                                                <small style="color: #94a3b8;">{{ $lead->created_at->diffForHumans() }}</small>
                                            </td>
                                            <td>
                                                <strong style="font-size: 1.05rem; color: var(--primary-teal-dark); display: block;">{{ $lead->name }}</strong>
                                                <div style="display: flex; gap: 10px; margin-top: 0.25rem; font-size: 0.85rem;">
                                                    <a href="tel:{{ $lead->phone }}" style="color: var(--accent-orange); display: flex; align-items: center; gap: 4px; font-weight: 500;">
                                                        <i data-lucide="phone" style="width: 12px; height: 12px;"></i> {{ $lead->phone }}
                                                    </a>
                                                    @if($lead->email)
                                                        <a href="mailto:{{ $lead->email }}" style="color: var(--admin-text-muted); display: flex; align-items: center; gap: 4px;">
                                                            <i data-lucide="mail" style="width: 12px; height: 12px;"></i> {{ $lead->email }}
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge" style="background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; font-size: 0.75rem;">
                                                    {{ $lead->source }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($lead->status === 'New')
                                                    <span class="badge" style="background-color: #dbeafe; color: #1e40af;">New</span>
                                                @elseif($lead->status === 'Contacted')
                                                    <span class="badge" style="background-color: #fef9c3; color: #854d0e;">Contacted</span>
                                                @elseif($lead->status === 'In Progress')
                                                    <span class="badge" style="background-color: #ffedd5; color: #9a3412;">In Progress</span>
                                                @elseif($lead->status === 'Closed')
                                                    <span class="badge" style="background-color: #dcfce7; color: #166534;">Closed</span>
                                                @endif
                                            </td>
                                            <td style="text-align: right; white-space: nowrap;">
                                                <button type="button" onclick="toggleLeadDetails({{ $lead->id }})" class="btn-action edit" title="View Details / Edit" style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 4px; font-weight: 500; font-size: 0.85rem; border: 1px solid var(--primary-teal); background-color: transparent; color: var(--primary-teal);">
                                                    <i data-lucide="edit-3" style="width: 14px; height: 14px;"></i> Details
                                                </button>
                                            </td>
                                        </tr>
                                        
                                        <!-- Inline Expandable Detail/Edit Form Row -->
                                        <tr id="lead-details-{{ $lead->id }}" class="lead-detail-row" style="display: none; background-color: #f8fafc;">
                                            <td colspan="5" style="padding: 1.5rem; border-top: 1px dashed #e2e8f0; border-bottom: 1px dashed #e2e8f0;">
                                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                                                    
                                                    <!-- Details Section -->
                                                    <div>
                                                        <h4 style="margin: 0 0 0.75rem 0; color: var(--primary-teal-dark); font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.5px; border: none; padding: 0;">Lead Information Details</h4>
                                                        <div style="background-color: white; border: 1px solid #e2e8f0; border-radius: var(--radius-md); padding: 1rem; font-size: 0.9rem; line-height: 1.5; color: #334155;">
                                                            {!! nl2br(e($lead->message)) !!}
                                                        </div>
                                                        @if($lead->notes)
                                                            <div style="margin-top: 1rem;">
                                                                <h5 style="margin: 0 0 0.5rem 0; color: #475569;">Admin Notes History</h5>
                                                                <p style="font-size: 0.85rem; color: #64748b; font-style: italic; background-color: #f1f5f9; padding: 0.50rem 0.75rem; border-radius: 4px; border-left: 3px solid #cbd5e1; margin: 0;">
                                                                    {{ $lead->notes }}
                                                                </p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    
                                                    <!-- Actions & Notes Form Section -->
                                                    <div>
                                                        <h4 style="margin: 0 0 0.75rem 0; color: var(--primary-teal-dark); font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.5px; border: none; padding: 0;">Update Status & Actions</h4>
                                                        <form action="{{ route('admin.leads.update', $lead->id) }}" method="POST" style="margin-bottom: 0;">
                                                            @csrf
                                                            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                                                                <div class="form-group">
                                                                    <label style="font-size: 0.8rem; font-weight: 600; display: block; margin-bottom: 4px;">Lead Status</label>
                                                                    <select name="status" class="form-control" required style="padding: 0.5rem; height: auto;">
                                                                        <option value="New" @selected($lead->status === 'New')>New</option>
                                                                        <option value="Contacted" @selected($lead->status === 'Contacted')>Contacted</option>
                                                                        <option value="In Progress" @selected($lead->status === 'In Progress')>In Progress</option>
                                                                        <option value="Closed" @selected($lead->status === 'Closed')>Closed</option>
                                                                    </select>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label style="font-size: 0.8rem; font-weight: 600; display: block; margin-bottom: 4px;">Internal Follow-up Notes</label>
                                                                    <textarea name="notes" class="form-control" rows="3" placeholder="Write internal notes about client conversation..." style="font-size: 0.85rem; padding: 0.5rem;">{{ $lead->notes }}</textarea>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn-submit" style="padding: 0.5rem 1rem; width: auto; margin-top: 0.75rem; font-size: 0.85rem;">
                                                                Update Status & Notes
                                                            </button>
                                                        </form>
                                                        
                                                        <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 1.25rem 0;">
                                                        
                                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                                            <span style="font-size: 0.8rem; color: #94a3b8;">Dangerous operation:</span>
                                                            <form action="{{ route('admin.leads.delete', $lead->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this lead record?');" style="margin: 0;">
                                                                @csrf
                                                                <button type="submit" class="btn-action delete" style="padding: 0.4rem 0.8rem; font-size: 0.8rem; display: flex; align-items: center; gap: 4px; height: auto; background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; border-radius: 4px; cursor: pointer;">
                                                                    <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i> Delete Lead Record
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- 2. BRANDING & LOGOS TAB -->
            <div class="tab-panel" id="tab-branding">
                <form action="{{ route('admin.parameters.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="admin-card">
                        <h2>Website Information</h2>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="site_name">Website Name</label>
                                <input type="text" id="site_name" name="site_name" class="form-control" value="{{ $site['site_name'] ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label for="site_tagline">Website Tagline</label>
                                <input type="text" id="site_tagline" name="site_tagline" class="form-control" value="{{ $site['site_tagline'] ?? '' }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="admin-card">
                        <h2>Logo & Favicon Customization</h2>
                        <p style="font-size:0.85rem; color: var(--admin-text-muted); margin-bottom: 1.5rem; margin-top: -1rem;">
                            Uploaded images are automatically converted to <strong>WebP format</strong> on the server for web speed optimizations. SVG format files will be uploaded untouched.
                        </p>
                        
                        <div class="form-grid">
                            <!-- Logo file -->
                            <div class="form-group">
                                <label>Header & Footer Logo (Upload File)</label>
                                <input type="file" name="logo" class="form-control" accept="image/*">
                                <div style="margin-top: 10px;">
                                    <label>Or Paste Logo URL</label>
                                    <input type="text" name="logo_url" class="form-control" value="{{ !empty($site['logo_path']) && (str_starts_with($site['logo_path'], 'http') || str_starts_with($site['logo_path'], '//')) ? $site['logo_path'] : '' }}" placeholder="https://example.com/logo.webp">
                                </div>
                                <div class="image-preview-container">
                                    <div class="image-preview">
                                        @if(!empty($site['logo_path']))
                                            <img src="{{ site_image($site['logo_path']) }}" alt="Logo">
                                        @else
                                            <span style="font-size:0.7rem; color: var(--admin-text-muted);">Default SVG</span>
                                        @endif
                                    </div>
                                    @if(!empty($site['logo_path']) && !str_starts_with($site['logo_path'], 'http') && !str_starts_with($site['logo_path'], '//'))
                                        <span class="badge-webp">WebP Optimized</span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Favicon file -->
                            <div class="form-group">
                                <label>Browser Favicon (Upload File)</label>
                                <input type="file" name="favicon" class="form-control" accept="image/*">
                                <div style="margin-top: 10px;">
                                    <label>Or Paste Favicon URL</label>
                                    <input type="text" name="favicon_url" class="form-control" value="{{ !empty($site['favicon_path']) && (str_starts_with($site['favicon_path'], 'http') || str_starts_with($site['favicon_path'], '//')) ? $site['favicon_path'] : '' }}" placeholder="https://example.com/favicon.ico">
                                </div>
                                <div class="image-preview-container">
                                    <div class="image-preview">
                                        @if(!empty($site['favicon_path']))
                                            <img src="{{ site_image($site['favicon_path']) }}" alt="Favicon">
                                        @else
                                            <span style="font-size:0.7rem; color: var(--admin-text-muted);">Default ICO</span>
                                        @endif
                                    </div>
                                    @if(!empty($site['favicon_path']) && !str_starts_with($site['favicon_path'], 'http') && !str_starts_with($site['favicon_path'], '//'))
                                        <span class="badge-webp">WebP Optimized</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Save Branding</button>
                </form>
            </div>

            <!-- 3. HOMEPAGE SLIDER TAB -->
            <div class="tab-panel" id="tab-slider">
                <!-- Add New Slide -->
                <div class="admin-card">
                    <h2>Add New Homepage Hero Slide</h2>
                    <form action="{{ route('admin.slides.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="slide_title">Slide Title</label>
                                <input type="text" id="slide_title" name="title" class="form-control" required placeholder="Enter slide main title">
                            </div>
                            <div class="form-group">
                                <label for="slide_subtitle">Slide Subtitle</label>
                                <input type="text" id="slide_subtitle" name="subtitle" class="form-control" placeholder="Enter slide supporting subtitle">
                            </div>
                            <div class="form-group">
                                <label for="slide_btn_text">Button Text</label>
                                <input type="text" id="slide_btn_text" name="button_text" class="form-control" placeholder="Get Free Consultation">
                            </div>
                            <div class="form-group">
                                <label for="slide_btn_link">Button Link</label>
                                <input type="text" id="slide_btn_link" name="button_link" class="form-control" placeholder="#consultation">
                            </div>
                            <div class="form-group">
                                <label for="slide_image">Slide Image (Upload File)</label>
                                <input type="file" id="slide_image" name="image" class="form-control" accept="image/*">
                                <div style="margin-top: 10px;">
                                    <label for="slide_image_url">Or Paste Image URL</label>
                                    <input type="text" id="slide_image_url" name="image_url" class="form-control" placeholder="https://images.mlgfinedge.com/your-image.webp">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="slide_sort">Sort Order</label>
                                <input type="number" id="slide_sort" name="sort_order" class="form-control" value="0">
                            </div>
                        </div>
                        <button type="submit" class="btn-submit" style="margin-top: 1rem;">Add Slide</button>
                    </form>
                </div>

                <!-- Existing Slides List -->
                <div class="admin-card">
                    <h2>Current Active Slides</h2>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Subtitle</th>
                                    <th>CTA Button</th>
                                    <th>Sort</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($slides as $slide)
                                    <tr>
                                        <td>
                                            <div class="image-preview">
                                                @if($slide->image_path)
                                                    <img src="{{ site_image($slide->image_path) }}" alt="Slide Preview">
                                                @else
                                                    <span style="font-size:0.75rem; color:var(--admin-text-muted);">Generic Card</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td><strong>{{ $slide->title }}</strong></td>
                                        <td>{{ Str::limit($slide->subtitle, 50) }}</td>
                                        <td>
                                            @if($slide->button_text)
                                                <span class="badge-webp" style="background-color: var(--accent-orange);">{{ $slide->button_text }} ({{ $slide->button_link }})</span>
                                            @else
                                                <span style="color:var(--admin-text-muted);">None</span>
                                            @endif
                                        </td>
                                        <td>{{ $slide->sort_order }}</td>
                                        <td>
                                            <div class="action-btns">
                                                <form action="{{ route('admin.slides.delete', $slide->id) }}" method="POST" onsubmit="return confirm('Delete this slide?')">
                                                    @csrf
                                                    <button type="submit" class="btn-action delete" title="Delete"><i data-lucide="trash-2"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; color: var(--admin-text-muted);">No custom slides found. Showing default homepage layout as fallback.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 4. TESTIMONIALS TAB -->
            <div class="tab-panel" id="tab-testimonials">
                <!-- Add New Testimonial -->
                <div class="admin-card">
                    <h2>Add New Customer Testimonial</h2>
                    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="test_name">Client Name</label>
                                <input type="text" id="test_name" name="name" class="form-control" required placeholder="Vikram Sharma">
                            </div>
                            <div class="form-group">
                                <label for="test_role">Client Subtitle/Role</label>
                                <input type="text" id="test_role" name="role" class="form-control" placeholder="Government Teacher, Jaipur">
                            </div>
                            <div class="form-group">
                                <label for="test_rating">Rating (1 to 5 Stars)</label>
                                <select id="test_rating" name="rating" class="form-control" required>
                                    <option value="5">5 Stars</option>
                                    <option value="4">4 Stars</option>
                                    <option value="3">3 Stars</option>
                                    <option value="2">2 Stars</option>
                                    <option value="1">1 Star</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="test_avatar">Client Avatar (Upload File)</label>
                                <input type="file" id="test_avatar" name="avatar" class="form-control" accept="image/*">
                                <div style="margin-top: 10px;">
                                    <label for="test_avatar_url">Or Paste Avatar URL</label>
                                    <input type="text" id="test_avatar_url" name="avatar_url" class="form-control" placeholder="https://images.mlgfinedge.com/avatar.webp">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="test_sort">Sort Order</label>
                                <input type="number" id="test_sort" name="sort_order" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top:1.25rem;">
                            <label for="test_content">Testimonial Review Content</label>
                            <textarea id="test_content" name="content" class="form-control" required placeholder="Write review feedback here..."></textarea>
                        </div>
                        <button type="submit" class="btn-submit">Add Testimonial</button>
                    </form>
                </div>

                <!-- Existing Testimonials List -->
                <div class="admin-card">
                    <h2>Current Active Testimonials</h2>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Avatar</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Content</th>
                                    <th>Rating</th>
                                    <th>Sort</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($testimonials as $test)
                                    <tr>
                                        <td>
                                            <div class="image-preview" style="border-radius: 50%;">
                                                @if($test->avatar_path)
                                                    <img src="{{ site_image($test->avatar_path) }}" alt="Avatar">
                                                @else
                                                    <!-- Initials -->
                                                    <div style="background-color:var(--primary-teal); color:white; width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-weight:bold;">
                                                        {{ substr($test->name, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td><strong>{{ $test->name }}</strong></td>
                                        <td>{{ $test->role }}</td>
                                        <td>{{ Str::limit($test->content, 80) }}</td>
                                        <td style="color:#ffb100;">
                                            @for($i = 0; $i < $test->rating; $i++)★@endfor
                                        </td>
                                        <td>{{ $test->sort_order }}</td>
                                        <td>
                                            <div class="action-btns">
                                                <form action="{{ route('admin.testimonials.delete', $test->id) }}" method="POST" onsubmit="return confirm('Delete this testimonial?')">
                                                    @csrf
                                                    <button type="submit" class="btn-action delete" title="Delete"><i data-lucide="trash-2"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" style="text-align: center; color: var(--admin-text-muted);">No testimonials found in database. Showing defaults as fallback.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 5. SECTION STYLING & BACKGROUNDS TAB -->
            <div class="tab-panel" id="tab-styling">
                <form action="{{ route('admin.parameters.update') }}" method="POST">
                    @csrf
                    <div class="admin-card">
                        <h2>Section Styling & Backgrounds</h2>
                        <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.5rem; margin-top: -1rem;">
                            Customize background values for different sections of your homepage. You can use hexadecimal color codes (e.g. <code>#ffffff</code>), CSS gradients (e.g. <code>linear-gradient(135deg, #eef7f7 0%, #ffffff 100%)</code>), or even image URLs (e.g. <code>url('/storage/uploads/filename.webp') center/cover</code>).
                        </p>
                        
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="index_hero_bg">Home Hero Section Background</label>
                                <input type="text" id="index_hero_bg" name="index_hero_bg" class="form-control" value="{{ $site['index_hero_bg'] ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="index_services_bg">Home Services Section Background</label>
                                <input type="text" id="index_services_bg" name="index_services_bg" class="form-control" value="{{ $site['index_services_bg'] ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="index_about_bg">Home About Section Background</label>
                                <input type="text" id="index_about_bg" name="index_about_bg" class="form-control" value="{{ $site['index_about_bg'] ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="index_why_bg">Home Why Choose Us Background</label>
                                <input type="text" id="index_why_bg" name="index_why_bg" class="form-control" value="{{ $site['index_why_bg'] ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="index_testimonials_bg">Home Testimonials Background</label>
                                <input type="text" id="index_testimonials_bg" name="index_testimonials_bg" class="form-control" value="{{ $site['index_testimonials_bg'] ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="index_faq_bg">Home FAQ Background</label>
                                <input type="text" id="index_faq_bg" name="index_faq_bg" class="form-control" value="{{ $site['index_faq_bg'] ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="index_cta_bg">Home CTA Section Background</label>
                                <input type="text" id="index_cta_bg" name="index_cta_bg" class="form-control" value="{{ $site['index_cta_bg'] ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">Save Background Styles</button>
                </form>
            </div>

            <!-- 6. PAGE EDITOR TAB -->
            <div class="tab-panel" id="tab-pagecontents">
                <form action="{{ route('admin.page-contents.update') }}" method="POST">
                    @csrf
                    
                    <div class="admin-card">
                        <h2>Homepage - Hero Section</h2>
                        <div class="form-group">
                            <label>Hero Main Title</label>
                            <input type="text" name="contents[home][hero][title]" class="form-control" value="{{ $pageContents->where('page', 'home')->where('section', 'hero')->where('key', 'title')->first()->value ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Hero Subtitle / Description</label>
                            <textarea name="contents[home][hero][subtitle]" class="form-control" rows="3">{{ $pageContents->where('page', 'home')->where('section', 'hero')->where('key', 'subtitle')->first()->value ?? '' }}</textarea>
                        </div>
                    </div>

                    <div class="admin-card">
                        <h2>Homepage - Services Section Overview</h2>
                        <div class="form-group">
                            <label>Services Heading</label>
                            <input type="text" name="contents[home][services][title]" class="form-control" value="{{ $pageContents->where('page', 'home')->where('section', 'services')->where('key', 'title')->first()->value ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Services Intro Text</label>
                            <textarea name="contents[home][services][subtitle]" class="form-control" rows="3">{{ $pageContents->where('page', 'home')->where('section', 'services')->where('key', 'subtitle')->first()->value ?? '' }}</textarea>
                        </div>
                    </div>

                    <div class="admin-card">
                        <h2>Homepage - About Section</h2>
                        <div class="form-group">
                            <label>Pre-Heading / Category Tag</label>
                            <input type="text" name="contents[home][about][pre_title]" class="form-control" value="{{ $pageContents->where('page', 'home')->where('section', 'about')->where('key', 'pre_title')->first()->value ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>About Section Heading</label>
                            <input type="text" name="contents[home][about][title]" class="form-control" value="{{ $pageContents->where('page', 'home')->where('section', 'about')->where('key', 'title')->first()->value ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>About Paragraph 1</label>
                            <textarea name="contents[home][about][body_p1]" class="form-control" rows="3">{{ $pageContents->where('page', 'home')->where('section', 'about')->where('key', 'body_p1')->first()->value ?? '' }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>About Paragraph 2</label>
                            <textarea name="contents[home][about][body_p2]" class="form-control" rows="3">{{ $pageContents->where('page', 'home')->where('section', 'about')->where('key', 'body_p2')->first()->value ?? '' }}</textarea>
                        </div>
                    </div>

                    <div class="admin-card">
                        <h2>Homepage - Why Choose Us Overview</h2>
                        <div class="form-group">
                            <label>Why Choose Us Heading</label>
                            <input type="text" name="contents[home][why_choose_us][title]" class="form-control" value="{{ $pageContents->where('page', 'home')->where('section', 'why_choose_us')->where('key', 'title')->first()->value ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Why Choose Us Intro Subtitle</label>
                            <textarea name="contents[home][why_choose_us][subtitle]" class="form-control" rows="3">{{ $pageContents->where('page', 'home')->where('section', 'why_choose_us')->where('key', 'subtitle')->first()->value ?? '' }}</textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Save Page Content</button>
                </form>
            </div>

            <!-- 8. SERVICES MANAGER TAB -->
            <div class="tab-panel" id="tab-services">
                <!-- Add/Edit Service Card -->
                <div class="admin-card" id="service-form-container">
                    <h2 id="service-form-title">
                        <span id="service-form-title-text">Create New Service Page</span>
                        <button type="button" class="btn-ai-sparkle" id="service-ai-btn" onclick="openAiModal('service')">
                            <i data-lucide="sparkles"></i> Generate with AI
                        </button>
                    </h2>
                    <form id="service-form" action="{{ route('admin.services.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="service-form-method" value="POST">
                        
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="ser_service_name">Service Name (e.g. Personal Loan)</label>
                                <input type="text" id="ser_service_name" name="service_name" class="form-control" required placeholder="Personal Loan">
                            </div>
                            <div class="form-group">
                                <label for="ser_slug">URL Slug (leave empty to auto-generate)</label>
                                <input type="text" id="ser_slug" name="slug" class="form-control" placeholder="personal-loan">
                            </div>
                            <div class="form-group">
                                <label for="ser_badge">Badge / Promo Tag (optional)</label>
                                <input type="text" id="ser_badge" name="badge" class="form-control" placeholder="Best Rates">
                            </div>
                            <div class="form-group">
                                <label for="ser_sort_order">Sort Order</label>
                                <input type="number" id="ser_sort_order" name="sort_order" class="form-control" value="0">
                            </div>
                            <div class="form-group">
                                <label for="ser_hero_category">Hero Category Tag</label>
                                <input type="text" id="ser_hero_category" name="hero_category" class="form-control" placeholder="RETAIL LOAN">
                            </div>
                            <div class="form-group">
                                <label for="ser_hero_title">Hero Main Title</label>
                                <input type="text" id="ser_hero_title" name="hero_title" class="form-control" required placeholder="Personal Loan at Low Rates">
                            </div>
                            <div class="form-group" style="grid-column: span 2;">
                                <label for="ser_hero_subtitle">Hero Subtitle</label>
                                <textarea id="ser_hero_subtitle" name="hero_subtitle" class="form-control" rows="2" placeholder="Instant personal loans up to 40 Lakhs with minimum documentation."></textarea>
                            </div>
                            <div class="form-group">
                                <label for="ser_rate_value">Key Rate Value (e.g. 10.49% p.a.)</label>
                                <input type="text" id="ser_rate_value" name="rate_value" class="form-control" placeholder="10.49% p.a.">
                            </div>
                            <div class="form-group">
                                <label for="ser_max_loan">Key Max Loan (e.g. Up to ₹40 Lakhs)</label>
                                <input type="text" id="ser_max_loan" name="max_loan" class="form-control" placeholder="Up to ₹40 Lakhs">
                            </div>
                            <div class="form-group">
                                <label for="ser_tenure">Key Tenure (e.g. Up to 72 Months)</label>
                                <input type="text" id="ser_tenure" name="tenure" class="form-control" placeholder="Up to 72 Months">
                            </div>
                            <div class="form-group">
                                <label for="ser_intro_title">Intro Title</label>
                                <input type="text" id="ser_intro_title" name="intro_title" class="form-control" placeholder="Why Choose Our Personal Loan?">
                            </div>
                            <div class="form-group" style="grid-column: span 2;">
                                <label for="ser_intro_content">Intro Content (HTML Editor)</label>
                                <textarea id="ser_intro_content" name="intro_content" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="ser_eligibility_criteria">Eligibility Criteria (one per line)</label>
                                <textarea id="ser_eligibility_criteria" name="eligibility_criteria" class="form-control" rows="4" placeholder="Minimum Income: ₹25,000 net/month&#10;Age Range: 21 to 60 Years"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="ser_documents_required">Documents Required (one per line)</label>
                                <textarea id="ser_documents_required" name="documents_required" class="form-control" rows="4" placeholder="PAN Card & Aadhaar Card&#10;Last 3 Months Salary Slips"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="ser_tips_title">Tips Section Title (optional)</label>
                                <input type="text" id="ser_tips_title" name="tips_title" class="form-control" placeholder="How to get faster personal loan approval?">
                            </div>
                            <div class="form-group" style="grid-column: span 2;">
                                <label for="ser_tips_content">Tips Section Content (HTML Editor)</label>
                                <textarea id="ser_tips_content" name="tips_content" class="form-control"></textarea>
                            </div>
                            <div class="form-group" style="grid-column: span 2;">
                                <label for="ser_summary">Short Summary (shown in lists & footer)</label>
                                <textarea id="ser_summary" name="summary" class="form-control" rows="2" placeholder="Brief summary of the service..."></textarea>
                            </div>
                            <div class="form-group">
                                <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; margin-top: 1rem;">
                                    <input type="checkbox" id="ser_is_active" name="is_active" value="1" checked style="width: 18px; height: 18px; accent-color: var(--mint-green);">
                                    Active / Visible in navigation
                                </label>
                            </div>
                        </div>

                        <!-- FAQ Repeater Section -->
                        <div style="margin-top: 2rem; border-top: 1px solid var(--admin-border); padding-top: 1.5rem;">
                            <h3>Service FAQs</h3>
                            <div id="faq-repeater-container" style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.5rem;">
                                <!-- FAQ items will be added here dynamically -->
                            </div>
                            <button type="button" class="btn-submit" style="background-color: var(--admin-input-bg); color: #fff;" onclick="addFaqInput()">
                                <i data-lucide="plus" style="width: 14px; height: 14px; display: inline; vertical-align: middle;"></i> Add FAQ Question
                            </button>
                        </div>

                        <div style="margin-top: 2rem; display: flex; gap: 10px;">
                            <button type="submit" class="btn-submit" id="service-submit-btn">Create Service Page</button>
                            <button type="button" class="btn-submit" id="service-cancel-btn" style="background-color: var(--admin-input-bg); color: #fff; display: none;" onclick="cancelServiceEdit()">Cancel Edit</button>
                        </div>
                    </form>
                </div>

                <!-- Existing Services Table -->
                <div class="admin-card">
                    <h2>Active Service Pages</h2>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Rate</th>
                                    <th>Status</th>
                                    <th style="text-align: right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($services as $s)
                                    <tr>
                                        <td>{{ $s->sort_order }}</td>
                                        <td style="font-weight: 500;">{{ $s->service_name }}</td>
                                        <td style="color: var(--admin-text-muted);">{{ $s->slug }}</td>
                                        <td>{{ $s->rate_value ?? 'N/A' }}</td>
                                        <td>
                                            @if($s->is_active)
                                                <span style="color: var(--accent-teal); font-size: 0.85rem; font-weight: 600;">● Active</span>
                                            @else
                                                <span style="color: var(--admin-text-muted); font-size: 0.85rem;">● Inactive</span>
                                            @endif
                                        </td>
                                        <td style="text-align: right;">
                                            <div class="action-btns" style="justify-content: flex-end;">
                                                <button class="btn-submit" style="padding: 4px 10px; font-size: 0.8rem; background-color: var(--admin-input-bg); color: #fff;" 
                                                    onclick="editService({{ json_encode($s) }})">
                                                    Edit
                                                </button>
                                                <form action="{{ route('admin.services.delete', $s->id) }}" method="POST" onsubmit="return confirm('Delete this service page? This action cannot be undone.')">
                                                    @csrf
                                                    <button type="submit" class="btn-submit" style="padding: 4px 10px; font-size: 0.8rem; background-color: rgba(239, 68, 68, 0.2); color: #f87171;">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; color: var(--admin-text-muted);">No service pages configured.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 9. BANK COMPARISON TAB -->
            <div class="tab-panel" id="tab-banks">
                <!-- Add/Edit Bank Card -->
                <div class="admin-card" id="bank-form-container">
                    <h2 id="bank-form-title">Add New Lender / Bank</h2>
                    <form id="bank-form" action="{{ route('admin.banks.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="bank-form-method" value="POST">
                        
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="bank_name">Bank / Lender Name</label>
                                <input type="text" id="bank_name" name="name" class="form-control" required placeholder="HDFC Bank">
                            </div>
                            <div class="form-group">
                                <label for="bank_sector">Sector</label>
                                <select id="bank_sector" name="sector" class="form-control" required>
                                    <option value="Private">Private Bank</option>
                                    <option value="Public">Public Bank</option>
                                    <option value="NBFC">NBFC</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="bank_home_rate">Home Loan Rate (% p.a.)</label>
                                <input type="number" step="0.01" min="0" max="100" id="bank_home_rate" name="home_rate" class="form-control" required placeholder="8.40">
                            </div>
                            <div class="form-group">
                                <label for="bank_personal_rate">Personal Loan Rate (% p.a.)</label>
                                <input type="number" step="0.01" min="0" max="100" id="bank_personal_rate" name="personal_rate" class="form-control" required placeholder="10.50">
                            </div>
                            <div class="form-group">
                                <label for="bank_business_rate">Business Loan Rate (% p.a.)</label>
                                <input type="number" step="0.01" min="0" max="100" id="bank_business_rate" name="business_rate" class="form-control" required placeholder="13.00">
                            </div>
                            <div class="form-group">
                                <label for="bank_fee_percent">Processing Fee (%)</label>
                                <input type="number" step="0.01" min="0" max="100" id="bank_fee_percent" name="fee_percent" class="form-control" required placeholder="1.00">
                            </div>
                            <div class="form-group">
                                <label for="bank_sort_order">Sort Order</label>
                                <input type="number" id="bank_sort_order" name="sort_order" class="form-control" value="0">
                            </div>
                        </div>

                        <div style="margin-top: 1.5rem; display: flex; gap: 10px;">
                            <button type="submit" class="btn-submit" id="bank-submit-btn">Add Bank Comparison</button>
                            <button type="button" class="btn-submit" id="bank-cancel-btn" style="background-color: var(--admin-input-bg); color: #fff; display: none;" onclick="cancelBankEdit()">Cancel Edit</button>
                        </div>
                    </form>
                </div>

                <!-- Existing Banks Table -->
                <div class="admin-card">
                    <h2>Configured Comparison Lenders</h2>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Lender Name</th>
                                    <th>Sector</th>
                                    <th>Home Loan</th>
                                    <th>Personal Loan</th>
                                    <th>Business Loan</th>
                                    <th>Processing Fee</th>
                                    <th style="text-align: right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($banks as $b)
                                    <tr>
                                        <td>{{ $b->sort_order }}</td>
                                        <td style="font-weight: 500;">{{ $b->name }}</td>
                                        <td>
                                            <span style="background: rgba(255,255,255,0.05); padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">
                                                {{ $b->sector }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($b->home_rate, 2) }}%</td>
                                        <td>{{ number_format($b->personal_rate, 2) }}%</td>
                                        <td>{{ number_format($b->business_rate, 2) }}%</td>
                                        <td>{{ number_format($b->fee_percent, 2) }}%</td>
                                        <td style="text-align: right;">
                                            <div class="action-btns" style="justify-content: flex-end;">
                                                <button class="btn-submit" style="padding: 4px 10px; font-size: 0.8rem; background-color: var(--admin-input-bg); color: #fff;" 
                                                    onclick="editBank({{ json_encode($b) }})">
                                                    Edit
                                                </button>
                                                <form action="{{ route('admin.banks.delete', $b->id) }}" method="POST" onsubmit="return confirm('Delete this lender from comparison database?')">
                                                    @csrf
                                                    <button type="submit" class="btn-submit" style="padding: 4px 10px; font-size: 0.8rem; background-color: rgba(239, 68, 68, 0.2); color: #f87171;">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" style="text-align: center; color: var(--admin-text-muted);">No comparison lenders configured.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 7. BLOG MANAGER TAB -->
            <div class="tab-panel" id="tab-blogs">
                <!-- Add Blog Card -->
                <div class="admin-card" id="blog-form-container">
                    <h2 id="blog-form-title">
                        <span id="blog-form-title-text">Create New Blog Article</span>
                        <button type="button" class="btn-ai-sparkle" id="blog-ai-btn" onclick="openAiModal('blog')">
                            <i data-lucide="sparkles"></i> Generate with AI
                        </button>
                    </h2>
                    <form id="blog-form" action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" id="blog-form-method" value="POST">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="blog_title">Article Title</label>
                                <input type="text" id="blog_title" name="title" class="form-control" required placeholder="The Ultimate Guide to Securing a Loan">
                            </div>
                            <div class="form-group">
                                <label for="blog_slug">URL Slug (leave empty to auto-generate)</label>
                                <input type="text" id="blog_slug" name="slug" class="form-control" placeholder="ultimate-loan-guide">
                            </div>
                            <div class="form-group">
                                <label for="blog_category">Category</label>
                                <select id="blog_category" name="category" class="form-control" required>
                                    <option value="Personal Loans">Personal Loans</option>
                                    <option value="Home Loans">Home Loans</option>
                                    <option value="Business Loans">Business Loans</option>
                                    <option value="Loan Against Property">Loan Against Property</option>
                                    <option value="Financial Tips">Financial Tips</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="blog_published_at">Publish Date</label>
                                <input type="datetime-local" id="blog_published_at" name="published_at" class="form-control" value="{{ date('Y-m-d\TH:i') }}">
                            </div>
                            <div class="form-group">
                                <label for="blog_image">Cover Image (Upload File)</label>
                                <input type="file" id="blog_image" name="image" class="form-control" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label for="blog_image_url">Or Paste Cover Image URL</label>
                                <input type="text" id="blog_image_url" name="image_url" class="form-control" placeholder="https://images.mlgfinedge.com/cover.webp">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 1.25rem;">
                            <label for="blog_summary">Short Summary (shown in blog listing card)</label>
                            <textarea id="blog_summary" name="summary" class="form-control" required placeholder="A brief 1-2 sentence description of the article..." rows="2"></textarea>
                        </div>
                        <div class="form-group" style="margin-top: 1.25rem;">
                            <label for="blog_content">Article Content (HTML Editor)</label>
                            <textarea id="blog_content" name="content" class="form-control" placeholder="Write article content here..."></textarea>
                        </div>
                        <div style="margin-top: 1.5rem; display: flex; gap: 10px;">
                            <button type="submit" class="btn-submit" id="blog-submit-btn">Publish Blog Article</button>
                            <button type="button" class="btn-submit" id="blog-cancel-btn" style="background-color: var(--admin-input-bg); color: #fff; display: none;" onclick="cancelBlogEdit()">Cancel Edit</button>
                        </div>
                    </form>
                </div>

                <!-- Existing Blogs List -->
                <div class="admin-card">
                    <h2>Published Blog Articles</h2>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Cover Image</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Slug</th>
                                    <th>Published Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($blogs as $b)
                                    <tr>
                                        <td>
                                            <div class="image-preview">
                                                @if($b->image_path)
                                                    <img src="{{ site_image($b->image_path) }}" alt="Cover">
                                                @else
                                                    <span style="font-size:0.75rem; color:var(--admin-text-muted);">No Image</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td><strong>{{ $b->title }}</strong></td>
                                        <td><span class="badge-webp" style="background-color: var(--primary-teal);">{{ $b->category }}</span></td>
                                        <td><code>{{ $b->slug }}</code></td>
                                        <td>{{ $b->published_at ? $b->published_at->format('M d, Y H:i') : $b->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <div class="action-btns">
                                                <button type="button" class="btn-action edit" title="Edit Article" 
                                                    onclick="editBlog({
                                                        id: {{ $b->id }},
                                                        title: '{{ addslashes($b->title) }}',
                                                        slug: '{{ addslashes($b->slug) }}',
                                                        category: '{{ addslashes($b->category) }}',
                                                        published_at: '{{ $b->published_at ? $b->published_at->format('Y-m-d\TH:i') : $b->created_at->format('Y-m-d\TH:i') }}',
                                                        summary: '{{ addslashes(str_replace(["\r", "\n"], ' ', $b->summary)) }}',
                                                        content: '{{ addslashes(str_replace(["\r", "\n"], ' ', $b->content)) }}'
                                                    })"><i data-lucide="edit"></i></button>
                                                <form action="{{ route('admin.blogs.delete', $b->id) }}" method="POST" onsubmit="return confirm('Delete this blog post?')">
                                                    @csrf
                                                    <button type="submit" class="btn-action delete" title="Delete"><i data-lucide="trash-2"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; color: var(--admin-text-muted);">No blog posts found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 8. MEDIA MANAGER TAB -->
            <div class="tab-panel" id="tab-media">
                <div class="admin-card">
                    <h2>
                        <span>Upload Media File</span>
                        <button type="button" class="btn-ai-sparkle" onclick="openAiModal('image')">
                            <i data-lucide="sparkles"></i> Generate Image with AI
                        </button>
                    </h2>
                    <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.5rem; margin-top: -1rem;">
                        Upload any JPEG, PNG, GIF, WebP, or SVG image. Standard raster formats are automatically compressed and converted to the highly efficient <strong>WebP format</strong> on the server.
                    </p>
                    <form id="media-upload-form" action="{{ route('admin.media.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div style="border: 2px dashed var(--admin-border); padding: 3rem; text-align: center; border-radius: var(--radius-lg); background: rgba(255,255,255,0.01); cursor: pointer;" onclick="document.getElementById('media-file-input').click()">
                            <i data-lucide="upload-cloud" style="width: 48px; height: 48px; color: var(--mint-green); margin-bottom: 1rem;"></i>
                            <p style="margin: 0; font-weight: 500;">Click to select an image from your computer</p>
                            <p style="margin: 5px 0 0 0; font-size: 0.8rem; color: var(--admin-text-muted);">Maximum size: 10 MB (JPEG, PNG, GIF, WEBP, SVG)</p>
                            <input type="file" id="media-file-input" name="file" style="display: none;" onchange="uploadMediaFile(this)">
                        </div>
                    </form>
                    <div id="media-upload-progress" style="display: none; margin-top: 1rem;">
                        <div style="background-color: var(--admin-border); border-radius: 10px; height: 6px; width: 100%; overflow: hidden;">
                            <div id="media-progress-bar" style="background-color: var(--mint-green); height: 100%; width: 0%; transition: width 0.3s ease;"></div>
                        </div>
                        <p style="font-size: 0.8rem; margin-top: 5px; color: var(--mint-green);">Uploading and optimizing image...</p>
                    </div>
                </div>

                <div class="admin-card">
                    <h2 style="display: flex; justify-content: space-between; align-items: center; gap: 15px; flex-wrap: wrap;">
                        <span>Media Library</span>
                        <button type="button" class="btn-ai-sparkle" style="background: var(--blue-gradient, linear-gradient(135deg, #2563eb 0%, #3b82f6 100%)); border-color: #2563eb;" onclick="syncLocalImagesToR2(this)">
                            <i data-lucide="refresh-cw"></i> Sync Local Images to R2
                        </button>
                    </h2>
                    <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.5rem; margin-top: -1rem;">
                        Click on any image's <strong>Copy URL</strong> button to use its link in slider images, blog covers, page contents, or background section styles.
                    </p>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1.25rem;">
                        @forelse($mediaFiles as $media)
                            <div style="background: rgba(255,255,255,0.01); border: 1px solid var(--admin-border); border-radius: var(--radius-md); overflow: hidden; display: flex; flex-direction: column;">
                                <div style="height: 120px; background: rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                                    <img src="{{ $media['url'] }}" alt="{{ $media['name'] }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    <span class="badge-webp" style="position: absolute; bottom: 5px; right: 5px; font-size: 0.65rem;">{{ strtoupper(pathinfo($media['name'], PATHINFO_EXTENSION)) }}</span>
                                </div>
                                <div style="padding: 10px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                                    <div>
                                        <p style="margin: 0; font-size: 0.8rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $media['name'] }}">{{ $media['name'] }}</p>
                                        <p style="margin: 2px 0 0 0; font-size: 0.7rem; color: var(--admin-text-muted);">{{ round($media['size'] / 1024, 1) }} KB</p>
                                    </div>
                                    <button class="btn-submit" style="width: 100%; padding: 5px; font-size: 0.75rem; margin-top: 10px; border-radius: 4px; display: flex; align-items: center; justify-content: center; gap: 4px;" onclick="copyToClipboard('{{ $media['url'] }}', this)">
                                        <i data-lucide="copy" style="width: 12px; height: 12px;"></i> Copy URL
                                    </button>
                                </div>
                            </div>
                        @empty
                            <p style="grid-column: 1 / -1; text-align: center; color: var(--admin-text-muted); padding: 20px 0;">No media files uploaded yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- WEB ANALYTICS TAB -->
            <div class="tab-panel" id="tab-analytics">
                <div class="admin-card">
                    <h2><i data-lucide="bar-chart-2" style="display: inline-block; vertical-align: middle; margin-right: 5px;"></i> Cloudflare Web Analytics</h2>
                    
                    @if(empty($site['cloudflare_api_token']) || empty($site['cloudflare_zone_id']))
                        <div style="padding: 2rem; text-align: center; background: rgba(255,255,255,0.01); border: 1px dashed var(--admin-border); border-radius: var(--radius-md);">
                            <i data-lucide="info" style="width: 48px; height: 48px; color: var(--admin-text-muted); margin-bottom: 1rem;"></i>
                            <h3 style="color: #ffffff; margin-bottom: 0.5rem;">Integration Required</h3>
                            <p style="color: var(--admin-text-muted); max-width: 500px; margin: 0 auto 1.5rem auto; font-size: 0.9rem;">
                                Please configure your Cloudflare API Token and Zone ID in the <strong>General Settings</strong> tab to view detailed web traffic metrics here.
                            </p>
                            <button onclick="switchTab('general')" class="btn-submit" style="width: auto;">Configure Settings</button>
                        </div>
                    @else
                        <div id="analytics-loader" style="padding: 3rem; text-align: center; display: flex; flex-direction: column; align-items: center; gap: 10px;">
                            <div class="ai-toast-spinner" style="width: 40px; height: 40px;"></div>
                            <span style="color: var(--admin-text-muted); font-size: 0.9rem;">Fetching data from Cloudflare...</span>
                        </div>
                        
                        <div id="analytics-error" style="display: none; padding: 2rem; background: rgba(255,107,107,0.05); border: 1px solid rgba(255,107,107,0.2); border-radius: var(--radius-md); text-align: center; margin-bottom: 1.5rem;">
                            <i data-lucide="alert-triangle" style="color: #ff6b6b; margin-bottom: 0.5rem;"></i>
                            <p id="analytics-error-msg" style="color: #ff6b6b; margin: 0; font-size: 0.9rem;"></p>
                        </div>

                        <div id="analytics-dashboard" style="display: none;">
                            <!-- Stats Cards Grid -->
                            <div class="form-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); margin-bottom: 2rem;">
                                <div class="admin-card text-center" style="padding: 1.25rem; margin-bottom: 0;">
                                    <h4 style="margin: 0; font-size: 0.8rem; color: var(--admin-text-muted); text-transform: uppercase;">Total Pageviews</h4>
                                    <p id="stat-pageviews" style="font-size: 2rem; font-weight: 800; color: var(--mint-green); margin: 0.5rem 0 0 0;">0</p>
                                </div>
                                <div class="admin-card text-center" style="padding: 1.25rem; margin-bottom: 0;">
                                    <h4 style="margin: 0; font-size: 0.8rem; color: var(--admin-text-muted); text-transform: uppercase;">Total Requests</h4>
                                    <p id="stat-requests" style="font-size: 2rem; font-weight: 800; color: #3b82f6; margin: 0.5rem 0 0 0;">0</p>
                                </div>
                                <div class="admin-card text-center" style="padding: 1.25rem; margin-bottom: 0;">
                                    <h4 style="margin: 0; font-size: 0.8rem; color: var(--admin-text-muted); text-transform: uppercase;">Cache Hit Rate</h4>
                                    <p id="stat-cache" style="font-size: 2rem; font-weight: 800; color: #eab308; margin: 0.5rem 0 0 0;">0%</p>
                                </div>
                                <div class="admin-card text-center" style="padding: 1.25rem; margin-bottom: 0;">
                                    <h4 style="margin: 0; font-size: 0.8rem; color: var(--admin-text-muted); text-transform: uppercase;">Data Transferred</h4>
                                    <p id="stat-bandwidth" style="font-size: 2rem; font-weight: 800; color: #f97316; margin: 0.5rem 0 0 0;">0 MB</p>
                                </div>
                            </div>

                            <!-- Line Chart Container -->
                            <div class="admin-card" style="padding: 1.5rem; margin-bottom: 0; background: rgba(0,0,0,0.15);">
                                <h3>Traffic Metrics (Last 7 Days)</h3>
                                <div style="position: relative; height: 300px; width: 100%;">
                                    <canvas id="cloudflareChart"></canvas>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- AI Toast Notification Container -->
    <div id="ai-toast-container" style="position: fixed; bottom: 20px; right: 20px; z-index: 999999; display: flex; flex-direction: column; gap: 10px;"></div>

    <!-- AI Blog Generator Modal -->
    <div class="ai-modal-overlay" id="ai-blog-modal">
        <div class="ai-modal-card">
            <button class="ai-modal-close" onclick="closeAiModal('blog')">&times;</button>
            <h3><i data-lucide="sparkles"></i> AI Blog Article Generator</h3>
            
            <div id="ai-blog-form-wrapper">
                <div class="form-group">
                    <label for="ai_blog_prompt">What should the blog article be about?</label>
                    <textarea id="ai_blog_prompt" class="form-control" rows="4" placeholder="e.g. Benefits of choosing a home loan through a broker vs directly from a bank..."></textarea>
                </div>
                
                <div class="form-grid" style="grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="ai_blog_tone">Writing Tone</label>
                        <select id="ai_blog_tone" class="form-control">
                            <option value="Professional & Informative">Professional & Informative</option>
                            <option value="Conversational & Friendly">Conversational & Friendly</option>
                            <option value="Persuasive & Engaging">Persuasive & Engaging</option>
                            <option value="Simple & Clear">Simple & Clear</option>
                        </select>
                    </div>
                    <div class="form-group" style="display: flex; align-items: center; margin-top: 1.5rem;">
                        <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.85rem;">
                            <input type="checkbox" id="ai_blog_gen_image" value="1" checked style="width: 16px; height: 16px; accent-color: var(--mint-green);">
                            Generate Cover Image
                        </label>
                    </div>
                </div>
                
                <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn-submit" style="background-color: var(--admin-input-bg); color: #fff;" onclick="closeAiModal('blog')">Cancel</button>
                    <button type="button" class="btn-ai-sparkle" onclick="generateAiBlog()"><i data-lucide="sparkles"></i> Generate Draft</button>
                </div>
            </div>
            
            <div class="ai-loader-container" id="ai-blog-loader">
                <div class="ai-sparkle-loader"></div>
                <p class="ai-loader-text">Gemini is writing your article...</p>
                <p class="ai-loader-subtext">This can take up to 20-30 seconds depending on image generation.</p>
            </div>
        </div>
    </div>

    <!-- AI Service Page Generator Modal -->
    <div class="ai-modal-overlay" id="ai-service-modal">
        <div class="ai-modal-card">
            <button class="ai-modal-close" onclick="closeAiModal('service')">&times;</button>
            <h3><i data-lucide="sparkles"></i> AI Service Page Generator</h3>
            
            <div id="ai-service-form-wrapper">
                <div class="form-group">
                    <label for="ai_service_prompt">Describe the Service Page you want to create:</label>
                    <textarea id="ai_service_prompt" class="form-control" rows="4" placeholder="e.g. Home Renovation Loans: covering collateral requirements, processing speed, competitive interest rates starting at 8.9% p.a., and top reasons to apply."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="ai_service_tone">Writing Tone</label>
                    <select id="ai_service_tone" class="form-control">
                        <option value="Professional & Financial">Professional & Financial</option>
                        <option value="Informative & Helpful">Informative & Helpful</option>
                        <option value="Persuasive & Sales-Oriented">Persuasive & Sales-Oriented</option>
                    </select>
                </div>
                
                <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn-submit" style="background-color: var(--admin-input-bg); color: #fff;" onclick="closeAiModal('service')">Cancel</button>
                    <button type="button" class="btn-ai-sparkle" onclick="generateAiService()"><i data-lucide="sparkles"></i> Generate Service</button>
                </div>
            </div>
            
            <div class="ai-loader-container" id="ai-service-loader">
                <div class="ai-sparkle-loader"></div>
                <p class="ai-loader-text">Gemini is generating service page details...</p>
                <p class="ai-loader-subtext">Structuring Hero content, eligibility criteria, required documents, and FAQs.</p>
            </div>
        </div>
    </div>

    <!-- AI Picture Generator Modal -->
    <div class="ai-modal-overlay" id="ai-image-modal">
        <div class="ai-modal-card">
            <button class="ai-modal-close" onclick="closeAiModal('image')">&times;</button>
            <h3><i data-lucide="sparkles"></i> AI Picture Generator (Imagen 3)</h3>
            
            <div id="ai-image-form-wrapper">
                <div class="form-group">
                    <label for="ai_image_prompt">Describe the image you want to generate:</label>
                    <textarea id="ai_image_prompt" class="form-control" rows="4" placeholder="e.g. A realistic photo of a young couple receiving keys to their new home, warm lighting, high detail..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="ai_image_aspect_ratio">Aspect Ratio</label>
                    <select id="ai_image_aspect_ratio" class="form-control">
                        <option value="1:1">1:1 Square (Default)</option>
                        <option value="16:9">16:9 Landscape (Slider / Blog cover)</option>
                        <option value="4:3">4:3 Standard</option>
                    </select>
                </div>
                
                <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" class="btn-submit" style="background-color: var(--admin-input-bg); color: #fff;" onclick="closeAiModal('image')">Cancel</button>
                    <button type="button" class="btn-ai-sparkle" onclick="generateAiImage()"><i data-lucide="sparkles"></i> Generate Picture</button>
                </div>
            </div>
            
            <div class="ai-loader-container" id="ai-image-loader">
                <div class="ai-sparkle-loader"></div>
                <p class="ai-loader-text">Imagen is rendering your picture...</p>
                <p class="ai-loader-subtext">This will take 10-15 seconds. Please do not close this modal.</p>
            </div>

            <!-- Preview box of generated image -->
            <div class="ai-img-preview-box" id="ai-image-preview-container">
                <img id="ai-image-preview-img" src="" alt="Generated Preview">
                <div class="info">
                    <span style="font-size: 0.8rem; color: var(--admin-text-muted);" id="ai-image-status-text">Saved to Media Library!</span>
                    <button type="button" class="btn-submit" style="padding: 5px 12px; font-size: 0.8rem;" id="ai-image-copy-btn">
                        <i data-lucide="copy" style="width: 14px; height: 14px; display: inline; vertical-align: middle;"></i> Copy URL
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Add CKEditor CSS custom overrides -->
    <style>
        .ck-editor__editable {
            color: #111111 !important;
            min-height: 250px;
        }
    </style>

    <!-- Lucide CDN & CKEditor CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        lucide.createIcons();

        let cloudflareChartInstance = null;

        function syncLocalImagesToR2(btn) {
            const originalHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="ai-toast-spinner" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 5px;"></span> Syncing...';

            showToast('Syncing local backups to your Cloudflare R2 bucket...', 'info');

            fetch("{{ route('admin.media.sync') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
            .then(res => res.json())
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
                if (res.success) {
                    showToast(res.message, 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    showToast(res.message || 'Sync failed.', 'error');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
                showToast('Sync failed: ' + err.message, 'error');
            });
        }

        function fetchCloudflareAnalytics() {
            const loader = document.getElementById('analytics-loader');
            const errorDiv = document.getElementById('analytics-error');
            const errorMsg = document.getElementById('analytics-error-msg');
            const dashboard = document.getElementById('analytics-dashboard');

            if (!loader) return;

            loader.style.display = 'flex';
            errorDiv.style.display = 'none';
            dashboard.style.display = 'none';

            fetch("{{ route('admin.cloudflare.analytics') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
            .then(res => res.json())
            .then(res => {
                if (res.success && res.data) {
                    const data = res.data;
                    
                    let totalPageviews = 0;
                    let totalRequests = 0;
                    let totalBytes = 0;
                    let totalCachedRequests = 0;
                    
                    const labels = [];
                    const pageviewsSeries = [];
                    const requestsSeries = [];

                    data.forEach(day => {
                        const sum = day.sum;
                        totalPageviews += parseInt(sum.pageViews || 0);
                        totalRequests += parseInt(sum.requests || 0);
                        totalBytes += parseInt(sum.bytes || 0);
                        totalCachedRequests += parseInt(sum.cachedRequests || 0);

                        // Format date nicely (YYYY-MM-DD to DD MMM)
                        const dateObj = new Date(day.dimensions.date);
                        const formattedDate = dateObj.toLocaleDateString('en-US', { day: 'numeric', month: 'short' });

                        labels.push(formattedDate);
                        pageviewsSeries.push(sum.pageViews || 0);
                        requestsSeries.push(sum.requests || 0);
                    });

                    document.getElementById('stat-pageviews').innerText = totalPageviews.toLocaleString();
                    document.getElementById('stat-requests').innerText = totalRequests.toLocaleString();
                    
                    const cacheRate = totalRequests > 0 ? Math.round((totalCachedRequests / totalRequests) * 100) : 0;
                    document.getElementById('stat-cache').innerText = cacheRate + '%';
                    
                    const bandwidthMb = (totalBytes / (1024 * 1024)).toFixed(1);
                    document.getElementById('stat-bandwidth').innerText = parseFloat(bandwidthMb).toLocaleString() + ' MB';

                    loader.style.display = 'none';
                    dashboard.style.display = 'block';

                    // Render Chart.js
                    const ctx = document.getElementById('cloudflareChart').getContext('2d');
                    if (cloudflareChartInstance) {
                        cloudflareChartInstance.destroy();
                    }

                    cloudflareChartInstance = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Pageviews',
                                    data: pageviewsSeries,
                                    borderColor: '#5ccbb3',
                                    backgroundColor: 'rgba(92, 203, 179, 0.15)',
                                    tension: 0.3,
                                    fill: true,
                                    borderWidth: 3,
                                    pointBackgroundColor: '#5ccbb3',
                                    pointBorderColor: '#ffffff',
                                    pointHoverRadius: 6
                                },
                                {
                                    label: 'Requests',
                                    data: requestsSeries,
                                    borderColor: '#3b82f6',
                                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                    tension: 0.3,
                                    fill: true,
                                    borderWidth: 2,
                                    borderDash: [5, 5],
                                    pointBackgroundColor: '#3b82f6',
                                    pointBorderColor: '#ffffff',
                                    pointHoverRadius: 5
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    labels: {
                                        color: '#ffffff',
                                        font: { family: 'Outfit', size: 12 }
                                    }
                                },
                                tooltip: {
                                    mode: 'index',
                                    intersect: false,
                                    bodyFont: { family: 'Outfit' },
                                    titleFont: { family: 'Outfit', weight: 'bold' }
                                }
                            },
                            scales: {
                                x: {
                                    grid: { color: 'rgba(255, 255, 255, 0.05)' },
                                    ticks: { color: 'rgba(255, 255, 255, 0.6)', font: { family: 'Outfit' } }
                                },
                                y: {
                                    grid: { color: 'rgba(255, 255, 255, 0.05)' },
                                    ticks: { color: 'rgba(255, 255, 255, 0.6)', font: { family: 'Outfit' } }
                                }
                            }
                        }
                    });
                } else {
                    loader.style.display = 'none';
                    errorDiv.style.display = 'block';
                    errorMsg.innerText = res.error || 'Failed to retrieve Cloudflare analytics data.';
                }
            })
            .catch(err => {
                loader.style.display = 'none';
                errorDiv.style.display = 'block';
                errorMsg.innerText = 'Network error fetching Cloudflare analytics: ' + err.message;
            });
        }

        // Switch Tabs logic
        function switchTab(tabId) {
            const panel = document.getElementById('tab-' + tabId);
            const btn = document.getElementById('btn-' + tabId);
            if (!panel || !btn) return;

            document.querySelectorAll('.tab-panel').forEach(p => {
                p.classList.remove('active');
            });
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('active');
            });
            panel.classList.add('active');
            btn.classList.add('active');

            // Save to localStorage to persist tab across refreshes/saves
            localStorage.setItem('active_tab', tabId);

            if (tabId === 'analytics') {
                fetchCloudflareAnalytics();
            }
        }

        // Initialize active tab from localStorage, defaulting to 'leads'
        window.addEventListener('DOMContentLoaded', () => {
            const activeTab = localStorage.getItem('active_tab') || 'leads';
            switchTab(activeTab);
        });

        // Toggle Lead Details
        function toggleLeadDetails(id) {
            const row = document.getElementById('lead-details-' + id);
            if (row.style.display === 'none') {
                row.style.display = 'table-row';
                setTimeout(() => lucide.createIcons(), 10);
            } else {
                row.style.display = 'none';
            }
        }

        // Initialize CKEditor
        let blogEditor;
        ClassicEditor
            .create(document.querySelector('#blog_content'))
            .then(editor => {
                blogEditor = editor;
            })
            .catch(error => {
                console.error(error);
            });

        let serviceIntroEditor;
        let serviceTipsEditor;
        ClassicEditor
            .create(document.querySelector('#ser_intro_content'))
            .then(editor => {
                serviceIntroEditor = editor;
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#ser_tips_content'))
            .then(editor => {
                serviceTipsEditor = editor;
            })
            .catch(error => {
                console.error(error);
            });

        // Blog Edit functions
        function editBlog(data) {
            document.getElementById('blog-form-title-text').innerText = 'Edit Blog Article: ' + data.title;
            document.getElementById('blog-ai-btn').style.display = 'none';
            document.getElementById('blog-form').action = '/admin/blogs/' + data.id + '/update';
            document.getElementById('blog-form-method').value = 'POST';
            document.getElementById('blog_title').value = data.title;
            document.getElementById('blog_slug').value = data.slug;
            document.getElementById('blog_category').value = data.category;
            document.getElementById('blog_published_at').value = data.published_at;
            document.getElementById('blog_summary').value = data.summary;
            if (blogEditor) {
                blogEditor.setData(data.content);
            } else {
                document.getElementById('blog_content').value = data.content;
            }
            document.getElementById('blog-submit-btn').innerText = 'Update Blog Article';
            document.getElementById('blog_image_url').value = (data.image_path && (data.image_path.startsWith('http') || data.image_path.startsWith('//'))) ? data.image_path : '';
            document.getElementById('blog-cancel-btn').style.display = 'inline-block';
            
            document.getElementById('blog-form-container').scrollIntoView({ behavior: 'smooth' });
        }

        function cancelBlogEdit() {
            document.getElementById('blog-form-title-text').innerText = 'Create New Blog Article';
            document.getElementById('blog-ai-btn').style.display = 'inline-flex';
            document.getElementById('blog-form').action = "{{ route('admin.blogs.store') }}";
            document.getElementById('blog-form-method').value = 'POST';
            document.getElementById('blog_title').value = '';
            document.getElementById('blog_slug').value = '';
            document.getElementById('blog_category').selectedIndex = 0;
            document.getElementById('blog_published_at').value = "{{ date('Y-m-d\TH:i') }}";
            document.getElementById('blog_summary').value = '';
            document.getElementById('blog_image_url').value = '';
            if (blogEditor) {
                blogEditor.setData('');
            } else {
                document.getElementById('blog_content').value = '';
            }
            document.getElementById('blog-submit-btn').innerText = 'Publish Blog Article';
            document.getElementById('blog-cancel-btn').style.display = 'none';
        }

        // HTML escaping helper
        function escapeHtml(text) {
            if (!text) return '';
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        // FAQ Repeater actions
        function addFaqInput(question = '', answer = '') {
            const container = document.getElementById('faq-repeater-container');
            const faqRow = document.createElement('div');
            faqRow.className = 'faq-repeater-row';
            faqRow.style = 'background: rgba(255,255,255,0.01); border: 1px solid var(--admin-border); padding: 1rem; border-radius: var(--radius-md); position: relative; margin-bottom: 0.5rem;';
            faqRow.innerHTML = `
                <button type="button" onclick="this.parentElement.remove()" style="position: absolute; right: 10px; top: 10px; background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem;" title="Remove FAQ">&times;</button>
                <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-top: 0.5rem;">
                    <div>
                        <label style="font-size: 0.8rem; color: rgba(255,255,255,0.6); display:block; margin-bottom:0.25rem;">Question</label>
                        <input type="text" name="faq_questions[]" class="form-control" value="${escapeHtml(question)}" required placeholder="e.g. What is the minimum interest rate?">
                    </div>
                    <div>
                        <label style="font-size: 0.8rem; color: rgba(255,255,255,0.6); display:block; margin-bottom:0.25rem;">Answer</label>
                        <textarea name="faq_answers[]" class="form-control" rows="2" required placeholder="e.g. The minimum interest rate starts from 10.49% p.a.">${escapeHtml(answer)}</textarea>
                    </div>
                </div>
            `;
            container.appendChild(faqRow);
            lucide.createIcons();
        }

        // Service Edit functions
        function editService(data) {
            document.getElementById('service-form-title-text').innerText = 'Edit Service Page: ' + data.service_name;
            document.getElementById('service-ai-btn').style.display = 'none';
            document.getElementById('service-form').action = '/admin/services/' + data.id + '/update';
            document.getElementById('service-form-method').value = 'POST';
            
            document.getElementById('ser_service_name').value = data.service_name;
            document.getElementById('ser_slug').value = data.slug;
            document.getElementById('ser_badge').value = data.badge || '';
            document.getElementById('ser_sort_order').value = data.sort_order || 0;
            document.getElementById('ser_hero_category').value = data.hero_category || '';
            document.getElementById('ser_hero_title').value = data.hero_title || '';
            document.getElementById('ser_hero_subtitle').value = data.hero_subtitle || '';
            
            document.getElementById('ser_rate_value').value = data.rate_value || '';
            document.getElementById('ser_max_loan').value = data.max_loan || '';
            document.getElementById('ser_tenure').value = data.tenure || '';
            document.getElementById('ser_intro_title').value = data.intro_title || '';
            
            if (serviceIntroEditor) {
                serviceIntroEditor.setData(data.intro_content || '');
            } else {
                document.getElementById('ser_intro_content').value = data.intro_content || '';
            }
            
            document.getElementById('ser_eligibility_criteria').value = data.eligibility_criteria || '';
            document.getElementById('ser_documents_required').value = data.documents_required || '';
            document.getElementById('ser_tips_title').value = data.tips_title || '';
            
            if (serviceTipsEditor) {
                serviceTipsEditor.setData(data.tips_content || '');
            } else {
                document.getElementById('ser_tips_content').value = data.tips_content || '';
            }
            
            document.getElementById('ser_summary').value = data.summary || '';
            document.getElementById('ser_is_active').checked = !!data.is_active;
            
            // Clear and rebuild FAQs
            const container = document.getElementById('faq-repeater-container');
            container.innerHTML = '';
            
            let faqs = [];
            if (typeof data.faqs === 'string') {
                try {
                    faqs = JSON.parse(data.faqs);
                } catch(e) {
                    console.error("Failed to parse FAQs JSON string", e);
                }
            } else if (Array.isArray(data.faqs)) {
                faqs = data.faqs;
            }
            
            if (faqs && faqs.length > 0) {
                faqs.forEach(faq => {
                    addFaqInput(faq.question, faq.answer);
                });
            }
            
            document.getElementById('service-submit-btn').innerText = 'Update Service Page';
            document.getElementById('service-cancel-btn').style.display = 'inline-block';
            document.getElementById('service-form-container').scrollIntoView({ behavior: 'smooth' });
        }

        function cancelServiceEdit() {
            document.getElementById('service-form-title-text').innerText = 'Create New Service Page';
            document.getElementById('service-ai-btn').style.display = 'inline-flex';
            document.getElementById('service-form').action = "{{ route('admin.services.store') }}";
            document.getElementById('service-form-method').value = 'POST';
            
            document.getElementById('ser_service_name').value = '';
            document.getElementById('ser_slug').value = '';
            document.getElementById('ser_badge').value = '';
            document.getElementById('ser_sort_order').value = 0;
            document.getElementById('ser_hero_category').value = '';
            document.getElementById('ser_hero_title').value = '';
            document.getElementById('ser_hero_subtitle').value = '';
            
            document.getElementById('ser_rate_value').value = '';
            document.getElementById('ser_max_loan').value = '';
            document.getElementById('ser_tenure').value = '';
            document.getElementById('ser_intro_title').value = '';
            
            if (serviceIntroEditor) {
                serviceIntroEditor.setData('');
            } else {
                document.getElementById('ser_intro_content').value = '';
            }
            
            document.getElementById('ser_eligibility_criteria').value = '';
            document.getElementById('ser_documents_required').value = '';
            document.getElementById('ser_tips_title').value = '';
            
            if (serviceTipsEditor) {
                serviceTipsEditor.setData('');
            } else {
                document.getElementById('ser_tips_content').value = '';
            }
            
            document.getElementById('ser_summary').value = '';
            document.getElementById('ser_is_active').checked = true;
            
            document.getElementById('faq-repeater-container').innerHTML = '';
            
            document.getElementById('service-submit-btn').innerText = 'Create Service Page';
            document.getElementById('service-cancel-btn').style.display = 'none';
        }

        // Bank Edit functions
        function editBank(data) {
            document.getElementById('bank-form-title').innerText = 'Edit Lender: ' + data.name;
            document.getElementById('bank-form').action = '/admin/banks/' + data.id + '/update';
            document.getElementById('bank-form-method').value = 'POST';
            
            document.getElementById('bank_name').value = data.name;
            document.getElementById('bank_sector').value = data.sector;
            document.getElementById('bank_home_rate').value = data.home_rate;
            document.getElementById('bank_personal_rate').value = data.personal_rate;
            document.getElementById('bank_business_rate').value = data.business_rate;
            document.getElementById('bank_fee_percent').value = data.fee_percent;
            document.getElementById('bank_sort_order').value = data.sort_order || 0;
            
            document.getElementById('bank-submit-btn').innerText = 'Update Bank Comparison';
            document.getElementById('bank-cancel-btn').style.display = 'inline-block';
            document.getElementById('bank-form-container').scrollIntoView({ behavior: 'smooth' });
        }

        function cancelBankEdit() {
            document.getElementById('bank-form-title').innerText = 'Add New Lender / Bank';
            document.getElementById('bank-form').action = "{{ route('admin.banks.store') }}";
            document.getElementById('bank-form-method').value = 'POST';
            
            document.getElementById('bank_name').value = '';
            document.getElementById('bank_sector').selectedIndex = 0;
            document.getElementById('bank_home_rate').value = '';
            document.getElementById('bank_personal_rate').value = '';
            document.getElementById('bank_business_rate').value = '';
            document.getElementById('bank_fee_percent').value = '';
            document.getElementById('bank_sort_order').value = 0;
            
            document.getElementById('bank-submit-btn').innerText = 'Add Bank Comparison';
            document.getElementById('bank-cancel-btn').style.display = 'none';
        }

        // Copy URL Helper
        function copyToClipboard(text, button) {
            navigator.clipboard.writeText(text).then(() => {
                const originalText = button.innerHTML;
                button.innerHTML = '<i data-lucide="check" style="width: 12px; height: 12px;"></i> Copied!';
                button.style.backgroundColor = 'var(--accent-teal)';
                button.style.color = '#fff';
                lucide.createIcons();
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.style.backgroundColor = '';
                    button.style.color = '';
                    lucide.createIcons();
                }, 2000);
            }).catch(err => {
                alert('Failed to copy link: ' + err);
            });
        }

        // AJAX Media Upload Helper
        function uploadMediaFile(input) {
            if (input.files.length === 0) return;
            
            const file = input.files[0];
            const formData = new FormData();
            formData.append('file', file);
            formData.append('_token', "{{ csrf_token() }}");
            
            const progressContainer = document.getElementById('media-upload-progress');
            const progressBar = document.getElementById('media-progress-bar');
            
            progressContainer.style.display = 'block';
            progressBar.style.width = '0%';
            
            const xhr = new XMLHttpRequest();
            xhr.open('POST', "{{ route('admin.media.upload') }}", true);
            
            xhr.upload.onprogress = function(e) {
                if (e.lengthComputable) {
                    const percentage = (e.loaded / e.total) * 100;
                    progressBar.style.width = percentage + '%';
                }
            };
            
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert('Image uploaded and optimized to WebP successfully!');
                        location.reload();
                    } else {
                        alert('Upload failed: ' + (response.message || 'Unknown error'));
                    }
                } else {
                    alert('Upload failed with status ' + xhr.status);
                }
                progressContainer.style.display = 'none';
            };
            
            xhr.onerror = function() {
                alert('Network error during upload.');
                progressContainer.style.display = 'none';
            };
            
            xhr.send(formData);
        }

        // AI Generation UI & AJAX Helpers
        function openAiModal(type) {
            const overlay = document.getElementById('ai-' + type + '-modal');
            if (overlay) {
                overlay.style.display = 'flex';
                setTimeout(() => overlay.classList.add('show'), 10);
            }
        }

        function closeAiModal(type) {
            const overlay = document.getElementById('ai-' + type + '-modal');
            if (overlay) {
                overlay.classList.remove('show');
                setTimeout(() => {
                    overlay.style.display = 'none';
                    const formWrapper = document.getElementById('ai-' + type + '-form-wrapper');
                    const loader = document.getElementById('ai-' + type + '-loader');
                    if (formWrapper) formWrapper.style.display = 'block';
                    if (loader) loader.style.display = 'none';
                    
                    const promptInput = document.getElementById('ai_' + type + '_prompt');
                    if (promptInput) promptInput.value = '';

                    const previewBox = document.getElementById('ai-image-preview-container');
                    if (previewBox) previewBox.style.display = 'none';
                }, 300);
            }
        }

        // Toast Notification System
        function showToast(title, message, type = 'info', uniqueId = null) {
            const container = document.getElementById('ai-toast-container');
            if (!container) return null;

            let toast = uniqueId ? document.getElementById(uniqueId) : null;
            let isNew = false;

            if (!toast) {
                isNew = true;
                toast = document.createElement('div');
                toast.className = 'ai-toast';
                if (uniqueId) toast.id = uniqueId;
            }

            let iconHtml = '';
            if (type === 'info') {
                iconHtml = '<div class="ai-toast-spinner"></div>';
            } else if (type === 'success') {
                iconHtml = '<div class="ai-toast-success-icon"><i data-lucide="check-circle" style="width: 20px; height: 20px;"></i></div>';
            } else if (type === 'error') {
                iconHtml = '<div class="ai-toast-error-icon"><i data-lucide="alert-triangle" style="width: 20px; height: 20px;"></i></div>';
            }

            toast.innerHTML = `
                ${iconHtml}
                <div class="ai-toast-content">
                    <div class="ai-toast-title">${title}</div>
                    <p class="ai-toast-message">${message}</p>
                </div>
                <button class="ai-toast-close" onclick="this.parentElement.remove()">&times;</button>
            `;

            if (isNew) {
                container.appendChild(toast);
            }

            lucide.createIcons();

            if (Notification.permission === 'granted' && isNew) {
                try {
                    new Notification(title, { body: message });
                } catch(e) {}
            }

            if (type !== 'info') {
                setTimeout(() => {
                    if (toast && toast.parentElement) {
                        toast.style.transform = 'translateX(120%)';
                        toast.style.opacity = '0';
                        setTimeout(() => toast.remove(), 300);
                    }
                }, 6000);
            }

            return toast;
        }

        if (typeof Notification !== 'undefined' && Notification.permission === 'default') {
            Notification.requestPermission();
        }

        function generateAiBlog() {
            const prompt = document.getElementById('ai_blog_prompt').value.trim();
            const tone = document.getElementById('ai_blog_tone').value;
            const generateImage = document.getElementById('ai_blog_gen_image').checked;

            if (!prompt) {
                alert('Please enter a description or topic for the blog article.');
                return;
            }

            const formWrapper = document.getElementById('ai-blog-form-wrapper');
            const loader = document.getElementById('ai-blog-loader');

            formWrapper.style.display = 'none';
            loader.style.display = 'flex';

            // Generate blog text FIRST (without image to keep it fast!)
            fetch("{{ route('admin.ai.blog') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    prompt: prompt,
                    tone: tone,
                    generate_image: false
                })
            })
            .then(res => res.json())
            .then(res => {
                if (res.success && res.data) {
                    const data = res.data;
                    document.getElementById('blog_title').value = data.title || '';
                    document.getElementById('blog_category').value = data.category || 'Financial Tips';
                    document.getElementById('blog_summary').value = data.summary || '';
                    
                    if (blogEditor) {
                        blogEditor.setData(data.content || '');
                    } else {
                        document.getElementById('blog_content').value = data.content || '';
                    }

                    closeAiModal('blog');
                    
                    // Now, if generateImage was checked, kick off background cover image generation!
                    if (generateImage) {
                        const imgPrompt = data.image_prompt || prompt;
                        
                        showToast("Generating Blog Cover", "AI is rendering cover image in the background...", "info", "ai-blog-cover-job");
                        
                        fetch("{{ route('admin.ai.image') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                prompt: imgPrompt,
                                aspect_ratio: "16:9"
                            })
                        })
                        .then(imgRes => imgRes.json())
                        .then(imgRes => {
                            if (imgRes.success && imgRes.url) {
                                document.getElementById('blog_image_url').value = imgRes.url;
                                showToast("Cover Image Attached!", "AI cover image generated and attached to blog form successfully.", "success", "ai-blog-cover-job");
                            } else {
                                showToast("Cover Image Failed", imgRes.error || "Failed to generate cover image. You can upload or paste a link manually.", "error", "ai-blog-cover-job");
                            }
                        })
                        .catch(err => {
                            showToast("Cover Image Failed", "Network error during cover image generation.", "error", "ai-blog-cover-job");
                        });
                    } else {
                        alert('AI generated draft successfully! Please review the form before publishing.');
                    }
                    
                    document.getElementById('blog-form-container').scrollIntoView({ behavior: 'smooth' });
                } else {
                    alert('AI Generation Error: ' + (res.error || 'Failed to generate blog article.'));
                    formWrapper.style.display = 'block';
                    loader.style.display = 'none';
                }
            })
            .catch(err => {
                alert('Network Error: ' + err.message);
                formWrapper.style.display = 'block';
                loader.style.display = 'none';
            });
        }

        function generateAiService() {
            const prompt = document.getElementById('ai_service_prompt').value.trim();
            const tone = document.getElementById('ai_service_tone').value;

            if (!prompt) {
                alert('Please enter a description for the service page.');
                return;
            }

            const formWrapper = document.getElementById('ai-service-form-wrapper');
            const loader = document.getElementById('ai-service-loader');

            formWrapper.style.display = 'none';
            loader.style.display = 'flex';

            fetch("{{ route('admin.ai.service') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    prompt: prompt,
                    tone: tone
                })
            })
            .then(res => res.json())
            .then(res => {
                if (res.success && res.data) {
                    const data = res.data;
                    
                    document.getElementById('ser_service_name').value = data.service_name || '';
                    if (data.service_name) {
                        const slug = data.service_name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
                        document.getElementById('ser_slug').value = slug;
                    }
                    
                    document.getElementById('ser_badge').value = data.badge || '';
                    document.getElementById('ser_hero_category').value = data.hero_category || '';
                    document.getElementById('ser_hero_title').value = data.hero_title || '';
                    document.getElementById('ser_hero_subtitle').value = data.hero_subtitle || '';
                    
                    document.getElementById('ser_rate_value').value = data.rate_value || '';
                    document.getElementById('ser_max_loan').value = data.max_loan || '';
                    document.getElementById('ser_tenure').value = data.tenure || '';
                    document.getElementById('ser_intro_title').value = data.intro_title || '';
                    
                    if (serviceIntroEditor) {
                        serviceIntroEditor.setData(data.intro_content || '');
                    } else {
                        document.getElementById('ser_intro_content').value = data.intro_content || '';
                    }
                    
                    document.getElementById('ser_eligibility_criteria').value = data.eligibility_criteria || '';
                    document.getElementById('ser_documents_required').value = data.documents_required || '';
                    document.getElementById('ser_tips_title').value = data.tips_title || '';
                    
                    if (serviceTipsEditor) {
                        serviceTipsEditor.setData(data.tips_content || '');
                    } else {
                        document.getElementById('ser_tips_content').value = data.tips_content || '';
                    }
                    
                    document.getElementById('ser_summary').value = data.summary || '';

                    // Clear existing FAQs
                    const faqContainer = document.getElementById('faq-repeater-container');
                    faqContainer.innerHTML = '';

                    // Populate FAQs
                    if (data.faqs && Array.isArray(data.faqs)) {
                        data.faqs.forEach(faq => {
                            addFaqInput(faq.question, faq.answer);
                        });
                    }

                    closeAiModal('service');
                    alert('AI generated service page details successfully! Please review the form before saving.');
                    document.getElementById('service-form-container').scrollIntoView({ behavior: 'smooth' });
                } else {
                    alert('AI Generation Error: ' + (res.error || 'Failed to generate service page.'));
                    formWrapper.style.display = 'block';
                    loader.style.display = 'none';
                }
            })
            .catch(err => {
                alert('Network Error: ' + err.message);
                formWrapper.style.display = 'block';
                loader.style.display = 'none';
            });
        }

        function generateAiImage() {
            const prompt = document.getElementById('ai_image_prompt').value.trim();
            const ratio = document.getElementById('ai_image_aspect_ratio').value;

            if (!prompt) {
                alert('Please describe the image you want to generate.');
                return;
            }

            // Close modal immediately and run in background!
            closeAiModal('image');
            
            const jobId = "ai-image-job-" + Date.now();
            showToast("Generating AI Image", "Gemini is rendering your picture in the background...", "info", jobId);

            fetch("{{ route('admin.ai.image') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    prompt: prompt,
                    aspect_ratio: ratio
                })
            })
            .then(res => res.json())
            .then(res => {
                if (res.success && res.url) {
                    const toast = showToast("AI Image Ready!", "Your generated image is ready and saved to the library.", "success", jobId);
                    
                    // Add Copy URL button directly in the background toast success notification!
                    const copyBtn = document.createElement('button');
                    copyBtn.className = 'btn-submit';
                    copyBtn.style = 'margin-top: 8px; font-size: 0.75rem; padding: 4px 8px; width: auto; display: inline-flex; align-items: center; gap: 4px;';
                    copyBtn.innerHTML = '<i data-lucide="copy" style="width: 12px; height: 12px;"></i> Copy URL';
                    const fullUrl = res.url.startsWith('http') || res.url.startsWith('//') || res.url.startsWith('/') 
                        ? res.url 
                        : ("{{ asset('storage') }}/" + res.url);
                    copyBtn.onclick = function() {
                        copyToClipboard(fullUrl, copyBtn);
                    };
                    
                    toast.querySelector('.ai-toast-content').appendChild(copyBtn);
                    lucide.createIcons();
                } else {
                    showToast("AI Generation Failed", res.error || "Failed to generate picture in background.", "error", jobId);
                }
            })
            .catch(err => {
                showToast("AI Generation Failed", "Network error during background image generation.", "error", jobId);
            });
        }
    </script>
</body>
</html>
