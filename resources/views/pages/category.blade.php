@extends('layouts.dashboard')

@section('title', 'Category')

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
        <div class="row g-3">
            <div class="col-12 card-cs d-flex align-items-center ">
                <span class="me-3 h1 mb-0 text-secondary"><i class="fas fa-clipboard-list"></i></span>
                <h4 class="card-title"> Category </h4>
            </div>

            <div class="col-md-5 me-3">
                <div class="card-content ">
                    <form class="row g-3" method="POST" action="{{ route('category.post') }}">
                        @csrf
                        <div class="col-md-12">
                            <label for="cat_name" class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="ex:- Assignments" id="cat_name"
                                name="cat_name" autocomplete="new-password" required>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Create Category</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Display categories --}}
            <div class="col-md-6 px-0">
                <div class="card-content ">
                    @if (count($categories) > 0)
                        <div class="text-end w-100 mb-2">
                            <a href="{{ route('category.truncate') }}" class="btn btn-outline-danger"> <i
                                    class="far fa-trash-alt"></i> Delete All Categories</a>
                        </div>
                    @endif
                    <table class="table table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if ($categories && count($categories) > 0)
                            @foreach ($categories as $cat)
                                <tr>
                                    <td>{{ $cat->id }}</td>
                                    <td>{{ $cat->name }}</td>
                                    <td>
                                        <a href="{{ route('category.delete', ['id' => $cat->id]) }}"
                                            class="btn btn-danger"><i class="far fa-trash-alt"></i> Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="text-center "><b>No data found</b></td>
                            </tr>
                        @endif
                    </tbody>
                    </table>
                </div>
            </div>



        </div>
    </div>

@if( count($categories) !== 0)
<!-- Initialize DataTables -->
<script>
    $(document).ready(function() {
        $('#data-table').DataTable({
            "paging": true,         // Enable pagination
            "searching": true,      // Enable searching
            "info": true,           // Show table information
            "lengthChange": true,    // Enable the ability to change page length
            "pageLength": 5         // Set the default number of records per page
        });
    });
</script>
@endif

@endsection
