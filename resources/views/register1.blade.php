@extends('layouts.auth')

@push('title')
<title>Login Page - Gifts Hub</title>
@endpush

@section('content')

<!-- Modern Login Section -->
<section class="min-vh-100 d-flex align-items-center">
    <div class="container my-2">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="login-form-card">
                            <div class="text-center mb-3">
                                <h2 class="form-title">Sign In</h2>
                                <p class="form-subtitle mb-2">Enter your credentials to access your account</p>
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

                                <div class="mb-3">
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

                                <div class="mb-3">
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

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember">
                                        <label class="form-check-label" for="remember">
                                            Remember me
                                        </label>
                                    </div>
                                    <a href="{{ route('user.forget') }}" class="forgot-link">Forgot password?</a>
                                </div>

                                <button type="submit" class="btn btn-primary-modern w-100 mb-3">
                                    Sign In
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
