@extends('layouts.dashboard')

@section('content')


<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12 card-cs d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <span class="me-3 h1 mb-0 text-secondary"><i class="fas fa-user"></i></span>
                <h4 class="card-title"> {{str_replace('_' , ' ' , $doc->std_name)}}</h4>
            </div>
        </div>

        <div class="col-md-12 px-0">
            <div class="card-content ">
                <form class="row g-3"  method="POST" action="" enctype="multipart/form-data" >
                    @csrf
                    <div class="col-md-6">
                      <label for="std_id" class="form-label">Student ID <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="ex:- ABC1234" id="std_id" name="std_id" autocomplete="new-password"   value="{{$doc->std_id}}" disabled>
                    </div>
                    <div class="col-md-6">
                      <label for="std_name" class="form-label">Student Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="ex:- Jack" id="std_name" name="std_name" autocomplete="new-password"   value="{{$doc->std_name}}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="doc_cat" class="form-label">Document Category <span class="text-danger">*</span></label>
                        <select id="doc_cat" class="form-select"  disabled name="doc_cat">
                          <option> {{$doc->doc_type}} </option>
                        </select>
                      </div>

                    <div class="col-md-6">
                      <label for="document" class="form-label">Document <span class="text-danger">*</span></label>
                      <input class="form-control" type="file" id="document" name="document" disabled>
                      <span class="text-secondary small">File name : <span class="text-dark" style="text-wrap: balance;display: block;max-width: 100%;position: relative;word-wrap: break-word;">{{$doc->file_name}} </span></span><br>
                      
                    </div>
                    <div class="col-md-6">
                      <label for="doc_desc" class="form-label">Document Description</label>
                      <textarea type="text" class="form-control" id="doc_desc" name="doc_desc" disabled>{{$doc->desc !== null ? $doc->desc : 'No description entered'}}</textarea>
                    </div>
                  </form>
                <a href="{{Auth::user()->user_type === 'admin' ? route('manage') : route('stdManage')}}" class="btn btn-outline-warning mt-3">Back</a>
                <a href="{{route('manage.doc.view' , $doc->doc_id)}}" class="btn btn-outline-success mt-3">View File</a>
            </div>
        </div>
    </div>
</div>

@endsection
