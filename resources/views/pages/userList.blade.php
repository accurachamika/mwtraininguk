@extends('layouts.dashboard')

@section('title' , 'User List')

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<!-- Sales Chart Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12 card-cs d-flex justify-content-between align-items-center">
          <div class="d-flex align-items-center">
              <span class="me-3 h1 mb-0 text-secondary"><i class="fas fa-address-card"></i></span>
              <h3 class="card-title"> User List</h3>
          </div>
      </div>
      <div class="card-content text-end">
        <a href="{{route('migrateUsers')}}" class="btn btn-outline-success">Migrate Users</a>

        <a href="{{route('truncateUsers')}}" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete all users? This action cannot be undone.');">Delete All Users</a>
        <a href="{{route('bulk_activate')}}" class="btn btn-outline-info">User Bulk Activation</a>
      
        </div>
      @if($users)
      <div class="card-content" style="max-width: 100%; overflow-x: auto">
        <table class="table" id="data-table" style="width: 100%; table-layout: auto; white-space: nowrap;">
            <thead>
                <tr>
                    <th>
                        User Name 
                    </th>
                    <th>
                        User Role 
                    </th>
                    <th>
                        Account Status
                    </th>
                    <th>
                        Action
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>
                        {{$user->user_name}}
                    </td>
                    <td>
                        {{$user->user_type}}
                    </td>
                    <td>
                        @if($user->active === 0)
                            <span class="badge text-danger">Deactivated</span>
                        @else
                            <span class="badge text-success">Activated</span>
                        @endif
                    </td>
                    <td>
                        @if($user->active !== 0)
                            <a href="{{route('acc_activate' , ['id' => $user->user_id])}}" class="btn btn-danger">Deactivate</a>
                        @else
                            <a href="{{route('acc_activate' , ['id' => $user->user_id])}}" class="btn btn-success">Activate</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
      </div>
      @endif
</div>
</div>

@if( count($users) !== 0)
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

