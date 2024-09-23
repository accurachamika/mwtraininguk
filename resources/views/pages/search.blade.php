@extends('layouts.dashboard')

@section('content')

<!-- Sales Chart Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12 card-cs d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <span class="me-3 h1 mb-0 text-secondary"><i class="fas fa-search"></i></span>
                <h3 class="card-title"> Search Documents</h3>
            </div>
        </div>

        <div class="col-md-6 card-content">
            <form class="row g-3"  method="POST" action="{{route('search.post')}}" enctype="multipart/form-data">
                @csrf
                <div class="col-md-6">
                  <label for="std_id" class="form-label">Student ID</label>
                  <input type="text" class="form-control" placeholder="ex:- ABC1234" id="std_id" name="std_id" autocomplete="new-password" >
                </div>
                <div class="col-md-12">
                  <label for="std_name" class="form-label">Student Name </label>
                  <input type="text" class="form-control" placeholder="ex:- Jack" id="std_name" name="std_name" autocomplete="new-password" >
                </div>


                <div class="col-md-6">
                  <label for="doc_cat" class="form-label">Document Category</label>
                  <select id="doc_cat" class="form-select" name="doc_cat">
                    <option value="">Please Select Category</option>
                        @if(count($categories) > 0)
                        @foreach ($categories as $cat)
                        <option value="{{$cat->name}}"> {{$cat->name}} </option>
                        @endforeach
                        @else
                        <option> No data </option>
                        @endif
                  </select>
                </div>

                <div class="col-12">
                  <button type="submit" class="btn btn-primary">Search Documents</button>
                </div>
              </form>
        </div>

        <div class="col-md-6 text-center">
            <img src="{{url('assets/images/doc.jpg')}}" alt="" class="search-img">
        </div>
    </div>
</div>
<!-- Sales Chart End -->

@endsection
