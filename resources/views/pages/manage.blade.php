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


@if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
@endif

<!-- Sales Chart Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12 card-cs d-flex justify-content-between align-items-center manage-head">
            <div class="d-flex align-items-center">
                <span class="me-3 h1 mb-0 text-secondary"><i class="fas fa-tasks"></i></span>
                <h4 class="card-title"> Manage Documents</h4>
            </div>
            <div class="text-end">
                @if (count($documents) > 0)
                {{-- <a href="{{ route('doc.truncate') }}" class="btn btn-outline-danger"> <i
                        class="far fa-trash-alt"></i> Delete All documents</a> --}}
                @endif
                <a href="{{ route('upload') }}" class="btn btn-outline-success mx-1"> <i
                    class="far fa-trash-alt"></i> Upload Documents</a>
                <a href="{{ route('doc.resource') }}" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete all the resources? This action cannot be undone.');"> <i
                    class="far fa-trash-alt" ></i> Delete Resource Folder</a>
            </div>
        </div>

        <div class="col-12 card-cs d-flex justify-content-between align-items-center manage-head-sm">
            <div class="d-flex align-items-center">
                <span class="me-3 h1 mb-0 text-secondary"><i class="fas fa-tasks"></i></span>
                <h4 class="card-title"> Manage Documents</h4>
            </div>
        </div>

        <div class="text-end manage-head-sm">
            @if (count($documents) > 0)
            {{-- <a href="{{ route('doc.truncate') }}" class="btn btn-outline-danger"> <i
                    class="far fa-trash-alt"></i> Delete All documents</a> --}}
            @endif
            <a href="{{ route('upload') }}" class="btn btn-outline-success mx-1"> <i
                class="far fa-trash-alt"></i> Upload Documents</a>
            <a href="{{ route('doc.resource') }}" class="btn btn-outline-danger btn-resource" onclick="return confirm('Are you sure you want to delete all the resources? This action cannot be undone.');"> <i
                class="far fa-trash-alt"></i> Delete Resource Folder</a>
        </div>
        {{-- Display categories --}}
        <div class="col-md-12 px-0">
            <div class="card-content " style="max-width: 100%; overflow-x: auto">
                <table class="table table-hover"  id="data-table" style="width: 100%; table-layout: auto; white-space: nowrap;" >
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
                                <td>{{ $doc->desc === null ? 'NULL' : Str::limit($doc->desc , 10) }}</td>
                                <td>{{ date('Y-m-d' , strtotime($doc->last_updated))}}</td>
                                <td> 
                                    <a href="{{route('manage.view' , $doc->doc_id )}}" class="small text-info" title="View Document"><i class="fas fa-eye"></i></a> |
                                    <a href="{{route('manage.update' , $doc->doc_id )}}" class="small text-warning" title="Edit Document"><i class="fas fa-edit"></i></a> |
                                    <a href="{{route('manage.delete' , $doc->doc_id )}}" class="small text-danger" title="Delete Document"><i class="fas fa-trash-alt"></i></a> |
                                    <a href="{{route('manage.download' , $doc->doc_id )}}" class="small text-success" title="Download Document"><i class="fas fa-file-download"></i></a> |
                                    <a href="{{route('manage.search' , $doc->std_id )}}" class="small text-primary" title="Download Document"><i class="fas fa-search"></i></a>
                                </td>
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
