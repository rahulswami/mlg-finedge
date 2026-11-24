@extends('layouts.app')

@section('title', (!empty($pageSeo->meta_title) ? $pageSeo->meta_title : ('Privacy Policy | ' . ($site['site_name'] ?? 'MLG FinEdge'))))
@section('meta_description', (!empty($pageSeo->meta_description) ? $pageSeo->meta_description : 'Read the Privacy Policy of MLG FinEdge. Learn how we collect, use, process and protect your personal and financial information when using our financial advisory and loan assistance services.'))
@if(!empty($pageSeo->meta_keywords))
@section('meta_keywords', $pageSeo->meta_keywords)
@endif
@if(!empty($pageSeo->canonical_url))
@section('canonical', $pageSeo->canonical_url)
@else
@section('canonical', url('/privacy-policy'))
@endif
@if(!empty($pageSeo->meta_robots))
@section('meta_robots', $pageSeo->meta_robots)
@endif
@if(!empty($pageSeo->og_image))
@section('og_image', seo_image($pageSeo->og_image))
@endif

@section('schema')
@if(!empty($pageSeo->schema_markup))
{!! $pageSeo->schema_markup !!}
@else
<script type="application/ld+json">
{
  "{{ '@' }}context": "https://schema.org",
  "{{ '@graph' }}": [
    {
      "{{ '@type' }}": "WebPage",
      "{{ '@id' }}": "{{ url('/privacy-policy') }}/#webpage",
      "url": "{{ url('/privacy-policy') }}",
      "name": "{{ $pageSeo->meta_title ?? ('Privacy Policy | ' . ($site['site_name'] ?? 'MLG FinEdge')) }}",
      "description": "{{ $pageSeo->meta_description ?? 'Read the Privacy Policy of MLG FinEdge. Learn how we collect, use, process and protect your personal and financial information.' }}",
      "isPartOf": {
        "{{ '@type' }}": "WebSite",
        "{{ '@id' }}": "{{ route('home') }}/#website",
        "name": "{{ $site['site_name'] ?? 'MLG FinEdge' }}",
        "url": "{{ route('home') }}"
      },
      "publisher": {
        "{{ '@type' }}": "Organization",
        "{{ '@id' }}": "{{ route('home') }}/#organization",
        "name": "{{ $site['site_name'] ?? 'MLG FinEdge' }}",
        "url": "{{ route('home') }}"
      }
    }
  ]
}
</script>
@endif
@endsection

