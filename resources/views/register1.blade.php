@extends('layouts.auth')

@push('title')
<title>Login Page - Gifts Hub</title>
@endpush

@section('content')

<!-- Modern Login Section -->
<section class="min-vh-100 d-flex align-items-center gradient-bg">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row align-items-center">
                    <div class="col-lg-5 mb-4 mb-lg-0">
                        <div class="login-illustration text-center">
                            <div class="floating-card">
                                <img src="{{ asset('assets/images/Hero/login.avif') }}" 
                                     class="img-fluid rounded-4" 
                                     alt="Login Illustration"
                                     style="max-width: 100%; height: auto;">
                                <div class="overlay-pattern"></div>
                            </div>
                            <div class="mt-4">
                                <h3 class="text-white fw-bold">Welcome Back!</h3>
                                <p class="text-white-50">Access your personalized gift recommendations and order history</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 offset-lg-1">
                        <div class="login-form-card">
                            <div class="text-center mb-4">
                                <div class="logo-circle mb-3">
                                    <i class="fa-solid fa-gift fa-2x text-primary"></i>
                                </div>
                                <h2 class="form-title">Sign In</h2>
                                <p class="form-subtitle">Enter your credentials to access your account</p>
                            </div>

                            <form action="{{ route('login.post') }}" method="POST" autocomplete="off">
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
                                           placeholder="Enter your email" 
                                           required 
                                           autocomplete="off">
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label fw-semibold">
                                        <i class="fa-solid fa-lock me-2 text-primary"></i>Password
                                    </label>
                                    <div class="password-toggle">
                                        <input type="password" 
                                               class="form-control form-control-modern" 
                                               id="password" 
                                               name="password" 
                                               placeholder="Enter your password" 
                                               required 
                                               autocomplete="new-password">
                                        <button type="button" class="password-toggle-btn" onclick="togglePassword('password')">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember">
                                        <label class="form-check-label" for="remember">
                                            Remember me
                                        </label>
                                    </div>
                                    <a href="#" class="forgot-link">Forgot password?</a>
                                </div>

                                <button type="submit" class="btn btn-primary-modern w-100 mb-4">
                                    <i class="fa-solid fa-sign-in-alt me-2"></i>Sign In
                                </button>

                                <div class="text-center">
                                    <p class="signup-prompt">Don't have an account? 
                                        <a href="{{url('register')}}" class="signup-link">Sign up now</a>
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
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = field.nextElementSibling.querySelector('i');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>

@endsection
