@extends('layouts.app')

@section('title', 'Our Loan Services Overview | ' . ($site['site_name'] ?? 'MLG Finedge'))
@section('meta_description', 'Explore MLG Finedge\'s wide array of loan advisory services: Personal, Home, Car, Business, Working Capital, Project Funding, LAP, and Gold Loans in Jaipur.')

@section('schema')
<script type="application/ld+json">
{
  "{{ '@' }}context": "https://schema.org",
  "{{ '@graph' }}": [
    {
      "{{ '@type' }}": "WebPage",
      "{{ '@id' }}": "{{ route('services') }}/#webpage",
      "url": "{{ route('services') }}",
      "name": "Our Loan Services Overview | {{ $site['site_name'] ?? 'MLG Finedge' }}",
      "description": "Explore MLG Finedge's wide array of loan advisory services: Personal, Home, Car, Business, Working Capital, Project Funding, LAP, and Gold Loans in Jaipur.",
      "isPartOf": {
        "{{ '@type' }}": "WebSite",
        "{{ '@id' }}": "{{ route('home') }}/#website"
      },
      "about": [
        @foreach($globalServices as $index => $gs)
        {
          "{{ '@type' }}": "Service",
          "name": "{{ $gs->service_name }}",
          "url": "{{ route('services.show', $gs->slug) }}",
          "provider": {
            "{{ '@type' }}": "Organization",
            "{{ '@id' }}": "{{ route('home') }}/#organization"
          }
        }{{ $index < count($globalServices) - 1 ? ',' : '' }}
        @endforeach
      ]
    }
  ]
}
</script>
@endsection

@section('content')

    <!-- Details Hero -->
    <section class="details-hero">
        <div class="container text-center">
            <span class="color-mint font-semibold" style="text-transform: uppercase; letter-spacing: 1.5px; font-size: 0.9rem;">OUR OFFERS</span>
            <h1>Our Loan Consultation Services</h1>
            <p style="color: var(--text-light-muted); max-width: 600px; margin: 0 auto;">We compare, analyze, and assist you in selecting the ideal loan products with the lowest interest burdens.</p>
        </div>
    </section>

    <!-- Services Cards grid with details -->
    <section class="section">
        <div class="container">
            <div class="solutions-grid animate-on-scroll">
                @foreach($services as $service)
                    <div class="solution-premium-card" style="margin-bottom: 2rem;">
                        <div class="sol-header">
                            <div class="sol-title-wrap">
                                <h3>{{ $service->service_name }}</h3>
                                <p>{{ $service->hero_category }}</p>
                            </div>
                            @if($service->badge)
                                <span class="sol-badge">{{ $service->badge }}</span>
                            @endif
                        </div>
                        <div class="sol-body">
                            <p class="text-muted" style="margin-bottom:1.5rem;">{{ $service->summary }}</p>
                            <div class="sol-features-title">Core Benefits</div>
                            <ul class="sol-features-list">
                                @if($service->rate_value)
                                    <li class="sol-feature-item"><i data-lucide="check"></i> {{ $service->rate_value }}</li>
                                @endif
                                @if($service->max_loan)
                                    <li class="sol-feature-item"><i data-lucide="check"></i> {{ $service->max_loan }}</li>
                                @endif
                                @if($service->tenure)
                                    <li class="sol-feature-item"><i data-lucide="check"></i> {{ $service->tenure }}</li>
                                @endif
                            </ul>
                            <div class="sol-eligibility-box">
                                <p>Eligibility: <strong>{{ \Illuminate\Support\Str::limit($service->eligibility_criteria, 80) }}</strong></p>
                            </div>
                        </div>
                        <div class="sol-footer">
                            <a href="{{ route('services.show', $service->slug) }}" class="btn btn-secondary">Learn More</a>
                            <button onclick="triggerCallbackModal()" class="btn btn-primary">Enquire Now</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