@section('content')

    <!-- Details Hero -->
    <section class="details-hero">
        <div class="container text-center">
            <span class="color-mint font-semibold" style="text-transform: uppercase; letter-spacing: 1.5px; font-size: 0.9rem;">LEGAL &amp; COMPLIANCE</span>
            <h1 style="margin-top: 10px;">{{ $pageSeo->h1_tag ?? ($pageContents['privacy_policy']['hero']['title'] ?? 'Privacy Policy') }}</h1>
            <p style="color: var(--text-light-muted); max-width: 650px; margin: 0 auto; font-size: 1rem;">
                {{ $pageContents['privacy_policy']['hero']['subtitle'] ?? 'Our commitment to protecting your personal and financial information with transparency, security, and integrity.' }}
            </p>
            <div style="margin-top: 1.5rem; display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(255, 255, 255, 0.08); padding: 0.4rem 1.25rem; border-radius: 20px; font-size: 0.85rem; color: var(--mint-green-light); border: 1px solid rgba(255, 255, 255, 0.1);">
                <i data-lucide="calendar" style="width: 14px; height: 14px;"></i>
                <span>Last Updated: {{ $pageContents['privacy_policy']['meta']['last_updated'] ?? 'November 24, 2026' }}</span>
            </div>
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="section" style="background-color: var(--bg-light); padding: 4rem 0;">
        <div class="container">
            <div class="policy-card">
                
                <!-- Section 1 -->
                <div class="policy-section">
                    <h2 class="policy-title">1. Introduction</h2>
                    <p>Welcome to MLG FinEdge. We respect your privacy and are committed to protecting your personal and financial information. This Privacy Policy explains how MLG FinEdge collects, uses, stores, processes and protects your personal information when you visit our website, submit an enquiry, request a loan consultation or use our financial advisory and loan assistance services.</p>
                    <p>By accessing or using our website, you agree to the practices described in this Privacy Policy.</p>
                </div>

                <!-- Section 2 -->
                <div class="policy-section">
                    <h2 class="policy-title">2. Information We Collect</h2>
                    <p>We may collect different types of information when you visit our website, submit a form, contact us or request our services.</p>
                    
                    <h3 class="policy-subtitle">Personal Information</h3>
                    <ul class="policy-list">
                        <li>Full name</li>
                        <li>Phone number</li>
                        <li>Email address</li>
                        <li>Residential address</li>
                        <li>Contact details and other information you voluntarily provide.</li>
                    </ul>

                    <h3 class="policy-subtitle">Financial and Loan-Related Information</h3>
                    <p>When you request loan advisory, consultation or assistance, we may collect information such as:</p>
                    <ul class="policy-list">
                        <li>Employment details and occupation.</li>
                        <li>Monthly or annual income.</li>
                        <li>Business details and business income, where applicable.</li>
                        <li>Loan amount required.</li>
                        <li>Existing loan or financial obligations.</li>
                        <li>Credit score or credit-related information, where voluntarily provided or lawfully accessed.</li>
                        <li>Property details, where relevant to your loan requirements.</li>
                        <li>Documents and other details required for loan eligibility assessment and processing.</li>
                    </ul>

                    <h3 class="policy-subtitle">Technical and Website Information</h3>
                    <p>We may automatically collect certain information when you visit our website, including:</p>
                    <ul class="policy-list">
                        <li>IP address.</li>
                        <li>Browser type and version.</li>
                        <li>Device and operating system information.</li>
                        <li>Pages visited and website interaction data.</li>
                        <li>Cookies and similar tracking technologies.</li>
                        <li>Website traffic and usage information.</li>
                    </ul>
                </div>

                <!-- Section 3 -->
                <div class="policy-section">
                    <h2 class="policy-title">3. How We Use Your Information</h2>
                    <p>We may use the information collected for the following purposes:</p>
                    <ul class="policy-list">
                        <li>To understand your financial requirements and loan eligibility.</li>
                        <li>To provide loan consultation, financial guidance and advisory services.</li>
                        <li>To identify and compare suitable loan options from banks, NBFCs and other lending institutions.</li>
                        <li>To process, manage and follow up on loan enquiries and applications.</li>
                        <li>To communicate with you regarding your enquiries, loan applications, documents and services.</li>
                        <li>To coordinate with banks, NBFCs and lending partners, where required and authorized.</li>
                        <li>To provide customer support and respond to requests.</li>
                        <li>To improve our website, services and customer experience.</li>
                        <li>To maintain records and comply with applicable legal and regulatory requirements.</li>
                        <li>To protect our website, business and users against fraud, unauthorized activities and security risks.</li>
                    </ul>
                </div>

                <!-- Section 4 -->
                <div class="policy-section">
                    <h2 class="policy-title">4. Sharing of Personal Information</h2>
                    <p>We do not sell or rent your personal information to third parties.</p>
                    <p>We may share your information with trusted third parties when necessary to provide our services, including:</p>
                    <ul class="policy-list">
                        <li>Banks and financial institutions.</li>
                        <li>Non-Banking Financial Companies (NBFCs).</li>
                        <li>Lending partners and loan processing partners.</li>
                        <li>Credit bureaus or credit-related service providers, where legally permitted and appropriately authorized.</li>
                        <li>Technology, website hosting and IT service providers.</li>
                        <li>Communication service providers.</li>
                        <li>Legal, compliance and professional advisors.</li>
                        <li>Government authorities, regulators or law enforcement agencies when required by applicable law.</li>
                    </ul>
                    <p>We share personal and financial information with lending partners only when necessary for your requested services and subject to applicable legal requirements and authorization.</p>
                </div>

                <!-- Section 5 -->
                <div class="policy-section">
                    <h2 class="policy-title">5. Data Security</h2>
                    <p>We take reasonable technical, administrative and organizational measures to protect your personal information from unauthorized access, misuse, loss, alteration, disclosure or destruction.</p>
                    <p>We strive to protect the confidentiality and security of the personal and financial information you share with us. However, no method of data transmission or electronic storage is completely secure, and we cannot guarantee absolute security.</p>
                </div>

                <!-- Section 6 -->
                <div class="policy-section">
                    <h2 class="policy-title">6. Cookies and Tracking Technologies</h2>
                    <p>Our website may use cookies and similar technologies to improve website functionality, analyse visitor behaviour and enhance your browsing experience.</p>
                    <p>Cookies may be used to:</p>
                    <ul class="policy-list">
                        <li>Understand website traffic and visitor behaviour.</li>
                        <li>Improve website performance and usability.</li>
                        <li>Remember user preferences.</li>
                        <li>Analyse website usage and performance.</li>
                        <li>Support website analytics and marketing activities, where applicable.</li>
                    </ul>
                    <p>You may manage or disable cookies through your browser settings. Disabling certain cookies may affect website functionality.</p>
                </div>

                <!-- Section 7 -->
                <div class="policy-section">
                    <h2 class="policy-title">7. Data Retention</h2>
                    <p>We retain personal information for as long as necessary to provide our services, process enquiries, manage loan applications, maintain business records, comply with legal obligations and resolve disputes.</p>
                    <p>When personal information is no longer required, we may delete, anonymize or securely dispose of it, subject to applicable laws and record-retention requirements.</p>
                </div>

                <!-- Section 8 -->
                <div class="policy-section">
                    <h2 class="policy-title">8. Your Privacy Rights</h2>
                    <p>Subject to applicable laws, you may have the right to:</p>
                    <ul class="policy-list">
                        <li>Request access to your personal information.</li>
                        <li>Request correction or updating of inaccurate personal information.</li>
                        <li>Request deletion of personal information, where applicable.</li>
                        <li>Withdraw consent for certain processing activities, where processing is based on consent.</li>
                        <li>Raise concerns regarding the collection, use or sharing of your personal information.</li>
                    </ul>
                    <p>You may contact us to exercise your privacy rights. We will review and respond to your requests in accordance with applicable laws.</p>
                </div>

                <!-- Section 9 -->
                <div class="policy-section">
                    <h2 class="policy-title">9. Third-Party Websites and Services</h2>
                    <p>Our website may contain links to third-party websites, financial institutions, banks, NBFCs or other external services.</p>
                    <p>We are not responsible for the privacy practices, content, security or policies of third-party websites or services. We encourage you to review their privacy policies and terms before sharing any personal or financial information with them.</p>
                </div>

                <!-- Section 10 -->
                <div class="policy-section">
                    <h2 class="policy-title">10. Consent and Communication</h2>
                    <p>By submitting an enquiry form, requesting a callback, contacting us or voluntarily sharing your information through our website or other communication channels, you authorize us to contact you regarding your enquiry, loan requirements, consultation or related services, subject to applicable laws.</p>
                    <p>You may request that we stop sending promotional or non-essential communications at any time.</p>
                </div>

                <!-- Section 11 -->
                <div class="policy-section">
                    <h2 class="policy-title">11. Children's Privacy</h2>
                    <p>Our website and services are intended for individuals who can legally avail of financial consultation and loan-related services.</p>
                    <p>We do not knowingly collect personal information from children in violation of applicable laws. If we become aware that personal information has been collected inappropriately, we will take reasonable steps to address the matter in accordance with applicable laws.</p>
                </div>

                <!-- Section 12 -->
                <div class="policy-section">
                    <h2 class="policy-title">12. Changes to This Privacy Policy</h2>
                    <p>MLG FinEdge reserves the right to update or modify this Privacy Policy from time to time to reflect changes in our services, website functionality, business practices or applicable laws.</p>
                    <p>Any updates will be published on this page along with the revised date. We encourage visitors to review this Privacy Policy periodically.</p>
                </div>

                <!-- Section 13 -->
                <div class="policy-section" style="margin-bottom: 0;">
                    <h2 class="policy-title">13. Contact Us</h2>
                    <p>If you have any questions, concerns or requests regarding this Privacy Policy or how we handle your personal information, you may contact us using the details below:</p>
                    
                    <div class="policy-contact-card">
                        <h4 style="font-size: 1.15rem; color: var(--primary-teal-dark); margin-bottom: 1rem; font-weight: 700;">MLG FinEdge</h4>
                        <div class="contact-card-item">
                            <i data-lucide="map-pin"></i>
                            <span><strong>Address:</strong> B-13A, 10B Scheme, Gopalpura Bypass Road, Behind The Park Classic, Jaipur, Rajasthan – 302018</span>
                        </div>
                        <div class="contact-card-item">
                            <i data-lucide="phone"></i>
                            <span><strong>Phone:</strong> <a href="tel:{{ $site['phone'] ?? '+919672777749' }}">{{ $site['phone'] ?? '+91 96727 77749' }}</a></span>
                        </div>
                        <div class="contact-card-item">
                            <i data-lucide="mail"></i>
                            <span><strong>Email:</strong> <a href="mailto:{{ $site['email'] ?? 'info@mlgfinedge.com' }}">{{ $site['email'] ?? 'info@mlgfinedge.com' }}</a></span>
                        </div>
                        <div class="contact-card-item">
                            <i data-lucide="globe"></i>
                            <span><strong>Website:</strong> <a href="https://www.mlgfinedge.com/" target="_blank" rel="noopener">https://www.mlgfinedge.com/</a></span>
                        </div>
                    </div>

                    <p style="margin-top: 1.5rem; margin-bottom: 0;">We will make reasonable efforts to address your privacy-related queries and concerns in a timely manner.</p>
                </div>

            </div>
        </div>
    </section>

@endsection
