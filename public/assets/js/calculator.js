/**
 * MLG FINEDGE EMI CALCULATOR SCRIPT
 * Description: Interactive calculations and lightweight SVG progress indicator.
 */

document.addEventListener('DOMContentLoaded', () => {
    initEMICalculator();
});

function initEMICalculator() {
    const loanAmountSlider = document.getElementById('calc-loan-amount');
    const loanAmountText = document.getElementById('val-loan-amount');
    
    const interestSlider = document.getElementById('calc-interest');
    const interestText = document.getElementById('val-interest');
    
    const tenureSlider = document.getElementById('calc-tenure');
    const tenureText = document.getElementById('val-tenure');
    
    const outputEmi = document.getElementById('output-emi');
    const outputPrincipal = document.getElementById('output-principal');
    const outputInterest = document.getElementById('output-interest');
    const outputTotal = document.getElementById('output-total');
    const chartValCircle = document.querySelector('.chart-val-circle');
    
    if (!loanAmountSlider) return; // Only runs on pages with calculators
    
    const formatCurrency = (value) => {
        return new Intl.NumberFormat('en-IN', {
            style: 'currency',
            currency: 'INR',
            maximumFractionDigits: 0
        }).format(value);
    };

    function updateCalculator() {
        const principal = parseFloat(loanAmountSlider.value);
        const annualRate = parseFloat(interestSlider.value);
        const years = parseFloat(tenureSlider.value);
        
        // Display input slider values
        loanAmountText.innerText = formatCurrency(principal);
        interestText.innerText = annualRate + '%';
        tenureText.innerText = years + ' Years';
        
        // Monthly interest calculation
        const monthlyRate = annualRate / (12 * 100);
        const totalMonths = years * 12;
        
        let emi = 0;
        if (monthlyRate === 0) {
            emi = principal / totalMonths;
        } else {
            emi = principal * monthlyRate * Math.pow(1 + monthlyRate, totalMonths) / (Math.pow(1 + monthlyRate, totalMonths) - 1);
        }
        
        const totalAmount = emi * totalMonths;
        const totalInterest = totalAmount - principal;
        
        // Render values to output displays
        outputEmi.innerText = formatCurrency(emi);
        outputPrincipal.innerText = formatCurrency(principal);
        outputInterest.innerText = formatCurrency(totalInterest);
        outputTotal.innerText = formatCurrency(totalAmount);
        
        // SVG Chart calculations
        // Circumference of a circle with r=50 is 2 * PI * 50 = 314.159
        const circumference = 2 * Math.PI * 50;
        const principalPercentage = principal / totalAmount;
        const strokeDashOffset = circumference * (1 - principalPercentage);
        
        // Update SVG circle stroke dash
        if (chartValCircle) {
            chartValCircle.style.strokeDasharray = `${circumference}`;
            chartValCircle.style.strokeDashoffset = `${strokeDashOffset}`;
        }
    }
    
    // Attach event listeners
    loanAmountSlider.addEventListener('input', updateCalculator);
    interestSlider.addEventListener('input', updateCalculator);
    tenureSlider.addEventListener('input', updateCalculator);
    
    // Initial Run
    updateCalculator();
}
