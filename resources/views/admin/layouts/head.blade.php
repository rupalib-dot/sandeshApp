<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{env('APP_NAME')}} </title>

    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('logo/favicon/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('logo/favicon/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('logo/favicon/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('logo/favicon/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('logo/favicon/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('logo/favicon/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('logo/favicon/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('logo/favicon/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('logo/favicon/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{asset('logo/favicon/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('logo/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('logo/favicon/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('logo/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('logo/favicon/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{asset('/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">

    <!-- plugins:css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <link rel="stylesheet" href="{{asset('assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/vendors/iconfonts/ionicons/dist/css/ionicons.css') }}">
    <link rel="stylesheet" href="{{asset('assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{asset('assets/vendors/css/vendor.bundle.addons.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->

    <link rel="stylesheet" href="{{asset('assets/css/shared/style.css') }}">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset('assets/css/demo_1/style.css') }}">
    <!-- End Layout styles -->
</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
            <a class="navbar-brand brand-logo" href="{{ route('sitehome') }}">
                <img src="{{asset('logo/sandeshlogo.svg') }}" alt="logo" /> </a>
            <a class="navbar-brand brand-logo-mini" href="{{ route('sitehome') }}">
                <img src="{{asset('logo/favicon/favicon-96x96.png') }}" alt="logo" /> </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
            </button>
        </div>
    </nav>

    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas pt-5" id="sidebar">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admindashboard') }}">
                        <i class="menu-icon typcn typcn-document-text"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.users.index')}}">
                        <i class="menu-icon typcn typcn-user-outline"></i>
                        <span class="menu-title">Manage Users</span>
                    </a>
                </li>

                @if(Auth::user()->userRole->pluck('name')->toArray()[0] != 'subAdmin')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.subadmin.index')}}">
                        <i class="menu-icon typcn typcn-user-outline"></i>
                        <span class="menu-title">SubAdmin</span>
                    </a>
                </li>
                @endif

                @if(Auth::user()->userRole->pluck('name')->toArray()[0] != 'subAdmin')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.template.index')}}">
                        <i class="menu-icon typcn typcn-user-outline"></i>
                        <span class="menu-title">Templates</span>
                    </a>
                </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.posts.index')}}">
                        <i class="menu-icon typcn typcn-user-outline"></i>
                        <span class="menu-title">Posts</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.logfiles.index')}}">
                        <i class="menu-icon typcn typcn-user-outline"></i>
                        <span class="menu-title">Manage Log Files</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="menu-icon typcn typcn-user-outline"></i>
                        <span class="menu-title">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

                <li class="nav-item d-none">
                    <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                        <i class="menu-icon typcn typcn-coffee"></i>
                        <span class="menu-title">Basic UI Elements</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages/ui-features/dropdowns.html">Dropdowns</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages/ui-features/typography.html">Typography</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item d-none">
                    <a class="nav-link" href="pages/forms/basic_elements.html">
                        <i class="menu-icon typcn typcn-shopping-bag"></i>
                        <span class="menu-title">Form elements</span>
                    </a>
                </li>
                <li class="nav-item d-none">
                    <a class="nav-link" href="pages/charts/chartjs.html">
                        <i class="menu-icon typcn typcn-th-large-outline"></i>
                        <span class="menu-title">Charts</span>
                    </a>
                </li>
                <li class="nav-item d-none">
                    <a class="nav-link" href="pages/tables/basic-table.html">
                        <i class="menu-icon typcn typcn-bell"></i>
                        <span class="menu-title">Tables</span>
                    </a>
                </li>
                <li class="nav-item d-none">
                    <a class="nav-link" href="pages/icons/font-awesome.html">
                        <i class="menu-icon typcn typcn-user-outline"></i>
                        <span class="menu-title">Icons</span>
                    </a>
                </li>
                <li class="nav-item d-none">
                    <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="menu-icon typcn typcn-document-add"></i>
                        <span class="menu-title">User Pages</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="auth">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="pages/samples/blank-page.html"> Blank Page </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages/samples/login.html"> Login </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages/samples/register.html"> Register </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages/samples/error-404.html"> 404 </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pages/samples/error-500.html"> 500 </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
