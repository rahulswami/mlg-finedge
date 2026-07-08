@extends('layouts.app')

@section('title', 'About Us | Loan Advisory Specialists in Jaipur | ' . ($site['site_name'] ?? 'MLG Finedge'))
@section('meta_description', 'Read about MLG Finedge, a premium loan advisory and consultation firm based in Gopalpura Jaipur. Learn about our vision, mission, and banking partnerships.')

@section('schema')
<script type="application/ld+json">
{
  "{{ '@' }}context": "https://schema.org",
  "{{ '@graph' }}": [
    {
      "{{ '@type' }}": "AboutPage",
      "{{ '@id' }}": "{{ route('about') }}/#webpage",
      "url": "{{ route('about') }}",
      "name": "About Us | Loan Advisory Specialists in Jaipur | {{ $site['site_name'] ?? 'MLG Finedge' }}",
      "description": "Read about MLG Finedge, a premium loan advisory and consultation firm based in Gopalpura Jaipur. Learn about our vision, mission, and banking partnerships.",
      "isPartOf": {
        "{{ '@type' }}": "WebSite",
        "{{ '@id' }}": "{{ route('home') }}/#website"
      },
      "mainEntity": {
        "{{ '@type' }}": "Organization",
        "{{ '@id' }}": "{{ route('home') }}/#organization",
        "name": "{{ $site['site_name'] ?? 'MLG Finedge' }}",
        "url": "{{ route('home') }}"
      }
    }
  ]
}
</script>
@endsection

