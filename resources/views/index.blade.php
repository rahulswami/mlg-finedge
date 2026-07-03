@extends('layouts.app')

@section('title', 'Trusted Loan Provider in Gopalpura Jaipur | ' . ($site['site_name'] ?? 'MLG FINEDGE'))
@section('meta_description', 'MLG Finedge is the leading loan provider in Gopalpura Jaipur. We offer expert loan advisory & consultation for Personal Loans, Home Loans, Business Loans, and LAP. Get free advice now!')

@section('schema')
<script type="application/ld+json">
{
  "{{ '@' }}context": "https://schema.org",
  "{{ '@graph' }}": [
    {
      "{{ '@type' }}": "Organization",
      "{{ '@id' }}": "{{ route('home') }}/#organization",
      "name": "{{ $site['site_name'] ?? 'MLG Finedge' }}",
      "url": "{{ route('home') }}",
      "logo": {
        "{{ '@type' }}": "ImageObject",
        "{{ '@id' }}": "{{ route('home') }}/#logo",
        "url": "{{ !empty($site['logo_path']) ? site_image($site['logo_path']) : asset('assets/images/logo.png') }}",
        "caption": "{{ $site['site_name'] ?? 'MLG Finedge' }}"
      },
      "contactPoint": {
        "{{ '@type' }}": "ContactPoint",
        "telephone": "{{ $site['phone'] ?? '+919672777749' }}",
        "contactType": "customer service",
        "areaServed": "IN",
        "availableLanguage": ["en", "hi"]
      },
      "sameAs": [
        "https://www.facebook.com/mlgfinedge",
        "https://www.instagram.com/mlgfinedge",
        "https://www.linkedin.com/company/mlgfinedge"
      ]
    },
    {
      "{{ '@type' }}": "FinancialService",
      "{{ '@id' }}": "{{ route('home') }}/#service",
      "name": "{{ $site['site_name'] ?? 'MLG Finedge' }}",
      "description": "Jaipur's premier credit advisory firm. We help individuals & small companies secure appropriate loan products with minimum interest cost.",
      "url": "{{ route('home') }}",
      "telephone": "{{ $site['phone'] ?? '+919672777749' }}",
      "address": {
        "{{ '@type' }}": "PostalAddress",
        "streetAddress": "{{ $site['address'] ?? 'Gopalpura Sector 5, Near Metro Station' }}",
        "addressLocality": "Jaipur",
        "addressRegion": "Rajasthan",
        "postalCode": "302020",
        "addressCountry": "IN"
      },
      "geo": {
        "{{ '@type' }}": "GeoCoordinates",
        "latitude": 26.864382,
        "longitude": 75.760126
      },
      "priceRange": "$$",
      "openingHoursSpecification": {
        "{{ '@type' }}": "OpeningHoursSpecification",
        "dayOfWeek": [
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday"
        ],
        "opens": "09:00",
        "closes": "18:00"
      }
    },
    {
      "{{ '@type' }}": "WebSite",
      "{{ '@id' }}": "{{ route('home') }}/#website",
      "url": "{{ route('home') }}",
      "name": "{{ $site['site_name'] ?? 'MLG Finedge' }}",
      "publisher": {
        "{{ '@id' }}": "{{ route('home') }}/#organization"
      }
    }
  ]
}
</script>
@endsection

@section('content')

