@extends('layouts.main')

@section('content')
<style>
.auth-container {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.auth-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    animation: slideIn 0.5s ease-out;
    max-width: 420px;
    width: 100%;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.auth-header {
    background: #ffffff;
    color: #1f2937;
    padding: 2.5rem 2rem 1.5rem;
    text-align: center;
    position: relative;
}

.auth-logo {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 1.5rem;
    color: white;
    font-weight: bold;
}

.auth-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.auth-subtitle {
    color: #6b7280;
    font-size: 0.95rem;
    margin-bottom: 0;
}

.auth-body {
    padding: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.form-control {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f9fafb;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    background: white;
}

.form-control.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
}

.invalid-feedback {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: block;
}

.btn {
    padding: 0.875rem 1.5rem;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    width: 100%;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
}

.btn-secondary {
    background: #f3f4f6;
    color: #6b7280;
    border: 2px solid #e5e7eb;
    width: 100%;
}

.btn-secondary:hover {
    background: #e5e7eb;
    transform: translateY(-2px);
}

.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
}

.auth-timer {
    text-align: center;
    margin: 1.5rem 0;
    padding: 1rem;
    background: #f3f4f6;
    border-radius: 10px;
    border-left: 4px solid #667eea;
}

.auth-timer-text {
    font-weight: 600;
    color: #374151;
    font-size: 0.9rem;
}

.auth-timer-text.warning {
    color: #dc3545;
}

.auth-footer {
    text-align: center;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e5e7eb;
}

.auth-footer a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
}

.auth-footer a:hover {
    text-decoration: underline;
}

.alert {
    border: none;
    border-radius: 10px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    animation: slideIn 0.3s ease-out;
}

.alert-success {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.alert-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
    border-width: 2px;
}

.email-display {
    background: #f3f4f6;
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    text-align: center;
}

.email-display-text {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.25rem;
}

.email-display-value {
    color: #667eea;
    font-weight: 600;
}

@media (max-width: 576px) {
    .auth-container {
        padding: 1rem;
    }
    
    .auth-card {
        margin: 0;
    }
    
    .auth-body {
        padding: 1.5rem;
    }
}
</style>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                🔐
            </div>
            <h1 class="auth-title">Verify OTP</h1>
            <p class="auth-subtitle">Enter the 6-digit code sent to your email</p>
        </div>
        
        <div class="auth-body">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <span class="me-2">⚠️</span>
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <span class="me-2">✅</span>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="email-display">
                <div class="email-display-text">Code sent to:</div>
                <div class="email-display-value">{{ $email }}</div>
                <small class="text-muted">
                    <a href="{{ route('otp.request.form') }}" class="auth-footer">
                        <i class="fas fa-edit me-1"></i> Change email
                    </a>
                </small>
            </div>

            <form id="otpVerifyForm">
                @csrf
                <div class="form-group">
                    <label for="otp" class="form-label">Verification Code</label>
                    <input type="text" class="form-control" id="otp" name="otp" 
                           placeholder="Enter 6-digit code" maxlength="6" pattern="[0-9]{6}" required
                           autocomplete="one-time-code">
                    <div class="invalid-feedback"></div>
                </div>

                <button type="submit" class="btn btn-primary" id="verifyBtn">
                    <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                    <span class="btn-text">
                        <i class="fas fa-check-circle me-2"></i>Verify Code
                    </span>
                </button>
            </form>

            <div class="auth-timer">
                <div class="auth-timer-text" id="timer">
                    <i class="fas fa-clock me-2"></i>
                    <span id="timerText">Code expires in 5:00</span>
                </div>
            </div>

            <div class="text-center mt-3">
                <button type="button" class="btn btn-secondary" id="resendBtn">
                    <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                    <span class="btn-text">
                        <i class="fas fa-redo me-2"></i>Resend Code
                    </span>
                </button>
            </div>

            <div class="auth-footer">
                <small class="text-muted">
                    <i class="fas fa-question-circle me-1"></i>
                    Didn't receive the code? 
                    <a href="#" id="resendLink">Check spam folder</a> or 
                    <a href="#" id="resendLink2">request new code</a>
                </small>
            </div>
        </div>
    </div>
</div>

<script>
let timeLeft = 300; // 5 minutes in seconds
let timerInterval;

// Auto-format OTP input
document.getElementById('otp').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});

// Start countdown timer
function startTimer() {
    timerInterval = setInterval(function() {
        timeLeft--;
        
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            const timerElement = document.getElementById('timer');
            const timerText = document.getElementById('timerText');
            timerElement.classList.add('warning');
            timerText.textContent = 'Code has expired!';
            document.getElementById('verifyBtn').disabled = true;
        } else {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            const timerText = document.getElementById('timerText');
            timerText.textContent = `Code expires in ${minutes}:${seconds.toString().padStart(2, '0')}`;
            
            // Add warning class when less than 1 minute
            if (timeLeft < 60) {
                document.getElementById('timer').classList.add('warning');
            }
        }
    }, 1000);
}

