@extends('layouts.app')

@section('title', (!empty($pageSeo->meta_title) ? $pageSeo->meta_title : ('Client Testimonials & Success Stories | ' . ($site['site_name'] ?? 'MLG Finedge'))))
@section('meta_description', (!empty($pageSeo->meta_description) ? $pageSeo->meta_description : 'Read reviews from local home buyers, government employees, and business owners who secured optimal financing through MLG Finedge\'s loan advisory services.'))
@if(!empty($pageSeo->meta_keywords))
@section('meta_keywords', $pageSeo->meta_keywords)
@endif
@if(!empty($pageSeo->canonical_url))
@section('canonical', $pageSeo->canonical_url)
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
      "{{ '@id' }}": "{{ route('testimonials') }}/#webpage",
      "url": "{{ route('testimonials') }}",
      "name": "{{ $pageSeo->meta_title ?? ('Client Testimonials & Success Stories | ' . ($site['site_name'] ?? 'MLG Finedge')) }}",
      "description": "{{ $pageSeo->meta_description ?? 'Read reviews from borrowers who secured funding through MLG Finedge.' }}",
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
@endif
@endsection

@section('content')

    <!-- Details Hero -->
    <section class="details-hero">
        <div class="container text-center">
            <span class="color-mint font-semibold" style="text-transform: uppercase; letter-spacing: 1.5px; font-size: 0.9rem;">SUCCESS STORIES</span>
            <h1 style="margin-top: 10px;">{{ $pageSeo->h1_tag ?? 'What Our Clients Say' }}</h1>
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
