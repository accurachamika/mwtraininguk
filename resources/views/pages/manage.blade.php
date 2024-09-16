@extends('layouts.dashboard')

@section('content')

@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<!-- Sales Chart Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        {{-- Display categories --}}
        <div class="col-md-12 px-0">
            <div class="card-content ">
                @if (count($documents) > 0)
                    <div class="text-end w-100 mb-2">
                        <a href="{{ route('doc.truncate') }}" class="btn btn-outline-danger"> <i
                                class="far fa-trash-alt"></i> Delete All documents</a>
                    </div>
                @endif
                <table class="table table-hover">
                    <tr>
                        <th>Student Id</th>
                        <th>Student Name</th>
                        <th>File Name</th>
                        <th>Document type</th>
                        <th>Description</th>
                        <th>Last Updated</th>
                        <th>Action</th>
                    </tr>
                    @if ($documents && count($documents) > 0)
                        @foreach ($documents as $doc)
                            <tr>
                                <td>{{ $doc->std_id }}</td>
                                <td>{{ $doc->std_name }}</td>
                                <td>{{ $doc->file_name }}</td>
                                <td>{{ $doc->doc_type }}</td>
                                <td>{{ $doc->desc === null ? 'NULL' : $doc->desc }}</td>
                                <td>{{ date('Y-m-d' , strtotime($doc->last_updated))}}</td>
                                <td>Action</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="text-center "><b>No data found</b></td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Sales Chart End -->

@endsection
