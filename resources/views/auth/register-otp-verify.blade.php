@extends('layouts.auth')

@push('title')
<title>Verify OTP - Gifts Hub Registration</title>
@endpush

@section('content')

<!--  OTP Verification Section -->
<section class="min-vh-100 d-flex align-items-center" style="background-color: white;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                        <div class="otp-form-card">
                            <div class="text-center mb-4">
                                <div class="logo-circle mb-3">
                                    <i class="fa-solid fa-envelope-open-text fa-2x text-primary"></i>
                                </div>
                                <h2 class="form-title">Verify OTP</h2>
                                <p class="form-subtitle">Enter the 6-digit code sent to your email</p>
                                <div class="email-display">
                                    <small class="text-muted">Email:</small>
                                    <strong>{{ $email }}</strong>
                                </div>
                            </div>

                            <form id="otpVerifyForm" action="{{ route('register.otp.verify.post') }}" method="POST">
                                @csrf
                                
                                @if(session('error'))
                                    <div class="alert alert-danger alert-modern" role="alert">
                                        <i class="fa-solid fa-exclamation-circle me-2"></i>
                                        {{ session('error') }}
                                    </div>
                                @endif
                                
                                @if(session('success'))
                                    <div class="alert alert-success alert-modern" role="alert">
                                        <i class="fa-solid fa-check-circle me-2"></i>
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <div class="mb-4">
                                    <label for="otp" class="form-label fw-semibold">
                                        <i class="fa-solid fa-key me-2 text-primary"></i>Verification Code
                                    </label>
                                    <div class="otp-input-group">
                                        <input type="text" 
                                               class="form-control form-control-modern otp-input" 
                                               id="otp" 
                                               name="otp" 
                                               placeholder="Enter 6-digit code" 
                                               maxlength="6" 
                                               pattern="[0-9]{6}" 
                                               required 
                                               autocomplete="off">
                                        <div class="otp-spinner" id="otpSpinner" style="display: none;">
                                            <i class="fa-solid fa-spinner fa-spin"></i>
                                        </div>
                                    </div>
                                    <small class="text-muted">The code will expire in 5 minutes</small>
                                </div>

                                <div class="d-grid gap-2 mb-4">
                                    <button type="submit" class="btn btn-primary-modern" id="verifyBtn">
                                        <i class="fa-solid fa-check-circle me-2"></i>Verify & Complete Registration
                                    </button>
                                </div>

                                <div class="text-center">
                                    <p class="resend-text">
                                        Didn't receive the code? 
                                        <button type="button" class="btn btn-link p-0 ms-1 resend-btn" id="resendBtn">
                                            <i class="fa-solid fa-redo me-1"></i>Resend OTP
                                        </button>
                                    </p>
                                    <small class="text-muted" id="resendTimer" style="display: none;">
                                        Resend available in <span id="countdown">60</span> seconds
                                    </small>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
let resendTimer = null;
let countdownValue = 60;

document.getElementById('otpVerifyForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const verifyBtn = document.getElementById('verifyBtn');
    const spinner = document.getElementById('otpSpinner');
    const formData = new FormData(this);
    
    // Show loading state
    verifyBtn.disabled = true;
    verifyBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Verifying...';
    spinner.style.display = 'block';
    
    // Create timeout controller for better browser compatibility
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 30000);

    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        signal: controller.signal
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        clearTimeout(timeoutId);
        if (data.success) {
            window.location.href = data.redirect;
        } else {
            // Show error message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger alert-modern';
            alertDiv.innerHTML = `<i class="fa-solid fa-exclamation-circle me-2"></i>${data.message}`;
            
            // Remove existing alerts
            const existingAlerts = this.querySelectorAll('.alert');
            existingAlerts.forEach(alert => alert.remove());
            
            // Add new alert
            document.getElementById('otpVerifyForm').insertBefore(alertDiv, document.getElementById('otpVerifyForm').firstChild);
            
            // Reset button state
            verifyBtn.disabled = false;
            verifyBtn.innerHTML = '<i class="fa-solid fa-check-circle me-2"></i>Verify & Complete Registration';
            spinner.style.display = 'none';
        }
    })
    .catch(error => {
        clearTimeout(timeoutId);
        console.error('Error:', error);
        
        // Show error message to user
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-modern';
        alertDiv.innerHTML = `<i class="fa-solid fa-exclamation-circle me-2"></i>Network error. Please check your connection and try again.`;
        
        // Remove existing alerts
        const existingAlerts = this.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());
        
        // Add new alert
        this.insertBefore(alertDiv, this.firstChild);
        
        // Reset button state
        verifyBtn.disabled = false;
        verifyBtn.innerHTML = '<i class="fa-solid fa-check-circle me-2"></i>Verify & Complete Registration';
        spinner.style.display = 'none';
    });
});

