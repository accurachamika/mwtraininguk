@extends('layouts.auth')

@section('content')
    <div class="auth-container shadow-lg m-5">
        <div class="row">
            <div class="col-md-6 col-lg-6 login-left-container" style="background-image: url({{url('/assets/images/login-img.jpg')}});" >
            </div>

            <div class="col-md-6 col-lg-6">

                <div class="auth-form">
                    <h2 class="auth-title mb-5">Document Management System</h2>
                    <form method="POST" action="{{route('login.post')}}">
                        @csrf
                        <div class="mb-3">
                            <label for="user_name" class="form-label">User Name</label>
                            <input type="text" name="user_name" class="form-control" id="user_name" required>
                        </div>
                         <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>
                        {{--
                        <div class="d-flex justify-content-between">
                            <a href="#" class="link-secondary">Forgot Password?</a>
                        </div> --}}
                        <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
                    </form>
                    @if ($errors->has('login_error'))
                        <div class="alert alert-danger mt-3">
                            {{ $errors->first('login_error') }}
                        </div>
                    @endif
                    <p class="mt-3 text-center">
                        Don't have an account? <a href="{{ route('register')}}" class="link-primary">Sign Up</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
@endsection
