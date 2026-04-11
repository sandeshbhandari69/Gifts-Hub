@extends('layouts.main')

@section('content')
<style>
.otp-container {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.otp-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: none;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    animation: slideIn 0.5s ease-out;
    max-width: 450px;
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

.otp-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    text-align: center;
    position: relative;
}

.otp-header::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
    transform: rotate(45deg);
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%) translateY(-100%); }
    100% { transform: translateX(100%) translateY(100%); }
}

.otp-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
}

.otp-input-group {
    position: relative;
    margin: 2rem 0;
}

.otp-input {
    width: 100%;
    padding: 1rem 1rem 1rem 3rem;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    font-size: 1.5rem;
    font-weight: 600;
    text-align: center;
    letter-spacing: 0.5rem;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.otp-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    background: white;
}

.otp-input.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.otp-input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-size: 1.2rem;
}

.otp-buttons {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.otp-btn {
    flex: 1;
    padding: 1rem;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.otp-btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.otp-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
}

.otp-btn-secondary {
    background: #f8f9fa;
    color: #6c757d;
    border: 2px solid #e9ecef;
}

.otp-btn-secondary:hover {
    background: #e9ecef;
    transform: translateY(-2px);
}

.otp-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
}

.otp-timer {
    text-align: center;
    margin: 1.5rem 0;
    padding: 1rem;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 12px;
    border-left: 4px solid #667eea;
}

.otp-timer-text {
    font-weight: 600;
    color: #495057;
}

.otp-timer-text.warning {
    color: #dc3545;
}

.otp-help {
    text-align: center;
    margin-top: 1rem;
}

.otp-help a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
}

.otp-help a:hover {
    text-decoration: underline;
}

.alert-custom {
    border: none;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    animation: slideIn 0.3s ease-out;
}

.alert-success-custom {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.alert-danger-custom {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
}

.spinner-custom {
    width: 1rem;
    height: 1rem;
    border-width: 2px;
}

@media (max-width: 576px) {
    .otp-container {
        padding: 1rem;
    }
    
    .otp-card {
        margin: 0;
    }
    
    .otp-input {
        font-size: 1.2rem;
        letter-spacing: 0.3rem;
    }
    
    .otp-buttons {
        flex-direction: column;
    }
}
</style>

<div class="otp-container">
    <div class="otp-card">
        <div class="otp-header">
            <div class="otp-icon">
                🔐
            </div>
            <h3 class="mb-3">Verify OTP</h3>
            <p class="mb-0">Enter the 6-digit code sent to your email</p>
        </div>
        
        <div class="card-body p-4">
            @if(session('error'))
                <div class="alert alert-danger alert-custom alert-danger-custom alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <span class="me-2">⚠️</span>
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-custom alert-success-custom alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <span class="me-2">✅</span>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="text-center mb-4">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <i class="fas fa-envelope me-2" style="color: #667eea;"></i>
                    <span class="fw-bold">{{ $email }}</span>
                </div>
                <small class="text-muted">
                    <a href="{{ route('otp.request.form') }}" class="otp-help">
                        <i class="fas fa-edit me-1"></i> Change email
                    </a>
                </small>
            </div>

            <form id="otpVerifyForm">
                @csrf
                <div class="otp-input-group">
                    <div class="otp-input-icon">
                        🔢
                    </div>
                    <input type="text" class="form-control otp-input" id="otp" name="otp" 
                           placeholder="000000" maxlength="6" pattern="[0-9]{6}" required
                           autocomplete="one-time-code">
                    <div class="invalid-feedback text-center mt-2"></div>
                </div>

                <div class="otp-buttons">
                    <button type="submit" class="btn otp-btn otp-btn-primary" id="verifyBtn">
                        <span class="spinner-border spinner-border-sm spinner-custom d-none" role="status"></span>
                        <span class="btn-text">
                            <i class="fas fa-check-circle me-2"></i>Verify OTP
                        </span>
                    </button>
                    
                    <button type="button" class="btn otp-btn otp-btn-secondary" id="resendBtn">
                        <span class="spinner-border spinner-border-sm spinner-custom d-none" role="status"></span>
                        <span class="btn-text">
                            <i class="fas fa-redo me-2"></i>Resend OTP
                        </span>
                    </button>
                </div>
            </form>

            <div class="otp-timer">
                <div class="otp-timer-text" id="timer">
                    <i class="fas fa-clock me-2"></i>
                    <span id="timerText">OTP expires in 5:00</span>
                </div>
            </div>

            <div class="otp-help">
                <small class="text-muted">
                    <i class="fas fa-question-circle me-1"></i>
                    Didn't receive the code? 
                    <a href="#" id="resendLink">Check spam folder</a> or 
                    <a href="#" id="resendLink2">resend OTP</a>
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
            timerText.textContent = 'OTP has expired!';
            document.getElementById('verifyBtn').disabled = true;
        } else {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            const timerText = document.getElementById('timerText');
            timerText.textContent = `OTP expires in ${minutes}:${seconds.toString().padStart(2, '0')}`;
            
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
        document.querySelector('#otp + .invalid-feedback').textContent = 'OTP must be exactly 6 digits.';
        return;
    }
    
    // Show loading state
    submitBtn.disabled = true;
    spinner.classList.remove('d-none');
    submitBtn.querySelector('.btn-text').innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Verifying...';
    
    const formData = new FormData(form);
    console.log('Form data:', Object.fromEntries(formData));
    
    fetch('{{ route("otp.verify") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
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
        showAlert('danger', 'An error occurred. Please try again.');
    })
    .finally(() => {
        // Reset button state
        submitBtn.disabled = false;
        spinner.classList.add('d-none');
        submitBtn.querySelector('.btn-text').innerHTML = '<i class="fas fa-check-circle me-2"></i>Verify OTP';
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
    
    fetch('{{ route("otp.resend") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
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
        showAlert('danger', 'Failed to resend OTP. Please try again.');
    })
    .finally(() => {
        // Reset button state
        resendBtn.disabled = false;
        spinner.classList.add('d-none');
        resendBtn.querySelector('.btn-text').innerHTML = '<i class="fas fa-redo me-2"></i>Resend OTP';
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
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    document.querySelector('.card-body').insertAdjacentHTML('afterbegin', alertHtml);
}

// Start timer when page loads
document.addEventListener('DOMContentLoaded', function() {
    startTimer();
});
</script>
@endsection