document.getElementById('resendBtn').addEventListener('click', function() {
    const resendBtn = this;
    const resendTimer = document.getElementById('resendTimer');
    const countdown = document.getElementById('countdown');
    
    // Disable resend button
    resendBtn.disabled = true;
    resendBtn.style.opacity = '0.6';
    
    // Show timer
    resendTimer.style.display = 'block';
    countdownValue = 60;
    countdown.textContent = countdownValue;
    
    // Start countdown
    const timerInterval = setInterval(() => {
        countdownValue--;
        countdown.textContent = countdownValue;
        
        if (countdownValue <= 0) {
            clearInterval(timerInterval);
            resendTimer.style.display = 'none';
            resendBtn.disabled = false;
            resendBtn.style.opacity = '1';
        }
    }, 1000);
    
    // Send resend request
    // Create timeout controller for resend request
    const resendController = new AbortController();
    const resendTimeoutId = setTimeout(() => resendController.abort(), 30000);

    fetch('{{ route("register.otp.resend") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        signal: resendController.signal
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-modern';
            alertDiv.innerHTML = `<i class="fa-solid fa-check-circle me-2"></i>${data.message}`;
            
            // Remove existing alerts
            const existingAlerts = document.querySelectorAll('.alert');
            existingAlerts.forEach(alert => alert.remove());
            
            // Add new alert
            document.getElementById('otpVerifyForm').insertBefore(alertDiv, document.getElementById('otpVerifyForm').firstChild);
        } else {
            // Show error message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger alert-modern';
            alertDiv.innerHTML = `<i class="fa-solid fa-exclamation-circle me-2"></i>${data.message}`;
            
            // Remove existing alerts
            const existingAlerts = document.querySelectorAll('.alert');
            existingAlerts.forEach(alert => alert.remove());
            
            // Add new alert
            document.getElementById('otpVerifyForm').insertBefore(alertDiv, document.getElementById('otpVerifyForm').firstChild);
            
            // Reset button state on error
            clearInterval(timerInterval);
            resendTimer.style.display = 'none';
            resendBtn.disabled = false;
            resendBtn.style.opacity = '1';
        }
    })
    .catch(error => {
        clearTimeout(resendTimeoutId);
        console.error('Error:', error);
        
        // Show error message to user
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-modern';
        alertDiv.innerHTML = `<i class="fa-solid fa-exclamation-circle me-2"></i>Failed to resend OTP. Please try again.`;
        
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());
        
        // Add new alert
        document.getElementById('otpVerifyForm').insertBefore(alertDiv, document.getElementById('otpVerifyForm').firstChild);
        
        // Reset button state
        clearInterval(timerInterval);
        resendTimer.style.display = 'none';
        resendBtn.disabled = false;
        resendBtn.style.opacity = '1';
    });
});

// Auto-format OTP input
document.getElementById('otp').addEventListener('input', function(e) {
    // Remove non-numeric characters
    this.value = this.value.replace(/[^0-9]/g, '');
    
    // Limit to 6 digits
    if (this.value.length > 6) {
        this.value = this.value.slice(0, 6);
    }
});

// Auto-focus on OTP input when page loads
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('otp').focus();
});
</script>

<style>
.otp-input-group {
    position: relative;
}

.otp-input {
    font-size: 1.5rem;
    font-weight: 600;
    text-align: center;
    letter-spacing: 0.5rem;
    padding: 1rem;
}

.otp-spinner {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

.email-display {
    background: rgba(0, 123, 255, 0.1);
    padding: 0.75rem;
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
}

.resend-text {
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.resend-btn {
    color: #007bff !important;
    text-decoration: none;
    font-weight: 500;
}

.resend-btn:hover {
    color: #0056b3 !important;
    text-decoration: underline;
}

.resend-btn:disabled {
    color: #6c757d !important;
    text-decoration: none;
    cursor: not-allowed;
}

#resendTimer {
    display: block;
    margin-top: 0.5rem;
}

.floating-card {
    position: relative;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.overlay-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(0, 123, 255, 0.1), rgba(0, 123, 255, 0.05));
    pointer-events: none;
}

.otp-form-card {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.logo-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #007bff, #0056b3);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
}

.form-title {
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.form-subtitle {
    color: #6c757d;
    margin-bottom: 2rem;
}

.form-control-modern {
    border: 2px solid #e9ecef;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control-modern:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn-primary-modern {
    background: linear-gradient(135deg, #007bff, #0056b3);
    border: none;
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary-modern:hover {
    background: linear-gradient(135deg, #0056b3, #004085);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
}

.alert-modern {
    border: none;
    border-radius: 0.5rem;
    padding: 1rem;
    margin-bottom: 1rem;
}

.alert-modern.alert-success {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    color: #155724;
}

.alert-modern.alert-danger {
    background: linear-gradient(135deg, #f8d7da, #f5c6cb);
    color: #721c24;
}
</style>

@endsection
