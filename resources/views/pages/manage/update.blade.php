@extends('layouts.dashboard')

@section('content')


<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
      <div class="col-12 card-cs d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <span class="me-3 h1 mb-0 text-secondary"><i class="fas fa-user-edit"></i></span>
            <h4 class="card-title"> {{str_replace('_' , ' ' , $doc->std_name)}}</h4>
        </div>
    </div>

        <div class="col-md-12 px-0">
            <div class="card-content ">
                <form class="row g-3"  method="POST" action="{{route('edit.post')}}" enctype="multipart/form-data" >
                    @csrf
                    <div class="col-md-6">
                      <label for="std_id" class="form-label">Student ID <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="ex:- ABC1234" id="std_id" name="std_id" autocomplete="new-password"   value="{{$doc->std_id}}" required>
                      <input type="text" class="form-control" id="doc_id" name="doc_id"  value="{{$doc->doc_id}}" hidden>
                      <input class="form-control" type="text" id="uploaded_by" name="uploaded_by" value="{{Auth::user()->user_name}}" hidden>
                    </div>
                    <div class="col-md-6">
                      <label for="std_name" class="form-label">Student Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" placeholder="ex:- Jack" id="std_name" name="std_name" autocomplete="new-password"   value="{{$doc->std_name}}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="doc_cat" class="form-label">Document Category <span class="text-danger">*</span></label>
                        <select id="doc_cat" class="form-select"  name="doc_cat" required>
                          <option value=""> Please Select</option>

                          @if($doc_type)

                          @foreach ( $doc_type as $dt)
                            <option @if($doc->doc_type === $dt->name) selected @endif value="{{$dt->name}}"> {{$dt->name}} </option>
                          @endforeach
                          
                          @else
                          <option> No data</option>
                          @endif
                        </select>
                      </div>

                    <div class="col-md-6">
                      <label for="document" class="form-label">Document </label>
                      <input class="form-control" type="file" id="document" name="document">
                      <span class="text-secondary small">File name : <span class="text-dark" style="text-wrap: balance;display: inline;max-width: 100%;position: relative;word-wrap: break-word;">{{$doc->file_name}}</span></span><br>
                      <span><a href="{{route('manage.doc.view' , $doc->doc_id)}}" class="text-decoration-none">View File</a></span>
                    </div>
                    <div class="col-md-6">
                      <label for="doc_desc" class="form-label">Document Description</label>
                      <textarea type="text" class="form-control" id="doc_desc" name="doc_desc">{{$doc->desc !== null ? $doc->desc : ''}}</textarea>
                    </div>

                    <div class="col-md-12">
                      <button type="submit" class="btn btn-outline-info">Update</button>
                      <a href="{{route('manage')}}" class="btn btn-outline-warning ml-2">Back</a>
                    </div>

                  </form>
                
            </div>
        </div>
    </div>
</div>

@endsection
