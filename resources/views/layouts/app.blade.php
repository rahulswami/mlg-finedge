<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trusted Loan Provider in Gopalpura Jaipur | MLG Finedge')</title>
    <meta name="description" content="@yield('meta_description', 'MLG Finedge is the leading loan provider in Gopalpura Jaipur. We offer expert loan advisory & consultation for Personal Loans, Home Loans, Business Loans, and LAP. Get free advice now!')">
    
    <!-- Dynamic Favicon -->
    @if(!empty($site['favicon_path']))
        <link rel="icon" type="image/webp" href="{{ site_image($site['favicon_path']) }}">
    @else
        <link rel="icon" type="image/x-icon" href="/favicon.ico">
    @endif

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @yield('styles')

    <!-- Google Tag (gtag.js) -->
    @if(!empty($site['google_tag_id']))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $site['google_tag_id'] }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $site['google_tag_id'] }}');
        </script>
    @endif

    <!-- Custom Header Tracking Scripts -->
    @if(!empty($site['header_scripts']))
        {!! $site['header_scripts'] !!}
    @endif

    <!-- Structured SEO Schemas -->
    @yield('schema')
</head>
<body>

    <!-- Sticky Header -->
    <header class="header">
        <div class="container nav-container">
            <a href="{{ route('home') }}" class="logo">
                @if(!empty($site['logo_path']))
                    <img src="{{ site_image($site['logo_path']) }}" alt="{{ $site['site_name'] ?? 'MLG FINEDGE' }}" style="height: 55px; width: auto; object-fit: contain;">
                @else
                    <svg class="logo-icon" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="25" y="45" width="12" height="30" rx="3" fill="#0c5354" />
                        <rect x="44" y="30" width="12" height="45" rx="3" fill="#135859" />
                        <rect x="63" y="15" width="12" height="60" rx="3" fill="#5ccbb3" />
                        <path d="M15 80 L35 60 L50 70 L85 35" stroke="#e85c24" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M72 35 H85 V48" stroke="#e85c24" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" />
                        <rect x="20" y="10" width="60" height="80" rx="4" stroke="#e85c24" stroke-width="3" stroke-dasharray="4 4" />
                    </svg>
                    <div>
                        <span class="logo-text">{{ $site['site_name'] ?? 'MLG FINEDGE' }}</span>
                        <span class="logo-tagline">{{ $site['site_tagline'] ?? 'Your Prosperity, Our Priority' }}</span>
                    </div>
                @endif
            </a>
            
            <nav>
                <ul class="nav-links">
                    <li><a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                    <li><a href="{{ route('about') }}" class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}">About Us</a></li>
                    <li class="nav-dropdown-item">
                        <a href="{{ route('services') }}" class="nav-item {{ request()->routeIs('services') || request()->routeIs('services.*') ? 'active' : '' }}">Services <i data-lucide="chevron-down" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-left: 2px;"></i></a>
                        <ul class="dropdown-menu">
                            @foreach($globalServices as $gs)
                                <li><a href="{{ route('services.show', $gs->slug) }}">{{ $gs->service_name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="{{ route('compare') }}" class="nav-item {{ request()->routeIs('compare') ? 'active' : '' }}">Compare Loans</a></li>
                    <li><a href="{{ route('testimonials') }}" class="nav-item {{ request()->routeIs('testimonials') ? 'active' : '' }}">Testimonials</a></li>
                    <li><a href="{{ route('blog') }}" class="nav-item {{ request()->routeIs('blog') || request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a></li>
                    <li><a href="{{ route('contact') }}" class="nav-item {{ request()->routeIs('contact') ? 'active' : '' }}">Contact Us</a></li>
                </ul>
            </nav>
            
            <div class="nav-actions">
                <a href="tel:{{ $site['phone'] ?? '+919876543210' }}" class="btn btn-primary btn-sm"><i data-lucide="phone"></i> Call Now</a>
            </div>
            
            <button class="mobile-toggle" aria-label="Toggle Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>

    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="container footer-grid">
            <div class="footer-col footer-col-about">
                <div class="logo" style="margin-bottom:1rem;">
                    @if(!empty($site['logo_path']))
                        <img src="{{ site_image($site['logo_path']) }}" alt="{{ $site['site_name'] ?? 'MLG FINEDGE' }}" style="height: 55px; width: auto; object-fit: contain;">
                    @else
                        <svg class="logo-icon" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="25" y="45" width="12" height="30" rx="3" fill="#ffffff" />
                            <rect x="44" y="30" width="12" height="45" rx="3" fill="#ffffff" />
                            <rect x="63" y="15" width="12" height="60" rx="3" fill="#5ccbb3" />
                            <path d="M15 80 L35 60 L50 70 L85 35" stroke="#e85c24" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M72 35 H85 V48" stroke="#e85c24" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div>
                            <span class="logo-text" style="color:white;">{{ $site['site_name'] ?? 'MLG FINEDGE' }}</span>
                            <span class="footer-logo-tagline">{{ $site['site_tagline'] ?? 'Your Prosperity, Our Priority' }}</span>
                        </div>
                    @endif
                </div>
                <p>{{ $site['site_name'] ?? 'MLG Finedge' }} is Jaipur's premier credit advisory firm. We help individuals & small companies secure appropriate loan products with minimum interest cost and fast payouts.</p>
                <div class="social-links">
                    <a href="#" class="social-icon" aria-label="Facebook"><i data-lucide="facebook"></i></a>
                    <a href="#" class="social-icon" aria-label="Instagram"><i data-lucide="instagram"></i></a>
                    <a href="#" class="social-icon" aria-label="LinkedIn"><i data-lucide="linkedin"></i></a>
                </div>
            </div>
            
            <div class="footer-col">
                <h3>Quick Links</h3>
                <ul class="footer-links-list">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('services') }}">Services Overview</a></li>
                    <li><a href="{{ route('testimonials') }}">Testimonials</a></li>
                    <li><a href="{{ route('faq') }}">FAQs Hub</a></li>
                    <li><a href="{{ route('blog') }}">Fintech Blog</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h3>Loan Services</h3>
                <ul class="footer-links-list">
                    @foreach($globalServices->take(6) as $gs)
                        <li><a href="{{ route('services.show', $gs->slug) }}">{{ $gs->service_name }}</a></li>
                    @endforeach
                </ul>
            </div>
            
            <div class="footer-col">
                <h3>Contact Info</h3>
                <ul class="footer-contact-info">
                    <li>
                        <i data-lucide="map-pin"></i>
                        <span>{{ $site['address'] ?? 'Gopalpura Sector 5, Near Metro Station, Jaipur, Rajasthan 302020' }}</span>
                    </li>
                    <li>
                        <i data-lucide="phone"></i>
                        <a href="tel:{{ $site['phone'] ?? '+919876543210' }}">{{ $site['phone'] ?? '+91 98765 43210' }}</a>
                    </li>
                    <li>
                        <i data-lucide="mail"></i>
                        <a href="mailto:{{ $site['email'] ?? 'info@mlgfinedge.com' }}">{{ $site['email'] ?? 'info@mlgfinedge.com' }}</a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="container footer-bottom">
            <p>&copy; {{ date('Y') }} {{ $site['site_name'] ?? 'MLG Finedge' }}. All Rights Reserved. Disclaimer: Interest rates and terms are subject to bank/NBFC guidelines and customer credit profile assessment.</p>
            <div class="footer-bottom-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
            </div>
        </div>
    </footer>

    <!-- Floating Conversion Action Buttons -->
    <div class="floating-widgets">
        <a href="https://wa.me/{{ $site['whatsapp_number'] ?? '919876543210' }}?text=Hi%20MLG%20Finedge,%20I'm%20interested%20in%20a%20loan%20consultation." target="_blank" class="widget-btn widget-whatsapp" aria-label="WhatsApp Us">
            <i data-lucide="message-circle"></i>
        </a>
        <a href="tel:{{ $site['phone'] ?? '+919876543210' }}" class="widget-btn widget-call" aria-label="Call Us Now">
            <i data-lucide="phone"></i>
        </a>
        <button class="widget-btn widget-top" aria-label="Back to Top">
            <i data-lucide="arrow-up"></i>
        </button>
    </div>

    <!-- Mobile Sticky Action Bar -->
    <div class="mobile-action-bar">
        <a href="tel:{{ $site['phone'] ?? '+919876543210' }}" class="mobile-action-btn call">
            <i data-lucide="phone"></i> Call Now
        </a>
        <a href="https://wa.me/{{ $site['whatsapp_number'] ?? '919876543210' }}?text=Hi%20MLG%20Finedge,%20I'm%20interested%20in%20a%20loan%20consultation." target="_blank" class="mobile-action-btn whatsapp">
            <i data-lucide="message-circle"></i> WhatsApp
        </a>
    </div>

    <!-- Callback Modals Overlay -->
    <div class="dialog-overlay" id="callback-dialog">
        <div class="dialog-modal">
            <button class="dialog-close" aria-label="Close Modal">&times;</button>
            <div class="dialog-header">
                <h3>Request a Free Callback</h3>
                <p>Share your contact detail and an expert advisor will call you within 2 business hours.</p>
            </div>
            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="cb-name">Your Full Name</label>
                    <input type="text" id="cb-name" name="name" class="form-control" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="cb-phone">Phone Number</label>
                    <input type="tel" id="cb-phone" name="phone" class="form-control" placeholder="Enter 10-digit number" pattern="[0-9]{10}" required>
                </div>
                <div class="form-group">
                    <label for="cb-loan">Loan Category Required</label>
                    <select id="cb-loan" name="loan_type" class="form-control" required>
                        <option value="">-- Select Loan Type --</option>
                        <option value="personal">Personal Loan</option>
                        <option value="home">Home Loan</option>
                        <option value="business">Business Loan</option>
                        <option value="lap">Loan Against Property (LAP)</option>
                        <option value="other">Other Loans</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Submit Callback Request</button>
            </form>
        </div>
    </div>

    <!-- Exit Intent Modal Overlay -->
    <div class="dialog-overlay" id="exit-intent-dialog">
        <div class="dialog-modal">
            <button class="dialog-close" aria-label="Close Modal">&times;</button>
            <div class="dialog-header">
                <h3 class="color-accent">Before You Go!</h3>
                <p>Get a Free Loan Eligibility Report outlining maximum limits and lowest bank rates for your profile.</p>
            </div>
            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="exit-name">Your Full Name</label>
                    <input type="text" id="exit-name" name="name" class="form-control" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="exit-phone">Phone Number</label>
                    <input type="tel" id="exit-phone" name="phone" class="form-control" placeholder="Enter 10-digit number" pattern="[0-9]{10}" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Get My Free Report</button>
            </form>
        </div>
    </div>

    <!-- Success Modal Overlay -->
    <div class="dialog-overlay" id="success-dialog" style="{{ session('success') ? 'display: flex;' : '' }}">
        <div class="dialog-modal text-center">
            <button class="dialog-close" aria-label="Close Modal" onclick="closeDialog('success-dialog')">&times;</button>
            <div class="success-icon-wrap">
                <i data-lucide="check"></i>
            </div>
            <h3>Request Submitted Successfully!</h3>
            <p style="margin-top:1rem; color: var(--text-muted);">{{ session('success') ?? 'Thank you for contacting MLG Finedge. One of our senior loan advisors will review your request and get in touch with you shortly.' }}</p>
            <button onclick="closeDialog('success-dialog')" class="btn btn-primary" style="margin-top: 2rem; width: 150px;">OK</button>
        </div>
    </div>

    <!-- Lucide Icons CDN and Initializer -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
        function closeDialog(id) {
            document.getElementById(id).style.display = 'none';
        }
    </script>
    
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @yield('scripts')
</body>
</html>
