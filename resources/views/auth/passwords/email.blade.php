@extends('layouts.auth')

@section('content')
<div class="auth-container">
    <div class="auth-form">
        <h2 class="auth-title">Document Management System</h2>
        <h4>Forgot Your Password?</h4>
        <p>Enter your email and we will send you a reset link.</p>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-3">Send Password Reset Link</button>
        </form>
        <p class="mt-3 text-center">
            <a href="{{ route('login') }}" class="link-primary">Back to Login</a>
        </p>
    </div>
</div>
@endsection
