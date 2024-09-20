@extends('layouts.dashboard')


@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12 card-cs d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <span class="me-3 h1 mb-0 text-secondary"><i class="fas fa-user"></i></span>
                <h4 class="card-title">Document Viewer </h4>
            </div>
        </div>
        
        <div class="col-12">
            <div class="pdf-viewer card-content mt-1">
                <iframe src="{{ $fileUrl }}" width="100%" height="600px"></iframe>
            </div>
            
            <div class="mt-3">
                <a href="{{ url()->previous() }}" class="btn btn-outline-warning">Back</a>
            </div>
        </div>
    </div>
    
    

    
</div>
@endsection
