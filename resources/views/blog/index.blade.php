@extends('layouts.app')

@section('title', 'Financial Planning & Loan Advisory Blog | MLG Finedge Jaipur')
@section('meta_description', 'Read expert financial advice, guides on interest rates, tax benefits, CIBIL credit score improvement tips, and loan comparisons from MLG Finedge.')

@section('schema')
<script type="application/ld+json">
{
  "{{ '@' }}context": "https://schema.org",
  "{{ '@graph' }}": [
    {
      "{{ '@type' }}": "Blog",
      "{{ '@id' }}": "{{ route('blog') }}/#blog",
      "url": "{{ route('blog') }}",
      "name": "Financial Planning & Loan Advisory Blog | MLG Finedge",
      "description": "Read expert financial advice, guides on interest rates, tax benefits, CIBIL credit score improvement tips, and loan comparisons from MLG Finedge.",
      "publisher": {
        "{{ '@type' }}": "Organization",
        "{{ '@id' }}": "{{ route('home') }}/#organization"
      }
    }
  ]
}
</script>
@endsection

@section('content')

<section class="details-hero">
        <div class="container text-center">
            <span class="color-mint font-semibold" style="text-transform: uppercase; letter-spacing: 1.5px; font-size: 0.9rem;">FINANCIAL EDUCATION</span>
            <h1 style="margin-top: 10px;">MLG Finedge Knowledge Hub</h1>
            <p style="color: var(--text-light-muted); max-width: 600px; margin: 0 auto;">Articles, guides, and tips designed to make credit terms, CIBIL metrics, and home finance simple.</p>
        </div>
    </section>

    <!-- Blog Grid -->
    <section class="section">
        <div class="container blog-grid animate-on-scroll">
            
            @forelse($blogs as $blog)
            <article class="blog-card">
                <div class="blog-img" style="{{ $blog->image_path ? '' : 'background-color: ' . ($blog->category === 'Home Loans' ? 'var(--accent-orange)' : 'var(--accent-teal)') }}">
                    @if($blog->image_path)
                        <img src="{{ site_image($blog->image_path) }}" alt="{{ $blog->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i data-lucide="{{ $blog->category === 'Home Loans' ? 'home' : 'book-open' }}"></i>
                    @endif
                    <span class="blog-category-badge">{{ $blog->category }}</span>
                </div>
                <div class="blog-body">
                    <span class="blog-date">{{ $blog->published_at ? $blog->published_at->format('F d, Y') : $blog->created_at->format('F d, Y') }}</span>
                    <h3>{{ $blog->title }}</h3>
                    <p>{{ $blog->summary }}</p>
                    <a href="{{ route('blog.show', $blog->slug) }}" class="blog-readmore">Read Article <i data-lucide="chevron-right"></i></a>
                </div>
            </article>
            @empty
            <div class="text-center" style="grid-column: 1 / -1; padding: 40px; color: var(--text-light-muted);">
                <p>No blog posts found at the moment. Please check back later.</p>
            </div>
            @endforelse
        </div>
    </section>

    <!-- Footer -->

@endsection
