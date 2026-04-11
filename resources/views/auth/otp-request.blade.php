@extends('layouts.main')

@section('content')
<style>
.otp-request-container {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.otp-request-card {
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

.otp-request-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    text-align: center;
    position: relative;
}

.otp-request-header::before {
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

.otp-request-icon {
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

.otp-request-input-group {
    position: relative;
    margin: 2rem 0;
}

.otp-request-input {
    width: 100%;
    padding: 1rem 1rem 1rem 3rem;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.otp-request-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    background: white;
}

.otp-request-input.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.otp-request-input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-size: 1.2rem;
}

.otp-request-btn {
    width: 100%;
    padding: 1rem;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.otp-request-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
}

.otp-request-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
}

.otp-request-help {
    text-align: center;
    margin-top: 1.5rem;
}

.otp-request-help a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
}

.otp-request-help a:hover {
    text-decoration: underline;
}

@media (max-width: 576px) {
    .otp-request-container {
        padding: 1rem;
    }
    
    .otp-request-card {
        margin: 0;
    }
}
</style>

<div class="otp-request-container">
    <div class="otp-request-card">
        <div class="otp-request-header">
            <div class="otp-request-icon">
                📧
            </div>
            <h3 class="mb-3">Email Verification</h3>
            <p class="mb-0">Enter your email address to receive OTP</p>
        </div>
        
        <div class="card-body p-4">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #dc3545, #c82333); color: white;">
                    <div class="d-flex align-items-center">
                        <span class="me-2">⚠️</span>
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="border: none; border-radius: 12px; background: linear-gradient(135deg, #28a745, #20c997); color: white;">
                    <div class="d-flex align-items-center">
                        <span class="me-2">✅</span>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form id="otpRequestForm">
                @csrf
                <div class="otp-request-input-group">
                    <div class="otp-request-input-icon">
                        📧
                    </div>
                    <input type="email" class="form-control otp-request-input" id="email" name="email" 
                           placeholder="Enter your email address" required
                           autocomplete="email">
                    <div class="invalid-feedback text-center mt-2"></div>
                </div>

                <button type="submit" class="otp-request-btn" id="sendOtpBtn">
                    <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                    <span class="btn-text">
                        <i class="fas fa-paper-plane me-2"></i>Send OTP
                    </span>
                </button>
            </form>

            <div class="otp-request-help">
                <small class="text-muted">
                    <i class="fas fa-key me-1"></i>
                    Already have an OTP? 
                    <a href="{{ route('otp.verify.form') }}">Verify OTP</a>
                </small>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('otpRequestForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const submitBtn = document.getElementById('sendOtpBtn');
    const spinner = submitBtn.querySelector('.spinner-border');
    const btnText = submitBtn.lastChild;
    
    // Clear previous errors
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    
    // Show loading state
    submitBtn.disabled = true;
    spinner.classList.remove('d-none');
    submitBtn.querySelector('.btn-text').innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
    
    fetch('{{ route("otp.send") }}', {
        method: 'POST',
        body: new FormData(form),
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showAlert('success', data.message);
            
            // Redirect after a short delay
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 1500);
        } else {
            // Show error message
            showAlert('danger', data.message);
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
        submitBtn.querySelector('.btn-text').innerHTML = '<i class="fas fa-paper-plane me-2"></i>Send OTP';
    });
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
</script>
@endsection
