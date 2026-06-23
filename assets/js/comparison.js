/**
 * MLG FINEDGE LOAN COMPARISON CALCULATOR ENGINE
 * Database: 10 Major Banks in India
 * Calculations: EMI, Interest Payables, CIBIL modifications, and dynamic sorting.
 */

const BANK_DATABASE = [
    { name: "State Bank of India (SBI)", homeRate: 7.25, personalRate: 10.00, businessRate: 11.20, feePercent: 0.35, sector: "Public" },
    { name: "HDFC Bank", homeRate: 7.75, personalRate: 9.99, businessRate: 11.90, feePercent: 0.50, sector: "Private" },
    { name: "ICICI Bank", homeRate: 7.50, personalRate: 9.99, businessRate: 11.75, feePercent: 0.50, sector: "Private" },
    { name: "Axis Bank", homeRate: 8.00, personalRate: 9.99, businessRate: 12.00, feePercent: 0.50, sector: "Private" },
    { name: "Bank of Baroda (BoB)", homeRate: 7.20, personalRate: 10.15, businessRate: 11.50, feePercent: 0.35, sector: "Public" },
    { name: "Punjab National Bank (PNB)", homeRate: 7.20, personalRate: 10.25, businessRate: 11.40, feePercent: 0.35, sector: "Public" },
    { name: "Kotak Mahindra Bank", homeRate: 7.40, personalRate: 10.25, businessRate: 11.80, feePercent: 0.40, sector: "Private" },
    { name: "Union Bank of India", homeRate: 7.25, personalRate: 10.40, businessRate: 11.35, feePercent: 0.30, sector: "Public" },
    { name: "IDFC First Bank", homeRate: 7.75, personalRate: 10.49, businessRate: 12.25, feePercent: 0.50, sector: "Private" },
    { name: "IndusInd Bank", homeRate: 7.95, personalRate: 10.25, businessRate: 12.00, feePercent: 0.50, sector: "Private" }
];

document.addEventListener('DOMContentLoaded', () => {
    initComparisonCalculator();
});

