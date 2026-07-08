@extends('layouts.app')

@section('title', 'Contact Us | Get Free Loan Advisory | ' . ($site['site_name'] ?? 'MLG Finedge'))
@section('meta_description', 'Contact MLG Finedge Jaipur. Get expert loan consultations, submit an inquiry form, or visit our office in Gopalpura Jaipur. Free callback within 2 hours.')

@section('schema')
<script type="application/ld+json">
{
  "{{ '@' }}context": "https://schema.org",
  "{{ '@graph' }}": [
    {
      "{{ '@type' }}": "ContactPage",
      "{{ '@id' }}": "{{ route('contact') }}/#webpage",
      "url": "{{ route('contact') }}",
      "name": "Contact Us | Get Free Loan Advisory | {{ $site['site_name'] ?? 'MLG Finedge' }}",
      "description": "Contact MLG Finedge Jaipur. Get expert loan consultations, submit an inquiry form, or visit our office in Gopalpura Jaipur.",
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
            <span class="color-mint font-semibold" style="text-transform: uppercase; letter-spacing: 1.5px; font-size: 0.9rem;">CONNECT WITH US</span>
            <h1 style="margin-top: 10px;">Contact Our Loan Experts</h1>
            <p style="color: var(--text-light-muted); max-width: 600px; margin: 0 auto;">Reach out for immediate assistance, interest rate queries, or loan processing status updates.</p>
        </div>
    </section>

    <!-- Contact Main Grid -->
    <section class="section">
        <div class="container contact-grid animate-on-scroll">
            <div class="contact-info-list">
                <h2>Office Location & Details</h2>
                <p class="text-muted" style="margin-bottom: 2rem;">We are based in Gopalpura, Jaipur. Drop by for a cup of coffee and a detailed assessment of your financial documents.</p>
                
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i data-lucide="map-pin"></i></div>
                    <div class="contact-info-content">
                        <h3>Our Office</h3>
                        <p>{{ $site['address'] ?? 'B-13 A, 10 B Scheme, Gopalpura Byepass, Behind The Park Classic, Jaipur - 302018' }}</p>
                    </div>
                </div>
                
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i data-lucide="phone"></i></div>
                    <div class="contact-info-content">
                        <h3>Phone Support</h3>
                        <p><a href="tel:{{ $site['phone'] ?? '+919672777749' }}">{{ $site['phone'] ?? '+91 96727 77749' }}</a> (Direct Support)</p>
                    </div>
                </div>
                
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i data-lucide="mail"></i></div>
                    <div class="contact-info-content">
                        <h3>Email Inquiries</h3>
                        <p><a href="mailto:{{ $site['email'] ?? 'info@mlgfinedge.com' }}">{{ $site['email'] ?? 'info@mlgfinedge.com' }}</a></p>
                    </div>
                </div>

                <div class="contact-info-item">
                    <div class="contact-info-icon" style="background-color:#25d366; color:white;"><i data-lucide="message-circle"></i></div>
                    <div class="contact-info-content">
                        <h3>WhatsApp Assistance</h3>
                        <p><a href="https://wa.me/{{ $site['whatsapp_number'] ?? '919672777749' }}?text=Hi%20MLG%20Finedge,%20I'd%20like%20to%20consult%20on%20a%20loan." target="_blank">Chat with Advisor Now</a> (Instant response)</p>
                    </div>
                </div>
            </div>
            
            <div class="form-card">
                <h2 style="margin-bottom: 1.5rem;">Send an Inquiry</h2>
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="source" value="Contact Page Form">
                    <div class="form-group">
                        <label for="c-name">Full Name</label>
                        <input type="text" id="c-name" name="name" class="form-control" placeholder="Enter your name" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="c-phone">Phone Number</label>
                            <input type="tel" id="c-phone" name="phone" class="form-control" placeholder="10-digit number" pattern="[0-9]{10}" required>
                        </div>
                        <div class="form-group">
                            <label for="c-email">Email Address</label>
                            <input type="email" id="c-email" name="email" class="form-control" placeholder="Enter email" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="c-loan">Loan Type</label>
                            <select id="c-loan" name="loan_type" class="form-control" required>
                                <option value="">-- Select --</option>
                                <option value="personal">Personal Loan</option>
                                <option value="home">Home Loan</option>
                                <option value="business">Business Loan</option>
                                <option value="lap">Loan Against Property</option>
                                <option value="working-capital">Working Capital</option>
                                <option value="other">Other Options</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="c-amount">Expected Amount</label>
                            <input type="number" id="c-amount" name="amount" class="form-control" placeholder="e.g. 500000" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="c-message">Brief Details / Profile Details</label>
                        <textarea id="c-message" name="message" class="form-control" rows="4" placeholder="Briefly specify if salaried/business and your requirements..."></textarea>
                    </div>
                    
                    @if(!empty($site['recaptcha_enabled']) && $site['recaptcha_enabled'] == '1' && !empty($site['recaptcha_site_key']))
                        <div class="form-group" style="margin-bottom: 1.5rem; display: flex; justify-content: center;">
                            <div class="g-recaptcha" data-sitekey="{{ $site['recaptcha_site_key'] }}"></div>
                        </div>
                    @endif
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Submit Loan Inquiry</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Map Integration Section -->
    <section class="section" style="padding-top:0;">
        <div class="container animate-on-scroll">
            <div class="contact-map-box">
                <!-- Google Maps centered on Gopalpura Jaipur -->
                <iframe src="https://www.google.com/maps/embed?pb=!11m18!1m12!1m3!1d14233.916960010996!2d75.77660232537989!3d26.856037042531333!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396db67eb9fdfc4d%3A0x4468f70044b7d598!2sGopalpura%2C%20Jaipur%2C%20Rajasthan!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin" 
                    width="100%" height="450" style="border:0; border-radius: var(--radius-lg);" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

@endsection
