@extends('layouts.auth')

@section('content')
<div class="auth-container">
    <div class="auth-form">
        <h2 class="auth-title">Sign Up</h2>

        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">User Name</label>
                <input type="text" name="username" class="form-control border" id="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label ">Password</label>
                <input type="password" name="password" class="form-control border" id="password" required>
            </div>
            <div class="mb-3">
                <label for="password-confirm" class="form-label ">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control border" id="password-confirm" required  onchange="checkpassword()">
                <span class="text-danger small mt-2 d-none" id="error-msg">** Passwords do not match</span>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-3" id="submit-btn">Register</button>
        </form>
        <p class="mt-3 text-center">
            Already have an account? <a href="{{ route('login') }}" class="link-primary">Login</a>
        </p>
    </div>
</div>
<script>
    function checkpassword(){
        const password1 = document.getElementById('password').value;
        const password2 = document.getElementById('password-confirm').value;
        const password1Class = document.getElementById('password').classList;
        const password2Class = document.getElementById('password-confirm').classList;

        const submitBtn = document.getElementById('submit-btn');
        const errorMsg = document.getElementById('error-msg').classList;


        if(password2 !== password1){
            // console.log("True");
            password1Class.add("border-danger");
            password2Class.add("border-danger");

            submitBtn.disabled = true;
            errorMsg.remove("d-none");


        }else{
            // console.log("False");
            password1Class.remove("border-danger");
            password2Class.remove("border-danger");

            password1Class.add("border-success");
            password2Class.add("border-success");

            submitBtn.disabled = false;
            errorMsg.add("d-none");



        }
    }
</script>
@endsection
