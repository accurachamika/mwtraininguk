<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Document Management System')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.1.6/css/dataTables.bootstrap5.css" rel="stylesheet">


    <!-- Template Stylesheet -->
    <link  rel="stylesheet" href="{{url('assets/CSS/theme-style.css')}}">
    <link  rel="stylesheet" href="{{url('assets/CSS/style.css')}}">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0 m-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">

                <a href="{{route('home')}}" class="navbar-brand mx-4 mb-3 text-center">
                    <h4 class="text-primary text-lowercase">mwTRAININGuk</h4>
                </a>

                <div class="navbar-nav w-100">
                    <a href="{{route('home')}}" class="nav-item nav-link {{Route::is('home')? 'active' : ''}}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>

                    @if(Auth::user()->user_type === 'admin')
                    <a href="{{route('userlist')}}" class="nav-item nav-link {{Route::is('userlist')? 'active' : ''}}"><i class="fas fa-users"></i>User List</a>
                    <a href="{{route('search')}}" class="nav-item nav-link {{Route::is('search')? 'active' : ''}}"><i class="fas fa-search"></i>Search</a>
                    <a href="{{route('category')}}" class="nav-item nav-link {{Route::is('category')? 'active' : ''}}"><i class="fas fa-clipboard-list"></i>Category</a>
                    <a href="{{route('upload')}}" class="nav-item nav-link {{Route::is('upload')? 'active' : ''}}"><i class="fas fa-file-upload"></i>Upload</a>
                    <a href="{{route('manage')}}" class="nav-item nav-link {{Route::is('manage')? 'active' : ''}}"><i class="fas fa-tasks"></i>Manage</a>

                    @else
                    <a href="{{route('stdManage')}}" class="nav-item nav-link {{Route::is('manage')? 'active' : ''}}"><i class="fas fa-tasks"></i>View Documents</a>
                    @endif
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">

            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0 shadow-sm">
                <button type="button" class="border-none sidebar-toggler">
                    <i class="fas fa-bars shadow-sm"></i>
                </button>
                <div class="navbar-nav align-items-center ms-auto">

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="{{url('assets/images/user-img.jpg')}}" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex" style="text-transform: capitalize; font-weight: bold">{{Auth::user()->user_name}}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-dark border-0 rounded m-0 mt-2">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a href="{{route('logout')}}" class="dropdown-item text-light" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="fas fa-sign-out-alt"></i> Log Out</a>
                        </div>


                    </div>
                </div>
            </nav>
            <!-- Navbar End -->


            @yield('content')

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-3">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-12 text-center text-sm-center">
                            &copy;<b>2024</b> <br>Design by <b> HAAS Solutions</b>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script>

    <!-- Template Javascript -->
    <script src="{{url('assets/js/main.js')}}"></script>
</body>

</html>