function initComparisonCalculator() {
    const loanTypeSelect = document.getElementById('comp-loan-type');
    
    const amountSlider = document.getElementById('comp-amount-slider');
    const amountInput = document.getElementById('comp-amount-input');
    
    const tenureSlider = document.getElementById('comp-tenure-slider');
    const tenureInput = document.getElementById('comp-tenure-input');
    
    const cibilOptions = document.querySelectorAll('input[name="comp-cibil"]');
    const resultsContainer = document.getElementById('comparison-results');
    const cibilWarning = document.getElementById('cibil-warning');

    if (!amountSlider || !resultsContainer) return; // Verify page load

    const formatCurrency = (val) => {
        return new Intl.NumberFormat('en-IN', {
            style: 'currency',
            currency: 'INR',
            maximumFractionDigits: 0
        }).format(val);
    };

    // Synchronize slider & text inputs
    amountSlider.addEventListener('input', () => {
        amountInput.value = amountSlider.value;
        recalculateComparison();
    });
    amountInput.addEventListener('change', () => {
        let val = parseInt(amountInput.value);
        if (isNaN(val)) val = 1000000;
        if (val < 100000) val = 100000;
        if (val > 100000000) val = 100000000;
        amountInput.value = val;
        amountSlider.value = val;
        recalculateComparison();
    });

    tenureSlider.addEventListener('input', () => {
        tenureInput.value = tenureSlider.value;
        recalculateComparison();
    });
    tenureInput.addEventListener('change', () => {
        let val = parseInt(tenureInput.value);
        if (isNaN(val)) val = 5;
        if (val < 1) val = 1;
        if (val > 30) val = 30;
        tenureInput.value = val;
        tenureSlider.value = val;
        recalculateComparison();
    });

    loanTypeSelect.addEventListener('change', () => {
        // Automatically adjust slider limits based on type
        const type = loanTypeSelect.value;
        if (type === 'personal') {
            amountSlider.max = 4000000; // 40 Lakhs max for personal
            if (parseInt(amountInput.value) > 4000000) {
                amountInput.value = 2000000;
                amountSlider.value = 2000000;
            }
            tenureSlider.max = 7; // 7 years max for personal
            if (parseInt(tenureInput.value) > 7) {
                tenureInput.value = 5;
                tenureSlider.value = 5;
            }
        } else {
            amountSlider.max = 100000000; // 10 Cr max
            tenureSlider.max = 30;
        }
        recalculateComparison();
    });

    cibilOptions.forEach(opt => {
        opt.addEventListener('change', recalculateComparison);
    });

    function recalculateComparison() {
        const loanType = loanTypeSelect.value;
        const amount = parseFloat(amountInput.value);
        const years = parseFloat(tenureInput.value);
        
        // Get CIBIL modifier
        let cibilValue = "excellent";
        cibilOptions.forEach(opt => {
            if (opt.checked) cibilValue = opt.value;
        });

        // Toggle CIBIL Warning if poor score
        if (cibilValue === 'poor') {
            cibilWarning.style.display = 'block';
            resultsContainer.innerHTML = '';
            return;
        } else {
            cibilWarning.style.display = 'none';
        }

        let cibilModifier = 0;
        if (cibilValue === 'good') cibilModifier = 0.50; // Add 0.50%
        if (cibilValue === 'average') cibilModifier = 1.50; // Add 1.50%

        const calculatedBanks = BANK_DATABASE.map(bank => {
            // Select base rate based on loan category
            let baseRate = bank.homeRate;
            if (loanType === 'personal') baseRate = bank.personalRate;
            if (loanType === 'business') baseRate = bank.businessRate;

            const finalRate = baseRate + cibilModifier;
            const monthlyRate = finalRate / (12 * 100);
            const totalMonths = years * 12;

            let emi = 0;
            if (monthlyRate === 0) {
                emi = amount / totalMonths;
            } else {
                emi = amount * monthlyRate * Math.pow(1 + monthlyRate, totalMonths) / (Math.pow(1 + monthlyRate, totalMonths) - 1);
            }

            const totalRepayment = emi * totalMonths;
            const totalInterest = totalRepayment - amount;
            const processingFee = amount * (bank.feePercent / 100);

            return {
                name: bank.name,
                rate: finalRate,
                emi: emi,
                interest: totalInterest,
                repayment: totalRepayment,
                fee: processingFee,
                sector: bank.sector
            };
        });

        // Sort by EMI (lowest first)
        calculatedBanks.sort((a, b) => a.emi - b.emi);

        // Render Results HTML
        renderResults(calculatedBanks, loanType, amount, years);
    }

    function renderResults(banks, loanType, amount, years) {
        resultsContainer.innerHTML = '';

        banks.forEach((bank, idx) => {
            const card = document.createElement('div');
            card.className = 'solution-premium-card animate-on-scroll animated';
            card.style.marginBottom = '1.5rem';
            
            // Add ribbon for the lowest rate option
            const rankRibbon = idx === 0 ? `<div style="background-color: var(--mint-green); color: white; padding: 4px 12px; font-size: 0.75rem; font-weight: 700; border-radius: 0 0 0 var(--radius-sm); text-transform: uppercase;">Best Option</div>` : ``;

            card.innerHTML = `
                <div class="sol-header" style="padding: 1.5rem 2rem; border: none; background: linear-gradient(135deg, #f0f7f7 0%, #eef5f5 100%); flex-wrap: wrap; gap: 1rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 45px; height: 45px; border-radius: 50%; background-color: var(--primary-teal); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem;">
                            ${bank.name.charAt(0)}
                        </div>
                        <div>
                            <h3 style="font-size: 1.25rem;">${bank.name}</h3>
                            <span style="font-size: 0.75rem; background-color: var(--border-color); color: var(--text-muted); padding: 2px 8px; border-radius: 10px;">${bank.sector} Sector</span>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1.5rem; margin-left: auto;">
                        <div style="text-align: right;">
                            <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">EMI (Monthly)</span>
                            <strong style="font-size: 1.4rem; color: var(--primary-teal); font-family: var(--font-heading);">${formatCurrency(bank.emi)}</strong>
                        </div>
                        ${rankRibbon}
                    </div>
                </div>
                <div class="sol-body" style="padding: 1.5rem 2rem; display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; border-top: 1px solid var(--border-color);">
                    <div>
                        <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Interest Rate</span>
                        <strong style="font-size: 1.1rem; color: var(--text-dark);">${bank.rate.toFixed(2)}% p.a.</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Total Interest</span>
                        <strong style="font-size: 1.1rem; color: var(--text-dark);">${formatCurrency(bank.interest)}</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Total Repayment</span>
                        <strong style="font-size: 1.1rem; color: var(--text-dark);">${formatCurrency(bank.repayment)}</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Est. Processing Fee</span>
                        <strong style="font-size: 1.1rem; color: var(--text-dark);">${formatCurrency(bank.fee)}</strong>
                    </div>
                </div>
                <div style="padding: 1rem 2rem; background-color: #fafdfd; border-top: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between;">
                    <span style="font-size: 0.8rem; color: var(--text-muted);"><i data-lucide="check-circle" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; color: var(--mint-green); margin-right: 4px;"></i> Free assistance and doorstep documentation support.</span>
                    <button onclick="window.triggerCallbackModalWithBank('${bank.name}', '${loanType}', ${amount})" class="btn btn-primary btn-sm" style="padding: 0.5rem 1.25rem;">Choose this Bank <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i></button>
                </div>
            `;
            resultsContainer.appendChild(card);
        });
        
        // Re-trigger Lucide icons for dynamically added HTML
        if (window.lucide) {
            window.lucide.createIcons();
        }
    }

    // Initialize first calculation
    recalculateComparison();
}

// Hook up prefilled callback dialog from choose buttons
window.triggerCallbackModalWithBank = function(bankName, loanType, amount) {
    const loanNameMapping = {
        'home': 'Home Loan',
        'personal': 'Personal Loan',
        'business': 'Business Loan'
    };

    // 1. Select correct loan option in dropdown
    const select = document.getElementById('cb-loan');
    if (select) select.value = loanType;

    // 2. Add message to subtitle
    const subtitle = document.querySelector('#callback-dialog .dialog-header p');
    if (subtitle) {
        subtitle.innerHTML = `You have selected <strong>${bankName}</strong> for your estimated <strong>${loanNameMapping[loanType] || 'Loan'}</strong> of <strong>₹${amount.toLocaleString('en-IN')}</strong>. Share details to submit your bank application file.`;
    }

    // 3. Open Dialog
    const dialog = document.getElementById('callback-dialog');
    if (dialog) {
        dialog.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
};
