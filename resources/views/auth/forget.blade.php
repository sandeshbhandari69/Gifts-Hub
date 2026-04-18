@extends('layouts.auth')

@push('title')
<title>Forgot Password - Gifts Hub</title>
@endpush

@section('content')

<!-- Modern Forgot Password Section -->
<section class="min-vh-100 d-flex align-items-center">
    <div class="container my-2">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="login-form-card">
                            <div class="text-center mb-3">
                                <h2 class="form-title">Reset Password</h2>
                                <p class="form-subtitle mb-2">Enter your email and new password to reset your account</p>
                            </div>

                            <form action="{{ route('user.forget.post') }}" method="POST" autocomplete="off">
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

                                @if ($errors->any())
                                    <div class="alert alert-danger alert-modern" role="alert">
                                        <i class="fa-solid fa-exclamation-triangle me-2"></i>
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}<br>
                                        @endforeach
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
                                           placeholder="Enter your registered email" 
                                           required 
                                           autocomplete="off">
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">
                                        <i class="fa-solid fa-lock me-2 text-primary"></i>New Password
                                    </label>
                                    <div class="password-toggle">
                                        <input type="password" 
                                               class="form-control form-control-modern" 
                                               id="password" 
                                               name="password" 
                                               placeholder="Enter new password" 
                                               required 
                                               autocomplete="new-password">
                                        <button type="button" class="password-toggle-btn" onclick="togglePassword('password')">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label fw-semibold">
                                        <i class="fa-solid fa-lock me-2 text-primary"></i>Confirm New Password
                                    </label>
                                    <div class="password-toggle">
                                        <input type="password" 
                                               class="form-control form-control-modern" 
                                               id="password_confirmation" 
                                               name="password_confirmation" 
                                               placeholder="Confirm new password" 
                                               required 
                                               autocomplete="new-password">
                                        <button type="button" class="password-toggle-btn" onclick="togglePassword('password_confirmation')">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary-modern w-100 mb-3">
                                    <i class="fa-solid fa-key me-2"></i>Reset Password
                                </button>

                                <div class="text-center">
                                    <p class="signup-prompt">Remember your password? 
                                        <a href="{{ route('login') }}" class="signup-link">Back to login</a>
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
