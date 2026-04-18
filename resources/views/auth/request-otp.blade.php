@extends('layouts.auth')

@push('title')
    <title>Request OTP - Gifts Hub</title>
@endpush

@section('content')
<!-- Modern OTP Request Section -->
<section class="min-vh-100 d-flex align-items-center">
    <div class="container my-2">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="register-form-card">
                            <div class="text-center mb-3">
                                <h2 class="form-title">Request OTP</h2>
                                <p class="form-subtitle mb-2">Enter your email to receive a verification code</p>
                            </div>

                            <form action="{{ route('otp.send') }}" method="POST" autocomplete="off">
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
                                    <label for="email" class="form-label fw-semibold">
                                        <i class="fa-solid fa-envelope me-2 text-primary"></i>Email Address
                                    </label>
                                    <input type="email" 
                                           class="form-control form-control-modern" 
                                           id="email" 
                                           name="email" 
                                           placeholder="Enter your registered email" 
                                           required 
                                           autocomplete="off">
                                </div>

                                <div class="mb-4">
                                    <button type="submit" class="btn btn-primary-modern w-100">
                                        <i class="fa-solid fa-paper-plane me-2"></i>Send OTP
                                    </button>
                                </div>

                                <div class="text-center">
                                    <p class="signup-prompt">Already have a code? 
                                        <a href="{{ route('otp.verify.form') }}" class="signup-link">Verify here</a>
                                    </p>
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

.signup-link {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.signup-link:hover {
    color: #5a67d8;
    text-decoration: underline;
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
