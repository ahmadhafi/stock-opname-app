// Modern JavaScript enhancements for Stock Opname App
document.addEventListener('DOMContentLoaded', function() {
    console.log('Stock Opname App loaded with modern features');

    // Smooth scrolling for anchor links
    const links = document.querySelectorAll('a[href^="#"]');
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Form validation and enhancement
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, textarea');

        inputs.forEach(input => {
            // Add focus/blur animations
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
                validateInput(this);
            });

            // Real-time validation for number inputs
            if (input.type === 'number') {
                input.addEventListener('input', function() {
                    if (this.value < 0) {
                        this.value = 0;
                        showError(this, 'Quantity cannot be negative');
                    }
                });
            }
        });

        // Form submission with loading state
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<span class="loading"></span> Processing...';
                submitBtn.disabled = true;
            }
        });
    });

    // Table row animations
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.1}s`;
        row.classList.add('animate-in');
    });

    // Add CSS for animations
    const style = document.createElement('style');
    style.textContent = `
        .animate-in {
            animation: slideIn 0.5s ease-out forwards;
            opacity: 0;
            transform: translateX(-20px);
        }

        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .focused label {
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        .error {
            border-color: var(--danger-color) !important;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1) !important;
        }

        .error-message {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 4px;
            display: block;
        }
    `;
    document.head.appendChild(style);

    // Utility functions
    function validateInput(input) {
        const value = input.value.trim();
        let isValid = true;
        let errorMessage = '';

        // Remove existing error messages
        const existingError = input.parentElement.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        input.classList.remove('error');

        // Validation rules
        if (input.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'This field is required';
        }

        if (input.type === 'number' && value && isNaN(value)) {
            isValid = false;
            errorMessage = 'Please enter a valid number';
        }

        if (input.name === 'name' && value.length < 2) {
            isValid = false;
            errorMessage = 'Name must be at least 2 characters long';
        }

        if (!isValid) {
            input.classList.add('error');
            const errorElement = document.createElement('span');
            errorElement.className = 'error-message';
            errorElement.textContent = errorMessage;
            input.parentElement.appendChild(errorElement);
        }

        return isValid;
    }

    function showError(input, message) {
        const existingError = input.parentElement.querySelector('.error-message');
        if (existingError) {
            existingError.textContent = message;
        } else {
            const errorElement = document.createElement('span');
            errorElement.className = 'error-message';
            errorElement.textContent = message;
            input.parentElement.appendChild(errorElement);
        }
        input.classList.add('error');
    }

    // Add loading class to body for initial animation
    document.body.classList.add('loaded');
});
