@extends('layouts.auth')

@push('title')
    <title>Verify OTP - Gifts Hub</title>
@endpush

@section('content')
<!-- OTP Verification Section -->
<section class="min-vh-100 d-flex align-items-center">
    <div class="container my-2">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="register-form-card">
                            <div class="text-center mb-3">
                                <h2 class="form-title">Verify OTP</h2>
                                <p class="form-subtitle mb-2">Enter the verification code sent to your email</p>
                            </div>

                            <form action="{{ route('otp.verify') }}" method="POST" autocomplete="off">
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
                                        <i class="fa-solid fa-shield-halved me-2 text-primary"></i>Verification Code
                                    </label>
                                    <input type="text" 
                                           class="form-control form-control-modern text-center" 
                                           id="otp" 
                                           name="otp" 
                                           placeholder="Enter 6-digit code" 
                                           maxlength="6"
                                           pattern="[0-9]{6}"
                                           required 
                                           autocomplete="off">
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <button type="submit" class="btn btn-primary-modern">
                                            <i class="fa-solid fa-check me-2"></i>Verify Code
                                        </button>
                                        <button type="button" class="btn btn-outline-modern" onclick="resendOTP()">
                                            <i class="fa-solid fa-redo me-2"></i>Resend Code
                                        </button>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <p class="mb-2">Didn't receive the code?</p>
                                    <a href="{{ route('otp.resend') }}" class="resend-link">Request a new code</a>
                                </div>

                                <div class="text-center">
                                    <p class="signup-prompt">Back to 
                                        <a href="{{ url('login') }}" class="signup-link">Login</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function resendOTP() {
    // Show loading state
    const resendBtn = event.target;
    const originalText = resendBtn.innerHTML;
    resendBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Sending...';
    resendBtn.disabled = true;
    
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
            // Show success message
            const successDiv = document.createElement('div');
            successDiv.className = 'alert alert-success alert-modern mb-3';
            successDiv.innerHTML = '<i class="fa-solid fa-check-circle me-2"></i>' + data.message;
            
            const form = document.querySelector('form');
            form.insertBefore(successDiv, form.firstChild);
            
            // Remove message after 5 seconds
            setTimeout(() => {
                if (successDiv.parentNode) {
                    successDiv.parentNode.removeChild(successDiv);
                }
            }, 5000);
        } else {
            // Show error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-danger alert-modern mb-3';
            errorDiv.innerHTML = '<i class="fa-solid fa-exclamation-circle me-2"></i>' + data.message;
            
            const form = document.querySelector('form');
            form.insertBefore(errorDiv, form.firstChild);
            
            // Remove message after 5 seconds
            setTimeout(() => {
                if (errorDiv.parentNode) {
                    errorDiv.parentNode.removeChild(errorDiv);
                }
            }, 5000);
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
        
        // Show error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'alert alert-danger alert-modern mb-3';
        errorDiv.innerHTML = '<i class="fa-solid fa-exclamation-circle me-2"></i>' + errorMessage;
        
        const form = document.querySelector('form');
        form.insertBefore(errorDiv, form.firstChild);
        
        // Remove message after 5 seconds
        setTimeout(() => {
            if (errorDiv.parentNode) {
                errorDiv.parentNode.removeChild(errorDiv);
            }
        }, 5000);
    })
    .finally(() => {
        // Clear timeout
        clearTimeout(timeoutId);
        
        // Reset button state
        resendBtn.innerHTML = originalText;
        resendBtn.disabled = false;
    });
}

// Auto-focus OTP input
document.addEventListener('DOMContentLoaded', function() {
    const otpInput = document.getElementById('otp');
    if (otpInput) {
        otpInput.focus();
        
        // Auto-format and move to next input after each digit
        otpInput.addEventListener('input', function(e) {
            // Remove any non-numeric characters
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Auto-submit when 6 digits entered
            if (this.value.length === 6) {
                setTimeout(() => {
                    document.querySelector('form').submit();
                }, 500);
            }
        });
    }
});
</script>

<style>
.alert-modern {
    border-radius: 12px;
    border: none;
    padding: 15px 20px;
    margin-bottom: 20px;
    font-size: 14px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.alert-success {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.alert-danger {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
}

.btn-primary-modern {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    padding: 14px 28px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-primary-modern:hover {
    background: linear-gradient(135deg, #5a67d8, #667eea);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
}

.btn-outline-modern {
    background: transparent;
    color: #667eea;
    border: 2px solid #667eea;
    padding: 14px 28px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-outline-modern:hover {
    background: #667eea;
    color: white;
    transform: translateY(-2px);
}

.resend-link {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.resend-link:hover {
    color: #5a67d8;
    text-decoration: underline;
}

.text-center {
    text-align: center;
}

.form-control-modern {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(102, 126, 234, 0.2);
    color: #333;
    padding: 16px 20px;
    border-radius: 12px;
    font-size: 16px;
    transition: all 0.3s ease;
    letter-spacing: 2px;
    font-weight: 600;
}

.form-control-modern:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    background: rgba(255, 255, 255, 0.15);
    outline: none;
}

.form-control-modern::placeholder {
    color: #999;
}
</style>
@endsection
