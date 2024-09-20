@extends('layouts.dashboard')

@section('title', 'Manage Documents')

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
        <div class="col-12 card-cs d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <span class="me-3 h1 mb-0 text-secondary"><i class="fas fa-tasks"></i></span>
                <h4 class="card-title"> Manage Documents</h4>
            </div>
        </div>
        {{-- Display categories --}}
        <div class="col-md-12 px-0">
            <div class="card-content ">
                <table class="table table-hover"  id="data-table">
                    <thead>
                        <tr>
                            <th>Student Id</th>
                            <th>Student Name</th>
                            <th>File Name</th>
                            <th>Document type</th>
                            <th>Description</th>
                            <th>Last Updated</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if ($documents && count($documents) > 0)
                        @foreach ($documents as $doc)
                            <tr >
                                <td>{{ $doc->std_id }}</td>
                                <td>{{ $doc->std_name }}</td>
                                <td>{{ $doc->file_name }}</td>
                                <td>{{ $doc->doc_type }}</td>
                                <td>{{ $doc->desc === null ? 'NULL' : $doc->desc }}</td>
                                <td>{{ date('Y-m-d' , strtotime($doc->last_updated))}}</td>
                                <td class="text-center "> <a href="{{route('manage.stdView' , $doc->doc_id )}}" class="small text-info" title="View Document"><i class="fas fa-eye"></i></a></td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center "><b>No data found</b></td>
                        </tr>
                    @endif
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@if( count($documents) !== 0)
<!-- Initialize DataTables -->
<script>
    $(document).ready(function() {
        $('#data-table').DataTable({
            "paging": true,         // Enable pagination
            "searching": true,      // Enable searching
            "info": true,           // Show table information
            "lengthChange": true    // Enable the ability to change page length
        });
    });
</script>
@endif

@endsection
