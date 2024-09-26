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
                    <a href="{{ route('upload') }}" class="btn btn-outline-success mx-1"> <i class="far fa-trash-alt"></i>
                        Upload Documents</a>
                    <a href="{{ route('doc.resource') }}" class="btn btn-outline-danger"
                        onclick="return confirm('Are you sure you want to delete all the resources? This action cannot be undone.');">
                        <i class="far fa-trash-alt"></i> Delete Resource Folder</a>
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
                <a href="{{ route('upload') }}" class="btn btn-outline-success mx-1"> <i class="far fa-trash-alt"></i>
                    Upload Documents</a>
                <a href="{{ route('doc.resource') }}" class="btn btn-outline-danger btn-resource"
                    onclick="return confirm('Are you sure you want to delete all the resources? This action cannot be undone.');">
                    <i class="far fa-trash-alt"></i> Delete Resource Folder</a>
            </div>
            {{-- Display categories --}}
            <div class="col-md-12 px-0">
                <div class="card-content mb-3">
                    <form class="row g-3 align-items-end"  method="GET" action="{{route('search.post')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-3">
                          <label for="std_id" class="form-label">Student ID</label>
                          <input type="text" class="form-control" placeholder="ex:- ABC1234" id="std_id" name="std_id" autocomplete="new-password" @if( request('std_id')) value="{{request('std_id')}}" @endif>
                        </div>
                        <div class="col-md-3">
                          <label for="std_name" class="form-label">Student Name </label>
                          <input type="text" class="form-control" placeholder="ex:- Jack" id="std_name" name="std_name" autocomplete="new-password" @if( request('std_name')) value="{{request('std_name')}}" @endif>
                        </div>


                        <div class="col-md-3">
                          <label for="doc_cat" class="form-label">Document Category</label>
                          <select id="doc_cat" class="form-select" name="doc_cat" id="doc_cat">
                            <option value="" hidden>Please Select Category</option>
                            <option value="" >All Categories</option>
                          </select>
                        </div>

                        <div class="col-3 text-center">
                          <button type="submit" class="btn btn-primary">Search Documents</button>
                        </div>
                      </form>
                </div>
                <div class="card-content " style="max-width: 100%; overflow-x: auto">
                    <table class="table table-hover" id="data-table"
                        style="width: 100%; table-layout: auto; white-space: nowrap;">
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
                                    <tr>
                                        <td>{{ $doc->std_id }}</td>
                                        <td>{{ $doc->std_name }}</td>
                                        <td>{{ $doc->file_name }}</td>
                                        <td>{{ $doc->doc_type }}</td>
                                        <td>{{ $doc->desc === null ? 'NULL' : Str::limit($doc->desc, 10) }}</td>
                                        <td>{{ date('Y-m-d', strtotime($doc->last_updated)) }}</td>
                                        <td>
                                            <a href="{{ route('manage.view', $doc->doc_id) }}" class="small text-info"
                                                title="View Document"><i class="fas fa-eye"></i></a> |
                                            <a href="{{ route('manage.update', $doc->doc_id) }}" class="small text-warning"
                                                title="Edit Document"><i class="fas fa-edit"></i></a> |
                                            <a href="{{ route('manage.delete', $doc->doc_id) }}" class="small text-danger"
                                                title="Delete Document"
                                                onclick="return confirm('Are you sure you want to delete the file? This action cannot be undone.');"><i
                                                    class="fas fa-trash-alt"></i></a> |
                                            <a href="{{ route('manage.download', $doc->doc_id) }}"
                                                class="small text-success" title="Download Document"><i
                                                    class="fas fa-file-download"></i></a> |
                                            <a href="{{ route('manage.search', $doc->std_id) }}" class="small text-primary"
                                                title="Download Document"><i class="fas fa-search"></i></a>
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
    @if ($documents instanceof \Illuminate\Pagination\LengthAwarePaginator)
        @if ($documents->hasPages())
            <div class="d-flex justify-content-between mx-3 mt-3">
                <div>Showing {{ $documents->firstItem() }} to {{ $documents->lastItem() }} of {{ $documents->total() }}
                    entries</div>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm m-0">
                        {{-- Previous Page Link --}}
                        @if ($documents->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">&laquo; Previous</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $documents->previousPageUrl() }}"
                                    aria-label="Previous">&laquo; Previous</a></li>
                        @endif

                        {{-- Pagination Links --}}
                        @for ($page = 1; $page <= $documents->lastPage(); $page++)
                            @if (
                                $page == 1 ||
                                    $page == 2 ||
                                    $page == $documents->lastPage() ||
                                    $page == $documents->lastPage() - 1 ||
                                    ($page >= $documents->currentPage() - 1 && $page <= $documents->currentPage() + 1))
                                @if ($page == $documents->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $documents->url($page) }}">{{ $page }}</a></li>
                                @endif
                            @elseif ($page == 3 && $documents->currentPage() > 4)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @elseif ($page == $documents->lastPage() - 2 && $documents->currentPage() < $documents->lastPage() - 3)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                        @endfor

                        {{-- Next Page Link --}}
                        @if ($documents->hasMorePages())
                            <li class="page-item"><a class="page-link" href="{{ $documents->nextPageUrl() }}"
                                    aria-label="Next">Next &raquo;</a></li>
                        @else
                            <li class="page-item disabled"><span class="page-link">Next &raquo;</span></li>
                        @endif
                    </ul>
                </nav>
            </div>
        @endif
    @endif



    @if (count($documents) > 0)
        <script>
            $(document).ready(function() {
                $('#data-table').DataTable({
                    "paging": false, // Enable pagination
                    "searching": false, // Enable searching
                    "info": false, // Show table information
                });
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('catJquery') }}", // Fetch categories
                method: 'GET',
                success: function(response) {
                    var selectedCat = "{{ request('doc_cat') }}"; // Get the selected category from request
                    var select = $('#doc_cat'); // Select the dropdown element

                    $.each(response, function(index, cat) {
                        // Check if the category from the response matches the selected one
                        var isSelected = selectedCat === cat.name ? 'selected' : '';

                        // Append option with dynamic selected attribute
                        select.append('<option value="' + cat.name + '" ' + isSelected + '>' + cat.name + '</option>');
                    });
                },
                error: function() {
                    alert('Error fetching categories');
                }
            });
        });
    </script>

@endsection
