@extends('user.layouts.main')

@push('title')
    <title>Account & Billing</title>
@endpush

@section('content')
<div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 mt-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card mb-4">
                    <div>
                        <div class="card-body">
                            <h5 class="mb-4 pt-3">Account Settings</h5>
                            <form action="{{ route('user.update.profile') }}" method="POST">
                                @csrf
                                <div class="row">
                                    {{-- LEFT FORM --}}
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">First Name</label>
                                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Phone Number</label>
                                                <input type="text" name="phone" class="form-control" value="{{ $user->phone ?? '' }}" placeholder="+91">
                                            </div>

                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- RIGHT IMAGE --}}
                                    <div class="col-lg-4 text-center">
                                        <img src="{{ asset('assets/images/Review/user.png') }}" 
                                            class="rounded-circle mb-3"
                                            style="width:150px;height:150px;object-fit:cover;">

                                        <div>
                                            <label for="image" class="btn btn-primary btn-sm">
                                                Choose Image
                                            </label>
                                            <input type="file" id="image" class="d-none">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- ================= PASSWORD CHANGE ================= --}}
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="mb-4 pt-3">Change Password</h5>
                        <form action="{{ route('user.update.password') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Current Password</label>
                                    <input type="password" name="current_password" class="form-control" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="password" class="form-control" required minlength="6">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-warning">Update Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
@endsection