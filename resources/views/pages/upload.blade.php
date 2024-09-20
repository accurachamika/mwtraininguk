@extends('layouts.dashboard')

@section('title' , 'Document Upload')

@section('content')

<!-- Sales Chart Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-3">
        <div class="col-12 card-cs d-flex align-items-center ">
            <span class="me-3 h1 mb-0 text-secondary"><i class="fas fa-file-upload"></i></span>
            <h4 class="card-title">  Document Upload</h4>
        </div>

        <div class="col-md-12 px-0">
            <div class="card-content ">
                <form class="row g-3"  method="POST" action="{{route('upload.post')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6">
                      <label for="std_id" class="form-label">Student ID <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="ex:- ABC1234" id="std_id" name="std_id" autocomplete="new-password" required>
                    </div>
                    <div class="col-md-6">
                      <label for="std_name" class="form-label">Student Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="ex:- Jack" id="std_name" name="std_name" autocomplete="new-password" required>
                    </div>

                    <div class="col-md-6">
                        <label for="doc_cat" class="form-label">Document Category <span class="text-danger">*</span></label>
                        <select id="doc_cat" class="form-select" required name="doc_cat">
                          <option>Please Select Category</option>
                          @if(count($categories) > 0)
                          @foreach ($categories as $cat)
                            <option value="{{$cat->name}}"> {{$cat->name}} </option>
                          @endforeach
                          @else
                            <option> No data </option>
                          @endif
                        </select>
                        @if(count($categories) === 0 || count($categories) < 3)
                            <a href="{{route('category')}}" class="small mt-2">Add New Category</a>
                        @endif
                      </div>

                    <div class="col-md-6">
                      <label for="document" class="form-label">Document <span class="text-danger">*</span></label>
                      <input class="form-control" type="file" id="document" name="document" required>
                      <input class="form-control" type="text" id="uploaded_by" name="uploaded_by" value="{{Auth::user()->user_name}}" hidden>
                    </div>
                    <div class="col-md-6">
                      <label for="doc_desc" class="form-label">Document Description</label>
                      <textarea type="text" class="form-control" id="doc_desc" name="doc_desc"></textarea>
                    </div>

                    <div class="col-12">
                      <button type="submit" class="btn btn-primary">Upload Document</button>
                    </div>
                  </form>
            </div>

        </div>

    </div>
</div>

@endsection
