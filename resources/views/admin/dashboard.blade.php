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
            <li class="menu-item"><button onclick="switchTab('general')" class="tab-btn active" id="btn-general"><i data-lucide="settings"></i> General Settings</button></li>
            <li class="menu-item"><button onclick="switchTab('branding')" class="tab-btn" id="btn-branding"><i data-lucide="image"></i> Branding & Logos</button></li>
            <li class="menu-item"><button onclick="switchTab('slider')" class="tab-btn" id="btn-slider"><i data-lucide="sliders"></i> Homepage Slider</button></li>
            <li class="menu-item"><button onclick="switchTab('testimonials')" class="tab-btn" id="btn-testimonials"><i data-lucide="users"></i> Testimonials</button></li>
            <li class="menu-item"><button onclick="switchTab('styling')" class="tab-btn" id="btn-styling"><i data-lucide="palette"></i> Section Backgrounds</button></li>
            <li class="menu-item"><button onclick="switchTab('pagecontents')" class="tab-btn" id="btn-pagecontents"><i data-lucide="file-text"></i> Page Editor</button></li>
            <li class="menu-item"><button onclick="switchTab('services')" class="tab-btn" id="btn-services"><i data-lucide="layers"></i> Services Manager</button></li>
            <li class="menu-item"><button onclick="switchTab('banks')" class="tab-btn" id="btn-banks"><i data-lucide="landmark"></i> Bank Comparison</button></li>
            <li class="menu-item"><button onclick="switchTab('blogs')" class="tab-btn" id="btn-blogs"><i data-lucide="book-open"></i> Blog Manager</button></li>
            <li class="menu-item"><button onclick="switchTab('media')" class="tab-btn" id="btn-media"><i data-lucide="hard-drive"></i> Media Manager</button></li>
        </ul>
        
        <div class="sidebar-footer">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i data-lucide="log-out"></i> Log Out
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content Panel -->
    <div class="main-panel">
        <div class="admin-header">
            <h1>CMS Control Panel</h1>
            <div class="admin-user">
                <span>{{ Auth::user()->name }}</span>
                <div class="admin-user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
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
            <div class="tab-panel active" id="tab-general">
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

                    <button type="submit" class="btn-submit">Save Parameters</button>
                </form>
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
                                <label>Header & Footer Logo</label>
                                <input type="file" name="logo" class="form-control" accept="image/*">
                                <div class="image-preview-container">
                                    <div class="image-preview">
                                        @if(!empty($site['logo_path']))
                                            <img src="{{ asset('storage/' . $site['logo_path']) }}" alt="Logo">
                                        @else
                                            <span style="font-size:0.7rem; color: var(--admin-text-muted);">Default SVG</span>
                                        @endif
                                    </div>
                                    @if(!empty($site['logo_path']))
                                        <span class="badge-webp">WebP Optimized</span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Favicon file -->
                            <div class="form-group">
                                <label>Browser Favicon</label>
                                <input type="file" name="favicon" class="form-control" accept="image/*">
                                <div class="image-preview-container">
                                    <div class="image-preview">
                                        @if(!empty($site['favicon_path']))
                                            <img src="{{ asset('storage/' . $site['favicon_path']) }}" alt="Favicon">
                                        @else
                                            <span style="font-size:0.7rem; color: var(--admin-text-muted);">Default ICO</span>
                                        @endif
                                    </div>
                                    @if(!empty($site['favicon_path']))
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
                                <label for="slide_image">Slide Image (converted to WebP)</label>
                                <input type="file" id="slide_image" name="image" class="form-control" accept="image/*">
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
                                                    <img src="{{ asset('storage/' . $slide->image_path) }}" alt="Slide Preview">
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
                                <label for="test_avatar">Client Avatar (WebP Auto-optimized)</label>
                                <input type="file" id="test_avatar" name="avatar" class="form-control" accept="image/*">
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
                                                    <img src="{{ asset('storage/' . $test->avatar_path) }}" alt="Avatar">
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
                    <h2 id="service-form-title">Create New Service Page</h2>
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
                    <h2 id="blog-form-title">Create New Blog Article</h2>
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
                            <div class="form-group" style="grid-column: span 2;">
                                <label for="blog_image">Cover Image (JPEG/PNG/WebP, will be compressed to WebP)</label>
                                <input type="file" id="blog_image" name="image" class="form-control" accept="image/*">
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
                                                    <img src="{{ asset('storage/' . $b->image_path) }}" alt="Cover">
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
                    <h2>Upload Media File</h2>
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
                    <h2>Media Library</h2>
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
    <script>
        lucide.createIcons();

        // Switch Tabs logic
        function switchTab(tabId) {
            document.querySelectorAll('.tab-panel').forEach(panel => {
                panel.classList.remove('active');
            });
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            document.getElementById('tab-' + tabId).classList.add('active');
            document.getElementById('btn-' + tabId).classList.add('active');
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
            document.getElementById('blog-form-title').innerText = 'Edit Blog Article: ' + data.title;
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
            document.getElementById('blog-cancel-btn').style.display = 'inline-block';
            
            document.getElementById('blog-form-container').scrollIntoView({ behavior: 'smooth' });
        }

        function cancelBlogEdit() {
            document.getElementById('blog-form-title').innerText = 'Create New Blog Article';
            document.getElementById('blog-form').action = "{{ route('admin.blogs.store') }}";
            document.getElementById('blog-form-method').value = 'POST';
            document.getElementById('blog_title').value = '';
            document.getElementById('blog_slug').value = '';
            document.getElementById('blog_category').selectedIndex = 0;
            document.getElementById('blog_published_at').value = "{{ date('Y-m-d\TH:i') }}";
            document.getElementById('blog_summary').value = '';
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
            document.getElementById('service-form-title').innerText = 'Edit Service Page: ' + data.service_name;
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
            document.getElementById('service-form-title').innerText = 'Create New Service Page';
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
    </script>
</body>
</html>
