@extends('layouts.app')

@section('title', 'Compare Loan Interest Rates of 10 Banks | ' . ($site['site_name'] ?? 'MLG Finedge'))
@section('meta_description', 'Use our dynamic Loan Comparison Calculator to compare interest rates, monthly EMIs, and processing fees across 10 major Indian banks like SBI, HDFC, and ICICI.')

@section('schema')
<script type="application/ld+json">
{
  "{{ '@' }}context": "https://schema.org",
  "{{ '@graph' }}": [
    {
      "{{ '@type' }}": "WebPage",
      "{{ '@id' }}": "{{ route('compare') }}/#webpage",
      "url": "{{ route('compare') }}",
      "name": "Compare Loan Interest Rates of 10 Banks | {{ $site['site_name'] ?? 'MLG Finedge' }}",
      "description": "Use our dynamic Loan Comparison Calculator to compare interest rates, monthly EMIs, and processing fees across 10 major Indian banks.",
      "isPartOf": {
        "{{ '@type' }}": "WebSite",
        "{{ '@id' }}": "{{ route('home') }}/#website"
      },
      "about": {
        "{{ '@type' }}": "FinancialProduct",
        "name": "Loan Comparison Calculator",
        "description": "Interactive calculator comparing interest rates, EMIs, and fees for Home Loans, Personal Loans, and Business Loans.",
        "offers": {
          "{{ '@type' }}": "AggregateOffer",
          "priceCurrency": "INR",
          "provider": {
            "{{ '@type' }}": "Organization",
            "{{ '@id' }}": "{{ route('home') }}/#organization"
          }
        }
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
            <span class="color-mint font-semibold" style="text-transform: uppercase; letter-spacing: 1.5px; font-size: 0.9rem;">ADVISORY COMPARISON</span>
            <h1 style="margin-top: 10px;">Compare Bank Loan Offers</h1>
            <p style="color: var(--text-light-muted); max-width: 600px; margin: 0 auto;">Enter your requirements and credit profile to compare real-time EMIs and rates across 10 top Indian lenders.</p>
        </div>
    </section>

    <!-- Calculator Input Panel -->
    <section class="section">
        <div class="container">
            <div class="calculator-box animate-on-scroll animated" style="grid-template-columns: 1fr; margin-bottom: 3rem; background-color: var(--bg-white);">
                <div class="calc-inputs">
                    
                    <!-- Left side inputs -->
                    <div style="display: flex; flex-direction: column; gap: 2rem;">
                        <!-- Loan Category -->
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="comp-loan-type" style="font-size: 1rem; margin-bottom:0.75rem;">Select Loan Category</label>
                            <select id="comp-loan-type" class="form-control" style="padding: 1rem; border-width: 2px;">
                                <option value="home">Home Loan (Base rates: {{ $site['home_loan_rate'] ?? '8.4%' }} - 8.90%)</option>
                                <option value="personal">Personal Loan (Base rates: {{ $site['personal_loan_rate'] ?? '10.5%' }} - 11.49%)</option>
                                <option value="business">Business Loan (Base rates: {{ $site['business_loan_rate'] ?? '12.0%' }} - 13.25%)</option>
                            </select>
                        </div>
                        
                        <!-- Credit CIBIL Score selection -->
                        <div class="form-group" style="margin-bottom:0;">
                            <label style="font-size: 1rem; margin-bottom:0.75rem; display:block;">Your Credit Score (CIBIL)</label>
                            <div class="card-selectors">
                                <label class="card-selector-item">
                                    <input type="radio" name="comp-cibil" value="excellent" checked>
                                    <div class="card-selector-box" style="padding:0.75rem 1rem;">
                                        <div class="selector-icon"><i data-lucide="shield-check" style="width: 20px; height: 20px;"></i></div>
                                        <div class="selector-label">Excellent (750+)</div>
                                    </div>
                                </label>
                                <label class="card-selector-item">
                                    <input type="radio" name="comp-cibil" value="good">
                                    <div class="card-selector-box" style="padding:0.75rem 1rem;">
                                        <div class="selector-icon"><i data-lucide="check" style="width: 20px; height: 20px;"></i></div>
                                        <div class="selector-label">Good (700-749)</div>
                                    </div>
                                </label>
                                <label class="card-selector-item">
                                    <input type="radio" name="comp-cibil" value="average">
                                    <div class="card-selector-box" style="padding:0.75rem 1rem;">
                                        <div class="selector-icon"><i data-lucide="alert-circle" style="width: 20px; height: 20px;"></i></div>
                                        <div class="selector-label">Average (650-699)</div>
                                    </div>
                                </label>
                                <label class="card-selector-item">
                                    <input type="radio" name="comp-cibil" value="poor">
                                    <div class="card-selector-box" style="padding:0.75rem 1rem;">
                                        <div class="selector-icon"><i data-lucide="x-circle" style="width: 20px; height: 20px;"></i></div>
                                        <div class="selector-label">Below 650</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right side inputs -->
                    <div style="display: flex; flex-direction: column; gap: 2rem;">
                        <!-- Loan Amount -->
                        <div class="input-slider-group">
                            <div class="slider-label-wrap">
                                <span class="slider-label">Required Loan Amount (₹)</span>
                                <input type="number" id="comp-amount-input" class="form-control" style="width: 150px; text-align: right; padding: 0.5rem;" value="5000000">
                            </div>
                            <input type="range" id="comp-amount-slider" min="100000" max="100000000" step="100000" value="5000000" class="calc-slider">
                            <div class="slider-limits">
                                <span>₹1 Lakh</span>
                                <span>₹10 Crore</span>
                            </div>
                        </div>

                        <!-- Loan Tenure -->
                        <div class="input-slider-group">
                            <div class="slider-label-wrap">
                                <span class="slider-label">Loan Tenure (Years)</span>
                                <input type="number" id="comp-tenure-input" class="form-control" style="width: 100px; text-align: right; padding: 0.5rem;" value="15">
                            </div>
                            <input type="range" id="comp-tenure-slider" min="1" max="30" step="1" value="15" class="calc-slider">
                            <div class="slider-limits">
                                <span>1 Year</span>
                                <span>30 Years</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Poor CIBIL Warning Callout -->
            <div id="cibil-warning" class="form-card text-center" style="display:none; background-color: #fdf6f6; border: 2px dashed var(--accent-orange); padding: 3rem;">
                <div class="success-icon-wrap" style="background-color: rgba(232, 92, 36, 0.15); color: var(--accent-orange);">
                    <i data-lucide="shield-alert"></i>
                </div>
                <h3 class="color-accent" style="font-size: 1.5rem; margin-top: 1rem;">Credit Score Alert</h3>
                <p style="max-width: 600px; margin: 1rem auto; color: var(--text-muted);">A CIBIL credit score below 650 generally results in rejections for unsecured bank loans. However, our advisors can consult on specialized secured options (such as Gold Loans, Loan Against Property) or NBFC lenders offering flexible credit scoring guidelines.</p>
                <button onclick="triggerCallbackModal()" class="btn btn-primary">Speak to credit specialist</button>
            </div>

            <!-- Results List Node -->
            <div id="comparison-results">
                <!-- Javascript will render sorted banks here -->
            </div>
            
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        window.BANK_DATABASE = [
            @foreach($banks as $bank)
            {
                name: "{{ $bank->name }}",
                homeRate: {{ $bank->home_rate }},
                personalRate: {{ $bank->personal_rate }},
                businessRate: {{ $bank->business_rate }},
                feePercent: {{ $bank->fee_percent }},
                sector: "{{ $bank->sector }}"
            },
            @endforeach
        ];
    </script>
    <script src="{{ asset('assets/js/comparison.js') }}"></script>
@endsection
