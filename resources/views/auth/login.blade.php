@extends('layouts.auth')

@section('content')
    <div class="auth-container shadow-lg m-lg-5">
        <div class="row no-gutters">
            <!-- Left Image Container -->
            <div class="col-12 col-md-6 d-none d-md-block login-left-container"
                 style="background-image: url({{ url('/assets/images/login-img.jpg') }}); background-size: cover; background-position: center; min-height: 100%;">
            </div>

            <!-- Form Container -->
            <div class="col-12 col-md-6">
                <div class="auth-form p-4">
                    <h2 class="auth-title mb-5 text-start">Document Management System</h2>
                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <!-- User Name Field -->
                        <div class="form-row">
                            <div class="mb-3 col-md-12">
                                <label for="user_name" class="form-label">User Name</label>
                                <input type="text" name="user_name" class="form-control" id="user_name" required>
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="form-row">
                            <div class="mb-3 col-md-12">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password" required>
                            </div>
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="form-row">
                            <div class="mb-3 form-check col-md-12">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember Me</label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
                    </form>

                    <!-- Error Handling -->
                    @if ($errors->has('login_error'))
                        <div class="alert alert-danger mt-3">
                            {{ $errors->first('login_error') }}
                        </div>
                    @endif

                    <!-- Signup Link -->
                    <p class="mt-3 text-center">
                        Don't have an account? <a href="{{ route('register')}}" class="link-primary">Sign Up</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