// Verify OTP form submission
document.getElementById('otpVerifyForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const submitBtn = document.getElementById('verifyBtn');
    const spinner = submitBtn.querySelector('.spinner-border');
    const btnText = submitBtn.lastChild;
    const otpInput = document.getElementById('otp');
    const otpValue = otpInput.value.trim();
    
    console.log('Submitting OTP:', otpValue);
    
    // Clear previous errors
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    
    // Validate OTP format
    if (!/^\d{6}$/.test(otpValue)) {
        otpInput.classList.add('is-invalid');
        document.querySelector('#otp + .invalid-feedback').textContent = 'Code must be exactly 6 digits.';
        return;
    }
    
    // Show loading state
    submitBtn.disabled = true;
    spinner.classList.remove('d-none');
    submitBtn.querySelector('.btn-text').innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Verifying...';
    
    const formData = new FormData(form);
    console.log('Form data:', Object.fromEntries(formData));
    
    // Create AbortController for timeout
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 30000); // 30 second timeout
    
    fetch('{{ route("otp.verify") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        signal: controller.signal
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        
        if (data.success) {
            showAlert('success', data.message);
            clearInterval(timerInterval);
            
            // Redirect after a short delay
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 1500);
        } else {
            showAlert('danger', data.message);
            
            // Highlight OTP field on error
            otpInput.classList.add('is-invalid');
            document.querySelector('#otp + .invalid-feedback').textContent = data.message;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        
        let errorMessage = 'An error occurred. Please try again.';
        
        if (error.name === 'TypeError' && error.message.includes('fetch')) {
            errorMessage = 'Network error. Please check your internet connection and try again.';
        } else if (error.name === 'AbortError') {
            errorMessage = 'Request timed out. Please try again.';
        } else if (error.response) {
            errorMessage = `Server error: ${error.response.status}. Please try again.`;
        }
        
        showAlert('danger', errorMessage);
    })
    .finally(() => {
        // Clear timeout
        clearTimeout(timeoutId);
        
        // Reset button state
        submitBtn.disabled = false;
        spinner.classList.add('d-none');
        submitBtn.querySelector('.btn-text').innerHTML = '<i class="fas fa-check-circle me-2"></i>Verify Code';
    });
});

// Resend OTP functionality
function resendOtp() {
    const resendBtn = document.getElementById('resendBtn');
    const spinner = resendBtn.querySelector('.spinner-border');
    const btnText = resendBtn.lastChild;
    
    console.log('Resending OTP...');
    
    // Show loading state
    resendBtn.disabled = true;
    spinner.classList.remove('d-none');
    resendBtn.querySelector('.btn-text').innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
    
    // Create AbortController for timeout
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 30000); // 30 second timeout
    
    fetch('{{ route("otp.resend") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        signal: controller.signal
    })
    .then(response => {
        console.log('Resend response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Resend response data:', data);
        
        if (data.success) {
            showAlert('success', data.message);
            
            // Reset timer
            clearInterval(timerInterval);
            timeLeft = 300;
            startTimer();
            
            // Enable verify button
            document.getElementById('verifyBtn').disabled = false;
            
            // Clear OTP input
            document.getElementById('otp').value = '';
            document.getElementById('otp').classList.remove('is-invalid');
            document.querySelector('#otp + .invalid-feedback').textContent = '';
        } else {
            showAlert('danger', data.message);
        }
    })
    .catch(error => {
        console.error('Resend error:', error);
        
        let errorMessage = 'Failed to resend code. Please try again.';
        
        if (error.name === 'TypeError' && error.message.includes('fetch')) {
            errorMessage = 'Network error. Please check your internet connection and try again.';
        } else if (error.name === 'AbortError') {
            errorMessage = 'Request timed out. Please try again.';
        } else if (error.response) {
            errorMessage = `Server error: ${error.response.status}. Please try again.`;
        }
        
        showAlert('danger', errorMessage);
    })
    .finally(() => {
        // Clear timeout
        clearTimeout(timeoutId);
        
        // Reset button state
        resendBtn.disabled = false;
        spinner.classList.add('d-none');
        resendBtn.querySelector('.btn-text').innerHTML = '<i class="fas fa-redo me-2"></i>Resend Code';
    });
}

// Resend button click handler
document.getElementById('resendBtn').addEventListener('click', resendOtp);
document.getElementById('resendLink').addEventListener('click', function(e) {
    e.preventDefault();
    resendOtp();
});

function showAlert(type, message) {
    // Remove existing alerts
    document.querySelectorAll('.alert').forEach(el => el.remove());
    
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <span class="me-2">${type === 'success' ? 'â ' : 'â ï¸'}</span>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    document.querySelector('.auth-body').insertAdjacentHTML('afterbegin', alertHtml);
}

// Start timer when page loads
document.addEventListener('DOMContentLoaded', function() {
    startTimer();
});
</script>
@endsection
