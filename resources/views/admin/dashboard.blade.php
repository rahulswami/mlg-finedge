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
            color-scheme: dark;
            --admin-sidebar-w: 260px;
            --admin-dark-bg: #111b1c;
            --admin-dark-sidebar: #0a1112;
            --admin-border: rgba(255,255,255,0.08);
            --admin-text-muted: rgba(255,255,255,0.5);
            --admin-input-bg: rgba(255,255,255,0.04);
            --primary-teal: #5ccbb3;
            --mint-green: #5ccbb3;
        }
        
        html, body {
            color-scheme: dark;
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
            overflow-y: auto;
            max-height: 100vh;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), padding 0.3s ease, border-color 0.3s ease;
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

        /* Select Form Controls Base Dark Styling */
        select.form-control {
            color-scheme: dark;
            background-color: var(--admin-dark-bg);
            color: #ffffff;
            border: 1px solid var(--admin-border);
            padding: 0.75rem 2.5rem 0.75rem 1rem;
            border-radius: var(--radius-md);
            font-family: 'Outfit', sans-serif;
            font-size: 0.95rem;
            line-height: 1.5;
            height: 46px;
            cursor: pointer;
            box-sizing: border-box;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23ffffff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 16px 16px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        select.form-control:focus {
            outline: none;
            border-color: var(--mint-green);
            box-shadow: 0 0 0 2px rgba(92, 203, 179, 0.25);
            background-color: var(--admin-dark-bg);
        }

        /* Specific Category Dropdown Styling to match screenshot */
        #blog_category {
            color-scheme: dark;
            background-color: var(--admin-dark-bg);
            color: #ffffff;
            border: 1px solid var(--mint-green) !important;
            padding: 0.75rem 2.5rem 0.75rem 1rem;
            border-radius: var(--radius-md);
            font-family: 'Outfit', sans-serif;
            font-size: 0.95rem;
            line-height: 1.5;
            height: 46px;
            cursor: pointer;
            box-sizing: border-box;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23ffffff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 16px 16px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            transition: all 0.3s ease;
        }

        #blog_category:focus,
        #blog_category:hover {
            outline: none;
            border-color: var(--mint-green);
            box-shadow: 0 0 0 3px rgba(92, 203, 179, 0.25);
            background-color: var(--admin-dark-bg);
        }

        /* Dropdown options styling: dark background, white text, no white blank area */
        select.form-control option,
        #blog_category option {
            color-scheme: dark;
            background-color: #111b1c !important;
            color: #ffffff !important;
            padding: 10px 14px;
            font-size: 0.95rem;
            font-family: 'Outfit', sans-serif;
        }

        select.form-control option:hover,
        select.form-control option:checked,
        select.form-control option:focus,
        #blog_category option:hover,
        #blog_category option:checked,
        #blog_category option:focus {
            background-color: #192a2b !important;
            color: var(--mint-green) !important;
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

        /* Custom Scrollbar for Main Content, Sidebar, Mobile Scroll, and Tables */
        .admin-content, .sidebar, .mobile-tabs-scroll, .admin-table-wrap {
            --scrollbar-thumb: var(--mint-green);
            --scrollbar-track: rgba(255, 255, 255, 0.02);
            scrollbar-color: var(--scrollbar-thumb) var(--scrollbar-track);
            scrollbar-width: thin;
        }
        @supports not (scrollbar-color: auto) {
            .admin-content::-webkit-scrollbar,
            .sidebar::-webkit-scrollbar,
            .mobile-tabs-scroll::-webkit-scrollbar,
            .admin-table-wrap::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }
            .admin-content::-webkit-scrollbar-thumb,
            .sidebar::-webkit-scrollbar-thumb,
            .mobile-tabs-scroll::-webkit-scrollbar-thumb,
            .admin-table-wrap::-webkit-scrollbar-thumb {
                background: var(--scrollbar-thumb);
                border-radius: 3px;
            }
            .admin-content::-webkit-scrollbar-track,
            .sidebar::-webkit-scrollbar-track,
            .mobile-tabs-scroll::-webkit-scrollbar-track,
            .admin-table-wrap::-webkit-scrollbar-track {
                background: var(--scrollbar-track);
            }
        }

        /* Mobile Hamburger & Close buttons */
        .mobile-toggle-btn {
            display: inline-flex;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--admin-border);
            color: #ffffff;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-md);
            transition: all 0.2s ease;
            width: 40px;
            height: 40px;
        }
        .mobile-toggle-btn:hover {
            background-color: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
            color: var(--mint-green);
        }

        .sidebar-close-btn {
            display: none;
            background: none;
            border: none;
            color: var(--admin-text-muted);
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.25rem;
            align-items: center;
            justify-content: center;
            margin-left: auto;
            border-radius: var(--radius-sm);
            transition: color 0.2s;
        }
        .sidebar-close-btn:hover {
            color: #ff6b6b;
        }

        /* Mobile Backdrop */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1040;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .sidebar-backdrop.show {
            display: block;
            opacity: 1;
        }

        /* Mobile Swipe Tab Strip */
        .mobile-tabs-scroll {
            display: none;
            gap: 8px;
            overflow-x: auto;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--admin-border);
            background-color: var(--admin-dark-sidebar);
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none; /* Hide for firefox */
        }
        .mobile-tabs-scroll::-webkit-scrollbar {
            display: none; /* Hide for Chrome/Safari */
        }
        .mobile-tab-btn {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--admin-border);
            color: var(--admin-text-muted);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-family: 'Outfit', sans-serif;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .mobile-tab-btn:hover, .mobile-tab-btn.active {
            color: var(--mint-green);
            background-color: rgba(92, 203, 179, 0.08);
            border-color: var(--mint-green);
        }

        @media (min-width: 992px) {
            body.sidebar-collapsed .sidebar {
                width: 0;
                padding-left: 0;
                padding-right: 0;
                border-right-color: transparent;
                overflow: hidden;
            }
            body.sidebar-collapsed {
                --admin-sidebar-w: 0px;
            }
        }

        /* Media Queries for Layout Responsiveness */
        @media (max-width: 991.98px) {
            body {
                flex-direction: column;
                height: 100vh;
                overflow: hidden;
            }
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                z-index: 1050;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                height: 100%;
                box-shadow: 20px 0 30px rgba(0, 0, 0, 0.5);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .sidebar-close-btn {
                display: inline-flex;
            }
            .mobile-toggle-btn {
                display: inline-flex;
            }
            .mobile-tabs-scroll {
                display: flex;
            }
            .admin-header {
                padding: 0 1rem;
            }
            .admin-content {
                padding: 1.25rem;
            }
            .admin-card {
                padding: 1.25rem;
                margin-bottom: 1.25rem;
            }
            /* Form grid styling */
            .form-grid {
                grid-template-columns: repeat(auto-fit, minmax(min(100%, 260px), 1fr));
                gap: 1rem;
            }
            .ai-toast {
                max-width: calc(100vw - 40px);
            }
        }

        @media (max-width: 575.98px) {
            .admin-header h1 {
                font-size: 1.2rem;
            }
            .admin-user span {
                display: none; /* Hide user name on small mobile, keep avatar */
            }
            .admin-card h2 {
                font-size: 1.1rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            .admin-card h2 button {
                width: 100%;
                justify-content: center;
            }
            .btn-submit {
                width: 100%;
                text-align: center;
            }
            /* Form fields */
            .form-group[style*="grid-column: span 2"] {
                grid-column: span 1 !important;
            }
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
            <button class="sidebar-close-btn" onclick="toggleSidebar()" aria-label="Close Sidebar">
                <i data-lucide="x"></i>
            </button>
        </div>
        
        <ul class="sidebar-menu">
            <li class="menu-item"><button onclick="switchTab('general')" class="tab-btn" id="btn-general"><i data-lucide="settings"></i> General Settings</button></li>
            <li class="menu-item"><button onclick="switchTab('leads')" class="tab-btn active" id="btn-leads"><i data-lucide="inbox"></i> Leads Manager</button></li>
            <li class="menu-item"><button onclick="switchTab('branding')" class="tab-btn" id="btn-branding"><i data-lucide="image"></i> Branding & Logos</button></li>
            <li class="menu-item"><button onclick="switchTab('slider')" class="tab-btn" id="btn-slider"><i data-lucide="sliders"></i> Homepage Slider</button></li>
            <li class="menu-item"><button onclick="switchTab('testimonials')" class="tab-btn" id="btn-testimonials"><i data-lucide="users"></i> Testimonials</button></li>
            <li class="menu-item"><button onclick="switchTab('styling')" class="tab-btn" id="btn-styling"><i data-lucide="palette"></i> Section Backgrounds</button></li>
            <li class="menu-item"><button onclick="switchTab('pagecontents')" class="tab-btn" id="btn-pagecontents"><i data-lucide="file-text"></i> Page Editor</button></li>
            <li class="menu-item"><button onclick="switchTab('landing')" class="tab-btn" id="btn-landing"><i data-lucide="layout"></i> AI Landing Pages</button></li>
            <li class="menu-item"><button onclick="switchTab('services')" class="tab-btn" id="btn-services"><i data-lucide="layers"></i> Services Manager</button></li>
            <li class="menu-item"><button onclick="switchTab('banks')" class="tab-btn" id="btn-banks"><i data-lucide="landmark"></i> Bank Comparison</button></li>
            <li class="menu-item"><button onclick="switchTab('blogs')" class="tab-btn" id="btn-blogs"><i data-lucide="book-open"></i> Blog Manager</button></li>
            <li class="menu-item"><button onclick="switchTab('media')" class="tab-btn" id="btn-media"><i data-lucide="hard-drive"></i> Media Manager</button></li>
            <li class="menu-item"><button onclick="switchTab('analytics')" class="tab-btn" id="btn-analytics"><i data-lucide="bar-chart-2"></i> Web Analytics</button></li>
            <li class="menu-item"><button onclick="switchTab('seo')" class="tab-btn" id="btn-seo"><i data-lucide="trending-up"></i> SEO Optimizer</button></li>
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

    <!-- Sidebar Backdrop for Mobile -->
    <div class="sidebar-backdrop" id="sidebar-backdrop" onclick="toggleSidebar()"></div>

    <!-- Main Content Panel -->
    <div class="main-panel">
        <div class="admin-header">
            <div style="display: flex; align-items: center; gap: 10px;">
                <button class="mobile-toggle-btn" onclick="toggleSidebar()" aria-label="Toggle Sidebar">
                    <i data-lucide="menu"></i>
                </button>
                <h1>CMS Control Panel</h1>
            </div>
            <div style="display: flex; gap: 1.5rem; align-items: center;">
                <div class="admin-user">
                    <span>{{ Auth::user()->name }}</span>
                    <div class="admin-user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                </div>
            </div>
        </div>

        <!-- Mobile Quick-Switch Tabs -->
        <div class="mobile-tabs-scroll">
            <button onclick="switchTab('general')" class="mobile-tab-btn" id="m-btn-general"><i data-lucide="settings" style="width: 14px; height: 14px;"></i> General</button>
            <button onclick="switchTab('leads')" class="mobile-tab-btn" id="m-btn-leads"><i data-lucide="inbox" style="width: 14px; height: 14px;"></i> Leads</button>
            <button onclick="switchTab('branding')" class="mobile-tab-btn" id="m-btn-branding"><i data-lucide="image" style="width: 14px; height: 14px;"></i> Branding</button>
            <button onclick="switchTab('slider')" class="mobile-tab-btn" id="m-btn-slider"><i data-lucide="sliders" style="width: 14px; height: 14px;"></i> Slider</button>
            <button onclick="switchTab('testimonials')" class="mobile-tab-btn" id="m-btn-testimonials"><i data-lucide="users" style="width: 14px; height: 14px;"></i> Testimonials</button>
            <button onclick="switchTab('styling')" class="mobile-tab-btn" id="m-btn-styling"><i data-lucide="palette" style="width: 14px; height: 14px;"></i> Styling</button>
            <button onclick="switchTab('pagecontents')" class="mobile-tab-btn" id="m-btn-pagecontents"><i data-lucide="file-text" style="width: 14px; height: 14px;"></i> Pages</button>
            <button onclick="switchTab('landing')" class="mobile-tab-btn" id="m-btn-landing"><i data-lucide="layout" style="width: 14px; height: 14px;"></i> AI Pages</button>
            <button onclick="switchTab('services')" class="mobile-tab-btn" id="m-btn-services"><i data-lucide="layers" style="width: 14px; height: 14px;"></i> Services</button>
            <button onclick="switchTab('banks')" class="mobile-tab-btn" id="m-btn-banks"><i data-lucide="landmark" style="width: 14px; height: 14px;"></i> Banks</button>
            <button onclick="switchTab('blogs')" class="mobile-tab-btn" id="m-btn-blogs"><i data-lucide="book-open" style="width: 14px; height: 14px;"></i> Blogs</button>
            <button onclick="switchTab('media')" class="mobile-tab-btn" id="m-btn-media"><i data-lucide="hard-drive" style="width: 14px; height: 14px;"></i> Media</button>
            <button onclick="switchTab('analytics')" class="mobile-tab-btn" id="m-btn-analytics"><i data-lucide="bar-chart-2" style="width: 14px; height: 14px;"></i> Analytics</button>
            <button onclick="switchTab('seo')" class="mobile-tab-btn" id="m-btn-seo"><i data-lucide="trending-up" style="width: 14px; height: 14px;"></i> SEO</button>
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
            @if($errors->any())
                <div class="alert-success" style="background-color: rgba(255,107,107,0.12); border-color: rgba(255,107,107,0.35); color: #ff6b6b; display: block; padding: 1rem 1.25rem;">
                    <div style="display: flex; align-items: center; gap: 8px; font-weight: 600; margin-bottom: 6px;">
                        <i data-lucide="alert-triangle"></i>
                        <span>Validation errors occurred:</span>
                    </div>
                    <ul style="margin: 0; padding-left: 20px; list-style-type: disc;">
                        @foreach($errors->all() as $err)
                            <li style="margin-bottom: 3px;">{{ $err }}</li>
                        @endforeach
                    </ul>
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
                        <h2>Social Media Profiles</h2>
                        <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.5rem; margin-top: -1rem;">Add links to your official social media pages to show them in the footer.</p>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="social_facebook">Facebook URL</label>
                                <input type="url" id="social_facebook" name="social_facebook" class="form-control" value="{{ $site['social_facebook'] ?? '' }}" placeholder="https://facebook.com/yourpage">
                            </div>
                            <div class="form-group">
                                <label for="social_instagram">Instagram URL</label>
                                <input type="url" id="social_instagram" name="social_instagram" class="form-control" value="{{ $site['social_instagram'] ?? '' }}" placeholder="https://instagram.com/yourusername">
                            </div>
                            <div class="form-group">
                                <label for="social_linkedin">LinkedIn URL</label>
                                <input type="url" id="social_linkedin" name="social_linkedin" class="form-control" value="{{ $site['social_linkedin'] ?? '' }}" placeholder="https://linkedin.com/company/yourcompany">
                            </div>
                            <div class="form-group">
                                <label for="social_twitter">Twitter / X URL</label>
                                <input type="url" id="social_twitter" name="social_twitter" class="form-control" value="{{ $site['social_twitter'] ?? '' }}" placeholder="https://twitter.com/yourhandle">
                            </div>
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

                    <div class="admin-card" id="gemini-ai-settings-card" style="border-left: 4px solid var(--mint-green);">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 10px; margin-bottom: 1rem;">
                            <div>
                                <h2 style="margin: 0; display: flex; align-items: center; gap: 8px;">
                                    <i data-lucide="sparkles" style="color: var(--mint-green);"></i> Google Gemini AI & Model Settings
                                </h2>
                                <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-top: 4px;">
                                    Configure your Google Gemini API Key, select your active generative model, and run real-time multi-model diagnostic tests.
                                </p>
                            </div>
                            <a href="https://aistudio.google.com/app/apikey" target="_blank" class="btn-submit" style="padding: 0.45rem 0.9rem; font-size: 0.8rem; width: auto; display: inline-flex; align-items: center; gap: 6px; background: rgba(92,203,179,0.15); color: var(--mint-green); border: 1px solid rgba(92,203,179,0.3);">
                                <i data-lucide="external-link" style="width: 14px; height: 14px;"></i> Get Free Key from Google AI Studio
                            </a>
                        </div>

                        <div class="form-grid" style="grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                            <!-- Gemini API Key with Show/Hide Toggle & Format Check -->
                            <div class="form-group" style="grid-column: span 2;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <label for="gemini_api_key" style="margin-bottom: 0; font-weight: 600;">Google Gemini API Key</label>
                                    <span id="gemini-key-format-badge" style="font-size: 0.75rem; padding: 2px 8px; border-radius: 4px; display: none;"></span>
                                </div>
                                <div style="position: relative; display: flex; align-items: center;">
                                    <input type="password" id="gemini_api_key" name="gemini_api_key" class="form-control" value="{{ $site['gemini_api_key'] ?? '' }}" placeholder="AIzaSy..." oninput="checkGeminiKeyFormat()" style="padding-right: 45px; font-family: monospace;">
                                    <button type="button" onclick="toggleGeminiKeyVisibility()" style="position: absolute; right: 10px; background: transparent; border: none; color: var(--admin-text-muted); cursor: pointer; padding: 4px;">
                                        <i data-lucide="eye" id="gemini-eye-icon" style="width: 18px; height: 18px;"></i>
                                    </button>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 5px; flex-wrap: wrap; gap: 5px;">
                                    <span style="font-size: 0.75rem; color: var(--admin-text-muted);">
                                        Valid Google AI Studio keys start with <code>AIzaSy...</code> (~39 characters).
                                    </span>
                                </div>
                            </div>

                            <!-- Active Gemini Model Selector -->
                            <div class="form-group">
                                <label for="gemini_model" style="font-weight: 600;">Active AI Engine Model</label>
                                @php
                                    $activeModel = $site['gemini_model'] ?? 'gemini-2.0-flash';
                                @endphp
                                <select id="gemini_model" name="gemini_model" class="form-control">
                                    <option value="gemini-2.0-flash" @selected($activeModel === 'gemini-2.0-flash')>gemini-2.0-flash (Recommended - Next-Gen Ultra Fast)</option>
                                    <option value="gemini-1.5-flash" @selected($activeModel === 'gemini-1.5-flash')>gemini-1.5-flash (High Quota & Production Stable)</option>
                                    <option value="gemini-1.5-pro" @selected($activeModel === 'gemini-1.5-pro')>gemini-1.5-pro (Deep Reasoning & Advanced SEO)</option>
                                    <option value="gemini-2.5-flash" @selected($activeModel === 'gemini-2.5-flash')>gemini-2.5-flash (Experimental / Preview)</option>
                                    <option value="gemini-1.0-pro" @selected($activeModel === 'gemini-1.0-pro')>gemini-1.0-pro (Legacy Compatibility)</option>
                                </select>
                                <span style="font-size: 0.75rem; color: var(--admin-text-muted); margin-top: 4px; display: block;">
                                    The system automatically cascades to fallback models if the selected model is unavailable.
                                </span>
                            </div>

                            <!-- Interactive Diagnostics Action Bar -->
                            <div class="form-group" style="display: flex; flex-direction: column; justify-content: flex-end;">
                                <label style="font-weight: 600; margin-bottom: 0.5rem;">Key & Model Live Diagnostics</label>
                                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    <button type="button" class="btn-submit" onclick="runGeminiModelTest('selected')" style="padding: 0.65rem 1rem; font-size: 0.82rem; width: auto; background: var(--mint-green); color: var(--primary-teal-dark); font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                        <i data-lucide="zap" style="width: 14px; height: 14px;"></i> Test Selected Model
                                    </button>
                                    <button type="button" class="btn-submit" onclick="runGeminiModelTest('all')" style="padding: 0.65rem 1rem; font-size: 0.82rem; width: auto; background: var(--admin-input-bg); color: #fff; display: inline-flex; align-items: center; gap: 6px; border: 1px solid var(--admin-border);">
                                        <i data-lucide="activity" style="width: 14px; height: 14px;"></i> Test All 5 Models
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Live Diagnostic Test Results Container -->
                        <div id="ai-test-results-box" style="display: none; margin-top: 1.5rem; background: #070c0d; border: 1px solid var(--admin-border); border-radius: var(--radius-md); padding: 1.25rem;">
                            <!-- Dynamically populated via JS -->
                        </div>

                        <!-- Google Business Profile Settings -->
                        <div style="border-top: 1px solid var(--admin-border); margin-top: 1.5rem; padding-top: 1.25rem;">
                            <h3 style="font-size: 1rem; margin: 0 0 1rem 0; color: #fff; display: flex; align-items: center; gap: 8px;">
                                <i data-lucide="map-pin" style="color: var(--accent-orange);"></i> Google My Business & Reviews Integration
                            </h3>
                            <div class="form-grid">
                                <div class="form-group" style="grid-column: span 2;">
                                    <label for="google_my_business_link">Google My Business Reviews Link</label>
                                    <input type="text" id="google_my_business_link" name="google_my_business_link" class="form-control" value="{{ $site['google_my_business_link'] ?? '' }}" placeholder="https://maps.app.goo.gl/... or https://g.page/r/...">
                                    <span style="font-size: 0.75rem; color: var(--admin-text-muted); display: block; margin-top: 5px;">
                                        Used by AI to sync/generate authentic testimonials matching your business reviews.
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label for="gmb_location_id">Google Business Profile Location ID (Optional)</label>
                                    <input type="text" id="gmb_location_id" name="gmb_location_id" class="form-control" value="{{ $site['gmb_location_id'] ?? '' }}" placeholder="locations/1234567890">
                                    <span style="font-size: 0.75rem; color: var(--admin-text-muted); display: block; margin-top: 5px;">
                                        Required for direct API publishing. Format: <code>locations/YOUR_LOCATION_ID</code>
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label for="gmb_access_token">Google Business Profile Access Token (Optional)</label>
                                    <input type="password" id="gmb_access_token" name="gmb_access_token" class="form-control" value="{{ $site['gmb_access_token'] ?? '' }}" placeholder="OAuth Access Token">
                                    <span style="font-size: 0.75rem; color: var(--admin-text-muted); display: block; margin-top: 5px;">
                                        OAuth 2.0 Bearer Access Token with <code>business.manage</code> scope.
                                    </span>
                                </div>
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

                    <div class="admin-card" style="border: 1px solid var(--accent-orange); position: relative; background: rgba(232, 92, 36, 0.01);">
                        <h2 style="color: var(--accent-orange); display: flex; align-items: center; gap: 8px;">
                            <i data-lucide="database" style="width: 22px; height: 22px;"></i> Database Sync (Local to Live Server)
                        </h2>
                        <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.5rem; margin-top: -1rem;">
                            Push and synchronize all local database content (Settings, Slides, Testimonials, Blogs, Services, and Page Contents) to your live production server database.
                        </p>
                        <div class="form-grid">
                            <div class="form-group" style="grid-column: span 2;">
                                <label for="live_site_url">Live Site Base URL</label>
                                <input type="text" id="live_site_url" name="live_site_url" class="form-control" value="{{ $site['live_site_url'] ?? 'https://mlgfinedge.com' }}" placeholder="e.g., https://mlgfinedge.com">
                                <span style="font-size: 0.75rem; color: var(--admin-text-muted); display: block; margin-top: 5px;">
                                    This is the target live domain where data will be pushed. The Sync uses your configured <strong>R2 Secret Access Key</strong> as a secure verification token between your local and live servers.
                                </span>
                            </div>
                        </div>
                        <div style="margin-top: 1.5rem;">
                            <button type="button" class="btn-submit" style="background: var(--accent-orange) !important; border-color: var(--accent-orange); display: inline-flex; align-items: center; gap: 8px; width: auto; font-size: 0.9rem;" onclick="pushLocalDatabaseToLive(this)">
                                <i data-lucide="cloud-lightning" style="width: 16px; height: 16px;"></i> Push Local Database to Live Server
                            </button>
                        </div>
                    </div>

                    <div class="admin-card">
                        <h2>SMTP Mailer Settings (Lead Notification Email)</h2>
                        <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.5rem; margin-top: -1rem;">
                            Configure SMTP details to send automated email alerts to admin when a new inquiry is submitted.
                        </p>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="smtp_host">SMTP Host</label>
                                <input type="text" id="smtp_host" name="smtp_host" class="form-control" value="{{ $site['smtp_host'] ?? '' }}" placeholder="smtp.mailtrap.io">
                            </div>
                            <div class="form-group">
                                <label for="smtp_port">SMTP Port</label>
                                <input type="text" id="smtp_port" name="smtp_port" class="form-control" value="{{ $site['smtp_port'] ?? '587' }}" placeholder="587">
                            </div>
                            <div class="form-group">
                                <label for="smtp_username">SMTP Username</label>
                                <input type="text" id="smtp_username" name="smtp_username" class="form-control" value="{{ $site['smtp_username'] ?? '' }}" placeholder="username">
                            </div>
                            <div class="form-group">
                                <label for="smtp_password">SMTP Password</label>
                                <input type="password" id="smtp_password" name="smtp_password" class="form-control" value="{{ $site['smtp_password'] ?? '' }}" placeholder="password">
                            </div>
                            <div class="form-group">
                                <label for="smtp_encryption">SMTP Encryption</label>
                                <select id="smtp_encryption" name="smtp_encryption" class="form-control">
                                    <option value="tls" @selected(($site['smtp_encryption'] ?? 'tls') == 'tls')>TLS</option>
                                    <option value="ssl" @selected(($site['smtp_encryption'] ?? 'tls') == 'ssl')>SSL</option>
                                    <option value="none" @selected(($site['smtp_encryption'] ?? 'tls') == 'none')>None</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="smtp_from_address">From Email Address</label>
                                <input type="email" id="smtp_from_address" name="smtp_from_address" class="form-control" value="{{ $site['smtp_from_address'] ?? 'no-reply@mlgfinedge.com' }}" placeholder="no-reply@mlgfinedge.com">
                            </div>
                            <div class="form-group">
                                <label for="smtp_from_name">From Sender Name</label>
                                <input type="text" id="smtp_from_name" name="smtp_from_name" class="form-control" value="{{ $site['smtp_from_name'] ?? 'MLG Finedge Alerts' }}" placeholder="MLG Finedge Alerts">
                            </div>
                            <div class="form-group">
                                <label for="smtp_to_email">Recipient Email Address (Admin Alert)</label>
                                <input type="email" id="smtp_to_email" name="smtp_to_email" class="form-control" value="{{ $site['smtp_to_email'] ?? 'admin@mlgfinedge.com' }}" placeholder="admin@mlgfinedge.com">
                            </div>
                        </div>
                    </div>

                    <div class="admin-card">
                        <h2>WhatsApp API Settings (Lead Notification WhatsApp)</h2>
                        <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.5rem; margin-top: -1rem;">
                            Configure WhatsApp API settings to send automated alerts when a new inquiry is submitted.
                        </p>
                        <div class="form-grid">
                            <div class="form-group" style="grid-column: span 2;">
                                <label for="whatsapp_api_url">WhatsApp API Gateway URL</label>
                                <input type="text" id="whatsapp_api_url" name="whatsapp_api_url" class="form-control" value="{{ $site['whatsapp_api_url'] ?? '' }}" placeholder="https://api.whatsapp.com/send or custom API endpoint">
                            </div>
                            <div class="form-group" style="grid-column: span 2;">
                                <label for="whatsapp_api_token">WhatsApp API Token / Key</label>
                                <input type="password" id="whatsapp_api_token" name="whatsapp_api_token" class="form-control" value="{{ $site['whatsapp_api_token'] ?? '' }}" placeholder="API Token / Auth Key">
                            </div>
                            <div class="form-group">
                                <label for="whatsapp_admin_recipient">Admin Recipient WhatsApp Number (with country code, no +)</label>
                                <input type="text" id="whatsapp_admin_recipient" name="whatsapp_admin_recipient" class="form-control" value="{{ $site['whatsapp_admin_recipient'] ?? '919672777749' }}" placeholder="e.g. 919672777749">
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
                        <div class="admin-table-wrap">
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
                                        <tr id="lead-details-{{ $lead->id }}" class="lead-detail-row" style="display: none; background-color: var(--admin-dark-sidebar);">
                                            <td colspan="5" style="padding: 1.5rem; border-top: 1px dashed var(--admin-border); border-bottom: 1px dashed var(--admin-border);">
                                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                                                    
                                                    <!-- Details Section -->
                                                    <div>
                                                        <h4 style="margin: 0 0 0.75rem 0; color: var(--mint-green); font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.5px; border: none; padding: 0;">Lead Information Details</h4>
                                                        <div style="background-color: rgba(255,255,255,0.02); border: 1px solid var(--admin-border); border-radius: var(--radius-md); padding: 1rem; font-size: 0.9rem; line-height: 1.5; color: rgba(255,255,255,0.95);">
                                                            {!! nl2br(e($lead->message)) !!}
                                                        </div>
                                                        @if($lead->notes)
                                                            <div style="margin-top: 1rem;">
                                                                <h5 style="margin: 0 0 0.5rem 0; color: rgba(255,255,255,0.6); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Admin Notes History</h5>
                                                                <p style="font-size: 0.85rem; color: rgba(255,255,255,0.85); font-style: italic; background-color: rgba(255,255,255,0.02); padding: 0.50rem 0.75rem; border-radius: 4px; border-left: 3px solid var(--mint-green); margin: 0;">
                                                                    {{ $lead->notes }}
                                                                </p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    
                                                    <!-- Actions & Notes Form Section -->
                                                    <div>
                                                        <h4 style="margin: 0 0 0.75rem 0; color: var(--mint-green); font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.5px; border: none; padding: 0;">Update Status & Actions</h4>
                                                        <form action="{{ route('admin.leads.update', $lead->id) }}" method="POST" style="margin-bottom: 0;">
                                                            @csrf
                                                            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                                                                <div class="form-group">
                                                                    <label style="font-size: 0.8rem; font-weight: 600; display: block; margin-bottom: 4px;">Lead Status</label>
                                                                    <select name="status" class="form-control" required style="padding: 0.5rem; height: auto; background-color: var(--admin-dark-bg); color: #ffffff;">
                                                                        <option value="New" @selected($lead->status === 'New') style="background-color: var(--admin-dark-bg); color: #ffffff;">New</option>
                                                                        <option value="Contacted" @selected($lead->status === 'Contacted') style="background-color: var(--admin-dark-bg); color: #ffffff;">Contacted</option>
                                                                        <option value="In Progress" @selected($lead->status === 'In Progress') style="background-color: var(--admin-dark-bg); color: #ffffff;">In Progress</option>
                                                                        <option value="Closed" @selected($lead->status === 'Closed') style="background-color: var(--admin-dark-bg); color: #ffffff;">Closed</option>
                                                                    </select>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label style="font-size: 0.8rem; font-weight: 600; display: block; margin-bottom: 4px;">Internal Follow-up Notes</label>
                                                                    <textarea name="notes" class="form-control" rows="3" placeholder="Write internal notes about client conversation..." style="font-size: 0.85rem; padding: 0.5rem; background-color: var(--admin-dark-bg); color: #ffffff;">{{ $lead->notes }}</textarea>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn-submit" style="padding: 0.5rem 1rem; width: auto; margin-top: 0.75rem; font-size: 0.85rem;">
                                                                Update Status & Notes
                                                            </button>
                                                        </form>
                                                        
                                                        <hr style="border: 0; border-top: 1px solid var(--admin-border); margin: 1.25rem 0;">
                                                        
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
                <!-- AI Sync Testimonials Card -->
                <div class="admin-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <div>
                            <h2>Import Google My Business Reviews</h2>
                            <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-top: -5px; margin-bottom: 0;">
                                Sync reviews automatically based on the Google My Business link configured in General Settings.
                            </p>
                        </div>
                        <button type="button" id="btn-sync-gmb" class="btn-submit" style="background-color: #4285F4; color: white; display: flex; align-items: center; gap: 8px; width: auto; padding: 0.6rem 1.2rem; font-size: 0.85rem;" onclick="syncGmbReviews()">
                            <i data-lucide="refresh-cw" id="icon-sync-gmb" style="width: 16px; height: 16px;"></i> Sync GMB Reviews via AI
                        </button>
                    </div>
                </div>

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

                    <!-- Website Header Elements -->
                    <div class="admin-card">
                        <h2>Website Header & Navigation</h2>
                        <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.5rem; margin-top: -1rem;">
                            Edit the navigation menu link labels and the header action button text.
                        </p>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Home Menu Label</label>
                                <input type="text" name="contents[header][menu][home]" class="form-control" value="{{ $pageContents->where('page', 'header')->where('section', 'menu')->where('key', 'home')->first()->value ?? 'Home' }}">
                            </div>
                            <div class="form-group">
                                <label>About Us Menu Label</label>
                                <input type="text" name="contents[header][menu][about]" class="form-control" value="{{ $pageContents->where('page', 'header')->where('section', 'menu')->where('key', 'about')->first()->value ?? 'About Us' }}">
                            </div>
                            <div class="form-group">
                                <label>Services Menu Label</label>
                                <input type="text" name="contents[header][menu][services]" class="form-control" value="{{ $pageContents->where('page', 'header')->where('section', 'menu')->where('key', 'services')->first()->value ?? 'Services' }}">
                            </div>
                            <div class="form-group">
                                <label>Compare Loans Menu Label</label>
                                <input type="text" name="contents[header][menu][compare]" class="form-control" value="{{ $pageContents->where('page', 'header')->where('section', 'menu')->where('key', 'compare')->first()->value ?? 'Compare Loans' }}">
                            </div>
                            <div class="form-group">
                                <label>Testimonials Menu Label</label>
                                <input type="text" name="contents[header][menu][testimonials]" class="form-control" value="{{ $pageContents->where('page', 'header')->where('section', 'menu')->where('key', 'testimonials')->first()->value ?? 'Testimonials' }}">
                            </div>
                            <div class="form-group">
                                <label>Blog Menu Label</label>
                                <input type="text" name="contents[header][menu][blog]" class="form-control" value="{{ $pageContents->where('page', 'header')->where('section', 'menu')->where('key', 'blog')->first()->value ?? 'Blog' }}">
                            </div>
                            <div class="form-group">
                                <label>Contact Us Menu Label</label>
                                <input type="text" name="contents[header][menu][contact]" class="form-control" value="{{ $pageContents->where('page', 'header')->where('section', 'menu')->where('key', 'contact')->first()->value ?? 'Contact Us' }}">
                            </div>
                            <div class="form-group">
                                <label>Header Call to Action Button</label>
                                <input type="text" name="contents[header][menu][cta]" class="form-control" value="{{ $pageContents->where('page', 'header')->where('section', 'menu')->where('key', 'cta')->first()->value ?? 'Call Now' }}">
                            </div>
                        </div>
                    </div>

                    <!-- Website Footer Settings -->
                    <div class="admin-card">
                        <h2>Website Footer Blocks</h2>
                        <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.5rem; margin-top: -1rem;">
                            Edit footer titles, disclaimer, copy and about summary text.
                        </p>
                        <div class="form-group">
                            <label>Footer Column 1 - Description Summary</label>
                            <textarea name="contents[footer][about][description]" class="form-control" rows="3">{{ $pageContents->where('page', 'footer')->where('section', 'about')->where('key', 'description')->first()->value ?? '' }}</textarea>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Column 2 Heading (Quick Links)</label>
                                <input type="text" name="contents[footer][headings][quick_links]" class="form-control" value="{{ $pageContents->where('page', 'footer')->where('section', 'headings')->where('key', 'quick_links')->first()->value ?? 'Quick Links' }}">
                            </div>
                            <div class="form-group">
                                <label>Column 3 Heading (Loan Services)</label>
                                <input type="text" name="contents[footer][headings][services]" class="form-control" value="{{ $pageContents->where('page', 'footer')->where('section', 'headings')->where('key', 'services')->first()->value ?? 'Loan Services' }}">
                            </div>
                            <div class="form-group">
                                <label>Column 4 Heading (Contact Info)</label>
                                <input type="text" name="contents[footer][headings][contact]" class="form-control" value="{{ $pageContents->where('page', 'footer')->where('section', 'headings')->where('key', 'contact')->first()->value ?? 'Contact Info' }}">
                            </div>
                            <div class="form-group">
                                <label>Footer Copyright suffix (e.g. All Rights Reserved)</label>
                                <input type="text" name="contents[footer][bottom][copyright]" class="form-control" value="{{ $pageContents->where('page', 'footer')->where('section', 'bottom')->where('key', 'copyright')->first()->value ?? 'All Rights Reserved.' }}">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 1rem;">
                            <label>Footer Bottom Disclaimer text</label>
                            <textarea name="contents[footer][bottom][disclaimer]" class="form-control" rows="2">{{ $pageContents->where('page', 'footer')->where('section', 'bottom')->where('key', 'disclaimer')->first()->value ?? '' }}</textarea>
                        </div>
                    </div>

                    <!-- About Us Page sections -->
                    <div class="admin-card">
                        <h2>About Us Page - Hero & Story</h2>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Hero Section Pre-heading</label>
                                <input type="text" name="contents[about][hero][pre_title]" class="form-control" value="{{ $pageContents->where('page', 'about')->where('section', 'hero')->where('key', 'pre_title')->first()->value ?? 'WHO WE ARE' }}">
                            </div>
                            <div class="form-group">
                                <label>Hero Section Main Title</label>
                                <input type="text" name="contents[about][hero][title]" class="form-control" value="{{ $pageContents->where('page', 'about')->where('section', 'hero')->where('key', 'title')->first()->value ?? '' }}">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 1rem;">
                            <label>Hero Subtitle / Description text</label>
                            <textarea name="contents[about][hero][subtitle]" class="form-control" rows="2">{{ $pageContents->where('page', 'about')->where('section', 'hero')->where('key', 'subtitle')->first()->value ?? '' }}</textarea>
                        </div>
                        <hr style="border: 0; border-top: 1px solid var(--admin-border); margin: 1.5rem 0;">
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Story Pre-heading</label>
                                <input type="text" name="contents[about][story][pre_title]" class="form-control" value="{{ $pageContents->where('page', 'about')->where('section', 'story')->where('key', 'pre_title')->first()->value ?? 'Our Story' }}">
                            </div>
                            <div class="form-group">
                                <label>Story Heading / Title</label>
                                <input type="text" name="contents[about][story][title]" class="form-control" value="{{ $pageContents->where('page', 'about')->where('section', 'story')->where('key', 'title')->first()->value ?? '' }}">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 1rem;">
                            <label>Story Paragraph 1</label>
                            <textarea name="contents[about][story][p1]" class="form-control" rows="3">{{ $pageContents->where('page', 'about')->where('section', 'story')->where('key', 'p1')->first()->value ?? '' }}</textarea>
                        </div>
                        <div class="form-group" style="margin-top: 1rem;">
                            <label>Story Paragraph 2</label>
                            <textarea name="contents[about][story][p2]" class="form-control" rows="3">{{ $pageContents->where('page', 'about')->where('section', 'story')->where('key', 'p2')->first()->value ?? '' }}</textarea>
                        </div>
                        <div class="form-group" style="margin-top: 1rem;">
                            <label>Story Paragraph 3</label>
                            <textarea name="contents[about][story][p3]" class="form-control" rows="3">{{ $pageContents->where('page', 'about')->where('section', 'story')->where('key', 'p3')->first()->value ?? '' }}</textarea>
                        </div>
                    </div>

                    <div class="admin-card">
                        <h2>About Us Page - Vision, Mission & Values</h2>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Vision Block Title</label>
                                <input type="text" name="contents[about][vision][title]" class="form-control" value="{{ $pageContents->where('page', 'about')->where('section', 'vision')->where('key', 'title')->first()->value ?? 'Our Vision' }}">
                            </div>
                            <div class="form-group">
                                <label>Vision Statement text</label>
                                <textarea name="contents[about][vision][text]" class="form-control" rows="3">{{ $pageContents->where('page', 'about')->where('section', 'vision')->where('key', 'text')->first()->value ?? '' }}</textarea>
                            </div>
                            
                            <div class="form-group" style="margin-top: 1rem;">
                                <label>Mission Block Title</label>
                                <input type="text" name="contents[about][mission][title]" class="form-control" value="{{ $pageContents->where('page', 'about')->where('section', 'mission')->where('key', 'title')->first()->value ?? 'Our Mission' }}">
                            </div>
                            <div class="form-group" style="margin-top: 1rem;">
                                <label>Mission Statement text</label>
                                <textarea name="contents[about][mission][text]" class="form-control" rows="3">{{ $pageContents->where('page', 'about')->where('section', 'mission')->where('key', 'text')->first()->value ?? '' }}</textarea>
                            </div>
                            
                            <div class="form-group" style="margin-top: 1rem;">
                                <label>Values Block Title</label>
                                <input type="text" name="contents[about][values][title]" class="form-control" value="{{ $pageContents->where('page', 'about')->where('section', 'values')->where('key', 'title')->first()->value ?? 'Our Core Values' }}">
                            </div>
                            <div class="form-group" style="margin-top: 1rem;">
                                <label>Core Values Statement text</label>
                                <textarea name="contents[about][values][text]" class="form-control" rows="3">{{ $pageContents->where('page', 'about')->where('section', 'values')->where('key', 'text')->first()->value ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="admin-card">
                        <h2>About Us Page - Advisory Team Section</h2>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Team Section Title</label>
                                <input type="text" name="contents[about][team][title]" class="form-control" value="{{ $pageContents->where('page', 'about')->where('section', 'team')->where('key', 'title')->first()->value ?? 'Our Advisory Team' }}">
                            </div>
                            <div class="form-group">
                                <label>Team Section Subtitle</label>
                                <input type="text" name="contents[about][team][subtitle]" class="form-control" value="{{ $pageContents->where('page', 'about')->where('section', 'team')->where('key', 'subtitle')->first()->value ?? '' }}">
                            </div>
                        </div>
                        
                        <h4 style="margin: 1.5rem 0 0.5rem 0; color: var(--mint-green); font-size: 0.9rem; text-transform: uppercase;">Advisor 1 Profile</h4>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="contents[about][team][advisor1_name]" class="form-control" value="{{ $pageContents->where('page', 'about')->where('section', 'team')->where('key', 'advisor1_name')->first()->value ?? 'Mahendra Gupta' }}">
                            </div>
                            <div class="form-group">
                                <label>Role / Subtitle</label>
                                <input type="text" name="contents[about][team][advisor1_role]" class="form-control" value="{{ $pageContents->where('page', 'about')->where('section', 'team')->where('key', 'advisor1_role')->first()->value ?? 'Founder & Principal Advisor' }}">
                            </div>
                            <div class="form-group">
                                <label>Initials</label>
                                <input type="text" name="contents[about][team][advisor1_initials]" class="form-control" value="{{ $pageContents->where('page', 'about')->where('section', 'team')->where('key', 'advisor1_initials')->first()->value ?? 'MG' }}" placeholder="MG">
                            </div>
                            <div class="form-group" style="grid-column: span 3; margin-top: 0.5rem;">
                                <label>Bio / Description summary</label>
                                <textarea name="contents[about][team][advisor1_bio]" class="form-control" rows="2">{{ $pageContents->where('page', 'about')->where('section', 'team')->where('key', 'advisor1_bio')->first()->value ?? '' }}</textarea>
                            </div>
                        </div>

                        <h4 style="margin: 1.5rem 0 0.5rem 0; color: var(--mint-green); font-size: 0.9rem; text-transform: uppercase;">Advisor 2 Profile</h4>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="contents[about][team][advisor2_name]" class="form-control" value="{{ $pageContents->where('page', 'about')->where('section', 'team')->where('key', 'advisor2_name')->first()->value ?? 'Ritu Sharma' }}">
                            </div>
                            <div class="form-group">
                                <label>Role / Subtitle</label>
                                <input type="text" name="contents[about][team][advisor2_role]" class="form-control" value="{{ $pageContents->where('page', 'about')->where('section', 'team')->where('key', 'advisor2_role')->first()->value ?? 'Senior Retail Loan Head' }}">
                            </div>
                            <div class="form-group">
                                <label>Initials</label>
                                <input type="text" name="contents[about][team][advisor2_initials]" class="form-control" value="{{ $pageContents->where('page', 'about')->where('section', 'team')->where('key', 'advisor2_initials')->first()->value ?? 'RS' }}" placeholder="RS">
                            </div>
                            <div class="form-group" style="grid-column: span 3; margin-top: 0.5rem;">
                                <label>Bio / Description summary</label>
                                <textarea name="contents[about][team][advisor2_bio]" class="form-control" rows="2">{{ $pageContents->where('page', 'about')->where('section', 'team')->where('key', 'advisor2_bio')->first()->value ?? '' }}</textarea>
                            </div>
                        </div>

                        <h4 style="margin: 1.5rem 0 0.5rem 0; color: var(--mint-green); font-size: 0.9rem; text-transform: uppercase;">Advisor 3 Profile</h4>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="contents[about][team][advisor3_name]" class="form-control" value="{{ $pageContents->where('page', 'about')->where('section', 'team')->where('key', 'advisor3_name')->first()->value ?? 'Amit Jain' }}">
                            </div>
                            <div class="form-group">
                                <label>Role / Subtitle</label>
                                <input type="text" name="contents[about][team][advisor3_role]" class="form-control" value="{{ $pageContents->where('page', 'about')->where('section', 'team')->where('key', 'advisor3_role')->first()->value ?? 'Business Finance Specialist' }}">
                            </div>
                            <div class="form-group">
                                <label>Initials</label>
                                <input type="text" name="contents[about][team][advisor3_initials]" class="form-control" value="{{ $pageContents->where('page', 'about')->where('section', 'team')->where('key', 'advisor3_initials')->first()->value ?? 'AJ' }}" placeholder="AJ">
                            </div>
                            <div class="form-group" style="grid-column: span 3; margin-top: 0.5rem;">
                                <label>Bio / Description summary</label>
                                <textarea name="contents[about][team][advisor3_bio]" class="form-control" rows="2">{{ $pageContents->where('page', 'about')->where('section', 'team')->where('key', 'advisor3_bio')->first()->value ?? '' }}</textarea>
                            </div>
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
                            <div class="form-group" style="grid-column: span 2;">
                                <label for="ser_schema_markup">Custom Schema Markup (JSON-LD script)</label>
                                <textarea id="ser_schema_markup" name="schema_markup" class="form-control" rows="3" placeholder='<script type="application/ld+json">...</script>'></textarea>
                                <span style="font-size: 0.75rem; color: var(--admin-text-muted);">Paste the complete <code>&lt;script type="application/ld+json"&gt;...&lt;/script&gt;</code> block to override the default service schema.</span>
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
                                                <button class="btn-submit" style="padding: 4px 10px; font-size: 0.8rem; background-color: rgba(66, 133, 244, 0.1); color: #4285f4; border: 1px solid rgba(66, 133, 244, 0.3);" 
                                                    onclick="openGmbShareModal('service', {{ json_encode($s) }})">
                                                    GMB
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
                            <label for="blog_schema_markup">Custom Schema Markup (JSON-LD script)</label>
                            <textarea id="blog_schema_markup" name="schema_markup" class="form-control" placeholder='<script type="application/ld+json">...</script>' rows="3"></textarea>
                            <span style="font-size: 0.75rem; color: var(--admin-text-muted);">Paste the complete <code>&lt;script type="application/ld+json"&gt;...&lt;/script&gt;</code> block to override the default blog posting schema.</span>
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
                                                    onclick="editBlogById({{ $b->id }})"><i data-lucide="edit"></i></button>
                                                <button type="button" class="btn-action" style="background-color: rgba(66, 133, 244, 0.1); color: #4285f4; border: 1px solid rgba(66, 133, 244, 0.3);" title="Share to Google Business Profile" 
                                                    onclick="openGmbShareModal('blog', {id: {{ $b->id }}, title: '{{ addslashes($b->title) }}', summary: '{{ addslashes(str_replace(["\r", "\n"], ' ', $b->summary)) }}'})"><i data-lucide="share-2"></i></button>
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

            <!-- LANDING PAGES TAB -->
            <div class="tab-panel" id="tab-landing">
                <!-- Create New Landing Page Card -->
                <div class="admin-card">
                    <h2>Create New Landing Page</h2>
                    <form action="{{ route('admin.landing.store') }}" method="POST">
                        @csrf
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="landing_title">Page Title</label>
                                <input type="text" id="landing_title" name="title" class="form-control" required placeholder="e.g. Doctors Loan Scheme" oninput="generateLandingSlug(this.value)">
                            </div>
                            <div class="form-group">
                                <label for="landing_slug">URL Slug</label>
                                <input type="text" id="landing_slug" name="slug" class="form-control" required placeholder="e.g. doctors-loan-scheme">
                            </div>
                            <div class="form-group">
                                <label for="landing_layout">Layout Structure Type</label>
                                <select id="landing_layout" name="layout_type" class="form-control" required>
                                    <option value="home">Homepage Structure (Hero, Features, About, CTA, FAQs)</option>
                                    <option value="about">About Page Structure (Hero, Story, Vision/Mission/Values, Team, CTA)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="landing_meta">Meta Description</label>
                                <input type="text" id="landing_meta" name="meta_description" class="form-control" placeholder="SEO optimized description for search results">
                            </div>
                        </div>
                        <button type="submit" class="btn-submit" style="margin-top: 1rem; width: auto; padding: 0.6rem 1.5rem;">Create Empty Landing Page</button>
                    </form>
                </div>

                <!-- Existing Landing Pages List -->
                <div class="admin-card">
                    <h2>Manage Landing Pages</h2>
                    <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.5rem; margin-top: -1rem;">
                        Edit generated layouts or trigger Google Gemini AI to write page sections based on prompts.
                    </p>
                    
                    @if($landingPages->isEmpty())
                        <p style="text-align: center; color: var(--admin-text-muted); padding: 2rem 0;">No landing pages created yet.</p>
                    @else
                        <div class="admin-table-wrap">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Page Title</th>
                                        <th>URL Route</th>
                                        <th>Layout Structure</th>
                                        <th>AI Content Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($landingPages as $lp)
                                        <tr>
                                            <td>
                                                <strong>{{ $lp->title }}</strong>
                                                <br>
                                                <small style="color: var(--admin-text-muted);">ID: {{ $lp->id }}</small>
                                            </td>
                                            <td>
                                                <a href="{{ route('landing.show', $lp->slug) }}" target="_blank" style="color: var(--mint-green); text-decoration: underline;">
                                                    /l/{{ $lp->slug }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge" style="background: rgba(92, 203, 179, 0.1); color: var(--mint-green);">
                                                    {{ ucfirst($lp->layout_type) }} Layout
                                                </span>
                                            </td>
                                            <td>
                                                @if(empty($lp->content))
                                                    <span class="badge" style="background: rgba(232, 92, 36, 0.1); color: #e85c24;">Empty Layout</span>
                                                @else
                                                    <span class="badge" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">Generated via AI</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="action-btns">
                                                    <button type="button" class="btn-action edit" onclick="toggleEditLandingForm('{{ $lp->id }}')" title="Edit Layout Content">
                                                        <i data-lucide="edit-3"></i> Edit
                                                    </button>
                                                    <button type="button" class="btn-action" style="background: rgba(92, 203, 179, 0.1); color: var(--mint-green); display: inline-flex; align-items: center; gap: 4px;" onclick="openLandingAiModal('{{ $lp->id }}', '{{ $lp->title }}')" title="Generate/Rewrite with Gemini AI">
                                                        <i data-lucide="sparkles"></i> Generate AI
                                                    </button>
                                                    <button type="button" class="btn-action" style="background: rgba(66, 133, 244, 0.1); color: #4285f4; display: inline-flex; align-items: center; gap: 4px;" onclick="openGmbShareModal('landing', {{ json_encode($lp) }})" title="Share to Google Business Profile">
                                                        <i data-lucide="share-2"></i> GMB
                                                    </button>
                                                    <form action="{{ route('admin.landing.delete', $lp->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this landing page?');" style="margin: 0;">
                                                        @csrf
                                                        <button type="submit" class="btn-action delete" title="Delete Page">
                                                            <i data-lucide="trash-2"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Expandable Landing Page Content Editor Row -->
                                        <tr id="landing-editor-{{ $lp->id }}" class="lead-detail-row" style="display: none; background-color: var(--admin-dark-sidebar);">
                                            <td colspan="5" style="padding: 1.5rem; border-top: 1px dashed var(--admin-border); border-bottom: 1px dashed var(--admin-border);">
                                                <form action="{{ route('admin.landing.update', $lp->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="layout_type" value="{{ $lp->layout_type }}">
                                                    
                                                    <h3 style="color: var(--mint-green); margin-bottom: 1rem;">Edit Content - {{ $lp->title }}</h3>
                                                    <div class="form-grid" style="margin-bottom: 1rem;">
                                                        <div class="form-group">
                                                            <label>Page Title</label>
                                                            <input type="text" name="title" class="form-control" value="{{ $lp->title }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>URL Route Slug</label>
                                                            <input type="text" name="slug" class="form-control" value="{{ $lp->slug }}" required>
                                                        </div>
                                                        <div class="form-group" style="grid-column: span 2;">
                                                            <label>Meta Description</label>
                                                            <input type="text" name="meta_description" class="form-control" value="{{ $lp->meta_description }}">
                                                        </div>
                                                        <div class="form-group" style="grid-column: span 2;">
                                                            <label>Custom Schema Markup (JSON-LD script)</label>
                                                            <textarea name="schema_markup" class="form-control" rows="3" placeholder='<script type="application/ld+json">...</script>'>{{ $lp->schema_markup ?? '' }}</textarea>
                                                            <span style="font-size: 0.75rem; color: var(--admin-text-muted);">Paste the complete <code>&lt;script type="application/ld+json"&gt;...&lt;/script&gt;</code> block.</span>
                                                        </div>
                                                    </div>

                                                    @if($lp->layout_type === 'home')
                                                        <!-- Home Layout Editor Fields -->
                                                        <div class="form-group" style="margin-top: 1rem;">
                                                            <label>Hero Title</label>
                                                            <input type="text" name="content[hero_title]" class="form-control" value="{{ $lp->content['hero_title'] ?? '' }}">
                                                        </div>
                                                        <div class="form-group" style="margin-top: 1rem;">
                                                            <label>Hero Subtitle</label>
                                                            <textarea name="content[hero_subtitle]" class="form-control" rows="2">{{ $lp->content['hero_subtitle'] ?? '' }}</textarea>
                                                        </div>
                                                        
                                                        <h4 style="color: var(--mint-green); margin: 1.5rem 0 0.5rem 0; font-size: 0.95rem; text-transform: uppercase;">Features Section (Grid of 4)</h4>
                                                        @for($i = 0; $i < 4; $i++)
                                                            <div class="form-grid" style="background: rgba(0,0,0,0.15); padding: 0.75rem; border-radius: 4px; margin-bottom: 0.5rem; border: 1px solid var(--admin-border);">
                                                                <div class="form-group">
                                                                    <label>Feature {{ $i + 1 }} Title</label>
                                                                    <input type="text" name="content[features][{{ $i }}][title]" class="form-control" value="{{ $lp->content['features'][$i]['title'] ?? '' }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Feature {{ $i + 1 }} Icon (Lucide name)</label>
                                                                    <input type="text" name="content[features][{{ $i }}][icon]" class="form-control" value="{{ $lp->content['features'][$i]['icon'] ?? 'shield' }}">
                                                                </div>
                                                                <div class="form-group" style="grid-column: span 2;">
                                                                    <label>Feature {{ $i + 1 }} Description</label>
                                                                    <textarea name="content[features][{{ $i }}][desc]" class="form-control" rows="1">{{ $lp->content['features'][$i]['desc'] ?? '' }}</textarea>
                                                                </div>
                                                            </div>
                                                        @endfor

                                                        <div class="form-group" style="margin-top: 1rem;">
                                                            <label>About Us Section Title</label>
                                                            <input type="text" name="content[about_title]" class="form-control" value="{{ $lp->content['about_title'] ?? '' }}">
                                                        </div>
                                                        <div class="form-group" style="margin-top: 1rem;">
                                                            <label>About Us Section Text</label>
                                                            <textarea name="content[about_text]" class="form-control" rows="4">{{ $lp->content['about_text'] ?? '' }}</textarea>
                                                        </div>
                                                        
                                                        <div class="form-group" style="margin-top: 1rem;">
                                                            <label>CTA Section Title</label>
                                                            <input type="text" name="content[cta_title]" class="form-control" value="{{ $lp->content['cta_title'] ?? '' }}">
                                                        </div>
                                                        <div class="form-group" style="margin-top: 1rem;">
                                                            <label>CTA Section Text</label>
                                                            <textarea name="content[cta_text]" class="form-control" rows="2">{{ $lp->content['cta_text'] ?? '' }}</textarea>
                                                        </div>

                                                        <h4 style="color: var(--mint-green); margin: 1.5rem 0 0.5rem 0; font-size: 0.95rem; text-transform: uppercase;">FAQ Section (3 items)</h4>
                                                        @for($i = 0; $i < 3; $i++)
                                                            <div style="background: rgba(0,0,0,0.15); padding: 0.75rem; border-radius: 4px; margin-bottom: 0.5rem; border: 1px solid var(--admin-border);">
                                                                <div class="form-group">
                                                                    <label>FAQ {{ $i + 1 }} Question</label>
                                                                    <input type="text" name="content[faqs][{{ $i }}][q]" class="form-control" value="{{ $lp->content['faqs'][$i]['q'] ?? '' }}">
                                                                </div>
                                                                <div class="form-group" style="margin-top: 0.5rem;">
                                                                    <label>FAQ {{ $i + 1 }} Answer</label>
                                                                    <textarea name="content[faqs][{{ $i }}][a]" class="form-control" rows="2">{{ $lp->content['faqs'][$i]['a'] ?? '' }}</textarea>
                                                                </div>
                                                            </div>
                                                        @endfor
                                                    @else
                                                        <!-- About Layout Editor Fields -->
                                                        <div class="form-group" style="margin-top: 1rem;">
                                                            <label>Hero Title</label>
                                                            <input type="text" name="content[hero_title]" class="form-control" value="{{ $lp->content['hero_title'] ?? '' }}">
                                                        </div>
                                                        <div class="form-group" style="margin-top: 1rem;">
                                                            <label>Hero Subtitle</label>
                                                            <textarea name="content[hero_subtitle]" class="form-control" rows="2">{{ $lp->content['hero_subtitle'] ?? '' }}</textarea>
                                                        </div>

                                                        <div class="form-group" style="margin-top: 1rem;">
                                                            <label>Story Section Title</label>
                                                            <input type="text" name="content[story_title]" class="form-control" value="{{ $lp->content['story_title'] ?? '' }}">
                                                        </div>
                                                        <div class="form-group" style="margin-top: 1rem;">
                                                            <label>Story Section Text</label>
                                                            <textarea name="content[story_text]" class="form-control" rows="5">{{ $lp->content['story_text'] ?? '' }}</textarea>
                                                        </div>

                                                        <div class="form-grid" style="margin-top: 1.5rem;">
                                                            <div class="form-group">
                                                                <label>Our Vision Statement</label>
                                                                <textarea name="content[vision]" class="form-control" rows="3">{{ $lp->content['vision'] ?? '' }}</textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Our Mission Statement</label>
                                                                <textarea name="content[mission]" class="form-control" rows="3">{{ $lp->content['mission'] ?? '' }}</textarea>
                                                            </div>
                                                            <div class="form-group" style="grid-column: span 2; margin-top: 0.5rem;">
                                                                <label>Our Core Values Statement</label>
                                                                <textarea name="content[values]" class="form-control" rows="2">{{ $lp->content['values'] ?? '' }}</textarea>
                                                            </div>
                                                        </div>

                                                        <h4 style="color: var(--mint-green); margin: 1.5rem 0 0.5rem 0; font-size: 0.95rem; text-transform: uppercase;">Team Section (3 members)</h4>
                                                        @for($i = 0; $i < 3; $i++)
                                                            <div class="form-grid" style="background: rgba(0,0,0,0.15); padding: 0.75rem; border-radius: 4px; margin-bottom: 0.5rem; border: 1px solid var(--admin-border);">
                                                                <div class="form-group">
                                                                    <label>Member {{ $i + 1 }} Name</label>
                                                                    <input type="text" name="content[team][{{ $i }}][name]" class="form-control" value="{{ $lp->content['team'][$i]['name'] ?? '' }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Member {{ $i + 1 }} Role</label>
                                                                    <input type="text" name="content[team][{{ $i }}][role]" class="form-control" value="{{ $lp->content['team'][$i]['role'] ?? '' }}">
                                                                </div>
                                                                <div class="form-group" style="grid-column: span 2; margin-top: 0.5rem;">
                                                                    <label>Member {{ $i + 1 }} Bio</label>
                                                                    <textarea name="content[team][{{ $i }}][bio]" class="form-control" rows="2">{{ $lp->content['team'][$i]['bio'] ?? '' }}</textarea>
                                                                </div>
                                                            </div>
                                                        @endfor

                                                        <div class="form-group" style="margin-top: 1rem;">
                                                            <label>CTA Section Title</label>
                                                            <input type="text" name="content[cta_title]" class="form-control" value="{{ $lp->content['cta_title'] ?? '' }}">
                                                        </div>
                                                        <div class="form-group" style="margin-top: 1rem;">
                                                            <label>CTA Section Text</label>
                                                            <textarea name="content[cta_text]" class="form-control" rows="2">{{ $lp->content['cta_text'] ?? '' }}</textarea>
                                                        </div>
                                                    @endif

                                                    <button type="submit" class="btn-submit" style="margin-top: 1rem; width: auto; padding: 0.6rem 1.5rem;">Save Landing Page Content</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SEO OPTIMIZER & MANAGEMENT COMMAND CENTER -->
            <div class="tab-panel" id="tab-seo">
                <!-- Master Header & Overview Bar -->
                <div class="admin-card" style="background: linear-gradient(135deg, rgba(12, 83, 84, 0.25) 0%, rgba(17, 27, 28, 0.95) 100%); border-color: rgba(92, 203, 179, 0.2);">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 1.25rem;">
                        <div>
                            <h2 style="margin: 0; border: none; padding: 0; display: flex; align-items: center; gap: 10px; font-size: 1.4rem;">
                                <i data-lucide="sparkles" style="color: var(--mint-green);"></i> Complete SEO & Structured Data Command Center
                            </h2>
                            <p style="font-size: 0.875rem; color: var(--admin-text-muted); margin: 6px 0 0 0;">
                                Manage Meta Titles, Descriptions, OpenGraph tags, Twitter Cards, H1 Tags, Image Alt Texts, and JSON-LD Schemas across every page of your site.
                            </p>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <a href="/sitemap.xml" target="_blank" class="btn-submit" style="background: rgba(255,255,255,0.06); color: #fff; padding: 0.5rem 1rem; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 6px; border: 1px solid var(--admin-border); text-decoration: none;">
                                <i data-lucide="external-link" style="width: 14px; height: 14px;"></i> View Sitemap
                            </a>
                            <a href="/robots.txt" target="_blank" class="btn-submit" style="background: rgba(255,255,255,0.06); color: #fff; padding: 0.5rem 1rem; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 6px; border: 1px solid var(--admin-border); text-decoration: none;">
                                <i data-lucide="file-text" style="width: 14px; height: 14px;"></i> Robots.txt
                            </a>
                        </div>
                    </div>

                    <!-- SEO Quick Stat Counters -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-top: 1rem;">
                        <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--admin-border); border-radius: var(--radius-md); padding: 1rem; text-align: center;">
                            <div style="font-size: 1.5rem; font-weight: 700; color: var(--mint-green);">9 / 9</div>
                            <div style="font-size: 0.75rem; color: var(--admin-text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Static Pages SEO</div>
                        </div>
                        <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--admin-border); border-radius: var(--radius-md); padding: 1rem; text-align: center;">
                            <div style="font-size: 1.5rem; font-weight: 700; color: var(--accent-orange);">{{ count($services) }}</div>
                            <div style="font-size: 0.75rem; color: var(--admin-text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Service Pages SEO</div>
                        </div>
                        <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--admin-border); border-radius: var(--radius-md); padding: 1rem; text-align: center;">
                            <div style="font-size: 1.5rem; font-weight: 700; color: #8ab4f8;">{{ count($blogs) }}</div>
                            <div style="font-size: 0.75rem; color: var(--admin-text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Blog Articles SEO</div>
                        </div>
                        <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--admin-border); border-radius: var(--radius-md); padding: 1rem; text-align: center;">
                            <div style="font-size: 1.5rem; font-weight: 700; color: #c084fc;">{{ count($landingPages) }}</div>
                            <div style="font-size: 0.75rem; color: var(--admin-text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px;">Landing Pages SEO</div>
                        </div>
                    </div>
                </div>

                <!-- SEO Sub-Navigation Bar -->
                <div style="display: flex; gap: 8px; overflow-x: auto; margin-bottom: 1.5rem; padding-bottom: 5px; border-bottom: 1px solid var(--admin-border);">
                    <button type="button" class="btn-submit seo-subtab-btn active" id="btn-seo-sub-pages" onclick="switchSeoSubTab('pages')" style="padding: 0.6rem 1.2rem; font-size: 0.85rem; width: auto; display: inline-flex; align-items: center; gap: 6px;">
                        <i data-lucide="file-text" style="width: 15px; height: 15px;"></i> Core Pages SEO
                    </button>
                    <button type="button" class="btn-submit seo-subtab-btn" id="btn-seo-sub-services" onclick="switchSeoSubTab('services')" style="padding: 0.6rem 1.2rem; font-size: 0.85rem; width: auto; background-color: var(--admin-input-bg); color: #fff; display: inline-flex; align-items: center; gap: 6px;">
                        <i data-lucide="layers" style="width: 15px; height: 15px;"></i> Services SEO ({{ count($services) }})
                    </button>
                    <button type="button" class="btn-submit seo-subtab-btn" id="btn-seo-sub-blogs" onclick="switchSeoSubTab('blogs')" style="padding: 0.6rem 1.2rem; font-size: 0.85rem; width: auto; background-color: var(--admin-input-bg); color: #fff; display: inline-flex; align-items: center; gap: 6px;">
                        <i data-lucide="book-open" style="width: 15px; height: 15px;"></i> Blog Posts SEO ({{ count($blogs) }})
                    </button>
                    <button type="button" class="btn-submit seo-subtab-btn" id="btn-seo-sub-landing" onclick="switchSeoSubTab('landing')" style="padding: 0.6rem 1.2rem; font-size: 0.85rem; width: auto; background-color: var(--admin-input-bg); color: #fff; display: inline-flex; align-items: center; gap: 6px;">
                        <i data-lucide="layout" style="width: 15px; height: 15px;"></i> Landing Pages SEO ({{ count($landingPages) }})
                    </button>
                    <button type="button" class="btn-submit seo-subtab-btn" id="btn-seo-sub-alts" onclick="switchSeoSubTab('alts')" style="padding: 0.6rem 1.2rem; font-size: 0.85rem; width: auto; background-color: var(--admin-input-bg); color: #fff; display: inline-flex; align-items: center; gap: 6px;">
                        <i data-lucide="image" style="width: 15px; height: 15px;"></i> Image Alt Tags Auditor
                    </button>
                    <button type="button" class="btn-submit seo-subtab-btn" id="btn-seo-sub-global" onclick="switchSeoSubTab('global')" style="padding: 0.6rem 1.2rem; font-size: 0.85rem; width: auto; background-color: var(--admin-input-bg); color: #fff; display: inline-flex; align-items: center; gap: 6px;">
                        <i data-lucide="globe" style="width: 15px; height: 15px;"></i> Global & Social Defaults
                    </button>
                    <button type="button" class="btn-submit seo-subtab-btn" id="btn-seo-sub-blueprints" onclick="switchSeoSubTab('blueprints')" style="padding: 0.6rem 1.2rem; font-size: 0.85rem; width: auto; background-color: var(--admin-input-bg); color: #fff; display: inline-flex; align-items: center; gap: 6px;">
                        <i data-lucide="trending-up" style="width: 15px; height: 15px;"></i> AI Blueprints & Backlinks
                    </button>
                    <button type="button" class="btn-submit seo-subtab-btn" id="btn-seo-sub-sitemap" onclick="switchSeoSubTab('sitemap')" style="padding: 0.6rem 1.2rem; font-size: 0.85rem; width: auto; background-color: var(--admin-input-bg); color: #fff; display: inline-flex; align-items: center; gap: 6px;">
                        <i data-lucide="map" style="width: 15px; height: 15px;"></i> XML Sitemap & Indexing
                    </button>
                </div>

                <!-- SUBPANEL 1: CORE STATIC PAGES SEO -->
                <div class="seo-subpanel" id="seo-subpanel-pages">
                    <!-- Page Selector Pills -->
                    <div class="admin-card" style="padding: 1.25rem 1.5rem; margin-bottom: 1.5rem;">
                        <div style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                            Select Page to Configure SEO:
                        </div>
                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                            @php
                                $corePagesList = [
                                    'home' => ['name' => 'Home Page', 'icon' => 'home', 'url' => '/'],
                                    'about' => ['name' => 'About Us', 'icon' => 'info', 'url' => '/about'],
                                    'services' => ['name' => 'Services Directory', 'icon' => 'layers', 'url' => '/services'],
                                    'compare' => ['name' => 'Compare Loans', 'icon' => 'scale', 'url' => '/compare-loans'],
                                    'testimonials' => ['name' => 'Testimonials', 'icon' => 'users', 'url' => '/testimonials'],
                                    'faq' => ['name' => 'FAQ & Help', 'icon' => 'help-circle', 'url' => '/faq'],
                                    'blog' => ['name' => 'Blog Index', 'icon' => 'book-open', 'url' => '/blog'],
                                    'contact' => ['name' => 'Contact Us', 'icon' => 'mail', 'url' => '/contact'],
                                    'thank_you' => ['name' => 'Thank You Page', 'icon' => 'check-circle', 'url' => '/thank-you'],
                                ];
                            @endphp
                            @foreach($corePagesList as $pkey => $pinfo)
                                <button type="button" class="btn-submit page-selector-btn @if($pkey === 'home') active @endif" id="btn-page-sel-{{ $pkey }}" onclick="selectPageSeoEditor('{{ $pkey }}')" style="padding: 0.5rem 1rem; font-size: 0.85rem; width: auto; @if($pkey !== 'home') background-color: var(--admin-input-bg); color: #fff; @endif display: inline-flex; align-items: center; gap: 6px;">
                                    <i data-lucide="{{ $pinfo['icon'] }}" style="width: 14px; height: 14px;"></i> {{ $pinfo['name'] }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Individual Page SEO Editors -->
                    @foreach($corePagesList as $pkey => $pinfo)
                        @php
                            $pSeo = $pageSeos[$pkey] ?? null;
                            $pTitle = $pSeo->meta_title ?? ($pinfo['name'] . ' | ' . ($parameters['General']['site_name']->value ?? 'MLG Finedge'));
                            $pDesc = $pSeo->meta_description ?? ($parameters['SEO']['seo_default_description']->value ?? 'MLG Finedge is Jaipur\'s premier loan advisory consultancy.');
                            $pH1 = $pSeo->h1_tag ?? $pinfo['name'];
                            $pKeywords = $pSeo->meta_keywords ?? '';
                            $pCanonical = $pSeo->canonical_url ?? '';
                            $pRobots = $pSeo->meta_robots ?? 'index, follow';
                            $pOgTitle = $pSeo->og_title ?? '';
                            $pOgDesc = $pSeo->og_description ?? '';
                            $pOgImage = $pSeo->og_image ?? '';
                            $pHeroAlt = $pSeo->hero_image_alt ?? '';
                            $pSchema = $pSeo->schema_markup ?? '';
                        @endphp
                        <div class="page-seo-form-container" id="page-seo-box-{{ $pkey }}" style="@if($pkey !== 'home') display: none; @endif">
                            <form action="{{ route('admin.seo.page.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="page_key" value="{{ $pkey }}">
                                <input type="hidden" name="page_name" value="{{ $pinfo['name'] }}">

                                <div class="form-grid" style="grid-template-columns: 1.2fr 0.8fr; gap: 1.5rem; align-items: start;">
                                    <!-- Left Column: Primary SEO & Metadata -->
                                    <div class="admin-card" style="margin-bottom: 0;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--admin-border); padding-bottom: 0.75rem; margin-bottom: 1.25rem;">
                                            <h3 style="margin: 0; font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
                                                <i data-lucide="edit-3" style="color: var(--mint-green);"></i> On-Page Meta & Heading Controls
                                            </h3>
                                            <button type="button" class="btn-ai-sparkle" onclick="triggerAiSeoGenerate('page', '{{ $pkey }}', null, '{{ $pinfo['name'] }}')" style="padding: 0.4rem 0.85rem; font-size: 0.8rem;">
                                                <i data-lucide="sparkles"></i> AI Generate SEO
                                            </button>
                                        </div>

                                        <!-- Meta Title -->
                                        <div class="form-group">
                                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                                <label for="meta_title_{{ $pkey }}" style="margin-bottom: 0;">Meta Title (Title Tag)</label>
                                                <span class="char-counter" id="cnt_title_{{ $pkey }}" style="font-size: 0.75rem; color: var(--mint-green); font-weight: 600;">{{ strlen($pTitle) }} / 60 chars</span>
                                            </div>
                                            <input type="text" id="meta_title_{{ $pkey }}" name="meta_title" class="form-control" value="{{ $pTitle }}" oninput="updateSerpPreview('{{ $pkey }}')" placeholder="e.g. Best Loan Provider in Gopalpura Jaipur | MLG Finedge">
                                        </div>

                                        <!-- Meta Description -->
                                        <div class="form-group">
                                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                                <label for="meta_desc_{{ $pkey }}" style="margin-bottom: 0;">Meta Description</label>
                                                <span class="char-counter" id="cnt_desc_{{ $pkey }}" style="font-size: 0.75rem; color: var(--mint-green); font-weight: 600;">{{ strlen($pDesc) }} / 160 chars</span>
                                            </div>
                                            <textarea id="meta_desc_{{ $pkey }}" name="meta_description" class="form-control" rows="3" oninput="updateSerpPreview('{{ $pkey }}')" placeholder="Summarize the page concisely with a compelling call to action...">{{ $pDesc }}</textarea>
                                        </div>

                                        <!-- Page H1 Tag -->
                                        <div class="form-group" style="background: rgba(92, 203, 179, 0.05); border: 1px dashed rgba(92, 203, 179, 0.3); border-radius: var(--radius-md); padding: 1rem;">
                                            <label for="h1_tag_{{ $pkey }}" style="color: var(--mint-green); font-weight: 700; display: flex; align-items: center; gap: 6px;">
                                                <i data-lucide="heading" style="width: 14px; height: 14px;"></i> Page Primary &lt;H1&gt; Tag Control
                                            </label>
                                            <input type="text" id="h1_tag_{{ $pkey }}" name="h1_tag" class="form-control" value="{{ $pH1 }}" placeholder="Custom primary H1 heading on the page">
                                            <span style="font-size: 0.75rem; color: var(--admin-text-muted); margin-top: 4px; display: block;">This controls the main visible `&lt;h1&gt;` text displayed at the top/hero of the page.</span>
                                        </div>

                                        <!-- Meta Keywords & Hero Image Alt -->
                                        <div class="form-grid" style="grid-template-columns: 1fr 1fr; gap: 1rem;">
                                            <div class="form-group">
                                                <label for="meta_keywords_{{ $pkey }}">Meta Keywords</label>
                                                <input type="text" id="meta_keywords_{{ $pkey }}" name="meta_keywords" class="form-control" value="{{ $pKeywords }}" placeholder="comma-separated phrases">
                                            </div>
                                            <div class="form-group">
                                                <label for="hero_alt_{{ $pkey }}">Hero Image / Banner Alt Text</label>
                                                <input type="text" id="hero_alt_{{ $pkey }}" name="hero_image_alt" class="form-control" value="{{ $pHeroAlt }}" placeholder="SEO-friendly alt attribute">
                                            </div>
                                        </div>

                                        <!-- Canonical URL & Meta Robots -->
                                        <div class="form-grid" style="grid-template-columns: 1fr 1fr; gap: 1rem;">
                                            <div class="form-group">
                                                <label for="canonical_{{ $pkey }}">Canonical URL (Optional)</label>
                                                <input type="url" id="canonical_{{ $pkey }}" name="canonical_url" class="form-control" value="{{ $pCanonical }}" placeholder="https://mlgfinedge.com/...">
                                            </div>
                                            <div class="form-group">
                                                <label for="robots_{{ $pkey }}">Robots Meta Directive</label>
                                                <select id="robots_{{ $pkey }}" name="meta_robots" class="form-control">
                                                    <option value="index, follow" @if($pRobots === 'index, follow') selected @endif>index, follow (Default - Recommended)</option>
                                                    <option value="noindex, follow" @if($pRobots === 'noindex, follow') selected @endif>noindex, follow (Hide from SERP, follow links)</option>
                                                    <option value="noindex, nofollow" @if($pRobots === 'noindex, nofollow') selected @endif>noindex, nofollow (Block completely)</option>
                                                    <option value="index, nofollow" @if($pRobots === 'index, nofollow') selected @endif>index, nofollow (Index page, ignore links)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Custom Schema JSON-LD -->
                                        <div class="form-group">
                                            <label for="schema_{{ $pkey }}" style="display: flex; justify-content: space-between; align-items: center;">
                                                <span>Custom Structured Data (JSON-LD Schema)</span>
                                                <button type="button" class="btn-submit" onclick="openAiSchemaModal('page', null, '{{ $pkey }}')" style="padding: 2px 8px; font-size: 0.75rem; width: auto; background: var(--admin-input-bg); color: var(--mint-green);">
                                                    <i data-lucide="code" style="width: 12px; height: 12px;"></i> AI Schema Builder
                                                </button>
                                            </label>
                                            <textarea id="schema_{{ $pkey }}" name="schema_markup" class="form-control" rows="4" style="font-family: monospace; font-size: 0.82rem;" placeholder="<script type=&quot;application/ld+json&quot;>...</script>">{{ $pSchema }}</textarea>
                                        </div>

                                        <button type="submit" class="btn-submit" style="width: 100%; margin-top: 1rem;">
                                            <i data-lucide="save" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle;"></i> Save SEO Configuration for {{ $pinfo['name'] }}
                                        </button>
                                    </div>

                                    <!-- Right Column: Live SERP Snippet & Social OpenGraph -->
                                    <div>
                                        <!-- Google SERP Live Snippet Preview Box -->
                                        <div class="admin-card" style="background: #202124; border-color: rgba(255,255,255,0.12); color: #fff; margin-bottom: 1.5rem;">
                                            <div style="font-size: 0.75rem; color: #9aa0a6; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem; display: flex; align-items: center; justify-content: space-between;">
                                                <span><i data-lucide="search" style="width: 12px; height: 12px; display: inline-block; vertical-align: middle;"></i> Google SERP Preview</span>
                                                <span style="color: var(--mint-green); font-weight: 600;">Live Search Result</span>
                                            </div>
                                            <div style="background: #171717; border-radius: 8px; padding: 1rem; border: 1px solid rgba(255,255,255,0.06);">
                                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                                                    <div style="width: 18px; height: 18px; border-radius: 50%; background: #303134; display: flex; align-items: center; justify-content: center; font-size: 10px;">🌐</div>
                                                    <div>
                                                        <div style="font-size: 0.8rem; color: #dadce0; line-height: 1.2;">{{ parse_url(url('/'), PHP_URL_HOST) ?? 'mlgfinedge.com' }}</div>
                                                        <div style="font-size: 0.7rem; color: #9aa0a6;">{{ url($pinfo['url']) }}</div>
                                                    </div>
                                                </div>
                                                <div id="serp_title_{{ $pkey }}" style="font-size: 1.15rem; color: #8ab4f8; line-height: 1.3; font-weight: 400; margin-bottom: 6px; cursor: pointer; text-decoration: none;">
                                                    {{ $pTitle }}
                                                </div>
                                                <div id="serp_desc_{{ $pkey }}" style="font-size: 0.85rem; color: #bdc1c6; line-height: 1.5;">
                                                    {{ $pDesc }}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- OpenGraph & Social Sharing Card -->
                                        <div class="admin-card" style="margin-bottom: 0;">
                                            <h3 style="margin: 0 0 1rem 0; font-size: 1rem; display: flex; align-items: center; gap: 8px;">
                                                <i data-lucide="share-2" style="color: var(--accent-orange);"></i> OpenGraph & Social Cards
                                            </h3>

                                            <div class="form-group">
                                                <label for="og_title_{{ $pkey }}">Custom OG / Social Title</label>
                                                <input type="text" id="og_title_{{ $pkey }}" name="og_title" class="form-control" value="{{ $pOgTitle }}" placeholder="Defaults to Meta Title if blank">
                                            </div>

                                            <div class="form-group">
                                                <label for="og_desc_{{ $pkey }}">Custom OG / Social Description</label>
                                                <textarea id="og_desc_{{ $pkey }}" name="og_description" class="form-control" rows="2" placeholder="Defaults to Meta Description if blank">{{ $pOgDesc }}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="og_image_file_{{ $pkey }}">Upload Page Social Image (1200x630px recommended)</label>
                                                <input type="file" id="og_image_file_{{ $pkey }}" name="og_image_file" class="form-control" accept="image/*">
                                                @if(!empty($pOgImage))
                                                    <div style="margin-top: 8px; display: flex; align-items: center; gap: 10px;">
                                                        <img src="{{ site_image($pOgImage) }}" alt="OG Preview" style="height: 45px; width: 80px; object-fit: cover; border-radius: 4px; border: 1px solid var(--admin-border);">
                                                        <span style="font-size: 0.75rem; color: var(--admin-text-muted);">Current Social Image: {{ basename($pOgImage) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>

                <!-- SUBPANEL 2: SERVICES SEO MANAGER -->
                <div class="seo-subpanel" id="seo-subpanel-services" style="display: none;">
                    <div class="admin-card">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 10px;">
                            <div>
                                <h2 style="margin: 0; border: none; padding: 0;">Loan Services SEO Optimizer</h2>
                                <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin: 4px 0 0 0;">Control titles, meta descriptions, controllable H1 headings, image alts, and structured schema for every loan product.</p>
                            </div>
                        </div>

                        <div class="admin-table-wrap">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th style="width: 20%;">Service & Slug</th>
                                        <th style="width: 25%;">Meta Title & H1 Tag</th>
                                        <th style="width: 30%;">Meta Description & Image Alt</th>
                                        <th style="width: 10%;">Schema</th>
                                        <th style="width: 15%; text-align: right;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($services as $ser)
                                        <tr>
                                            <td>
                                                <div style="font-weight: 700; color: #fff;">{{ $ser->service_name }}</div>
                                                <a href="{{ route('services.show', $ser->slug) }}" target="_blank" style="font-size: 0.75rem; color: var(--mint-green); text-decoration: underline;">
                                                    /services/{{ $ser->slug }}
                                                </a>
                                            </td>
                                            <td>
                                                <div style="font-size: 0.85rem; font-weight: 600; color: #dadce0;">
                                                    {{ $ser->meta_title ?: ($ser->service_name . ' | MLG Finedge') }}
                                                </div>
                                                <div style="font-size: 0.75rem; color: var(--mint-green); margin-top: 3px;">
                                                    <strong>H1:</strong> {{ $ser->h1_tag ?: $ser->hero_title }}
                                                </div>
                                            </td>
                                            <td>
                                                <div style="font-size: 0.8rem; color: var(--admin-text-muted); line-height: 1.4;">
                                                    {{ \Illuminate\Support\Str::limit($ser->meta_description ?: $ser->summary, 80) }}
                                                </div>
                                                <div style="font-size: 0.75rem; color: #c084fc; margin-top: 3px;">
                                                    <strong>Alt:</strong> {{ $ser->image_alt ?: ($ser->service_name . ' - MLG Finedge') }}
                                                </div>
                                            </td>
                                            <td>
                                                @if(!empty($ser->schema_markup))
                                                    <span style="background: rgba(92, 203, 179, 0.15); color: var(--mint-green); padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">Custom</span>
                                                @else
                                                    <span style="background: rgba(255, 255, 255, 0.05); color: var(--admin-text-muted); padding: 3px 8px; border-radius: 4px; font-size: 0.75rem;">Default</span>
                                                @endif
                                            </td>
                                            <td style="text-align: right;">
                                                <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                                    <button type="button" class="btn-submit" onclick="openServiceSeoModal({{ json_encode($ser) }})" style="padding: 0.4rem 0.75rem; font-size: 0.75rem; width: auto;">
                                                        <i data-lucide="edit" style="width: 13px; height: 13px;"></i> Edit SEO
                                                    </button>
                                                    <button type="button" class="btn-ai-sparkle" onclick="triggerAiSeoGenerate('service', null, {{ $ser->id }}, '{{ addslashes($ser->service_name) }}')" style="padding: 0.4rem 0.75rem; font-size: 0.75rem;">
                                                        <i data-lucide="sparkles" style="width: 13px; height: 13px;"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- SUBPANEL 3: BLOG POSTS SEO MANAGER -->
                <div class="seo-subpanel" id="seo-subpanel-blogs" style="display: none;">
                    <div class="admin-card">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 10px;">
                            <div>
                                <h2 style="margin: 0; border: none; padding: 0;">Blog Articles SEO Optimizer</h2>
                                <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin: 4px 0 0 0;">Optimize rankings, meta tags, and schema for all educational blog posts.</p>
                            </div>
                        </div>

                        <div class="admin-table-wrap">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th style="width: 25%;">Article Title & Category</th>
                                        <th style="width: 30%;">Meta Title & H1 Tag</th>
                                        <th style="width: 25%;">Description & Image Alt</th>
                                        <th style="width: 8%;">Schema</th>
                                        <th style="width: 12%; text-align: right;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($blogs as $b)
                                        <tr>
                                            <td>
                                                <div style="font-weight: 700; color: #fff;">{{ $b->title }}</div>
                                                <span style="font-size: 0.75rem; color: var(--accent-orange);">{{ $b->category }}</span> • 
                                                <a href="{{ route('blog.show', $b->slug) }}" target="_blank" style="font-size: 0.75rem; color: var(--mint-green); text-decoration: underline;">
                                                    /blog/{{ $b->slug }}
                                                </a>
                                            </td>
                                            <td>
                                                <div style="font-size: 0.85rem; font-weight: 600; color: #dadce0;">
                                                    {{ $b->meta_title ?: ($b->title . ' | MLG Finedge') }}
                                                </div>
                                                <div style="font-size: 0.75rem; color: var(--mint-green); margin-top: 3px;">
                                                    <strong>H1:</strong> {{ $b->h1_tag ?: $b->title }}
                                                </div>
                                            </td>
                                            <td>
                                                <div style="font-size: 0.8rem; color: var(--admin-text-muted); line-height: 1.4;">
                                                    {{ \Illuminate\Support\Str::limit($b->meta_description ?: $b->summary, 80) }}
                                                </div>
                                                <div style="font-size: 0.75rem; color: #c084fc; margin-top: 3px;">
                                                    <strong>Alt:</strong> {{ $b->image_alt ?: ($b->title . ' - MLG Finedge') }}
                                                </div>
                                            </td>
                                            <td>
                                                @if(!empty($b->schema_markup))
                                                    <span style="background: rgba(92, 203, 179, 0.15); color: var(--mint-green); padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">Custom</span>
                                                @else
                                                    <span style="background: rgba(255, 255, 255, 0.05); color: var(--admin-text-muted); padding: 3px 8px; border-radius: 4px; font-size: 0.75rem;">Default</span>
                                                @endif
                                            </td>
                                            <td style="text-align: right;">
                                                <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                                    <button type="button" class="btn-submit" onclick="openBlogSeoModal({{ json_encode($b) }})" style="padding: 0.4rem 0.75rem; font-size: 0.75rem; width: auto;">
                                                        <i data-lucide="edit" style="width: 13px; height: 13px;"></i> Edit
                                                    </button>
                                                    <button type="button" class="btn-ai-sparkle" onclick="triggerAiSeoGenerate('blog', null, {{ $b->id }}, '{{ addslashes($b->title) }}')" style="padding: 0.4rem 0.75rem; font-size: 0.75rem;">
                                                        <i data-lucide="sparkles" style="width: 13px; height: 13px;"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- SUBPANEL 4: LANDING PAGES SEO MANAGER -->
                <div class="seo-subpanel" id="seo-subpanel-landing" style="display: none;">
                    <div class="admin-card">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 10px;">
                            <div>
                                <h2 style="margin: 0; border: none; padding: 0;">AI Landing Pages SEO Optimizer</h2>
                                <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin: 4px 0 0 0;">Control metadata, headings, and schema for paid search and targeted landing pages.</p>
                            </div>
                        </div>

                        <div class="admin-table-wrap">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th style="width: 25%;">Landing Page & Slug</th>
                                        <th style="width: 30%;">Meta Title & H1 Tag</th>
                                        <th style="width: 25%;">Description & Alt</th>
                                        <th style="width: 8%;">Schema</th>
                                        <th style="width: 12%; text-align: right;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($landingPages as $lp)
                                        <tr>
                                            <td>
                                                <div style="font-weight: 700; color: #fff;">{{ $lp->title }}</div>
                                                <a href="{{ route('landing.show', $lp->slug) }}" target="_blank" style="font-size: 0.75rem; color: var(--mint-green); text-decoration: underline;">
                                                    /l/{{ $lp->slug }}
                                                </a>
                                            </td>
                                            <td>
                                                <div style="font-size: 0.85rem; font-weight: 600; color: #dadce0;">
                                                    {{ $lp->meta_title ?: ($lp->title . ' | MLG Finedge') }}
                                                </div>
                                                <div style="font-size: 0.75rem; color: var(--mint-green); margin-top: 3px;">
                                                    <strong>H1:</strong> {{ $lp->h1_tag ?: $lp->title }}
                                                </div>
                                            </td>
                                            <td>
                                                <div style="font-size: 0.8rem; color: var(--admin-text-muted); line-height: 1.4;">
                                                    {{ \Illuminate\Support\Str::limit($lp->meta_description, 80) }}
                                                </div>
                                                <div style="font-size: 0.75rem; color: #c084fc; margin-top: 3px;">
                                                    <strong>Alt:</strong> {{ $lp->image_alt ?: ($lp->title . ' - MLG Finedge') }}
                                                </div>
                                            </td>
                                            <td>
                                                @if(!empty($lp->schema_markup))
                                                    <span style="background: rgba(92, 203, 179, 0.15); color: var(--mint-green); padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600;">Custom</span>
                                                @else
                                                    <span style="background: rgba(255, 255, 255, 0.05); color: var(--admin-text-muted); padding: 3px 8px; border-radius: 4px; font-size: 0.75rem;">None</span>
                                                @endif
                                            </td>
                                            <td style="text-align: right;">
                                                <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                                    <button type="button" class="btn-submit" onclick="openLandingSeoModal({{ json_encode($lp) }})" style="padding: 0.4rem 0.75rem; font-size: 0.75rem; width: auto;">
                                                        <i data-lucide="edit" style="width: 13px; height: 13px;"></i> Edit
                                                    </button>
                                                    <button type="button" class="btn-ai-sparkle" onclick="triggerAiSeoGenerate('landing', null, {{ $lp->id }}, '{{ addslashes($lp->title) }}')" style="padding: 0.4rem 0.75rem; font-size: 0.75rem;">
                                                        <i data-lucide="sparkles" style="width: 13px; height: 13px;"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" style="text-align: center; color: var(--admin-text-muted); padding: 2rem;">
                                                No landing pages created yet. Create one in the AI Landing Pages tab!
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- SUBPANEL 5: ALT TAGS & IMAGE SEO AUDITOR -->
                <div class="seo-subpanel" id="seo-subpanel-alts" style="display: none;">
                    <form action="{{ route('admin.seo.alts.update') }}" method="POST">
                        @csrf
                        <!-- Global & Brand Alt Tags -->
                        <div class="admin-card">
                            <h2><i data-lucide="image" style="color: var(--mint-green); margin-right: 6px;"></i> Brand & Global Component Alt Tags</h2>
                            <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.5rem; margin-top: -1rem;">
                                Set descriptive alt texts for key brand assets and persistent images rendered in header, footer, and about sections.
                            </p>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="alt_seo_logo">Header & Footer Logo Alt Text</label>
                                    <input type="text" id="alt_seo_logo" name="seo_logo_alt" class="form-control" value="{{ $parameters['SEO']['seo_logo_alt']->value ?? 'MLG Finedge - Trusted Loan Advisor in Gopalpura Jaipur' }}">
                                </div>
                                <div class="form-group">
                                    <label for="alt_seo_about_img">About Us Showcase Badge Alt Text</label>
                                    <input type="text" id="alt_seo_about_img" name="seo_about_img_alt" class="form-control" value="{{ $parameters['SEO']['seo_about_img_alt']->value ?? 'MLG Finedge Verified Loan Advisory Firm Jaipur' }}">
                                </div>
                            </div>
                        </div>

                        <!-- Home Slides Alt Tags -->
                        <div class="admin-card">
                            <h2><i data-lucide="sliders" style="color: var(--accent-orange); margin-right: 6px;"></i> Homepage Slider Images Alt Tags</h2>
                            <div class="admin-table-wrap">
                                <table class="admin-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 15%;">Slide Image</th>
                                            <th style="width: 35%;">Slide Title</th>
                                            <th style="width: 50%;">Image Alt Text</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($slides as $sl)
                                            <tr>
                                                <td>
                                                    @if(!empty($sl->image_path))
                                                        <img src="{{ site_image($sl->image_path) }}" alt="{{ $sl->title }}" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px; border: 1px solid var(--admin-border);">
                                                    @else
                                                        <span style="font-size: 0.75rem; color: var(--admin-text-muted);">Gradient BG</span>
                                                    @endif
                                                </td>
                                                <td><strong>{{ $sl->title }}</strong></td>
                                                <td>
                                                    <input type="text" name="slides[{{ $sl->id }}]" class="form-control" value="{{ $sl->alt_text ?: ($sl->title . ' - MLG Finedge Jaipur') }}" placeholder="Descriptive Alt Text for this slide">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Service Card Images Alt Tags -->
                        <div class="admin-card">
                            <h2><i data-lucide="layers" style="color: #8ab4f8; margin-right: 6px;"></i> Loan Services Alt Tags</h2>
                            <div class="admin-table-wrap">
                                <table class="admin-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 35%;">Service Name</th>
                                            <th style="width: 65%;">Service Image / Banner Alt Text</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($services as $ser)
                                            <tr>
                                                <td><strong>{{ $ser->service_name }}</strong></td>
                                                <td>
                                                    <input type="text" name="services[{{ $ser->id }}]" class="form-control" value="{{ $ser->image_alt ?: ($ser->service_name . ' - MLG Finedge Loan Solutions') }}" placeholder="Alt text for service card and banner">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Blog Images Alt Tags -->
                        <div class="admin-card">
                            <h2><i data-lucide="book-open" style="color: #c084fc; margin-right: 6px;"></i> Blog Posts Featured Images Alt Tags</h2>
                            <div class="admin-table-wrap">
                                <table class="admin-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 15%;">Thumbnail</th>
                                            <th style="width: 35%;">Article Title</th>
                                            <th style="width: 50%;">Featured Image Alt Text</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($blogs as $b)
                                            <tr>
                                                <td>
                                                    @if(!empty($b->image_path))
                                                        <img src="{{ site_image($b->image_path) }}" alt="{{ $b->title }}" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px; border: 1px solid var(--admin-border);">
                                                    @else
                                                        <span style="font-size: 0.75rem; color: var(--admin-text-muted);">Icon</span>
                                                    @endif
                                                </td>
                                                <td><strong>{{ $b->title }}</strong></td>
                                                <td>
                                                    <input type="text" name="blogs[{{ $b->id }}]" class="form-control" value="{{ $b->image_alt ?: ($b->title . ' - MLG Finedge Blog') }}" placeholder="Alt text for blog article cover">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit" style="padding: 0.85rem 2rem; font-size: 1rem;">
                            <i data-lucide="save" style="display: inline-block; vertical-align: middle; margin-right: 6px;"></i> Update All Image Alt Tags
                        </button>
                    </form>
                </div>

                <!-- SUBPANEL 6: GLOBAL SEO & SOCIAL DEFAULTS -->
                <div class="seo-subpanel" id="seo-subpanel-global" style="display: none;">
                    <form action="{{ route('admin.seo.global.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="admin-card">
                            <h2><i data-lucide="globe" style="color: var(--mint-green); margin-right: 6px;"></i> Global Meta Defaults & Verification</h2>
                            <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.5rem; margin-top: -1rem;">
                                These parameters act as universal fallbacks whenever a page or dynamic record does not specify custom values.
                            </p>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="seo_title_suffix">Meta Title Suffix (Appended to page titles)</label>
                                    <input type="text" id="seo_title_suffix" name="seo_title_suffix" class="form-control" value="{{ $parameters['SEO']['seo_title_suffix']->value ?? ' | MLG Finedge Jaipur' }}" placeholder="e.g.  | MLG Finedge Jaipur">
                                </div>
                                <div class="form-group">
                                    <label for="seo_default_robots">Default Robots Directive</label>
                                    <select id="seo_default_robots" name="seo_default_robots" class="form-control">
                                        @php $defRob = $parameters['SEO']['seo_default_robots']->value ?? 'index, follow'; @endphp
                                        <option value="index, follow" @if($defRob === 'index, follow') selected @endif>index, follow (Recommended)</option>
                                        <option value="noindex, follow" @if($defRob === 'noindex, follow') selected @endif>noindex, follow</option>
                                        <option value="noindex, nofollow" @if($defRob === 'noindex, nofollow') selected @endif>noindex, nofollow</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="seo_default_description">Default Meta Description</label>
                                <textarea id="seo_default_description" name="seo_default_description" class="form-control" rows="2">{{ $parameters['SEO']['seo_default_description']->value ?? 'MLG Finedge is the leading loan provider in Gopalpura Jaipur. We offer expert loan advisory & consultation for Personal Loans, Home Loans, Business Loans, and LAP.' }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="seo_default_keywords">Default Meta Keywords</label>
                                <input type="text" id="seo_default_keywords" name="seo_default_keywords" class="form-control" value="{{ $parameters['SEO']['seo_default_keywords']->value ?? 'loan provider jaipur, loan advisor gopalpura, home loan, business loan, personal loan, loan against property, mlg finedge' }}">
                            </div>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="seo_twitter_handle">Twitter / X Username</label>
                                    <input type="text" id="seo_twitter_handle" name="seo_twitter_handle" class="form-control" value="{{ $parameters['SEO']['seo_twitter_handle']->value ?? '@mlgfinedge' }}" placeholder="@mlgfinedge">
                                </div>
                                <div class="form-group">
                                    <label for="seo_google_verification">Google Search Console Verification Code</label>
                                    <input type="text" id="seo_google_verification" name="seo_google_verification" class="form-control" value="{{ $parameters['SEO']['seo_google_verification']->value ?? '' }}" placeholder="Paste verification meta content string">
                                </div>
                                <div class="form-group">
                                    <label for="seo_bing_verification">Bing Webmaster Verification Code</label>
                                    <input type="text" id="seo_bing_verification" name="seo_bing_verification" class="form-control" value="{{ $parameters['SEO']['seo_bing_verification']->value ?? '' }}" placeholder="msvalidate.01 content">
                                </div>
                            </div>

                            <!-- Default Social Share OG Image -->
                            <div class="form-group" style="margin-top: 1rem;">
                                <label for="seo_default_og_image">Default OG Social Sharing Image (1200x630px recommended)</label>
                                <input type="file" id="seo_default_og_image" name="seo_default_og_image" class="form-control" accept="image/*">
                                @if(!empty($parameters['SEO']['seo_default_og_image']->value))
                                    <div style="margin-top: 8px; display: flex; align-items: center; gap: 10px;">
                                        <img src="{{ site_image($parameters['SEO']['seo_default_og_image']->value) }}" alt="OG Default" style="height: 50px; width: 90px; object-fit: cover; border-radius: 4px; border: 1px solid var(--admin-border);">
                                        <span style="font-size: 0.8rem; color: var(--admin-text-muted);">Current Global Image: {{ basename($parameters['SEO']['seo_default_og_image']->value) }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Global Knowledge Graph Schema -->
                            <div class="form-group" style="margin-top: 1.5rem;">
                                <label for="seo_global_schema">Global Organization / LocalBusiness JSON-LD Schema (Injected on all pages)</label>
                                <textarea id="seo_global_schema" name="seo_global_schema" class="form-control" rows="5" style="font-family: monospace; font-size: 0.82rem;" placeholder="<script type=&quot;application/ld+json&quot;>...</script>">{{ $parameters['SEO']['seo_global_schema']->value ?? '' }}</textarea>
                            </div>

                            <button type="submit" class="btn-submit" style="margin-top: 1rem;">
                                <i data-lucide="save" style="display: inline-block; vertical-align: middle; margin-right: 4px;"></i> Save Global SEO Settings
                            </button>
                        </div>
                    </form>
                </div>

                <!-- SUBPANEL 7: AI BLUEPRINTS & KEYWORD STRATEGY -->
                <div class="seo-subpanel" id="seo-subpanel-blueprints" style="display: none;">
                    <div class="admin-card">
                        <h2><i data-lucide="trending-up" style="display: inline-block; vertical-align: middle; margin-right: 5px;"></i> AI SEO Recommendations & Link-Building Blueprint</h2>
                        <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.5rem; margin-top: -1rem;">
                            Enter the target keywords or topics you want to rank for. Our AI will analyze search intent and draft a comprehensive blueprint of content ideas, guest articles, Quora answers, social copy, bookmarking platforms, and backlink opportunities.
                        </p>
                        <div class="form-group">
                            <label for="seo_keywords">Target Keywords (comma-separated or one per line)</label>
                            <textarea id="seo_keywords" class="form-control" rows="3" placeholder="e.g. low interest home loan, best financial adviser jaipur, secure business loans for startups"></textarea>
                        </div>
                        <button type="button" class="btn-ai-sparkle" onclick="generateSeoRecommendations()" style="margin-top: 1rem; padding: 0.75rem 1.5rem; font-size: 0.95rem;">
                            <i data-lucide="sparkles"></i> Generate SEO Blueprint
                        </button>
                    </div>

                    <div class="admin-card" id="seo-loader" style="display: none; padding: 4rem 2rem; text-align: center;">
                        <div class="ai-sparkle-loader" style="margin: 0 auto 1.5rem auto;"></div>
                        <h3 style="margin: 0; font-size: 1.25rem;">Analyzing Keywords & Formulating SEO Blueprint...</h3>
                        <p style="color: var(--admin-text-muted); margin-top: 5px; font-size: 0.9rem;">Gemini is researching backlink strategies and content maps in the background.</p>
                    </div>

                    <div id="seo-results" style="display: none;">
                        <div style="display: flex; justify-content: space-between; align-items: center; gap: 15px; margin-bottom: 1.5rem; border-bottom: 1px solid var(--admin-border); padding-bottom: 10px; flex-wrap: wrap;">
                            <div style="display: flex; gap: 8px; overflow-x: auto; flex-grow: 1; padding-bottom: 5px;">
                                <button type="button" class="btn-submit active" id="seo-tab-btn-content" onclick="switchSeoResultTab('content')" style="width: auto; padding: 0.5rem 1rem; font-size: 0.85rem;">Pages & Blogs</button>
                                <button type="button" class="btn-submit" id="seo-tab-btn-backlinks" onclick="switchSeoResultTab('backlinks')" style="width: auto; padding: 0.5rem 1rem; font-size: 0.85rem; background-color: var(--admin-input-bg); color: #fff;">Backlink Targets</button>
                                <button type="button" class="btn-submit" id="seo-tab-btn-quora" onclick="switchSeoResultTab('quora')" style="width: auto; padding: 0.5rem 1rem; font-size: 0.85rem; background-color: var(--admin-input-bg); color: #fff;">Quora & Q&A</button>
                                <button type="button" class="btn-submit" id="seo-tab-btn-social" onclick="switchSeoResultTab('social')" style="width: auto; padding: 0.5rem 1rem; font-size: 0.85rem; background-color: var(--admin-input-bg); color: #fff;">Social & Pinterest</button>
                                <button type="button" class="btn-submit" id="seo-tab-btn-bookmarking" onclick="switchSeoResultTab('bookmarking')" style="width: auto; padding: 0.5rem 1rem; font-size: 0.85rem; background-color: var(--admin-input-bg); color: #fff;">Bookmarking & Syndication</button>
                                <button type="button" class="btn-submit" id="seo-tab-btn-other" onclick="switchSeoResultTab('other')" style="width: auto; padding: 0.5rem 1rem; font-size: 0.85rem; background-color: var(--admin-input-bg); color: #fff;">Growth Tactics</button>
                            </div>
                            <div>
                                <button type="button" class="btn-submit" onclick="downloadSeoPdf()" style="width: auto; padding: 0.5rem 1.25rem; font-size: 0.85rem; background-color: var(--accent-teal); color: var(--primary-teal-dark); font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                                    <i data-lucide="download" style="width: 16px; height: 16px;"></i> Download PDF Report
                                </button>
                            </div>
                        </div>

                        <!-- Result Panels -->
                        <div class="seo-result-panel active" id="seo-panel-content">
                            <div class="admin-card">
                                <h2>On-Site Content Structure Recommendations</h2>
                                <div class="admin-table-wrap">
                                    <table class="admin-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 15%;">Type</th>
                                                <th style="width: 25%;">Recommended Title</th>
                                                <th style="width: 20%;">Target Keywords</th>
                                                <th style="width: 40%;">Content Outline & Search Intent</th>
                                            </tr>
                                        </thead>
                                        <tbody id="seo-table-content"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="seo-result-panel" id="seo-panel-backlinks" style="display: none;">
                            <div class="admin-card">
                                <h2>Third-Party Off-Site Content & Backlinks</h2>
                                <div class="admin-table-wrap">
                                    <table class="admin-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 20%;">Platform Type</th>
                                                <th style="width: 30%;">Article Title Idea</th>
                                                <th style="width: 20%;">Target Anchor Keywords</th>
                                                <th style="width: 30%;">Backlink Integration Context</th>
                                            </tr>
                                        </thead>
                                        <tbody id="seo-table-backlinks"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="seo-result-panel" id="seo-panel-quora" style="display: none;">
                            <div class="admin-card">
                                <h2>Quora Authority Building & Referral Traffic</h2>
                                <div id="seo-cards-quora" style="display: flex; flex-direction: column; gap: 1rem;"></div>
                            </div>
                        </div>

                        <div class="seo-result-panel" id="seo-panel-social" style="display: none;">
                            <div class="form-grid">
                                <div class="admin-card">
                                    <h2>Pinterest Graphic & Post Layouts</h2>
                                    <div class="admin-table-wrap">
                                        <table class="admin-table">
                                            <thead>
                                                <tr>
                                                    <th>Overlay Bold Text</th>
                                                    <th>Visual Graphic Concept</th>
                                                    <th>Category</th>
                                                </tr>
                                            </thead>
                                            <tbody id="seo-table-pinterest"></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="admin-card">
                                    <h2>Written Social Media Posts</h2>
                                    <div id="seo-cards-social" style="display: flex; flex-direction: column; gap: 1rem;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="seo-result-panel" id="seo-panel-bookmarking" style="display: none;">
                            <div class="form-grid">
                                <div class="admin-card">
                                    <h2>Bookmarking Websites & Submission Strategy</h2>
                                    <div class="admin-table-wrap">
                                        <table class="admin-table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 25%;">Platform</th>
                                                    <th style="width: 75%;">Tactical Submission Strategy</th>
                                                </tr>
                                            </thead>
                                            <tbody id="seo-table-bookmarking"></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="admin-card">
                                    <h2>Blog Promotion & Syndication Websites</h2>
                                    <div class="admin-table-wrap">
                                        <table class="admin-table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 25%;">Platform</th>
                                                    <th style="width: 75%;">Tactical Syndication Strategy</th>
                                                </tr>
                                            </thead>
                                            <tbody id="seo-table-syndication"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="seo-result-panel" id="seo-panel-other" style="display: none;">
                            <div class="admin-card">
                                <h2>Growth Tactics & Backlink Submission Blueprints</h2>
                                <div id="seo-cards-other" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SUBPANEL 8: XML SITEMAP & SEARCH ENGINES -->
                <div class="seo-subpanel" id="seo-subpanel-sitemap" style="display: none;">
                    <div class="admin-card">
                        <h2><i data-lucide="map" style="display: inline-block; vertical-align: middle; margin-right: 5px;"></i> XML Sitemap & Search Engine Indexing</h2>
                        <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.5rem; margin-top: -1rem;">
                            Regenerate the website XML sitemap and notify search engines whenever you add new service pages, blogs, or landing pages.
                        </p>
                        
                        <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                            <form action="{{ route('admin.sitemap.generate') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-submit" style="width: auto; padding: 0.75rem 1.75rem;">
                                    <i data-lucide="refresh-cw" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 6px;"></i> Regenerate XML Sitemap
                                </button>
                            </form>
                            <a href="/sitemap.xml" target="_blank" class="btn-submit" style="background: var(--admin-input-bg); color: #fff; width: auto; padding: 0.75rem 1.5rem; border: 1px solid var(--admin-border); text-decoration: none;">
                                <i data-lucide="external-link" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i> Open /sitemap.xml
                            </a>
                        </div>

                        <div style="margin-top: 2rem; border-top: 1px solid var(--admin-border); padding-top: 1.5rem;">
                            <h3 style="font-size: 1rem; margin-bottom: 0.75rem;">Search Engine Webmaster Tools Quick Links</h3>
                            <ul style="list-style: none; padding: 0; margin: 0; display: flex; gap: 1.5rem; flex-wrap: wrap;">
                                <li>
                                    <a href="https://search.google.com/search-console" target="_blank" style="color: var(--mint-green); text-decoration: underline; display: inline-flex; align-items: center; gap: 4px;">
                                        <i data-lucide="external-link" style="width: 14px; height: 14px;"></i> Google Search Console
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.bing.com/webmasters" target="_blank" style="color: var(--mint-green); text-decoration: underline; display: inline-flex; align-items: center; gap: 4px;">
                                        <i data-lucide="external-link" style="width: 14px; height: 14px;"></i> Bing Webmaster Tools
                                    </a>
                                </li>
                                <li>
                                    <a href="https://developers.google.com/search/docs/appearance/structured-data" target="_blank" style="color: var(--mint-green); text-decoration: underline; display: inline-flex; align-items: center; gap: 4px;">
                                        <i data-lucide="external-link" style="width: 14px; height: 14px;"></i> Google Rich Results Test Tool
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Toast Notification Container -->
    <div id="ai-toast-container" style="position: fixed; bottom: 20px; right: 20px; z-index: 999999; display: flex; flex-direction: column; gap: 10px;"></div>

    <!-- AI Landing Page Generator Modal -->
    <div class="ai-modal-overlay" id="ai-landing-modal">
        <div class="ai-modal-card">
            <button class="ai-modal-close" onclick="closeAiModal('landing')">&times;</button>
            <h3><i data-lucide="sparkles"></i> AI Landing Page Generator</h3>
            
            <input type="hidden" id="ai_landing_id" value="">
            <div id="ai-landing-form-wrapper">
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label>Page Title</label>
                    <input type="text" id="ai_landing_target_title" class="form-control" readonly style="opacity: 0.7;">
                </div>
                <div class="form-group">
                    <label for="ai_landing_prompt">Prompt / Describe the topic for this Landing Page</label>
                    <textarea id="ai_landing_prompt" class="form-control" rows="4" placeholder="e.g. Special home loan advisory page for Doctors and medical professionals in Jaipur with special pre-approved limit and minimal paperwork..."></textarea>
                </div>
                <div style="display: flex; gap: 10px; margin-top: 1.5rem;">
                    <button type="button" class="btn-ai-sparkle" onclick="generateAiLandingPage()"><i data-lucide="sparkles"></i> Generate Content</button>
                    <button type="button" class="btn-submit" style="background-color: var(--admin-input-bg); color: #fff; width: auto;" onclick="closeAiModal('landing')">Cancel</button>
                </div>
            </div>
            
            <div class="ai-loader-container" id="ai-landing-loader">
                <div class="ai-sparkle-loader"></div>
                <p class="ai-loader-text">Gemini is designing and writing your landing page...</p>
                <p class="ai-loader-subtext">This can take up to 10-15 seconds.</p>
            </div>
        </div>
    </div>

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

    <!-- GMB Sharing Modal -->
    <div class="ai-modal-overlay" id="gmb-share-modal">
        <div class="ai-modal-card">
            <button class="ai-modal-close" onclick="closeGmbModal()">&times;</button>
            <h3><i data-lucide="share-2" style="color: #4285F4; display: inline-block; vertical-align: middle;"></i> Share to Google Business Profile</h3>
            
            <div id="gmb-form-wrapper">
                <input type="hidden" id="gmb_post_type">
                <input type="hidden" id="gmb_post_id">
                <input type="hidden" id="gmb_target_url">
                
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label><strong>Post Text Copy (AI Generated or Custom)</strong></label>
                    <textarea id="gmb_post_text" class="form-control" rows="8" placeholder="Drafting your GMB post..."></textarea>
                </div>
                
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label><strong>Action Button (CTA) Target Link</strong></label>
                    <input type="text" id="gmb_post_cta_url" class="form-control" readonly style="background-color: var(--admin-input-bg); opacity: 0.8;">
                    <span style="font-size: 0.75rem; color: var(--admin-text-muted); display: block; margin-top: 5px;">
                        This CTA button redirects users to the page above with the label "Learn More".
                    </span>
                </div>
                
                <div style="background: rgba(232, 92, 36, 0.1); border: 1px solid rgba(232, 92, 36, 0.3); border-radius: var(--radius-sm); padding: 12px; margin-bottom: 1.5rem; font-size: 0.85rem;" id="gmb-manual-notice">
                    <strong style="color: var(--accent-orange);"><i data-lucide="info" style="width: 14px; height: 14px; display: inline; vertical-align: middle;"></i> Tip:</strong>
                    Copy the draft and use the "Open GMB Dashboard" button to publish it manually on Google Business Profile if GBP API is not configured.
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <button type="button" class="btn-ai-sparkle" onclick="generateGmbDraft()" id="gmb-draft-btn" style="padding: 0.5rem 1rem; font-size: 0.85rem; width: auto;">
                            <i data-lucide="sparkles"></i> Draft with AI
                        </button>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button type="button" class="btn-submit" style="background-color: var(--admin-input-bg); color: #fff; width: auto;" onclick="closeGmbModal()">Cancel</button>
                        
                        @if(!empty($site['gmb_location_id']) && !empty($site['gmb_access_token']))
                            <button type="button" class="btn-submit" style="background-color: #4285F4; color: #fff; width: auto;" onclick="publishGmbPostDirect()" id="gmb-publish-btn">
                                <i data-lucide="check"></i> Publish Now
                            </button>
                        @endif
                        
                        <button type="button" class="btn-submit" style="background-color: var(--mint-green); color: var(--primary-teal-dark); width: auto;" onclick="copyAndOpenGmb()" id="gmb-manual-btn">
                            <i data-lucide="external-link"></i> Copy & Open Dashboard
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="ai-loader-container" id="gmb-loader" style="display: none;">
                <div class="ai-sparkle-loader" style="margin: 0 auto 1.5rem auto;"></div>
                <p class="ai-loader-text" id="gmb-loader-text">Drafting post with Gemini AI...</p>
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

    <!-- Edit Service SEO Modal -->
    <div class="ai-modal-overlay" id="edit-service-seo-modal">
        <div class="ai-modal-card" style="max-width: 800px; max-height: 90vh; overflow-y: auto;">
            <button class="ai-modal-close" onclick="closeServiceSeoModal()">&times;</button>
            <h3 style="color: var(--mint-green);"><i data-lucide="layers"></i> Edit Service SEO & Social Meta</h3>
            
            <form id="service-seo-form" action="" method="POST" enctype="multipart/form-data" style="margin-top: 1.25rem;">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label>Target Service</label>
                        <input type="text" id="svc_seo_name" class="form-control" readonly style="opacity: 0.8; font-weight: 700;">
                    </div>
                    <div class="form-group">
                        <label for="svc_h1_tag">Main H1 Heading Tag (Controllable on-page H1)</label>
                        <input type="text" id="svc_h1_tag" name="h1_tag" class="form-control" placeholder="Defaults to service title if empty">
                    </div>
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between;">
                        <label for="svc_meta_title">Meta Title Tag</label>
                        <span id="svc_title_counter" style="font-size: 0.75rem; color: var(--admin-text-muted);">0 / 60 chars</span>
                    </div>
                    <input type="text" id="svc_meta_title" name="meta_title" class="form-control" oninput="countChars(this, 'svc_title_counter', 60)" placeholder="Primary keyword + Brand name">
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between;">
                        <label for="svc_meta_description">Meta Description</label>
                        <span id="svc_desc_counter" style="font-size: 0.75rem; color: var(--admin-text-muted);">0 / 160 chars</span>
                    </div>
                    <textarea id="svc_meta_description" name="meta_description" class="form-control" rows="3" oninput="countChars(this, 'svc_desc_counter', 160)" placeholder="Compelling call-to-action summary for Google SERP snippet"></textarea>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="svc_meta_keywords">Meta Keywords (Comma separated)</label>
                        <input type="text" id="svc_meta_keywords" name="meta_keywords" class="form-control" placeholder="e.g. home loan jaipur, lowest roi loan">
                    </div>
                    <div class="form-group">
                        <label for="svc_image_alt">Featured Image / Banner Alt Text</label>
                        <input type="text" id="svc_image_alt" name="image_alt" class="form-control" placeholder="Descriptive image alt text">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="svc_canonical_url">Canonical URL (Optional)</label>
                        <input type="text" id="svc_canonical_url" name="canonical_url" class="form-control" placeholder="https://mlgfinedge.com/services/...">
                    </div>
                    <div class="form-group">
                        <label for="svc_meta_robots">Meta Robots Indexing Directive</label>
                        <select id="svc_meta_robots" name="meta_robots" class="form-control">
                            <option value="">Default (Inherit global setting)</option>
                            <option value="index, follow">index, follow (Index and follow links)</option>
                            <option value="noindex, follow">noindex, follow (Do not index)</option>
                            <option value="noindex, nofollow">noindex, nofollow (Block completely)</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="svc_og_image">Social Sharing OpenGraph Image (1200x630px recommended)</label>
                    <input type="file" id="svc_og_image" name="og_image" class="form-control" accept="image/*">
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <label for="svc_schema_markup" style="margin: 0;">JSON-LD Structured Schema Markup</label>
                        <span style="font-size: 0.75rem; color: var(--mint-green);">FinancialProduct / LoanOrCredit Schema</span>
                    </div>
                    <textarea id="svc_schema_markup" name="schema_markup" class="form-control" rows="5" style="font-family: monospace; font-size: 0.8rem;" placeholder="<script type=&quot;application/ld+json&quot;>
{
  &quot;@@context&quot;: &quot;https://schema.org&quot;,
  &quot;@@type&quot;: &quot;FinancialProduct&quot;,
  &quot;name&quot;: &quot;Home Loan&quot;
}
</script>"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 1.5rem;">
                    <button type="button" class="btn-submit" style="background-color: var(--admin-input-bg); color: #fff; width: auto;" onclick="closeServiceSeoModal()">Cancel</button>
                    <button type="submit" class="btn-submit" style="width: auto;">
                        <i data-lucide="save" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i> Save Service SEO
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Blog SEO Modal -->
    <div class="ai-modal-overlay" id="edit-blog-seo-modal">
        <div class="ai-modal-card" style="max-width: 800px; max-height: 90vh; overflow-y: auto;">
            <button class="ai-modal-close" onclick="closeBlogSeoModal()">&times;</button>
            <h3 style="color: #c084fc;"><i data-lucide="book-open"></i> Edit Blog Post SEO & Social Meta</h3>
            
            <form id="blog-seo-form" action="" method="POST" enctype="multipart/form-data" style="margin-top: 1.25rem;">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label>Target Article</label>
                        <input type="text" id="blog_seo_name" class="form-control" readonly style="opacity: 0.8; font-weight: 700;">
                    </div>
                    <div class="form-group">
                        <label for="blog_h1_tag">Controllable H1 Article Heading</label>
                        <input type="text" id="blog_h1_tag" name="h1_tag" class="form-control" placeholder="Defaults to blog title if empty">
                    </div>
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between;">
                        <label for="blog_meta_title">Meta Title Tag</label>
                        <span id="blog_title_counter" style="font-size: 0.75rem; color: var(--admin-text-muted);">0 / 60 chars</span>
                    </div>
                    <input type="text" id="blog_meta_title" name="meta_title" class="form-control" oninput="countChars(this, 'blog_title_counter', 60)" placeholder="SEO Article Title">
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between;">
                        <label for="blog_meta_description">Meta Description</label>
                        <span id="blog_desc_counter" style="font-size: 0.75rem; color: var(--admin-text-muted);">0 / 160 chars</span>
                    </div>
                    <textarea id="blog_meta_description" name="meta_description" class="form-control" rows="3" oninput="countChars(this, 'blog_desc_counter', 160)" placeholder="Meta snippet description"></textarea>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="blog_meta_keywords">Meta Keywords</label>
                        <input type="text" id="blog_meta_keywords" name="meta_keywords" class="form-control" placeholder="e.g. loan interest tips, financial advisor">
                    </div>
                    <div class="form-group">
                        <label for="blog_image_alt">Cover Image Alt Text</label>
                        <input type="text" id="blog_image_alt" name="image_alt" class="form-control" placeholder="Alt text for featured cover">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="blog_canonical_url">Canonical URL (Optional)</label>
                        <input type="text" id="blog_canonical_url" name="canonical_url" class="form-control" placeholder="https://mlgfinedge.com/blog/...">
                    </div>
                    <div class="form-group">
                        <label for="blog_meta_robots">Meta Robots Directive</label>
                        <select id="blog_meta_robots" name="meta_robots" class="form-control">
                            <option value="">Default (Inherit global setting)</option>
                            <option value="index, follow">index, follow</option>
                            <option value="noindex, follow">noindex, follow</option>
                            <option value="noindex, nofollow">noindex, nofollow</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="blog_og_image">OG Social Share Image</label>
                    <input type="file" id="blog_og_image" name="og_image" class="form-control" accept="image/*">
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <label for="blog_schema_markup" style="margin: 0;">BlogPosting / Article JSON-LD Schema</label>
                        <span style="font-size: 0.75rem; color: #c084fc;">BlogPosting / NewsArticle Schema</span>
                    </div>
                    <textarea id="blog_schema_markup" name="schema_markup" class="form-control" rows="5" style="font-family: monospace; font-size: 0.8rem;" placeholder="<script type=&quot;application/ld+json&quot;>...</script>"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 1.5rem;">
                    <button type="button" class="btn-submit" style="background-color: var(--admin-input-bg); color: #fff; width: auto;" onclick="closeBlogSeoModal()">Cancel</button>
                    <button type="submit" class="btn-submit" style="width: auto;">
                        <i data-lucide="save" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i> Save Blog SEO
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Landing Page SEO Modal -->
    <div class="ai-modal-overlay" id="edit-landing-seo-modal">
        <div class="ai-modal-card" style="max-width: 800px; max-height: 90vh; overflow-y: auto;">
            <button class="ai-modal-close" onclick="closeLandingSeoModal()">&times;</button>
            <h3 style="color: #8ab4f8;"><i data-lucide="file-text"></i> Edit Landing Page SEO & Schema</h3>
            
            <form id="landing-seo-form" action="" method="POST" enctype="multipart/form-data" style="margin-top: 1.25rem;">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label>Landing Page</label>
                        <input type="text" id="landing_seo_name" class="form-control" readonly style="opacity: 0.8; font-weight: 700;">
                    </div>
                    <div class="form-group">
                        <label for="landing_h1_tag">Controllable Main H1 Tag</label>
                        <input type="text" id="landing_h1_tag" name="h1_tag" class="form-control" placeholder="Main H1 headline">
                    </div>
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between;">
                        <label for="landing_meta_title">Meta Title Tag</label>
                        <span id="landing_title_counter" style="font-size: 0.75rem; color: var(--admin-text-muted);">0 / 60 chars</span>
                    </div>
                    <input type="text" id="landing_meta_title" name="meta_title" class="form-control" oninput="countChars(this, 'landing_title_counter', 60)">
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between;">
                        <label for="landing_meta_description">Meta Description</label>
                        <span id="landing_desc_counter" style="font-size: 0.75rem; color: var(--admin-text-muted);">0 / 160 chars</span>
                    </div>
                    <textarea id="landing_meta_description" name="meta_description" class="form-control" rows="3" oninput="countChars(this, 'landing_desc_counter', 160)"></textarea>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="landing_meta_keywords">Meta Keywords</label>
                        <input type="text" id="landing_meta_keywords" name="meta_keywords" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="landing_image_alt">Hero Image Alt Text</label>
                        <input type="text" id="landing_image_alt" name="image_alt" class="form-control">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="landing_canonical_url">Canonical URL (Optional)</label>
                        <input type="text" id="landing_canonical_url" name="canonical_url" class="form-control" placeholder="https://mlgfinedge.com/l/...">
                    </div>
                    <div class="form-group">
                        <label for="landing_meta_robots">Meta Robots Directive</label>
                        <select id="landing_meta_robots" name="meta_robots" class="form-control">
                            <option value="">Default (Inherit global setting)</option>
                            <option value="index, follow">index, follow</option>
                            <option value="noindex, follow">noindex, follow</option>
                            <option value="noindex, nofollow">noindex, nofollow</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="landing_og_image">OG Social Share Image</label>
                    <input type="file" id="landing_og_image" name="og_image" class="form-control" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="landing_schema_markup">JSON-LD Structured Schema Markup</label>
                    <textarea id="landing_schema_markup" name="schema_markup" class="form-control" rows="5" style="font-family: monospace; font-size: 0.8rem;" placeholder="<script type=&quot;application/ld+json&quot;>...</script>"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 1.5rem;">
                    <button type="button" class="btn-submit" style="background-color: var(--admin-input-bg); color: #fff; width: auto;" onclick="closeLandingSeoModal()">Cancel</button>
                    <button type="submit" class="btn-submit" style="width: auto;">
                        <i data-lucide="save" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i> Save Landing SEO
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- AI SEO & Schema Generator Modal -->
    <div class="ai-modal-overlay" id="ai-seo-generator-modal">
        <div class="ai-modal-card" style="max-width: 650px;">
            <button class="ai-modal-close" onclick="closeAiSeoModal()">&times;</button>
            <h3><i data-lucide="sparkles" style="color: #a855f7;"></i> AI Complete SEO & Schema Generator</h3>
            
            <div id="ai-seo-form-wrapper">
                <input type="hidden" id="ai_seo_type" value="page">
                <input type="hidden" id="ai_seo_page_key" value="">
                <input type="hidden" id="ai_seo_id" value="">
                
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label>Target Page / Subject</label>
                    <input type="text" id="ai_seo_target_name" class="form-control" readonly style="opacity: 0.85; font-weight: 700;">
                </div>

                <div class="form-group">
                    <label for="ai_seo_extra_prompt">Target Keyword Focus & Intent (Optional)</label>
                    <textarea id="ai_seo_extra_prompt" class="form-control" rows="3" placeholder="e.g. Focus on low interest rate home loans for first-time buyers in Gopalpura Jaipur, fast approval, minimal documentation"></textarea>
                </div>

                <div style="display: flex; gap: 10px; margin-top: 1.5rem; justify-content: flex-end;">
                    <button type="button" class="btn-submit" style="background-color: var(--admin-input-bg); color: #fff; width: auto;" onclick="closeAiSeoModal()">Cancel</button>
                    <button type="button" class="btn-ai-sparkle" onclick="executeAiSeoGeneration()"><i data-lucide="sparkles"></i> Generate SEO Suite</button>
                </div>
            </div>

            <div class="ai-loader-container" id="ai-seo-loader" style="display: none; padding: 3rem 1rem; text-align: center;">
                <div class="ai-sparkle-loader" style="margin: 0 auto 1.5rem auto;"></div>
                <p class="ai-loader-text" style="font-weight: 600; font-size: 1.1rem; color: #fff;">Gemini is crafting high-CTR SEO Meta Tags & Schema...</p>
                <p class="ai-loader-subtext" style="color: var(--admin-text-muted); font-size: 0.85rem; margin-top: 4px;">Optimizing character lengths for Google SERP and writing valid JSON-LD.</p>
            </div>
        </div>
    </div>


    <!-- TinyMCE Rich Text & HTML Source Code Editor Overrides -->
    <style>
        .tox-tinymce {
            border-radius: var(--radius-md) !important;
            border: 1px solid var(--admin-border) !important;
            overflow: hidden;
        }
        .tox-tinymce-aux {
            z-index: 100000 !important;
        }
    </style>

    <!-- Lucide CDN & TinyMCE CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- html2pdf.js CDN for PDF Download -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        lucide.createIcons();

        // Safe JSON storage for blog articles (avoids inline HTML escaping corruption)
        const adminBlogsData = {
            @foreach($blogs as $b)
                {{ $b->id }}: {
                    id: {{ $b->id }},
                    title: @json($b->title),
                    slug: @json($b->slug),
                    category: @json($b->category),
                    published_at: @json($b->published_at ? $b->published_at->format('Y-m-d\TH:i') : $b->created_at->format('Y-m-d\TH:i')),
                    summary: @json($b->summary),
                    content: @json($b->content),
                    image_path: @json($b->image_path),
                    schema_markup: @json($b->schema_markup)
                },
            @endforeach
        };

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

        function pushLocalDatabaseToLive(btn) {
            const liveUrlInput = document.getElementById('live_site_url');
            const liveUrl = liveUrlInput ? liveUrlInput.value.trim() : 'https://mlgfinedge.com';
            
            if (!liveUrl) {
                showToast('Please enter a valid Live Site Base URL first.', 'error');
                return;
            }

            if (!confirm('Are you sure you want to push your local database content to the live server? This will overwrite the live server\'s Settings, Slides, Blogs, Services, and Page Contents with your local ones.')) {
                return;
            }

            const originalHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="ai-toast-spinner" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-right: 5px;"></span> Pushing...';

            showToast('Gathering local records and pushing to live server...', 'info');

            fetch("{{ route('admin.database.push-to-live') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    live_site_url: liveUrl
                })
            })
            .then(res => res.json())
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
                if (res.success) {
                    showToast(res.message, 'success');
                } else {
                    showToast(res.message || 'Push failed.', 'error');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
                showToast('Push network error: ' + err.message, 'error');
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
            const mBtn = document.getElementById('m-btn-' + tabId);
            if (!panel) return;

            document.querySelectorAll('.tab-panel').forEach(p => {
                p.classList.remove('active');
            });
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('active');
            });
            document.querySelectorAll('.mobile-tab-btn').forEach(b => {
                b.classList.remove('active');
            });
            panel.classList.add('active');
            if (btn) btn.classList.add('active');
            if (mBtn) {
                mBtn.classList.add('active');
                // Scroll the mobile tab button into view automatically
                mBtn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }

            // Save to localStorage to persist tab across refreshes/saves
            localStorage.setItem('active_tab', tabId);

            if (tabId === 'analytics') {
                fetchCloudflareAnalytics();
            }

            // Close sidebar on mobile
            const sidebar = document.querySelector('.sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            if (sidebar && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
                if (backdrop) backdrop.classList.remove('show');
            }
        }

        // Toggle Sidebar drawer on mobile or collapse on desktop
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            if (sidebar) {
                if (window.innerWidth >= 992) {
                    document.body.classList.toggle('sidebar-collapsed');
                } else {
                    sidebar.classList.toggle('show');
                    if (backdrop) {
                        backdrop.classList.toggle('show');
                    }
                }
            }
        }

        // Character counter utility
        function countChars(input, counterId, targetMax) {
            const len = input.value.length;
            const counterEl = document.getElementById(counterId);
            if (!counterEl) return;
            
            counterEl.textContent = `${len} / ${targetMax} chars`;
            if (len > targetMax) {
                counterEl.style.color = '#ef4444';
            } else if (len >= (targetMax * 0.8)) {
                counterEl.style.color = 'var(--mint-green)';
            } else {
                counterEl.style.color = 'var(--admin-text-muted)';
            }
        }

        // Switch SEO Subtabs (Pages, Services, Blogs, Landing, Alts, Global, Blueprints, Sitemap)
        function switchSeoSubTab(subTabId) {
            document.querySelectorAll('.seo-subtab-btn').forEach(btn => {
                btn.classList.remove('active');
                btn.style.backgroundColor = 'var(--admin-input-bg)';
                btn.style.color = '#fff';
            });
            document.querySelectorAll('.seo-subpanel').forEach(panel => {
                panel.style.display = 'none';
            });

            const activeBtn = document.getElementById('btn-seo-sub-' + subTabId);
            const activePanel = document.getElementById('seo-subpanel-' + subTabId);

            if (activeBtn) {
                activeBtn.classList.add('active');
                activeBtn.style.backgroundColor = '';
                activeBtn.style.color = '';
            }
            if (activePanel) {
                activePanel.style.display = 'block';
            }

            localStorage.setItem('active_seo_subtab', subTabId);
            if (window.lucide) {
                setTimeout(() => lucide.createIcons(), 50);
            }
        }

        function restoreSeoSubTab() {
            const saved = localStorage.getItem('active_seo_subtab') || 'pages';
            switchSeoSubTab(saved);
        }

        // Select which Core Page to Edit in Subpanel 1
        function selectPageSeoEditor(pageKey) {
            document.querySelectorAll('.page-selector-btn').forEach(btn => {
                btn.classList.remove('active');
                btn.style.backgroundColor = 'var(--admin-input-bg)';
                btn.style.color = '#fff';
            });
            document.querySelectorAll('.page-seo-form-container').forEach(box => {
                box.style.display = 'none';
            });

            const targetBtn = document.getElementById('btn-page-sel-' + pageKey);
            const targetBox = document.getElementById('page-seo-box-' + pageKey);

            if (targetBtn) {
                targetBtn.classList.add('active');
                targetBtn.style.backgroundColor = '';
                targetBtn.style.color = '';
            }
            if (targetBox) {
                targetBox.style.display = 'block';
            }

            updateSerpPreview(pageKey);
            if (window.lucide) {
                setTimeout(() => lucide.createIcons(), 50);
            }
        }

        // Live Google SERP Previewer
        function updateSerpPreview(pageKey) {
            const titleInput = document.getElementById(`meta_title_${pageKey}`);
            const descInput = document.getElementById(`meta_desc_${pageKey}`);
            
            const previewTitle = document.getElementById(`serp_title_${pageKey}`);
            const previewDesc = document.getElementById(`serp_desc_${pageKey}`);
            
            const titleCount = document.getElementById(`cnt_title_${pageKey}`);
            const descCount = document.getElementById(`cnt_desc_${pageKey}`);

            if (titleInput) {
                const len = titleInput.value.length;
                if (titleCount) {
                    titleCount.textContent = `${len} / 60 chars`;
                    titleCount.style.color = len > 60 ? '#ef4444' : (len >= 40 ? 'var(--mint-green)' : 'var(--accent-orange)');
                }
                if (previewTitle) {
                    previewTitle.textContent = titleInput.value.trim() || 'Page Title | MLG Finedge';
                }
            }

            if (descInput) {
                const len = descInput.value.length;
                if (descCount) {
                    descCount.textContent = `${len} / 160 chars`;
                    descCount.style.color = len > 160 ? '#ef4444' : (len >= 100 ? 'var(--mint-green)' : 'var(--accent-orange)');
                }
                if (previewDesc) {
                    previewDesc.textContent = descInput.value.trim() || 'Page meta description snippet preview...';
                }
            }
        }

        // Modals Management for Service, Blog, Landing Page SEO
        function openServiceSeoModal(service) {
            const form = document.getElementById('service-seo-form');
            if (form) form.action = `/admin/seo/services/${service.id}`;
            
            document.getElementById('svc_seo_name').value = service.service_name || '';
            document.getElementById('svc_h1_tag').value = service.h1_tag || '';
            document.getElementById('svc_meta_title').value = service.meta_title || '';
            document.getElementById('svc_meta_description').value = service.meta_description || '';
            document.getElementById('svc_meta_keywords').value = service.meta_keywords || '';
            document.getElementById('svc_image_alt').value = service.image_alt || '';
            document.getElementById('svc_canonical_url').value = service.canonical_url || '';
            document.getElementById('svc_meta_robots').value = service.meta_robots || '';
            document.getElementById('svc_schema_markup').value = service.schema_markup || '';

            countChars(document.getElementById('svc_meta_title'), 'svc_title_counter', 60);
            countChars(document.getElementById('svc_meta_description'), 'svc_desc_counter', 160);

            const overlay = document.getElementById('edit-service-seo-modal');
            if (overlay) {
                overlay.style.display = 'flex';
                setTimeout(() => overlay.classList.add('show'), 10);
            }
        }

        function closeServiceSeoModal() {
            const overlay = document.getElementById('edit-service-seo-modal');
            if (overlay) {
                overlay.classList.remove('show');
                setTimeout(() => { overlay.style.display = 'none'; }, 300);
            }
        }

        function openBlogSeoModal(blog) {
            const form = document.getElementById('blog-seo-form');
            if (form) form.action = `/admin/seo/blogs/${blog.id}`;
            
            document.getElementById('blog_seo_name').value = blog.title || '';
            document.getElementById('blog_h1_tag').value = blog.h1_tag || '';
            document.getElementById('blog_meta_title').value = blog.meta_title || '';
            document.getElementById('blog_meta_description').value = blog.meta_description || '';
            document.getElementById('blog_meta_keywords').value = blog.meta_keywords || '';
            document.getElementById('blog_image_alt').value = blog.image_alt || '';
            document.getElementById('blog_canonical_url').value = blog.canonical_url || '';
            document.getElementById('blog_meta_robots').value = blog.meta_robots || '';
            document.getElementById('blog_schema_markup').value = blog.schema_markup || '';

            countChars(document.getElementById('blog_meta_title'), 'blog_title_counter', 60);
            countChars(document.getElementById('blog_meta_description'), 'blog_desc_counter', 160);

            const overlay = document.getElementById('edit-blog-seo-modal');
            if (overlay) {
                overlay.style.display = 'flex';
                setTimeout(() => overlay.classList.add('show'), 10);
            }
        }

        function closeBlogSeoModal() {
            const overlay = document.getElementById('edit-blog-seo-modal');
            if (overlay) {
                overlay.classList.remove('show');
                setTimeout(() => { overlay.style.display = 'none'; }, 300);
            }
        }

        function openLandingSeoModal(landing) {
            const form = document.getElementById('landing-seo-form');
            if (form) form.action = `/admin/seo/landing/${landing.id}`;
            
            document.getElementById('landing_seo_name').value = landing.title || '';
            document.getElementById('landing_h1_tag').value = landing.h1_tag || '';
            document.getElementById('landing_meta_title').value = landing.meta_title || '';
            document.getElementById('landing_meta_description').value = landing.meta_description || '';
            document.getElementById('landing_meta_keywords').value = landing.meta_keywords || '';
            document.getElementById('landing_image_alt').value = landing.image_alt || '';
            document.getElementById('landing_canonical_url').value = landing.canonical_url || '';
            document.getElementById('landing_meta_robots').value = landing.meta_robots || '';
            document.getElementById('landing_schema_markup').value = landing.schema_markup || '';

            countChars(document.getElementById('landing_meta_title'), 'landing_title_counter', 60);
            countChars(document.getElementById('landing_meta_description'), 'landing_desc_counter', 160);

            const overlay = document.getElementById('edit-landing-seo-modal');
            if (overlay) {
                overlay.style.display = 'flex';
                setTimeout(() => overlay.classList.add('show'), 10);
            }
        }

        function closeLandingSeoModal() {
            const overlay = document.getElementById('edit-landing-seo-modal');
            if (overlay) {
                overlay.classList.remove('show');
                setTimeout(() => { overlay.style.display = 'none'; }, 300);
            }
        }

        // AI Complete SEO & Schema Generation
        function triggerAiSeoGenerate(type, pageKey, id, name) {
            document.getElementById('ai_seo_type').value = type;
            document.getElementById('ai_seo_page_key').value = pageKey || '';
            document.getElementById('ai_seo_id').value = id || '';
            document.getElementById('ai_seo_target_name').value = name || (pageKey ? pageKey.toUpperCase() + ' Page' : 'Target Entity');
            document.getElementById('ai_seo_extra_prompt').value = '';

            const overlay = document.getElementById('ai-seo-generator-modal');
            if (overlay) {
                overlay.style.display = 'flex';
                setTimeout(() => overlay.classList.add('show'), 10);
            }
        }

        function closeAiSeoModal() {
            const overlay = document.getElementById('ai-seo-generator-modal');
            if (overlay) {
                overlay.classList.remove('show');
                setTimeout(() => { 
                    overlay.style.display = 'none';
                    document.getElementById('ai-seo-form-wrapper').style.display = 'block';
                    document.getElementById('ai-seo-loader').style.display = 'none';
                }, 300);
            }
        }

        function executeAiSeoGeneration() {
            const type = document.getElementById('ai_seo_type').value;
            const pageKey = document.getElementById('ai_seo_page_key').value;
            const id = document.getElementById('ai_seo_id').value;
            const targetName = document.getElementById('ai_seo_target_name').value;
            const extraPrompt = document.getElementById('ai_seo_extra_prompt').value.trim();

            const formWrapper = document.getElementById('ai-seo-form-wrapper');
            const loader = document.getElementById('ai-seo-loader');

            formWrapper.style.display = 'none';
            loader.style.display = 'block';

            const jobId = 'ai-seo-' + Date.now();
            showToast("Generating SEO Suite", `Gemini is generating meta tags & schema for ${targetName}...`, "info", jobId);

            fetch("{{ route('admin.ai.seo-generate') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    type: type,
                    page_key: pageKey,
                    id: id,
                    target_name: targetName,
                    prompt: extraPrompt
                })
            })
            .then(res => res.json())
            .then(res => {
                closeAiSeoModal();
                if (res.success && res.data) {
                    const d = res.data;
                    showToast("SEO Suite Generated!", `Successfully generated SEO tags for ${targetName}`, "success", jobId);

                    if (type === 'page' && pageKey) {
                        // Populate page form fields
                        const tIn = document.getElementById(`meta_title_${pageKey}`);
                        const dIn = document.getElementById(`meta_desc_${pageKey}`);
                        const kIn = document.getElementById(`meta_keywords_${pageKey}`);
                        const hIn = document.getElementById(`h1_tag_${pageKey}`);
                        const aIn = document.getElementById(`hero_alt_${pageKey}`);
                        const sIn = document.getElementById(`schema_${pageKey}`);

                        if (tIn && d.meta_title) tIn.value = d.meta_title;
                        if (dIn && d.meta_description) dIn.value = d.meta_description;
                        if (kIn && d.meta_keywords) kIn.value = d.meta_keywords;
                        if (hIn && d.h1_tag) hIn.value = d.h1_tag;
                        if (aIn && d.image_alt) aIn.value = d.image_alt;
                        if (sIn && d.schema_markup) sIn.value = d.schema_markup;

                        updateSerpPreview(pageKey);
                    } else if (type === 'service') {
                        // Populate service modal form
                        if (d.meta_title) document.getElementById('svc_meta_title').value = d.meta_title;
                        if (d.meta_description) document.getElementById('svc_meta_description').value = d.meta_description;
                        if (d.meta_keywords) document.getElementById('svc_meta_keywords').value = d.meta_keywords;
                        if (d.h1_tag) document.getElementById('svc_h1_tag').value = d.h1_tag;
                        if (d.image_alt) document.getElementById('svc_image_alt').value = d.image_alt;
                        if (d.schema_markup) document.getElementById('svc_schema_markup').value = d.schema_markup;

                        const overlay = document.getElementById('edit-service-seo-modal');
                        if (overlay) {
                            overlay.style.display = 'flex';
                            setTimeout(() => overlay.classList.add('show'), 10);
                        }
                    } else if (type === 'blog') {
                        // Populate blog modal form
                        if (d.meta_title) document.getElementById('blog_meta_title').value = d.meta_title;
                        if (d.meta_description) document.getElementById('blog_meta_description').value = d.meta_description;
                        if (d.meta_keywords) document.getElementById('blog_meta_keywords').value = d.meta_keywords;
                        if (d.h1_tag) document.getElementById('blog_h1_tag').value = d.h1_tag;
                        if (d.image_alt) document.getElementById('blog_image_alt').value = d.image_alt;
                        if (d.schema_markup) document.getElementById('blog_schema_markup').value = d.schema_markup;

                        const overlay = document.getElementById('edit-blog-seo-modal');
                        if (overlay) {
                            overlay.style.display = 'flex';
                            setTimeout(() => overlay.classList.add('show'), 10);
                        }
                    } else if (type === 'landing') {
                        // Populate landing modal form
                        if (d.meta_title) document.getElementById('landing_meta_title').value = d.meta_title;
                        if (d.meta_description) document.getElementById('landing_meta_description').value = d.meta_description;
                        if (d.meta_keywords) document.getElementById('landing_meta_keywords').value = d.meta_keywords;
                        if (d.h1_tag) document.getElementById('landing_h1_tag').value = d.h1_tag;
                        if (d.image_alt) document.getElementById('landing_image_alt').value = d.image_alt;
                        if (d.schema_markup) document.getElementById('landing_schema_markup').value = d.schema_markup;

                        const overlay = document.getElementById('edit-landing-seo-modal');
                        if (overlay) {
                            overlay.style.display = 'flex';
                            setTimeout(() => overlay.classList.add('show'), 10);
                        }
                    }
                } else {
                    showToast("SEO Generation Failed", res.error || "Failed to generate SEO data.", "error", jobId);
                    alert("AI Error: " + (res.error || "Failed to generate SEO suite."));
                }
            })
            .catch(err => {
                closeAiSeoModal();
                showToast("Request Failed", err.message, "error", jobId);
                alert("Network Error: " + err.message);
            });
        }

        // Initialize active tab from localStorage, defaulting to 'leads'
        window.addEventListener('DOMContentLoaded', () => {
            const activeTab = localStorage.getItem('active_tab') || 'leads';
            switchTab(activeTab);
            restoreSeoSubTab();
        });

        // SEO Recommendations Switch Result Tab
        function switchSeoResultTab(tabId) {
            // Remove active class from all buttons and add background styling
            document.querySelectorAll('[id^="seo-tab-btn-"]').forEach(btn => {
                btn.classList.remove('active');
                btn.style.backgroundColor = 'var(--admin-input-bg)';
                btn.style.color = '#fff';
            });
            // Hide all subpanels
            document.querySelectorAll('.seo-result-panel').forEach(panel => {
                panel.style.display = 'none';
            });
            
            // Activate the clicked button
            const activeBtn = document.getElementById('seo-tab-btn-' + tabId);
            if (activeBtn) {
                activeBtn.classList.add('active');
                activeBtn.style.backgroundColor = 'var(--mint-green)';
                activeBtn.style.color = 'var(--primary-teal-dark)';
            }
            // Show the clicked panel
            const activePanel = document.getElementById('seo-panel-' + tabId);
            if (activePanel) {
                activePanel.style.display = activePanel.classList.contains('form-grid') ? 'grid' : 'block';
            }
        }

        let latestSeoData = null;

        // AJAX Generate SEO Strategy
        function generateSeoRecommendations() {
            const keywords = document.getElementById('seo_keywords').value.trim();
            if (!keywords) {
                alert('Please enter at least one target keyword.');
                return;
            }

            const loader = document.getElementById('seo-loader');
            const results = document.getElementById('seo-results');
            loader.style.display = 'block';
            results.style.display = 'none';
            loader.scrollIntoView({ behavior: 'smooth' });

            fetch("{{ route('admin.ai.seo-recommendations') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    keywords: keywords
                })
            })
            .then(res => res.json())
            .then(res => {
                loader.style.display = 'none';
                if (res.success && res.data) {
                    const data = res.data;
                    latestSeoData = data;
                    
                    // Render 1. On-Site Content Table
                    const contentTbody = document.getElementById('seo-table-content');
                    contentTbody.innerHTML = '';
                    if (data.pages_blogs && data.pages_blogs.length) {
                        data.pages_blogs.forEach(item => {
                            contentTbody.innerHTML += `
                                <tr>
                                    <td><span class="badge" style="background-color: rgba(92, 203, 179, 0.1); color: var(--mint-green); border: 1px solid rgba(92, 203, 179, 0.3); font-size: 0.75rem;">${item.type}</span></td>
                                    <td><strong>${item.title}</strong></td>
                                    <td><code style="font-size: 0.8rem; background: rgba(255,255,255,0.05); padding: 2px 4px; border-radius: 4px;">${item.keywords}</code></td>
                                    <td>${item.summary}</td>
                                </tr>
                            `;
                        });
                    } else {
                        contentTbody.innerHTML = '<tr><td colspan="4" style="text-align: center;">No content ideas generated.</td></tr>';
                    }

                    // Render 2. Backlinks Table
                    const backlinksTbody = document.getElementById('seo-table-backlinks');
                    backlinksTbody.innerHTML = '';
                    if (data.third_party_articles && data.third_party_articles.length) {
                        data.third_party_articles.forEach(item => {
                            backlinksTbody.innerHTML += `
                                <tr>
                                    <td><strong>${item.platform_type}</strong></td>
                                    <td>${item.title}</td>
                                    <td><code style="font-size: 0.8rem; background: rgba(255,255,255,0.05); padding: 2px 4px; border-radius: 4px;">${item.keywords}</code></td>
                                    <td>${item.context}</td>
                                </tr>
                            `;
                        });
                    } else {
                        backlinksTbody.innerHTML = '<tr><td colspan="4" style="text-align: center;">No off-site article suggestions.</td></tr>';
                    }

                    // Render 3. Quora Cards
                    const quoraContainer = document.getElementById('seo-cards-quora');
                    quoraContainer.innerHTML = '';
                    if (data.quora_questions && data.quora_questions.length) {
                        data.quora_questions.forEach(item => {
                            quoraContainer.innerHTML += `
                                <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--admin-border); border-radius: var(--radius-md); padding: 1.5rem;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; flex-wrap: wrap; gap: 8px;">
                                        <span class="badge" style="background-color: rgba(232, 92, 36, 0.1); color: var(--accent-orange); font-size: 0.75rem;">${item.topic}</span>
                                        <a href="https://www.quora.com/search?q=${encodeURIComponent(item.question_direction)}" target="_blank" class="btn-submit" style="width: auto; padding: 4px 10px; font-size: 0.75rem; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                            <i data-lucide="external-link" style="width: 12px; height: 12px;"></i> Search on Quora
                                        </a>
                                    </div>
                                    <h4 style="margin: 0 0 1rem 0; font-size: 1.1rem; color: #fff;">${item.question_direction}</h4>
                                    <strong style="font-size: 0.85rem; color: var(--mint-green); display: block; margin-bottom: 0.5rem;">Tactical Answer Blueprint:</strong>
                                    <ul style="margin: 0; padding-left: 1.25rem; font-size: 0.9rem; color: rgba(255,255,255,0.85);">
                                        ${item.draft_answer_points.split('\n').map(pt => pt.trim() ? ('<li>' + pt.replace(/^[-\*\d\.]+\s*/, '') + '</li>') : '').join('')}
                                    </ul>
                                </div>
                            `;
                        });
                    } else {
                        quoraContainer.innerHTML = '<p style="text-align: center; color: var(--admin-text-muted);">No Quora suggestions generated.</p>';
                    }

                    // Render 4. Pinterest Table
                    const pinterestTbody = document.getElementById('seo-table-pinterest');
                    pinterestTbody.innerHTML = '';
                    if (data.pinterest_posts && data.pinterest_posts.length) {
                        data.pinterest_posts.forEach(item => {
                            pinterestTbody.innerHTML += `
                                <tr>
                                    <td><strong style="color: #fff;">${item.overlay_text}</strong></td>
                                    <td>${item.visual_idea}</td>
                                    <td><span class="badge" style="background: rgba(255,255,255,0.05); color: #fff; font-size: 0.75rem;">${item.category}</span></td>
                                </tr>
                            `;
                        });
                    } else {
                        pinterestTbody.innerHTML = '<tr><td colspan="3" style="text-align: center;">No Pinterest suggestions.</td></tr>';
                    }

                    // Render 5. Social Media Cards
                    const socialContainer = document.getElementById('seo-cards-social');
                    socialContainer.innerHTML = '';
                    if (data.social_media && data.social_media.length) {
                        data.social_media.forEach((item, index) => {
                            const postTextEscaped = item.post_copy.replace(/`/g, '\\`').replace(/'/g, "\\'").replace(/"/g, '&quot;');
                            socialContainer.innerHTML += `
                                <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--admin-border); border-radius: var(--radius-md); padding: 1.25rem;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                        <span class="badge" style="background-color: rgba(92, 102, 241, 0.1); color: #a855f7; font-size: 0.75rem;">${item.platform}</span>
                                        <button class="btn-submit" style="width: auto; padding: 4px 10px; font-size: 0.75rem;" onclick="copySeoSocialCopy(this, \`${postTextEscaped}\`)">
                                            <i data-lucide="copy" style="width: 12px; height: 12px; display: inline; vertical-align: middle;"></i> Copy Caption
                                        </button>
                                    </div>
                                    <p style="font-family: inherit; font-size: 0.9rem; white-space: pre-wrap; margin: 0 0 1rem 0; color: rgba(255,255,255,0.85);">${item.post_copy}</p>
                                    <div style="font-size: 0.8rem; background: rgba(0,0,0,0.15); padding: 8px 12px; border-radius: 4px;">
                                        <strong style="color: var(--mint-green);">Graphic Concept:</strong> ${item.graphic_concept}
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        socialContainer.innerHTML = '<p style="text-align: center; color: var(--admin-text-muted);">No social posts generated.</p>';
                    }

                    // Render 6. Bookmarking Platforms
                    const bookmarkingTbody = document.getElementById('seo-table-bookmarking');
                    bookmarkingTbody.innerHTML = '';
                    if (data.bookmarking_sites && data.bookmarking_sites.length) {
                        data.bookmarking_sites.forEach(item => {
                            const link = item.url.startsWith('http') ? item.url : 'https://' + item.url;
                            bookmarkingTbody.innerHTML += `
                                <tr>
                                    <td>
                                        <a href="${link}" target="_blank" style="color: var(--mint-green); font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                                            ${item.name} <i data-lucide="external-link" style="width: 12px; height: 12px;"></i>
                                        </a>
                                    </td>
                                    <td>${item.strategy}</td>
                                </tr>
                            `;
                        });
                    } else {
                        bookmarkingTbody.innerHTML = '<tr><td colspan="2" style="text-align: center;">No bookmarking sites suggested.</td></tr>';
                    }

                    // Render 7. Syndication Platforms
                    const syndicationTbody = document.getElementById('seo-table-syndication');
                    syndicationTbody.innerHTML = '';
                    if (data.blog_promotion && data.blog_promotion.length) {
                        data.blog_promotion.forEach(item => {
                            const link = item.url.startsWith('http') ? item.url : 'https://' + item.url;
                            syndicationTbody.innerHTML += `
                                <tr>
                                    <td>
                                        <a href="${link}" target="_blank" style="color: var(--mint-green); font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                                            ${item.name} <i data-lucide="external-link" style="width: 12px; height: 12px;"></i>
                                        </a>
                                    </td>
                                    <td>${item.strategy}</td>
                                </tr>
                            `;
                        });
                    } else {
                        syndicationTbody.innerHTML = '<tr><td colspan="2" style="text-align: center;">No syndication sites suggested.</td></tr>';
                    }

                    // Render 8. Other growth tactics
                    const otherContainer = document.getElementById('seo-cards-other');
                    otherContainer.innerHTML = '';
                    if (data.other_backlinks && data.other_backlinks.length) {
                        data.other_backlinks.forEach(item => {
                            otherContainer.innerHTML += `
                                <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--admin-border); border-radius: var(--radius-md); padding: 1.25rem;">
                                    <h4 style="margin: 0 0 0.5rem 0; font-size: 1.05rem; color: var(--mint-green); font-weight: 600;">${item.strategy_name}</h4>
                                    <p style="font-size: 0.88rem; margin: 0; color: rgba(255,255,255,0.85);">${item.action_steps}</p>
                                </div>
                            `;
                        });
                    } else {
                        otherContainer.innerHTML = '<p style="grid-column: 1 / -1; text-align: center; color: var(--admin-text-muted);">No additional tactics generated.</p>';
                    }

                    // Trigger Lucide icons instantiation
                    setTimeout(() => lucide.createIcons(), 100);

                    // Show results and switch to Content Tab by default
                    results.style.display = 'block';
                    switchSeoResultTab('content');
                    results.scrollIntoView({ behavior: 'smooth' });
                } else {
                    alert('Error: ' + (res.error || 'Failed to generate SEO strategy.'));
                }
            })
            .catch(err => {
                loader.style.display = 'none';
                alert('Network Error: ' + err.message);
            });
        }

        // Generate and download a beautifully-styled PDF report on the client side
        function downloadSeoPdf() {
            if (!latestSeoData) {
                alert('No SEO data available to download. Please generate recommendations first.');
                return;
            }
            
            const keywords = document.getElementById('seo_keywords').value.trim();
            const dateStr = new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
            
            // Build temporary off-screen container for rendering
            const printEl = document.createElement('div');
            printEl.style.padding = '20px';
            printEl.style.color = '#333333';
            printEl.style.backgroundColor = '#ffffff';
            printEl.style.fontFamily = "'Outfit', 'Inter', sans-serif";
            printEl.style.lineHeight = '1.5';
            
            let html = `
                <div style="border-bottom: 2px solid #5ccbb3; padding-bottom: 15px; margin-bottom: 25px;">
                    <h1 style="color: #0a1112; margin: 0 0 5px 0; font-size: 26px;">MLG Finedge - AI SEO Recommendation Blueprint</h1>
                    <p style="color: #555; margin: 0; font-size: 13px;"><strong>Generated Date:</strong> ${dateStr} | <strong>Target Keywords:</strong> ${keywords}</p>
                </div>
                
                <h2 style="color: #0a1112; font-size: 18px; margin-top: 20px; border-bottom: 1px solid #ddd; padding-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">1. On-Site Content structure Recommendations</h2>
                <table style="width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 12px; margin-bottom: 30px;">
                    <thead>
                        <tr style="background-color: #f7f9f9; border-bottom: 2px solid #ddd;">
                            <th style="padding: 10px; text-align: left; width: 15%; border: 1px solid #ddd; font-weight: bold;">Type</th>
                            <th style="padding: 10px; text-align: left; width: 30%; border: 1px solid #ddd; font-weight: bold;">Recommended Title</th>
                            <th style="padding: 10px; text-align: left; width: 20%; border: 1px solid #ddd; font-weight: bold;">Keywords</th>
                            <th style="padding: 10px; text-align: left; width: 35%; border: 1px solid #ddd; font-weight: bold;">Outline & Search Intent</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            
            if (latestSeoData.pages_blogs && latestSeoData.pages_blogs.length) {
                latestSeoData.pages_blogs.forEach(item => {
                    html += `
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td style="padding: 8px 10px; border: 1px solid #ddd; font-weight: bold; color: #0f766e;">${item.type}</td>
                            <td style="padding: 8px 10px; border: 1px solid #ddd;"><strong>${item.title}</strong></td>
                            <td style="padding: 8px 10px; border: 1px solid #ddd; font-family: monospace; background-color: #f8fafc;">${item.keywords}</td>
                            <td style="padding: 8px 10px; border: 1px solid #ddd; color: #444;">${item.summary}</td>
                        </tr>
                    `;
                });
            } else {
                html += `<tr><td colspan="4" style="text-align: center; padding: 12px;">No content ideas.</td></tr>`;
            }
            
            html += `
                    </tbody>
                </table>
                
                <div style="page-break-after: always;"></div>
                
                <h2 style="color: #0a1112; font-size: 18px; margin-top: 20px; border-bottom: 1px solid #ddd; padding-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">2. Third-Party Off-Site Articles & Backlinks</h2>
                <table style="width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 12px; margin-bottom: 30px;">
                    <thead>
                        <tr style="background-color: #f7f9f9; border-bottom: 2px solid #ddd;">
                            <th style="padding: 10px; text-align: left; width: 20%; border: 1px solid #ddd; font-weight: bold;">Platform Type</th>
                            <th style="padding: 10px; text-align: left; width: 30%; border: 1px solid #ddd; font-weight: bold;">Article Title Idea</th>
                            <th style="padding: 10px; text-align: left; width: 20%; border: 1px solid #ddd; font-weight: bold;">Anchor Keywords</th>
                            <th style="padding: 10px; text-align: left; width: 30%; border: 1px solid #ddd; font-weight: bold;">Backlink Integration Context</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            
            if (latestSeoData.third_party_articles && latestSeoData.third_party_articles.length) {
                latestSeoData.third_party_articles.forEach(item => {
                    html += `
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td style="padding: 8px 10px; border: 1px solid #ddd; font-weight: bold;">${item.platform_type}</td>
                            <td style="padding: 8px 10px; border: 1px solid #ddd;"><strong>${item.title}</strong></td>
                            <td style="padding: 8px 10px; border: 1px solid #ddd; font-family: monospace; background-color: #f8fafc;">${item.keywords}</td>
                            <td style="padding: 8px 10px; border: 1px solid #ddd; color: #444;">${item.context}</td>
                        </tr>
                    `;
                });
            } else {
                html += `<tr><td colspan="4" style="text-align: center; padding: 12px;">No guest posting suggestions.</td></tr>`;
            }
            
            html += `
                    </tbody>
                </table>
                
                <h2 style="color: #0a1112; font-size: 18px; margin-top: 30px; border-bottom: 1px solid #ddd; padding-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">3. Quora Q&A Authority Roadmap</h2>
                <div style="display: flex; flex-direction: column; gap: 15px; margin-top: 10px; margin-bottom: 30px;">
            `;
            
            if (latestSeoData.quora_questions && latestSeoData.quora_questions.length) {
                latestSeoData.quora_questions.forEach(item => {
                    html += `
                        <div style="border: 1px solid #ddd; padding: 15px; border-radius: 6px; background-color: #fafafa;">
                            <span style="font-size: 10px; font-weight: bold; background: #e85c24; color: white; padding: 2px 8px; border-radius: 4px; display: inline-block; margin-bottom: 8px; text-transform: uppercase;">${item.topic}</span>
                            <h4 style="margin: 0 0 10px 0; font-size: 14px; color: #0a1112; font-weight: bold;">Question: ${item.question_direction}</h4>
                            <p style="margin: 0 0 5px 0; font-size: 12px; color: #555; font-weight: bold;">Tactical Answer Outline:</p>
                            <ul style="margin: 0; padding-left: 20px; font-size: 12px; color: #444;">
                                ${item.draft_answer_points.split('\n').map(pt => pt.trim() ? ('<li>' + pt.replace(/^[-\*\d\.]+\s*/, '') + '</li>') : '').join('')}
                            </ul>
                        </div>
                    `;
                });
            } else {
                html += `<p style="font-size: 13px;">No Quora suggestions.</p>`;
            }
            
            html += `
                </div>
                
                <div style="page-break-after: always;"></div>
                
                <h2 style="color: #0a1112; font-size: 18px; margin-top: 20px; border-bottom: 1px solid #ddd; padding-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">4. Pinterest Graphics & Written Social Copy</h2>
                <h3 style="font-size: 14px; margin-top: 15px; margin-bottom: 8px; color: #333; font-weight: bold;">Pinterest Overlay Graphics</h3>
                <table style="width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 35px;">
                    <thead>
                        <tr style="background-color: #f7f9f9; border-bottom: 2px solid #ddd;">
                            <th style="padding: 10px; text-align: left; width: 30%; border: 1px solid #ddd; font-weight: bold;">Overlay Bold Text</th>
                            <th style="padding: 10px; text-align: left; width: 50%; border: 1px solid #ddd; font-weight: bold;">Visual Graphic Concept</th>
                            <th style="padding: 10px; text-align: left; width: 20%; border: 1px solid #ddd; font-weight: bold;">Category</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            
            if (latestSeoData.pinterest_posts && latestSeoData.pinterest_posts.length) {
                latestSeoData.pinterest_posts.forEach(item => {
                    html += `
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td style="padding: 8px 10px; border: 1px solid #ddd; font-weight: bold;">${item.overlay_text}</td>
                            <td style="padding: 8px 10px; border: 1px solid #ddd; color: #444;">${item.visual_idea}</td>
                            <td style="padding: 8px 10px; border: 1px solid #ddd;">${item.category}</td>
                        </tr>
                    `;
                });
            } else {
                html += `<tr><td colspan="3" style="text-align: center; padding: 12px;">No Pinterest suggestions.</td></tr>`;
            }
            
            html += `
                    </tbody>
                </table>
                
                <h3 style="font-size: 14px; margin-top: 20px; margin-bottom: 10px; color: #333; font-weight: bold;">Social Media Written Copy</h3>
                <div style="display: flex; flex-direction: column; gap: 15px;">
            `;
            
            if (latestSeoData.social_media && latestSeoData.social_media.length) {
                latestSeoData.social_media.forEach(item => {
                    html += `
                        <div style="border: 1px solid #ddd; padding: 15px; border-radius: 6px; background-color: #fcfcfc;">
                            <strong style="color: #4f46e5; font-size: 12px; display: block; margin-bottom: 6px; text-transform: uppercase;">Platform: ${item.platform}</strong>
                            <p style="margin: 0 0 12px 0; font-size: 12px; white-space: pre-wrap; color: #333; line-height: 1.6; background-color: #fff; padding: 10px; border: 1px solid #eee; border-radius: 4px;">${item.post_copy}</p>
                            <div style="font-size: 11px; color: #444; background: #f1f5f9; padding: 8px 12px; border-radius: 4px; border-left: 3px solid #64748b;">
                                <strong>Graphic Concept:</strong> ${item.graphic_concept}
                            </div>
                        </div>
                    `;
                });
            } else {
                html += `<p style="font-size: 13px;">No social copy suggestions.</p>`;
            }
            
            html += `
                </div>
                
                <div style="page-break-after: always;"></div>
                
                <h2 style="color: #0a1112; font-size: 18px; margin-top: 20px; border-bottom: 1px solid #ddd; padding-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">5. Social Bookmarking & Syndication Directories</h2>
                <h3 style="font-size: 14px; margin-top: 15px; margin-bottom: 8px; color: #333; font-weight: bold;">Social Bookmarking Websites</h3>
                <table style="width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 30px;">
                    <thead>
                        <tr style="background-color: #f7f9f9; border-bottom: 2px solid #ddd;">
                            <th style="padding: 10px; text-align: left; width: 30%; border: 1px solid #ddd; font-weight: bold;">Platform</th>
                            <th style="padding: 10px; text-align: left; width: 70%; border: 1px solid #ddd; font-weight: bold;">Tactical Submission Strategy</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            
            if (latestSeoData.bookmarking_sites && latestSeoData.bookmarking_sites.length) {
                latestSeoData.bookmarking_sites.forEach(item => {
                    html += `
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td style="padding: 8px 10px; border: 1px solid #ddd;"><strong>${item.name}</strong><br><span style="font-size: 10px; color: #666;">${item.url}</span></td>
                            <td style="padding: 8px 10px; border: 1px solid #ddd; color: #444;">${item.strategy}</td>
                        </tr>
                    `;
                });
            } else {
                html += `<tr><td colspan="2" style="text-align: center; padding: 12px;">No bookmarking sites.</td></tr>`;
            }
            
            html += `
                    </tbody>
                </table>
                
                <h3 style="font-size: 14px; margin-top: 20px; margin-bottom: 8px; color: #333; font-weight: bold;">Blog Syndication Platforms</h3>
                <table style="width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 30px;">
                    <thead>
                        <tr style="background-color: #f7f9f9; border-bottom: 2px solid #ddd;">
                            <th style="padding: 10px; text-align: left; width: 30%; border: 1px solid #ddd; font-weight: bold;">Platform</th>
                            <th style="padding: 10px; text-align: left; width: 70%; border: 1px solid #ddd; font-weight: bold;">Syndication Strategy</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            
            if (latestSeoData.blog_promotion && latestSeoData.blog_promotion.length) {
                latestSeoData.blog_promotion.forEach(item => {
                    html += `
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td style="padding: 8px 10px; border: 1px solid #ddd;"><strong>${item.name}</strong><br><span style="font-size: 10px; color: #666;">${item.url}</span></td>
                            <td style="padding: 8px 10px; border: 1px solid #ddd; color: #444;">${item.strategy}</td>
                        </tr>
                    `;
                });
            } else {
                html += `<tr><td colspan="2" style="text-align: center; padding: 12px;">No syndication sites.</td></tr>`;
            }
            
            html += `
                    </tbody>
                </table>
                
                <h2 style="color: #0a1112; font-size: 18px; margin-top: 20px; border-bottom: 1px solid #ddd; padding-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">6. Advanced Growth Tactics</h2>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 10px;">
            `;
            
            if (latestSeoData.other_backlinks && latestSeoData.other_backlinks.length) {
                latestSeoData.other_backlinks.forEach(item => {
                    html += `
                        <div style="border: 1px solid #ddd; padding: 12px; border-radius: 6px; background-color: #fafafa;">
                            <h4 style="margin: 0 0 6px 0; font-size: 13px; color: #0f766e; font-weight: bold;">${item.strategy_name}</h4>
                            <p style="margin: 0; font-size: 11px; color: #555; line-height: 1.5;">${item.action_steps}</p>
                        </div>
                    `;
                });
            } else {
                html += `<p style="font-size: 13px;">No additional tactics.</p>`;
            }
            
            html += `
                </div>
            `;
            
            printEl.innerHTML = html;
            
            const opt = {
                margin:       [15, 15, 15, 15],
                filename:     'MLG_Finedge_SEO_Blueprint_' + keywords.replace(/[^a-z0-9]+/gi, '_') + '.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true, letterRendering: true },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' },
                pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] }
            };
            
            html2pdf().set(opt).from(printEl).save();
        }

        // GMB Modal Management
        function openGmbShareModal(type, data) {
            document.getElementById('gmb_post_type').value = type;
            document.getElementById('gmb_post_id').value = data.id;
            
            const baseUrl = 'https://www.mlgfinedge.com';
            let targetUrl = '';
            if (type === 'blog') {
                targetUrl = baseUrl + '/blog/' + data.slug;
            } else if (type === 'service') {
                targetUrl = baseUrl + '/services/' + data.slug;
            } else {
                targetUrl = baseUrl + '/l/' + data.slug;
            }
            
            document.getElementById('gmb_target_url').value = targetUrl;
            document.getElementById('gmb_post_cta_url').value = targetUrl;
            document.getElementById('gmb_post_text').value = '';
            
            // Open modal
            document.getElementById('gmb-share-modal').classList.add('show');
            
            // Auto draft with AI
            generateGmbDraft();
        }

        function closeGmbModal() {
            document.getElementById('gmb-share-modal').classList.remove('show');
        }

        function generateGmbDraft() {
            const type = document.getElementById('gmb_post_type').value;
            const id = document.getElementById('gmb_post_id').value;
            const form = document.getElementById('gmb-form-wrapper');
            const loader = document.getElementById('gmb-loader');
            
            form.style.display = 'none';
            loader.style.display = 'block';
            
            fetch("{{ route('admin.ai.gmb-draft') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ type: type, id: id })
            })
            .then(res => res.json())
            .then(res => {
                loader.style.display = 'none';
                form.style.display = 'block';
                if (res.success && res.draft) {
                    document.getElementById('gmb_post_text').value = res.draft;
                } else {
                    alert('AI Drafting failed: ' + (res.error || 'Unknown error'));
                    document.getElementById('gmb_post_text').value = 'Failed to draft post. Please write manually.';
                }
            })
            .catch(err => {
                loader.style.display = 'none';
                form.style.display = 'block';
                alert('Network Error drafting post: ' + err.message);
            });
        }

        function copyAndOpenGmb() {
            const text = document.getElementById('gmb_post_text').value;
            if (!text) {
                alert('No text draft to copy!');
                return;
            }
            navigator.clipboard.writeText(text).then(() => {
                showToast('Post content copied to clipboard!', 'success');
                setTimeout(() => {
                    window.open('https://business.google.com/', '_blank');
                }, 800);
            }).catch(err => {
                alert('Failed to copy to clipboard.');
            });
        }

        function publishGmbPostDirect() {
            const text = document.getElementById('gmb_post_text').value;
            const url = document.getElementById('gmb_target_url').value;
            const publishBtn = document.getElementById('gmb-publish-btn');
            
            if (!text) {
                alert('Please enter post text.');
                return;
            }
            
            const originalHtml = publishBtn.innerHTML;
            publishBtn.disabled = true;
            publishBtn.innerHTML = 'Publishing...';
            
            fetch("{{ route('admin.gmb.publish') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ text: text, url: url })
            })
            .then(res => res.json())
            .then(res => {
                publishBtn.disabled = false;
                publishBtn.innerHTML = originalHtml;
                if (res.success) {
                    showToast('Successfully published post directly to Google Business Profile!', 'success');
                    closeGmbModal();
                } else {
                    alert('API Publish failed: ' + (res.error || 'Unknown error'));
                }
            })
            .catch(err => {
                publishBtn.disabled = false;
                publishBtn.innerHTML = originalHtml;
                alert('Network Error publishing: ' + err.message);
            });
        }

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

        // Initialize TinyMCE for Rich Text and Raw HTML Source Code Editing
        function initAdminTinyMCE() {
            tinymce.init({
                selector: '#blog_content, #ser_intro_content, #ser_tips_content',
                height: 480,
                menubar: 'file edit view insert format tools table',
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table | code preview fullscreen',
                block_formats: 'Paragraph=p; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6; Blockquote=blockquote; Preformatted=pre',
                content_style: `
                    body {
                        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
                        font-size: 15px;
                        line-height: 1.75;
                        color: #1e293b;
                        padding: 12px;
                    }
                    h2 { font-size: 1.85rem; font-weight: 700; color: #0c5354; margin: 1.5rem 0 0.75rem 0; }
                    h3 { font-size: 1.4rem; font-weight: 600; color: #135859; margin: 1.25rem 0 0.5rem 0; }
                    h4 { font-size: 1.15rem; font-weight: 600; color: #1e293b; margin: 1rem 0 0.5rem 0; }
                    p { margin-bottom: 1rem; color: #1e293b; }
                    ul { list-style-type: disc !important; padding-left: 2rem !important; margin: 1rem 0 !important; }
                    ol { list-style-type: decimal !important; padding-left: 2rem !important; margin: 1rem 0 !important; }
                    li { margin-bottom: 0.4rem !important; }
                    blockquote { border-left: 4px solid #ff6b35; padding: 0.5rem 1rem; background: #f8fafc; font-style: italic; margin: 1rem 0; }
                    table { border-collapse: collapse; width: 100%; margin: 1rem 0; }
                    th, td { border: 1px solid #cbd5e1; padding: 8px 12px; }
                    th { background-color: #f1f5f9; }
                `,
                branding: false,
                promotion: false,
                convert_urls: false,
                relative_urls: false,
                remove_script_host: false,
                setup: function (editor) {
                    editor.on('change keyup NodeChange blur', function () {
                        editor.save();
                    });
                }
            });
        }
        initAdminTinyMCE();

        // Helper to set editor content safely
        function setEditorHtml(editorId, html) {
            const editor = tinymce.get(editorId);
            if (editor) {
                editor.setContent(html || '');
            }
            const textarea = document.getElementById(editorId);
            if (textarea) {
                textarea.value = html || '';
            }
        }

        // Helper to get editor content safely
        function getEditorHtml(editorId) {
            const editor = tinymce.get(editorId);
            if (editor) {
                return editor.getContent();
            }
            const textarea = document.getElementById(editorId);
            return textarea ? textarea.value : '';
        }

        // Edit Blog by ID using safe JSON dictionary
        function editBlogById(id) {
            const data = adminBlogsData[id];
            if (!data) {
                console.error("Blog ID " + id + " not found in adminBlogsData");
                return;
            }
            editBlog(data);
        }

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
            document.getElementById('blog_schema_markup').value = data.schema_markup || '';
            
            // Set content in TinyMCE & underlying textarea
            setEditorHtml('blog_content', data.content);
            
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
            document.getElementById('blog_schema_markup').value = '';
            document.getElementById('blog_image_url').value = '';
            
            setEditorHtml('blog_content', '');
            
            document.getElementById('blog-submit-btn').innerText = 'Publish Blog Article';
            document.getElementById('blog-cancel-btn').style.display = 'none';
        }

        // Form submission handlers to guarantee editor content is saved and validated before submission
        document.addEventListener('DOMContentLoaded', function () {
            const blogForm = document.getElementById('blog-form');
            if (blogForm) {
                blogForm.addEventListener('submit', function (e) {
                    if (typeof tinymce !== 'undefined') {
                        tinymce.triggerSave();
                    }
                    const title = (document.getElementById('blog_title')?.value || '').trim();
                    const content = getEditorHtml('blog_content').trim();
                    if (!title) {
                        alert('Please enter an article title.');
                        e.preventDefault();
                        return false;
                    }
                    if (!content) {
                        alert('Please enter article content before publishing or updating.');
                        e.preventDefault();
                        return false;
                    }
                    // Sync into textarea explicitly
                    const txt = document.getElementById('blog_content');
                    if (txt) txt.value = content;
                });
            }

            const serviceForm = document.getElementById('service-form');
            if (serviceForm) {
                serviceForm.addEventListener('submit', function () {
                    if (typeof tinymce !== 'undefined') {
                        tinymce.triggerSave();
                    }
                });
            }
        });

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
            
            setEditorHtml('ser_intro_content', data.intro_content || '');
            
            document.getElementById('ser_eligibility_criteria').value = data.eligibility_criteria || '';
            document.getElementById('ser_documents_required').value = data.documents_required || '';
            document.getElementById('ser_tips_title').value = data.tips_title || '';
            
            setEditorHtml('ser_tips_content', data.tips_content || '');
            
            document.getElementById('ser_summary').value = data.summary || '';
            document.getElementById('ser_schema_markup').value = data.schema_markup || '';
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
            
            setEditorHtml('ser_intro_content', '');
            
            document.getElementById('ser_eligibility_criteria').value = '';
            document.getElementById('ser_documents_required').value = '';
            document.getElementById('ser_tips_title').value = '';
            
            setEditorHtml('ser_tips_content', '');
            
            document.getElementById('ser_summary').value = '';
            document.getElementById('ser_schema_markup').value = '';
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

        function generateLandingSlug(title) {
            document.getElementById('landing_slug').value = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
        }

        function toggleEditLandingForm(id) {
            const row = document.getElementById('landing-editor-' + id);
            if (row.style.display === 'none') {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        }

        function openLandingAiModal(id, title) {
            document.getElementById('ai_landing_id').value = id;
            document.getElementById('ai_landing_target_title').value = title;
            document.getElementById('ai_landing_prompt').value = 'Create an optimized promotional landing page for ' + title + ' highlighting tailored loan interest options and fast processing payouts.';
            openAiModal('landing');
        }

        function generateAiLandingPage() {
            const id = document.getElementById('ai_landing_id').value;
            const prompt = document.getElementById('ai_landing_prompt').value.trim();
            
            if (!prompt) {
                alert('Please enter a description or topic for the landing page.');
                return;
            }
            
            const formWrapper = document.getElementById('ai-landing-form-wrapper');
            const loader = document.getElementById('ai-landing-loader');
            
            formWrapper.style.display = 'none';
            loader.style.display = 'flex';
            
            const jobId = 'landing-gen-' + Date.now();
            showToast("Generating AI Landing Page", "Gemini is writing the landing page copy...", "info", jobId);
            
            fetch('{{ route("admin.ai.landing") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: id,
                    prompt: prompt
                })
            })
            .then(response => response.json())
            .then(data => {
                closeAiModal('landing');
                if (data.success) {
                    showToast("Generation Successful", "Your landing page content is ready. Reloading...", "success", jobId);
                    setTimeout(() => window.location.reload(), 1200);
                } else {
                    alert('Error: ' + (data.error || 'Failed to generate content.'));
                }
            })
            .catch(error => {
                closeAiModal('landing');
                alert('Request failed: ' + error.message);
            });
        }

        function syncGmbReviews() {
            const btn = document.getElementById('btn-sync-gmb');
            const icon = document.getElementById('icon-sync-gmb');
            
            btn.disabled = true;
            btn.innerHTML = '<i data-lucide="loader" class="animate-spin" style="width: 16px; height: 16px;"></i> Syncing Reviews...';
            lucide.createIcons();
            
            const jobId = 'gmb-sync-' + Date.now();
            showToast("Syncing GMB Reviews", "Gemini is pulling reviews from your GMB profile link...", "info", jobId);
            
            fetch('{{ route("admin.ai.gmb-sync") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = '<i data-lucide="refresh-cw" id="icon-sync-gmb" style="width: 16px; height: 16px;"></i> Sync GMB Reviews via AI';
                lucide.createIcons();
                
                if (data.success) {
                    showToast("Sync Successful", data.message, "success", jobId);
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    showToast("Sync Failed", data.error || 'Unknown error occurred.', "error", jobId);
                    alert('Error: ' + (data.error || 'Unknown error occurred.'));
                }
            })
            .catch(error => {
                btn.disabled = false;
                btn.innerHTML = '<i data-lucide="refresh-cw" id="icon-sync-gmb" style="width: 16px; height: 16px;"></i> Sync GMB Reviews via AI';
                lucide.createIcons();
                showToast("Request Failed", error.message, "error", jobId);
                alert('Request failed: ' + error.message);
            });
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
                    
                    setEditorHtml('blog_content', data.content || '');

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
                    
                    setEditorHtml('ser_intro_content', data.intro_content || '');
                    
                    document.getElementById('ser_eligibility_criteria').value = data.eligibility_criteria || '';
                    document.getElementById('ser_documents_required').value = data.documents_required || '';
                    document.getElementById('ser_tips_title').value = data.tips_title || '';
                    
                    setEditorHtml('ser_tips_content', data.tips_content || '');
                    
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

        // Toggle Gemini Key Visibility (Show/Hide Password)
        function toggleGeminiKeyVisibility() {
            const input = document.getElementById('gemini_api_key');
            const icon = document.getElementById('gemini-eye-icon');
            if (!input) return;

            if (input.type === 'password') {
                input.type = 'text';
                if (icon) icon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = 'password';
                if (icon) icon.setAttribute('data-lucide', 'eye');
            }
            if (window.lucide) lucide.createIcons();
        }

        // Live Key Format Check
        function checkGeminiKeyFormat() {
            const input = document.getElementById('gemini_api_key');
            const badge = document.getElementById('gemini-key-format-badge');
            if (!input || !badge) return;

            const val = input.value.trim();
            if (val.length === 0) {
                badge.style.display = 'none';
                return;
            }

            badge.style.display = 'inline-block';
            if (val.startsWith('AIzaSy') && val.length >= 35) {
                badge.style.backgroundColor = 'rgba(92, 203, 179, 0.15)';
                badge.style.color = 'var(--mint-green)';
                badge.style.border = '1px solid rgba(92, 203, 179, 0.3)';
                badge.textContent = '✓ Valid Google AI Studio Format (AIzaSy...)';
            } else {
                badge.style.backgroundColor = 'rgba(232, 92, 36, 0.15)';
                badge.style.color = 'var(--accent-orange)';
                badge.style.border = '1px solid rgba(232, 92, 36, 0.3)';
                badge.textContent = '⚠️ Caution: Key should start with AIzaSy...';
            }
        }

        // Run Multi-Model Diagnostic Test
        function runGeminiModelTest(mode) {
            const keyInput = document.getElementById('gemini_api_key');
            const modelSelect = document.getElementById('gemini_model');
            const resultsBox = document.getElementById('ai-test-results-box');

            const key = keyInput ? keyInput.value.trim() : '';
            const selectedModel = (modelSelect && mode === 'selected') ? modelSelect.value : 'all';

            if (!key) {
                alert("Please paste your Gemini API Key in the input field first.");
                if (keyInput) keyInput.focus();
                return;
            }

            if (!resultsBox) return;

            // Render Loader State
            resultsBox.style.display = 'block';
            resultsBox.innerHTML = `
                <div style="display: flex; align-items: center; gap: 12px; padding: 0.5rem 0;">
                    <div class="spinner" style="width: 20px; height: 20px; border-width: 2px; margin: 0;"></div>
                    <div>
                        <div style="color: #fff; font-weight: 600; font-size: 0.9rem;">
                            Testing API Key with ${mode === 'selected' ? selectedModel : 'all Google Gemini models'}...
                        </div>
                        <div style="color: var(--admin-text-muted); font-size: 0.75rem;">
                            Sending live verification prompt to Google Generative Language API...
                        </div>
                    </div>
                </div>
            `;

            fetch("{{ route('admin.ai.test-key') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    api_key: key,
                    model: selectedModel
                })
            })
            .then(res => res.json())
            .then(data => {
                renderGeminiTestResults(data, key, mode);
            })
            .catch(err => {
                resultsBox.innerHTML = `
                    <div style="color: #ef4444; font-size: 0.85rem; padding: 0.5rem 0;">
                        <strong>Network Test Error:</strong> ${err.message}
                    </div>
                `;
            });
        }

        // Render Test Results UI
        function renderGeminiTestResults(data, testedKey, mode) {
            const resultsBox = document.getElementById('ai-test-results-box');
            if (!resultsBox) return;

            let html = '';

            if (data.success) {
                html += `
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--admin-border); padding-bottom: 0.75rem; margin-bottom: 1rem; flex-wrap: wrap; gap: 10px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="background: rgba(92,203,179,0.2); color: var(--mint-green); border: 1px solid rgba(92,203,179,0.4); padding: 3px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                                ✓ API Key Verified & Working!
                            </span>
                            ${data.recommended_model ? `<span style="font-size: 0.8rem; color: var(--admin-text-muted);">Recommended: <strong style="color: #fff;">${data.recommended_model}</strong></span>` : ''}
                        </div>
                        <button type="button" class="btn-submit" onclick="saveGeminiConfigFromTester('${testedKey}', '${data.recommended_model || 'gemini-2.0-flash'}')" style="padding: 0.4rem 0.9rem; font-size: 0.8rem; width: auto; background: var(--mint-green); color: var(--primary-teal-dark); font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                            <i data-lucide="check" style="width: 13px; height: 13px;"></i> Apply & Save to System
                        </button>
                    </div>
                `;
            } else {
                html += `
                    <div style="border-bottom: 1px solid var(--admin-border); padding-bottom: 0.75rem; margin-bottom: 1rem;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                            <span style="background: rgba(239,68,68,0.2); color: #ef4444; border: 1px solid rgba(239,68,68,0.4); padding: 3px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                                ✕ Key Authentication Failed
                            </span>
                        </div>
                        ${data.advice ? `<div style="font-size: 0.82rem; color: #fca5a5; line-height: 1.4; margin-top: 4px;">${data.advice}</div>` : ''}
                    </div>
                `;
            }

            if (data.format_warning) {
                html += `
                    <div style="background: rgba(232,92,36,0.1); border: 1px dashed rgba(232,92,36,0.4); border-radius: 6px; padding: 0.6rem 0.8rem; font-size: 0.8rem; color: #fed7aa; margin-bottom: 1rem;">
                        ${data.format_warning}
                    </div>
                `;
            }

            // Render Model Results Matrix
            html += `<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 10px; margin-bottom: 1rem;">`;
            
            for (const [modelName, mRes] of Object.entries(data.results || {})) {
                const isOk = mRes.working;
                const statusColor = isOk ? 'var(--mint-green)' : '#ef4444';
                const statusBg = isOk ? 'rgba(92,203,179,0.08)' : 'rgba(239,68,68,0.08)';
                const borderC = isOk ? 'rgba(92,203,179,0.25)' : 'rgba(239,68,68,0.25)';

                html += `
                    <div style="background: ${statusBg}; border: 1px solid ${borderC}; border-radius: 6px; padding: 0.75rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                            <strong style="font-size: 0.85rem; color: #fff;">${modelName}</strong>
                            <span style="font-size: 0.72rem; color: ${statusColor}; font-weight: 700;">
                                ${isOk ? `✓ 200 OK (${mRes.latency_ms}ms)` : `✕ ${mRes.http_code || 'Err'}`}
                            </span>
                        </div>
                        ${isOk ? `
                            <div style="font-size: 0.75rem; color: #94a3b8; font-style: italic; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                "${mRes.reply}"
                            </div>
                        ` : `
                            <div style="font-size: 0.72rem; color: #f87171; line-height: 1.3;">
                                ${mRes.error ? mRes.error.substring(0, 90) + '...' : 'Unavailable'}
                            </div>
                        `}
                    </div>
                `;
            }
            html += `</div>`;

            // How to fix guide if failed
            if (!data.success) {
                html += `
                    <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--admin-border); border-radius: 6px; padding: 0.8rem; font-size: 0.8rem; color: var(--admin-text-muted);">
                        <strong style="color: #fff;">How to generate a free working key:</strong>
                        <ol style="margin: 6px 0 0 1.25rem; padding: 0; line-height: 1.6;">
                            <li>Visit <a href="https://aistudio.google.com/app/apikey" target="_blank" style="color: var(--mint-green); text-decoration: underline;">Google AI Studio (aistudio.google.com/app/apikey)</a>.</li>
                            <li>Sign in with your Google account and click <strong>Create API key</strong>.</li>
                            <li>Copy the key (starts with <code>AIzaSy...</code>) and paste it into the field above.</li>
                            <li>Click <strong>Test Selected Model</strong> to verify, then click <strong>Apply & Save</strong>.</li>
                        </ol>
                    </div>
                `;
            }

            resultsBox.innerHTML = html;
            if (window.lucide) lucide.createIcons();
        }

        // One-Click Apply & Save from Tester
        function saveGeminiConfigFromTester(key, model) {
            const jobId = 'save-ai-key-' + Date.now();
            showToast("Saving AI Configuration", "Applying verified key and active model to database...", "info", jobId);

            fetch("{{ route('admin.ai.save-key') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    gemini_api_key: key,
                    gemini_model: model
                })
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    showToast("AI Configuration Saved!", res.message, "success", jobId);
                    const modelSelect = document.getElementById('gemini_model');
                    if (modelSelect && model) modelSelect.value = model;
                    checkGeminiKeyFormat();
                } else {
                    showToast("Save Failed", res.error || "Could not save key.", "error", jobId);
                }
            })
            .catch(err => {
                showToast("Save Failed", err.message, "error", jobId);
            });
        }

        // Initialize Gemini Key format badge on load
        window.addEventListener('DOMContentLoaded', () => {
            checkGeminiKeyFormat();
        });
    </script>
</body>
</html>