<style>
.hero-slider-container {
    position: relative;
    overflow: hidden;
}
.hero-slider-track {
    display: flex;
    transition: transform 0.5s ease-in-out;
}
.hero-slide-item {
    flex-shrink: 0;
    width: 100%;
}
.hero-slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(12, 83, 84, 0.1);
    color: var(--primary-teal-dark);
    border: none;
    border-radius: 50%;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    transition: background 0.3s, color 0.3s;
}
.hero-slider-btn:hover {
    background: var(--primary-teal);
    color: #ffffff;
}
.hero-slider-btn.prev {
    left: 20px;
}
.hero-slider-btn.next {
    right: 20px;
}
.hero-slider-dots {
    position: absolute;
    bottom: 240px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 8px;
    z-index: 10;
}
.hero-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.2);
    cursor: pointer;
    transition: background 0.3s;
}
.hero-dot.active {
    background: var(--primary-teal) !important;
}
@media (max-width: 768px) {
    .hero-slider-btn {
        display: none !important;
    }
    .hero-slider-dots {
        bottom: 200px;
    }
}
</style>

    <!-- Dynamic Hero Slider or Fallback Static Section -->
    @if(isset($slides) && $slides->count() > 0)
        <!-- Hero Slider Section -->
        <section class="hero hero-slider-container" style="background: {!! $site['index_hero_bg'] ?? 'linear-gradient(135deg, #eef7f7 0%, #ffffff 100%)' !!}; padding: 10rem 0 6rem 0; position: relative; overflow: hidden;">
            <div class="hero-slider-track" style="display: flex; transition: transform 0.5s ease-in-out; width: {{ $slides->count() * 100 }}%;">
                @foreach($slides as $index => $slide)
                    <div class="hero-slide-item" style="width: calc(100% / {{ $slides->count() }}); flex-shrink: 0;">
                        <div class="container" style="max-width: 800px; margin: 0 auto; padding: 0 1.5rem;">
                            <div class="hero-content" style="text-align: center; width: 100%;">
                                <span class="color-mint font-semibold" style="text-transform: uppercase; letter-spacing: 1.5px; font-size: 0.95rem; display: block; margin-bottom: 1rem;">Welcome to MLG Finedge</span>
                                <h1 style="font-size: 3rem; line-height: 1.2; margin-bottom: 1.5rem; color: var(--primary-teal-dark); font-weight: 800; letter-spacing: -0.5px;">
                                    {{ $slide->title }}
                                </h1>
                                <p class="subtitle" style="font-size: 1.2rem; color: var(--text-muted); margin-bottom: 2.5rem; line-height: 1.6; max-width: 700px; margin-left: auto; margin-right: auto;">
                                    {{ $slide->subtitle }}
                                </p>
                                <div class="hero-buttons" style="display: flex; gap: 1.25rem; justify-content: center;">
                                    @if($slide->button_text)
                                        <button onclick="triggerCallbackModal()" class="btn btn-primary">{{ $slide->button_text }} <i data-lucide="arrow-right"></i></button>
                                    @endif
                                    <a href="tel:{{ $site['phone'] ?? '+919672777749' }}" class="btn btn-secondary"><i data-lucide="phone"></i> Call Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Slider controls -->
            @if($slides->count() > 1)
                <button class="hero-slider-btn prev" onclick="moveHeroSlide(-1)"><i data-lucide="chevron-left"></i></button>
                <button class="hero-slider-btn next" onclick="moveHeroSlide(1)"><i data-lucide="chevron-right"></i></button>
                <div class="hero-slider-dots">
                    @foreach($slides as $index => $slide)
                        <span class="hero-dot @if($index === 0) active @endif" onclick="setHeroSlide({{ $index }})"></span>
                    @endforeach
                </div>
            @endif

            <!-- Global Static Trust Badges -->
            <div class="container hero-global-trust" style="margin-top: 4rem; position: relative; z-index: 5;">
                <div class="hero-trust">
                    <div class="trust-item">
                        <span class="trust-num">₹1,200 Cr+</span>
                        <span class="trust-label">Loans Assisted</span>
                    </div>
                    <div class="trust-item">
                        <span class="trust-num">5,000+</span>
                        <span class="trust-label">Happy Clients</span>
                    </div>
                    <div class="trust-item">
                        <span class="trust-num">150+</span>
                        <span class="trust-label">Lending Partners</span>
                    </div>
                </div>
            </div>
        </section>
    @else
        <!-- Static Hero Section (Fallback) -->
        <section class="hero" style="background: {!! $site['index_hero_bg'] ?? 'linear-gradient(135deg, #eef7f7 0%, #ffffff 100%)' !!}; padding: 10rem 0 6rem 0; text-align: center;">
            <div class="container" style="max-width: 800px; margin: 0 auto; padding: 0 1.5rem;">
                <div class="hero-content" style="text-align: center; width: 100%;">
                    <span class="color-mint font-semibold" style="text-transform: uppercase; letter-spacing: 1.5px; font-size: 0.95rem; display: block; margin-bottom: 1rem;">Welcome to MLG Finedge</span>
                    <h1 style="font-size: 3rem; line-height: 1.2; margin-bottom: 1.5rem; color: var(--primary-teal-dark); font-weight: 800; letter-spacing: -0.5px;">
                        {{ $pageContents['home']['hero']['title'] ?? 'Trusted Loan Provider in Gopalpura Jaipur' }}
                    </h1>
                    <p class="subtitle" style="font-size: 1.2rem; color: var(--text-muted); margin-bottom: 2.5rem; line-height: 1.6; max-width: 700px; margin-left: auto; margin-right: auto;">
                        {{ $pageContents['home']['hero']['subtitle'] ?? 'Your Trusted Partner for Smart Loan Solutions, Quick Assistance, and Reliable Financial Guidance.' }}
                    </p>
                    <div class="hero-buttons" style="display: flex; gap: 1.25rem; justify-content: center;">
                        <button onclick="triggerCallbackModal()" class="btn btn-primary">Get Free Consultation <i data-lucide="arrow-right"></i></button>
                        <a href="tel:{{ $site['phone'] ?? '+919672777749' }}" class="btn btn-secondary"><i data-lucide="phone"></i> Call Now</a>
                    </div>
                </div>
            </div>

            <!-- Global Static Trust Badges -->
            <div class="container hero-global-trust" style="margin-top: 4rem; position: relative; z-index: 5;">
                <div class="hero-trust">
                    <div class="trust-item">
                        <span class="trust-num">₹1,200 Cr+</span>
                        <span class="trust-label">Loans Assisted</span>
                    </div>
                    <div class="trust-item">
                        <span class="trust-num">5,000+</span>
                        <span class="trust-label">Happy Clients</span>
                    </div>
                    <div class="trust-item">
                        <span class="trust-num">150+</span>
                        <span class="trust-label">Lending Partners</span>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Services Overview Section -->
    <section class="section" id="services" style="background: {!! $site['index_services_bg'] ?? '#ffffff' !!};">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2>{{ $pageContents['home']['services']['title'] ?? 'Find the Right Loan for Your Needs' }}</h2>
                <p>{{ $pageContents['home']['services']['subtitle'] ?? 'We work as your advisory partner to match you with top-tier lenders. Here are the tailor-made lending solutions we consult on:' }}</p>
            </div>
            
            @php
            $iconMap = [
                'personal-loan' => 'user',
                'home-loan' => 'home',
                'car-loan' => 'car',
                'business-loan' => 'briefcase',
                'working-capital' => 'trending-up',
                'project-funding' => 'building-2',
                'loan-against-property' => 'landmark',
                'gold-loan' => 'coins',
            ];
            @endphp
            <div class="services-grid">
                @foreach($globalServices as $gs)
                    <div class="service-card animate-on-scroll">
                        <div class="service-icon"><i data-lucide="{{ $iconMap[$gs->slug] ?? 'wallet' }}"></i></div>
                        <h3>{{ $gs->service_name }}</h3>
                        <p>{{ $gs->summary }}</p>
                        <a href="{{ route('services.show', $gs->slug) }}" class="service-link">Learn More <i data-lucide="chevron-right"></i></a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section section-bg-dark" style="background: {!! $site['index_about_bg'] ?? '#111b1c' !!}; color: #ffffff;">
        <div class="container about-grid">
            <div class="about-visual animate-on-scroll">
                <div class="about-img-box" style="background-color: var(--primary-teal-light); height: 350px; display: flex; align-items: center; justify-content: center; color: var(--text-light);">
                    <div class="text-center" style="padding: 2rem;">
                        <i data-lucide="award" style="width: 60px; height: 60px; color: var(--mint-green); margin-bottom: 1.5rem;"></i>
                        <h3>Your Trust Is Our Asset</h3>
                        <p style="font-size: 0.9rem; color: var(--text-light-muted); margin-top: 10px;">We hold your hand through assessment, document checking, rate comparisons, and ultimate bank approvals.</p>
                    </div>
                </div>
                <div class="about-badge">
                    <span class="about-badge-num">16+</span>
                    <span class="about-badge-label"><br>Years of Advisory<br>Excellence</span>
                </div>
            </div>
            
            <div class="about-content animate-on-scroll">
                <span class="pre-title">{{ $pageContents['home']['about']['pre_title'] ?? 'Your Trusted Loan Advisory Partner' }}</span>
                <h2>{{ $pageContents['home']['about']['title'] ?? (($site['site_name'] ?? 'MLG Finedge') . ': Simplifying Credit for Jaipur') }}</h2>
                <p>{{ $pageContents['home']['about']['body_p1'] ?? (($site['site_name'] ?? 'MLG Finedge') . " helps individuals and businesses navigate India's complex credit markets. Rather than acting as a direct lender, we serve as your independent consultant, comparing loan schemes from leading nationalized banks, private financial entities, and NBFCs.") }}</p>
                <p>{{ $pageContents['home']['about']['body_p2'] ?? 'Our goal is to ensure you get the maximum loan amount eligibility at the lowest possible interest rate with the least amount of processing hassle.' }}</p>
                
                <div class="about-bullets">
                    <div class="about-bullet-item">
                        <i data-lucide="check" class="bullet-icon"></i>
                        <div>
                            <strong>Independent Comparisons:</strong> We analyze interest rates, processing fees, and terms across multiple banks, saving you hours of research.
                        </div>
                    </div>
                    <div class="about-bullet-item">
                        <i data-lucide="check" class="bullet-icon"></i>
                        <div>
                            <strong>End-to-End Processing:</strong> We collect documentation, verify eligibility, submit to lenders, and coordinate for smooth payouts.
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('about') }}" class="btn btn-primary">Discover Our Story</a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us & Statistics -->
    <section class="section" style="background: {!! $site['index_why_bg'] ?? '#ffffff' !!};">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2>{{ $pageContents['home']['why_choose_us']['title'] ?? 'Simplifying Your Loan Journey' }}</h2>
                <p>{{ $pageContents['home']['why_choose_us']['subtitle'] ?? 'We combine deep expertise with strong banking relationships to bring you unmatched credit advisory services.' }}</p>
            </div>
            
            <div class="why-grid">
                <div class="why-card animate-on-scroll">
                    <div class="why-icon"><i data-lucide="shield-check"></i></div>
                    <div class="why-info">
                        <h3>Expert Consultation</h3>
                        <p>Our senior advisors assess your profile to find the most fitting financial solution.</p>
                    </div>
                </div>
                
                <div class="why-card animate-on-scroll">
                    <div class="why-icon"><i data-lucide="users"></i></div>
                    <div class="why-info">
                        <h3>Multiple Lending Partners</h3>
                        <p>We maintain active associations with top national banks, private banks, and NBFCs.</p>
                    </div>
                </div>
                
                <div class="why-card animate-on-scroll">
                    <div class="why-icon"><i data-lucide="sliders"></i></div>
                    <div class="why-info">
                        <h3>Personalized Solutions</h3>
                        <p>No two files are the same. We construct customized profiles to match exact lender mandates.</p>
                    </div>
                </div>
                
                <div class="why-card animate-on-scroll">
                    <div class="why-icon"><i data-lucide="zap"></i></div>
                    <div class="why-info">
                        <h3>Fast Processing Support</h3>
                        <p>Our direct coordination channels with underwriters ensure speedier processing turns.</p>
                    </div>
                </div>
                
                <div class="why-card animate-on-scroll">
                    <div class="why-icon"><i data-lucide="eye"></i></div>
                    <div class="why-info">
                        <h3>Transparent Guidance</h3>
                        <p>Zero hidden broker margins. We provide complete details of terms, processing fees, and foreclosures.</p>
                    </div>
                </div>
                
                <div class="why-card animate-on-scroll">
                    <div class="why-icon"><i data-lucide="headphones"></i></div>
                    <div class="why-info">
                        <h3>Dedicated Assistance</h3>
                        <p>A single dedicated point of contact handles your file query from day one to payout.</p>
                    </div>
                </div>
            </div>
            
            <!-- Counters row -->
            <div class="stats-row animate-on-scroll">
                <div class="stat-box">
                    <h3><span class="counter-num" data-target="5000">0</span>+</h3>
                    <p>Happy Clients Served</p>
                </div>
                <div class="stat-box">
                    <h3>₹<span class="counter-num" data-target="1200">0</span> Cr+</h3>
                    <p>Loans Disbursed Assistance</p>
                </div>
                <div class="stat-box">
                    <h3><span class="counter-num" data-target="15">0</span>+</h3>
                    <p>Lending Institutions</p>
                </div>
                <div class="stat-box">
                    <h3><span class="counter-num" data-target="12">0</span>+</h3>
                    <p>Years of Service</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive EMI Calculator Section -->
    <section class="section" style="background-color: #f0f7f7;">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2>Plan Your Finances</h2>
                <p>Calculate your estimated monthly installments (EMI) and interest breakdown using our real-time calculator.</p>
            </div>
            
            <div class="calculator-box animate-on-scroll">
                <div class="calc-inputs">
                    <!-- Loan Amount -->
                    <div class="input-slider-group">
                        <div class="slider-label-wrap">
                            <span class="slider-label">Loan Amount Required</span>
                            <span class="slider-display-val" id="val-loan-amount">₹10,000,000</span>
                        </div>
                        <input type="range" id="calc-loan-amount" min="100000" max="100000000" step="100000" value="5000000" class="calc-slider">
                        <div class="slider-limits">
                            <span>₹1 Lakh</span>
                            <span>₹10 Crore</span>
                        </div>
                    </div>
                    
                    <!-- Interest Rate -->
                    <div class="input-slider-group">
                        <div class="slider-label-wrap">
                            <span class="slider-label">Rate of Interest (Annual)</span>
                            <span class="slider-display-val" id="val-interest">8.5%</span>
                        </div>
                        <input type="range" id="calc-interest" min="5" max="25" step="0.1" value="8.5" class="calc-slider">
                        <div class="slider-limits">
                            <span>5% p.a.</span>
                            <span>25% p.a.</span>
                        </div>
                    </div>
                    
                    <!-- Tenure -->
                    <div class="input-slider-group">
                        <div class="slider-label-wrap">
                            <span class="slider-label">Loan Tenure</span>
                            <span class="slider-display-val" id="val-tenure">20 Years</span>
                        </div>
                        <input type="range" id="calc-tenure" min="1" max="30" step="1" value="20" class="calc-slider">
                        <div class="slider-limits">
                            <span>1 Year</span>
                            <span>30 Years</span>
                        </div>
                    </div>
                </div>
                
                <div class="calc-outputs">
                    <div class="calc-chart-container">
                        <svg class="chart-svg" width="120" height="120" viewBox="0 0 120 120">
                            <circle class="chart-bg-circle" cx="60" cy="60" r="50"></circle>
                            <circle class="chart-val-circle" cx="60" cy="60" r="50" stroke-dasharray="314.16" stroke-dashoffset="100"></circle>
                        </svg>
                    </div>
                    
                    <div class="output-stat-block text-center">
                        <span class="output-label">Estimated Monthly EMI</span>
                        <div class="output-value" id="output-emi">₹43,391</div>
                    </div>
                    
                    <div class="split-stats">
                        <div class="split-item">
                            <span>Principal Amount:</span>
                            <span id="output-principal">₹5,000,000</span>
                        </div>
                        <div class="split-item">
                            <span>Total Interest Payable:</span>
                            <span id="output-interest">₹5,413,879</span>
                        </div>
                        <div class="split-item" style="border-top: 1px solid var(--border-dark); padding-top: 0.5rem; margin-top: 0.5rem;">
                            <span>Total Cost of Loan:</span>
                            <span id="output-total">₹10,413,879</span>
                        </div>
                    </div>
                    
                    <button onclick="triggerCallbackModal()" class="btn btn-primary" style="width: 100%;">Apply for this Loan</button>
                </div>
            </div>
        </div>
    </section>

    <!-- 4-Step Process Section -->
    <section class="section">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2>Our Simple 4-Step Process</h2>
                <p>Getting the right funding solution has never been this smooth. Here is how we process your requirements:</p>
            </div>
            
            <div class="process-timeline">
                <!-- Step 1 -->
                <div class="timeline-item animate-on-scroll">
                    <div class="timeline-step">1</div>
                    <div class="timeline-content">
                        <h3>Share Your Requirement</h3>
                        <p>Fill out our short online form, drop us a WhatsApp message, or hop on a brief call. Our advisors will identify your funding goal, profile parameters, and immediate needs.</p>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div class="timeline-item animate-on-scroll">
                    <div class="timeline-step">2</div>
                    <div class="timeline-content">
                        <h3>Financial Assessment</h3>
                        <p>We check your profile details (income, CIBIL credit score history, FOIR ratios) against various banking credit metrics to find matching schemes and maximize your loan size approval margins.</p>
                    </div>
                </div>
                
                <!-- Step 3 -->
                <div class="timeline-item animate-on-scroll">
                    <div class="timeline-step">3</div>
                    <div class="timeline-content">
                        <h3>Compare Loan Offers</h3>
                        <p>We present a clear side-by-side comparison matrix of interest rates, upfront fees, pre-payment terms, and processing timelines from over 15 financial institutes, giving you absolute power of choice.</p>
                    </div>
                </div>
                
                <!-- Step 4 -->
                <div class="timeline-item animate-on-scroll">
                    <div class="timeline-step">4</div>
                    <div class="timeline-content">
                        <h3>Complete Processing Support</h3>
                        <p>Once you select an offer, we collect the necessary paperwork, compile the bank files, submit them to underwriters, check valuations, and push until the money hits your bank account.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="section" style="background-color: var(--bg-white);">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2>What Makes Us Different?</h2>
                <p>We do not just find you loans; we provide full consultation support to ensure your long-term financial success.</p>
            </div>
            
            <div class="benefits-grid">
                <div class="benefit-block animate-on-scroll">
                    <span class="benefit-tag">Options</span>
                    <h3>Competitive Loan Options</h3>
                    <p>Access packages from multiple partner institutions. We check the finest rate margins to ensure your monthly installments remain light.</p>
                </div>
                
                <div class="benefit-block highlight animate-on-scroll">
                    <span class="benefit-tag">Guidance</span>
                    <h3>Better Guidance</h3>
                    <p>We evaluate complex criteria, hidden fees, and foreclosure conditions, explaining everything in simple terms before you sign any paperwork.</p>
                </div>
                
                <div class="benefit-block animate-on-scroll">
                    <span class="benefit-tag">Time</span>
                    <h3>Maximum Time Saving</h3>
                    <p>Avoid running from branch to branch filling forms. We manage the document check, files preparation, and bank follow-ups on your behalf.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="section testimonials-section" style="background: {!! $site['index_testimonials_bg'] ?? '#f4f8f8' !!};">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2>What Our Clients Say</h2>
                <p>Read real stories from individuals & businesses who found the right funding through our advisory consultation.</p>
            </div>
            
            <div class="carousel-container animate-on-scroll">
                <div class="carousel-track-wrapper">
                    <div class="carousel-track">
                        @foreach($testimonials as $test)
                            <!-- Slide -->
                            <div class="testimonial-slide">
                                <div class="testimonial-card">
                                    <div class="testimonial-rating" style="color: #ffb100; margin-bottom: 1rem;">
                                        @for($i = 0; $i < $test->rating; $i++)★@endfor
                                    </div>
                                    <p class="testimonial-text">"{{ $test->content }}"</p>
                                    <div class="testimonial-author">
                                        <div class="author-img" style="background-color: var(--primary-teal-light); display: flex; align-items: center; justify-content: center; color: var(--text-light); font-weight: 700; overflow: hidden; border-radius: 50%; width: 44px; height: 44px;">
                                            @if($test->avatar_path)
                                                <img src="{{ site_image($test->avatar_path) }}" alt="{{ $test->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                {{ substr($test->name, 0, 2) }}
                                            @endif
                                        </div>
                                        <div class="author-info">
                                            <h4>{{ $test->name }}</h4>
                                            <p>{{ $test->role }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                @if($testimonials->count() > 1)
                    <button class="carousel-btn carousel-btn-prev" aria-label="Previous Slide"><i data-lucide="chevron-left"></i></button>
                    <button class="carousel-btn carousel-btn-next" aria-label="Next Slide"><i data-lucide="chevron-right"></i></button>
                    <div class="carousel-dots"></div>
                @endif
            </div>
        </div>
    </section>

    <!-- FAQ Section (Accordion) -->
    <section class="section" style="background: {!! $site['index_faq_bg'] ?? '#ffffff' !!};">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2>Frequently Asked Questions</h2>
                <p>Get answers to common queries regarding loan advisory, interest rates, and process requirements.</p>
            </div>
            
            <div class="faq-accordion animate-on-scroll">
                <div class="faq-item">
                    <div class="faq-header">
                        <span class="faq-title">Are you a direct bank or a loan agency?</span>
                        <div class="faq-toggle"></div>
                    </div>
                    <div class="faq-body">
                        <div class="faq-content">
                            <p>We are a professional loan advisory & consultation agency. We do not directly lend money. Instead, we analyze your financial profile, match you with appropriate banks and NBFCs, compare interest rates, and handle file processing to secure approvals.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-header">
                        <span class="faq-title">What are the starting interest rates for Home Loans?</span>
                        <div class="faq-toggle"></div>
                    </div>
                    <div class="faq-body">
                        <div class="faq-content">
                            <p>Currently, Home Loan interest rates start at around {{ $site['home_loan_rate'] ?? '8.4%' }}* p.a. for salaried professionals with high credit scores (CIBIL 750+). However, final rates depend on individual eligibility metrics, loan size, and the lending bank's policy guidelines.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-header">
                        <span class="faq-title">Can I get a business loan without collateral?</span>
                        <div class="faq-toggle"></div>
                    </div>
                    <div class="faq-body">
                        <div class="faq-content">
                            <p>Yes, unsecured Business Loans and Working Capital Loans up to ₹75 Lakhs can be secured without any collateral, subject to your company's sales figures, ITR filings, banking history, and continuous operational proof (minimum 2 years).</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final Call to Action Section -->
    <section class="final-cta-section" style="background: {!! $site['index_cta_bg'] ?? 'linear-gradient(135deg, #0c5354 0%, #135859 100%)' !!};">
        <div class="final-cta-wrapper animate-on-scroll">
            <h2>Need Expert Loan Guidance?</h2>
            <p>Speak to our senior credit advisors today. Get free guidance and custom lender matchings based on your profile.</p>
            <div class="final-cta-buttons">
                <button onclick="triggerCallbackModal()" class="btn btn-white">Talk to a Loan Expert</button>
                <a href="{{ route('contact') }}" class="btn btn-outline-white"><i data-lucide="message-square"></i> Request Callback</a>
            </div>
            <div class="final-cta-trust">
                <i data-lucide="check-circle" style="display:inline-block; vertical-align:middle; margin-right:5px; width:16px; height:16px;"></i> No upfront consultancy fees. Absolute transparency guaranteed.
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/calculator.js') }}"></script>
    @if(isset($slides) && $slides->count() > 1)
        <script>
            let currentHeroSlide = 0;
            const heroSlidesCount = {{ $slides->count() }};
            function updateHeroSlider() {
                const track = document.querySelector('.hero-slider-track');
                if (!track) return;
                track.style.transform = `translateX(-${currentHeroSlide * (100 / heroSlidesCount)}%)`;
                
                // Update dots
                const dots = document.querySelectorAll('.hero-dot');
                dots.forEach((dot, idx) => {
                    if (idx === currentHeroSlide) {
                        dot.classList.add('active');
                    } else {
                        dot.classList.remove('active');
                    }
                });
            }
            function moveHeroSlide(direction) {
                currentHeroSlide = (currentHeroSlide + direction + heroSlidesCount) % heroSlidesCount;
                updateHeroSlider();
            }
            function setHeroSlide(index) {
                currentHeroSlide = index;
                updateHeroSlider();
            }
            document.addEventListener('DOMContentLoaded', () => {
                updateHeroSlider();
                // Auto-play every 6 seconds
                setInterval(() => {
                    moveHeroSlide(1);
                }, 6000);
            });
        </script>
    @endif
@endsection
