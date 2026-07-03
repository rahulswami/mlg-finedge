@extends('layouts.app')

@section('title', 'Client Testimonials & Success Stories | ' . ($site['site_name'] ?? 'MLG Finedge'))
@section('meta_description', 'Read reviews from local home buyers, government employees, and business owners who secured optimal financing through MLG Finedge\'s loan advisory services.')

@section('schema')
<script type="application/ld+json">
{
  "{{ '@' }}context": "https://schema.org",
  "{{ '@graph' }}": [
    {
      "{{ '@type' }}": "WebPage",
      "{{ '@id' }}": "{{ route('testimonials') }}/#webpage",
      "url": "{{ route('testimonials') }}",
      "name": "Client Testimonials & Success Stories | {{ $site['site_name'] ?? 'MLG Finedge' }}",
      "description": "Read reviews from local home buyers, government employees, and business owners who secured optimal financing through MLG Finedge.",
      "isPartOf": {
        "{{ '@type' }}": "WebSite",
        "{{ '@id' }}": "{{ route('home') }}/#website"
      },
      "reviewedBy": {
        "{{ '@type' }}": "Organization",
        "{{ '@id' }}": "{{ route('home') }}/#organization"
      }
    }
    @if(isset($testimonials) && $testimonials->isNotEmpty())
    ,
    {
      "{{ '@type' }}": "ItemList",
      "{{ '@id' }}": "{{ route('testimonials') }}/#reviewlist",
      "name": "Client Reviews",
      "itemListElement": [
        @foreach($testimonials as $index => $t)
        {
          "{{ '@type' }}": "ListItem",
          "position": {{ $index + 1 }},
          "item": {
            "{{ '@type' }}": "Review",
            "author": {
              "{{ '@type' }}": "Person",
              "name": "{{ $t->name }}"
            },
            "reviewBody": "{{ str_replace('"', '\"', $t->content) }}",
            "reviewRating": {
              "{{ '@type' }}": "Rating",
              "ratingValue": "{{ $t->rating }}",
              "bestRating": "5"
            },
            "itemReviewed": {
              "{{ '@type' }}": "Organization",
              "{{ '@id' }}": "{{ route('home') }}/#organization",
              "name": "{{ $site['site_name'] ?? 'MLG Finedge' }}"
            }
          }
        }{{ $index < count($testimonials) - 1 ? ',' : '' }}
        @endforeach
      ]
    }
    @endif
  ]
}
</script>
@endsection

@section('content')

    <!-- Details Hero -->
    <section class="details-hero">
        <div class="container text-center">
            <span class="color-mint font-semibold" style="text-transform: uppercase; letter-spacing: 1.5px; font-size: 0.9rem;">SUCCESS STORIES</span>
            <h1 style="margin-top: 10px;">What Our Clients Say</h1>
            <p style="color: var(--text-light-muted); max-width: 600px; margin: 0 auto;">Read real feedback from people who found the right funding with MLG Finedge's help.</p>
        </div>
    </section>

    <!-- Reviews Grid -->
    <section class="section">
        <div class="container">
            <div class="why-grid">
                @foreach($testimonials as $test)
                    <!-- Review Card -->
                    <div class="service-card animate-on-scroll">
                        <div class="testimonial-rating" style="color: #ffb100; margin-bottom: 1rem;">
                            @for($i = 0; $i < $test->rating; $i++)★@endfor
                        </div>
                        <p class="text-muted" style="font-style: italic; margin-bottom: 1.5rem;">"{{ $test->content }}"</p>
                        <div class="testimonial-author">
                            <div style="width:40px; height:40px; border-radius:50%; background-color:var(--primary-teal-light); display:flex; align-items:center; justify-content:center; color:white; font-weight:bold; overflow:hidden;">
                                @if($test->avatar_path)
                                    <img src="{{ site_image($test->avatar_path) }}" alt="{{ $test->name }}" style="width:100%; height:100%; object-fit:cover;">
                                @else
                                    {{ substr($test->name, 0, 2) }}
                                @endif
                            </div>
                            <div class="author-info">
                                <h4 style="font-size:0.9rem;">{{ $test->name }}</h4>
                                <p style="font-size:0.75rem;">{{ $test->role }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="final-cta-section">
        <div class="final-cta-wrapper animate-on-scroll">
            <h2>Start Your Own Success Story</h2>
            <p>Speak to our senior advisors today for free guidance on your profile.</p>
            <div class="final-cta-buttons">
                <button onclick="triggerCallbackModal()" class="btn btn-white">Free Consultation</button>
                <a href="{{ route('contact') }}" class="btn btn-outline-white"><i data-lucide="mail"></i> Email Us</a>
            </div>
        </div>
    </section>

@endsection