@section('content')

    <!-- Details Hero -->
    <section class="details-hero">
        <div class="container text-center">
            <span class="color-mint font-semibold" style="text-transform: uppercase; letter-spacing: 1.5px; font-size: 0.9rem;">{{ $pageContents['about']['hero']['pre_title'] ?? 'WHO WE ARE' }}</span>
            <h1 style="margin-top: 10px;">{{ $pageContents['about']['hero']['title'] ?? ('About ' . ($site['site_name'] ?? 'MLG Finedge')) }}</h1>
            <p style="color: var(--text-light-muted); max-width: 600px; margin: 0 auto;">{{ $pageContents['about']['hero']['subtitle'] ?? 'Jaipur\'s leading credit advisory firm assisting individuals and commercial ventures in obtaining tailored financial matches.' }}</p>
        </div>
    </section>

    <!-- Story Section -->
    <section class="section">
        <div class="container about-grid">
            <div class="about-content animate-on-scroll">
                <span class="pre-title">{{ $pageContents['about']['story']['pre_title'] ?? 'Our Story' }}</span>
                <h2>{{ $pageContents['about']['story']['title'] ?? 'Helping Jaipur Secure Better Financing' }}</h2>
                <p>{{ $pageContents['about']['story']['p1'] ?? (($site['site_name'] ?? 'MLG Finedge') . " was founded with a singular mission: to protect borrowers from overpriced loan products and opaque processes. Finding the right loan is rarely about accepting the first bank offer. It requires analyzing hidden parameters—such as pre-closure penalties, compound interest methods, processing times, and eligibility multipliers.") }}</p>
                <p>{{ $pageContents['about']['story']['p2'] ?? 'Over the last 12 years, we have built a reputation in Jaipur as a transparent, client-first consultancy that handles the heavy lifting, saving our clients time, stress, and lakhs in excess interest payments.' }}</p>
                <p>{{ $pageContents['about']['story']['p3'] ?? 'Whether you are a government teacher, a self-employed boutique owner, or a growing infrastructure company, we provide tailored consultation based on your income profiles and parameters.' }}</p>
            </div>
            
            <div class="about-visual animate-on-scroll">
                <div class="about-img-box" style="background-color: var(--primary-teal-light); height: 320px; display: flex; align-items: center; justify-content: center; color: var(--text-light);">
                    <div class="text-center" style="padding: 2rem;">
                        <i data-lucide="shield-check" style="width: 50px; height: 50px; color: var(--mint-green); margin-bottom: 1rem;"></i>
                        <h3>Verified Advisory Partner</h3>
                        <p style="font-size: 0.9rem; color: var(--text-light-muted); margin-top: 10px;">We act on your behalf to present clean financial files that underwriting boards approve with ease.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission -->
    <section class="section" style="background-color: #fafdfd;">
        <div class="container">
            <div class="benefits-grid">
                <div class="benefit-block animate-on-scroll">
                    <div class="why-icon" style="margin-bottom: 1.5rem;"><i data-lucide="eye"></i></div>
                    <h3>{{ $pageContents['about']['vision']['title'] ?? 'Our Vision' }}</h3>
                    <p>{{ $pageContents['about']['vision']['text'] ?? 'To be India\'s most trusted financial matchmaking advisory, helping thousands of families build assets and business owners generate sustainable local employment.' }}</p>
                </div>
                
                <div class="benefit-block highlight animate-on-scroll">
                    <div class="why-icon" style="margin-bottom: 1.5rem; background-color: rgba(255,255,255,0.1); color: var(--mint-green);"><i data-lucide="target"></i></div>
                    <h3>{{ $pageContents['about']['mission']['title'] ?? 'Our Mission' }}</h3>
                    <p>{{ $pageContents['about']['mission']['text'] ?? 'To deliver absolute transparency in loan comparisons, identify optimal lenders, eliminate unnecessary bank rejections, and speed up payouts.' }}</p>
                </div>
                
                <div class="benefit-block animate-on-scroll">
                    <div class="why-icon" style="margin-bottom: 1.5rem;"><i data-lucide="heart"></i></div>
                    <h3>{{ $pageContents['about']['values']['title'] ?? 'Our Core Values' }}</h3>
                    <p>{{ $pageContents['about']['values']['text'] ?? 'Client prosperity is our priority. We are independent of single-bank biases, offering objective guidance, clear pricing, and continuous document safety.' }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Leadership Section -->
    <section class="section">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2>{{ $pageContents['about']['team']['title'] ?? 'Our Advisory Team' }}</h2>
                <p>{{ $pageContents['about']['team']['subtitle'] ?? 'Meet the credit specialists guiding you through terms, rates, and approval cycles.' }}</p>
            </div>
            
            <div class="why-grid" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));">
                <!-- Advisor 1 -->
                <div class="service-card text-center animate-on-scroll">
                    <div style="width:100px; height:100px; border-radius:50%; background-color:var(--primary-teal-light); margin:0 auto 1.5rem auto; display:flex; align-items:center; justify-content:center; color:white; font-size:2rem; font-weight:700;">MG</div>
                    <h3>{{ $pageContents['about']['team']['advisor1_name'] ?? 'Mahendra Gupta' }}</h3>
                    <span class="color-accent" style="font-size:0.85rem; font-weight:600; display:block; margin-bottom:1rem;">{{ $pageContents['about']['team']['advisor1_role'] ?? 'Founder & Principal Advisor' }}</span>
                    <p style="font-size:0.85rem;">{{ $pageContents['about']['team']['advisor1_bio'] ?? 'Ex-banker with 18+ years of expertise in corporate credit, LAP approvals, and project finance deals.' }}</p>
                </div>
                
                <!-- Advisor 2 -->
                <div class="service-card text-center animate-on-scroll">
                    <div style="width:100px; height:100px; border-radius:50%; background-color:var(--accent-orange); margin:0 auto 1.5rem auto; display:flex; align-items:center; justify-content:center; color:white; font-size:2rem; font-weight:700;">RS</div>
                    <h3>{{ $pageContents['about']['team']['advisor2_name'] ?? 'Ritu Sharma' }}</h3>
                    <span class="color-accent" style="font-size:0.85rem; font-weight:600; display:block; margin-bottom:1rem;">{{ $pageContents['about']['team']['advisor2_role'] ?? 'Senior Retail Loan Head' }}</span>
                    <p style="font-size:0.85rem;">{{ $pageContents['about']['team']['advisor2_bio'] ?? 'Retail specialist overseeing home loan approvals, government schemes, and salary eligibility multipliers.' }}</p>
                </div>
                
                <!-- Advisor 3 -->
                <div class="service-card text-center animate-on-scroll">
                    <div style="width:100px; height:100px; border-radius:50%; background-color:var(--mint-green); margin:0 auto 1.5rem auto; display:flex; align-items:center; justify-content:center; color:white; font-size:2rem; font-weight:700;">AJ</div>
                    <h3>{{ $pageContents['about']['team']['advisor3_name'] ?? 'Amit Jain' }}</h3>
                    <span class="color-accent" style="font-size:0.85rem; font-weight:600; display:block; margin-bottom:1rem;">{{ $pageContents['about']['team']['advisor3_role'] ?? 'Business Finance Specialist' }}</span>
                    <p style="font-size:0.85rem;">{{ $pageContents['about']['team']['advisor3_bio'] ?? 'Advisor matching SMEs and startups with cash credit, overdraft, and working capital lines.' }}</p>
                </div>
            </div>
        </div>
    </section>n>

    <!-- Final Call to Action -->
    <section class="final-cta-section">
        <div class="final-cta-wrapper animate-on-scroll">
            <h2>Ready to Find the Best Loan Offer?</h2>
            <p>Skip the branch visits. Let our credit specialists check your eligibility across 150+ banks today.</p>
            <div class="final-cta-buttons">
                <button onclick="triggerCallbackModal()" class="btn btn-white">Request Free Advisory</button>
                <a href="{{ route('contact') }}" class="btn btn-outline-white"><i data-lucide="phone"></i> Contact Us</a>
            </div>
        </div>
    </section>

@endsection
