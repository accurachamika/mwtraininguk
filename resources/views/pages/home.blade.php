@extends('layouts.dashboard')

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<!-- Sales Chart Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12 card-cs d-flex justify-content-between align-items-center">
          <div class="d-flex align-items-center">
              <span class="me-3 h1 mb-0 text-secondary"><i class="fas fa-door-open"></i></span>
              <h3 class="card-title"> Welcome to Document Management System</h3>
          </div>
      </div>
      <div class="d-flex align-items-center card-content">
        <img src="{{url('/assets/images/welcomeBack.png')}}" alt="" class="w-100">
    </div>
</div>
</div>

@endsection

