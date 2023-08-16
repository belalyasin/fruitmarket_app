<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('cms.app_name') }} | @yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('cms/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('cms/dist/css/adminlte.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('cms/plugins/toastr/toastr.min.css') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('cms/dist/img/img.png')}}">
    @yield('styles')
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{asset('cms/dist/img/img.png')}}" alt="AdminLTELogo" height="60"
             width="60">
        <h2 class="text-success text-center text-bold">Fruit Market</h2>
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                        class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{route('dashboard')}}" class="nav-link">Home</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            {{-- <ul class="navbar-nav ml-auto"> --}}
            {{-- <li class="nav-item dropdown" style="cursor:pointer;">
                <div class="align-items-center">
                    <img src="{{ asset('cms/dist/img/avataryalow.png') }}" alt="User Avatar"
                        class="mr-2 mt-1 img-size-32 img-circle mr-2">
                    <div class="media-body">
                        <h6 class="dropdown-item-title text-dark" style="font-size: 14px">
                            {{ auth()->user()->name }}
                        </h6>
                    </div>
                </div>
                <ul class="dropdown-menu" style="width:200px">
                    <li class="user-header mb-1" style="height: 140px;">
                        <img class="profile-user-img img-fluid img-circle"
                            src="{{ asset('cms/dist/img/avataryalow.png') }}" alt="User profile picture">
                        <p class="mb-0">
                            {{ auth()->user()->name }}
                        </p>
                    </li>
                    <li class="user-footer d-flex justify-content-between">
                        <div class="pull-left">
                            <a href="" class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('auth.logout') }}" class="btn btn-default btn-flat"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">Sign
                                out</a>
                            <form id="logout-form" action="{{ route('auth.logout') }}" method="GET"
                                class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </li> --}}
            {{-- </ul> --}}
            <!-- Messages Dropdown Menu -->
            {{--            <li class="nav-item dropdown">--}}
            {{--                <a class="nav-link" data-toggle="dropdown" href="#">--}}
            {{--                    <img src="{{ asset('cms/dist/img/avataryalow.png') }}" alt="User Avatar"--}}
            {{--                         class="mr-2 img-size-32 img-circle mr-2">--}}
            {{--                </a>--}}
            {{--                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right align-content-center">--}}
            {{--                    <ul style="width:200px; list-style-type:none;">--}}
            {{--                        <li class="user-header mb-1 d-flex flex-column justify-content-center" style="height: 140px;">--}}
            {{--                            <img class="profile-user-img img-fluid img-circle"--}}
            {{--                                 src="{{ asset('cms/dist/img/avataryalow.png') }}" alt="User profile picture">--}}
            {{--                            <p class="mb-0 text-center">--}}
            {{--                                {{ auth()->user()->name }}--}}
            {{--                            </p>--}}
            {{--                        </li>--}}
            {{--                        <li class="user-footer d-flex justify-content-between pb-3">--}}
            {{--                            <div class="pull-left">--}}
            {{--                                <a href="" class="btn btn-default btn-flat">Profile</a>--}}
            {{--                            </div>--}}
            {{--                            <div class="pull-right">--}}
            {{--                                <a href="{{ route('auth.logout') }}" class="btn btn-default btn-flat"--}}
            {{--                                   onclick="event.preventDefault();--}}
            {{--                                        document.getElementById('logout-form').submit();">Sign--}}
            {{--                                    out</a>--}}
            {{--                                <form id="logout-form" action="{{ route('auth.logout') }}" method="POST"--}}
            {{--                                      class="d-none">--}}
            {{--                                    @csrf--}}
            {{--                                </form>--}}
            {{--                            </div>--}}
            {{--                        </li>--}}
            {{--                    </ul>--}}
            {{--                </div>--}}
            {{--            </li>--}}
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="{{asset('images/'.auth()->user()->profile_image)}}"
                         class="user-image img-circle elevation-2"
                         alt="User Image">
                    <span class="d-none d-md-inline">{{auth()->user()->name}}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                    <!-- User image -->
                    <li class="user-header bg-primary">
                        <img src="{{asset('images/'.auth()->user()->profile_image)}}" class="img-circle elevation-2"
                             alt="User Image">

                        <p>
                            {{auth()->user()->name}}
                            <small>{{auth()->user()->email}}</small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <a href="{{route('admin.admin_profile')}}" class="btn btn-default btn-flat">Profile</a>
                        <a href="{{ route('auth.logout') }}" class="btn btn-default btn-flat float-right"
                           onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            Sign out
                            <i class="nav-icon fas fa-sign-out-alt text-danger ml-1"></i>
                        </a>
                        {{--                        --}}
                        <form id="logout-form" action="{{ route('auth.logout') }}" method="POST"
                              class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        {{-- <a href="index3.html" class="brand-link">
    <img src="{{asset('cms/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
      class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">AdminLTE 3</span>
  </a> --}}

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{asset('images/'.auth()->user()->profile_image)}}" class="img-circle elevation-2"
                         alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                </div>
            </div>

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                           aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
                    <li class="nav-item menu-open">
                        <a href="{{route('dashboard')}}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Starter Pages
                                {{--                                <i class="right fas fa-angle-left"></i>--}}
                            </p>
                        </a>
                    </li>

                    {{--                        @canany(['Create-Role', 'Read-Roles', 'Create-Permission', 'Read-Permissions'])--}}
                    <li class="nav-header">{{ __('cms.products') }}</li>
                    {{--                            @canany(['Create-Role', 'Read-Roles'])--}}
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-barcode"></i>
                            <p>
                                {{ __('cms.products') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: none;">
                            {{--                                        @can('Read-Roles')--}}
                            <li class="nav-item">
                                <a href="{{ route('products.index') }}" class="nav-link">
                                    <i class="fas fa-stream nav-icon"></i>
                                    <p>{{ __('cms.index') }}</p>
                                </a>
                            </li>
                            {{--                                        @endcan--}}
                            {{--                                        @can('Create-Role')--}}
                            <li class="nav-item">
                                <a href="{{ route('products.create') }}" class="nav-link">
                                    <i class="far fa-plus-square nav-icon"></i>
                                    <p>{{ __('cms.create') }}</p>
                                </a>
                            </li>
                            {{--                                        @endcan--}}
                        </ul>
                    </li>

                    <li class="nav-header">{{ __('cms.category') }}</li>
                    {{--                            @canany(['Create-Role', 'Read-Roles'])--}}
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cube"></i>
                            {{--                            <i class="fa-duotone fa-shapes"></i>--}}
                            <p>
                                {{ __('cms.category') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: none;">
                            {{--                                        @can('Read-Roles')--}}
                            <li class="nav-item">
                                <a href="{{ route('categories.index') }}" class="nav-link">
                                    <i class="fas fa-stream nav-icon"></i>
                                    <p>{{ __('cms.index') }}</p>
                                </a>
                            </li>
                            {{--                                        @endcan--}}
                            {{--                                        @can('Create-Role')--}}
                            <li class="nav-item">
                                <a href="{{ route('categories.create') }}" class="nav-link">
                                    <i class="far fa-plus-square nav-icon"></i>
                                    <p>{{ __('cms.create') }}</p>
                                </a>
                            </li>
                            {{--                                        @endcan--}}
                        </ul>
                    </li>

                    <li class="nav-header">{{ __('cms.sub_category') }}</li>
                    {{--                            @canany(['Create-Role', 'Read-Roles'])--}}
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cubes"></i>
                            <p>
                                {{ __('cms.sub_category') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: none;">
                            {{--                                        @can('Read-Roles')--}}
                            <li class="nav-item">
                                <a href="{{ route('subCategories.index') }}" class="nav-link">
                                    <i class="fas fa-stream nav-icon"></i>
                                    <p>{{ __('cms.index') }}</p>
                                </a>
                            </li>
                            {{--                                        @endcan--}}
                            {{--                                        @can('Create-Role')--}}
                            <li class="nav-item">
                                <a href="{{ route('subCategories.create') }}" class="nav-link">
                                    <i class="far fa-plus-square nav-icon"></i>
                                    <p>{{ __('cms.create') }}</p>
                                </a>
                            </li>
                            {{--                                        @endcan--}}
                        </ul>
                    </li>
                    <li class="nav-header">{{ __('cms.nutrition') }}</li>
                    {{--                            @canany(['Create-Role', 'Read-Roles'])--}}
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tablets"></i>
                            <p>
                                {{ __('cms.nutrition') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: none;">
                            {{--                                        @can('Read-Roles')--}}
                            <li class="nav-item">
                                <a href="{{ route('nutritions.index') }}" class="nav-link">
                                    <i class="fas fa-stream nav-icon"></i>
                                    <p>{{ __('cms.index') }}</p>
                                </a>
                            </li>
                            {{--                                        @endcan--}}
                            {{--                                        @can('Create-Role')--}}
                            <li class="nav-item">
                                <a href="{{ route('nutritions.create') }}" class="nav-link">
                                    <i class="far fa-plus-square nav-icon"></i>
                                    <p>{{ __('cms.create') }}</p>
                                </a>
                            </li>
                            {{--                                        @endcan--}}
                        </ul>
                    </li>
                    {{--                            @endcanany--}}

                    {{--                            @canany(['Create-Permission', 'Read-Permission'])--}}
                    {{--                                <li class="nav-item">--}}
                    {{--                                    <a href="#" class="nav-link">--}}
                    {{--                                        <i class="nav-icon fas fa-circle"></i>--}}
                    {{--                                        <p>--}}
                    {{--                                            {{ __('cms.permissions') }}--}}
                    {{--                                            <i class="right fas fa-angle-left"></i>--}}
                    {{--                                        </p>--}}
                    {{--                                    </a>--}}
                    {{--                                    <ul class="nav nav-treeview" style="display: none;">--}}
                    {{--                                        @can('Read-Permissions')--}}
                    {{--                                            <li class="nav-item">--}}
                    {{--                                                <a href="{{ route('permissions.index') }}" class="nav-link">--}}
                    {{--                                                    <i class="far fa-circle nav-icon"></i>--}}
                    {{--                                                    <p>{{ __('cms.index') }}</p>--}}
                    {{--                                                </a>--}}
                    {{--                                            </li>--}}
                    {{--                                        @endcan--}}
                    {{--                                        @can('Create-Permission')--}}
                    {{--                                            <li class="nav-item">--}}
                    {{--                                                <a href="{{ route('permissions.create') }}" class="nav-link">--}}
                    {{--                                                    <i class="far fa-circle nav-icon"></i>--}}
                    {{--                                                    <p>{{ __('cms.create') }}</p>--}}
                    {{--                                                </a>--}}
                    {{--                                            </li>--}}
                    {{--                                        @endcan--}}
                    {{--                                    </ul>--}}
                    {{--                                </li>--}}
                    {{--                            @endcanany--}}
                    {{--                        @endcanany--}}


                    @canany(['Create-Admin', 'Read-Admins', 'Create-User', 'Read-Users'])
                        <li class="nav-header">{{ __('cms.hr') }}</li>
                        @canany(['Create-User', 'Read-Users'])
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-circle"></i>
                                    <p>
                                        {{ __('cms.users') }}
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview" style="display: none;">
                                    @can('Read-Users')
                                        <li class="nav-item">
                                            <a href="{{ route('users.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>{{ __('cms.index') }}</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('Create-User')
                                        <li class="nav-item">
                                            <a href="{{ route('users.create') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>{{ __('cms.create') }}</p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany
                        @canany(['Create-Admin', 'Read-Admins'])
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-circle"></i>
                                    <p>
                                        {{ __('cms.admins') }}
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview" style="display: none;">
                                    @can('Read-Admins')
                                        <li class="nav-item">
                                            <a href="{{ route('admins.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>{{ __('cms.index') }}</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('Create-Admin')
                                        <li class="nav-item">
                                            <a href="{{ route('admins.create') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>{{ __('cms.create') }}</p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany
                    @endcanany


                    <li class="nav-header">{{ __('cms.settings') }}</li>
                    <li class="nav-item">
                        <a href="{{ route('auth.logout') }}" class="nav-link"
                           onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                            <p class="text">{{ __('cms.logout') }}</p>
                        </a>
                        <form id="logout-form" action="{{ route('auth.logout') }}" method="POST"
                              class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page_name')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="@yield('redirect_page')">@yield('main_page')</a></li>
                            <li class="breadcrumb-item active">@yield('small_page_name')</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        @yield('main-content')
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        {{--        <div class="float-right d-none d-sm-inline">--}}
        {{--            Anything you want--}}
        {{--        </div>--}}
        <!-- Default to the left -->
        <strong>Copyright &copy; 2012-2023 <a href="#">Fruit Market-app</a>.</strong> All rights
        reserved.
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('cms/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('cms/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('cms/dist/js/adminlte.min.js') }}"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>--}}
<script src="{{asset('js/axios.js')}}"></script>
<script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>
@yield('scripts')
</body>

</html>
