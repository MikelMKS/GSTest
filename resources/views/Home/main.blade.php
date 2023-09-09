<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GSTEST - {{$windTit}}</title>
    <link href="{{url('img/logo.png')}}" rel="icon">

    {{-- Template Main CSS File --}}
    <link href="{{url('css/main.css')}}" rel="stylesheet">

      <!-- Vendor CSS Files -->
  <link href="{{url('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{url('vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{url('vendor/remixicon/remixicon.css')}}" rel="stylesheet">

    {{-- Multiple Functions JS --}}
    <script src="{{url('js/functions.js')}}"></script>

    {{-- JQuey Lib --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    {{-- Sweet Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- DataTable Lib --}}
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.2/b-2.3.4/b-colvis-2.3.4/b-html5-2.3.4/b-print-2.3.4/datatables.min.css"/>

    {{-- Select2 Lib --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body class="toggle-sidebar">
    <header id="header" class="header fixed-top d-flex align-items-center">
        {{-- Logo --}}
        <div class="d-flex align-items-center justify-content-between">
            <i class="bi bi-list toggle-sidebar-btn"></i>
            &nbsp;&nbsp;
            <a href="{{ route('home') }}" class="logo d-flex align-items-center">
                <img src="{{url('img/logo.png')}}" alt="">
            </a>
        </div>


        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                {{-- Notifications --}}
                <a class="nav-link nav-icon" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <span class="badge bg-primary badge-number"></span>
                </a>

                {{-- Profile section file --}}
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="https://www.linkedin.com/in/mikel-ms/" target="_blank">
                        <img src="{{url('img/mikel.jpeg')}}" alt="Profile" class="rounded-circle">
                        <span class="ps-2">Mikel Ruiz</span>
                    </a>
                </li>
            </ul>
        </nav>

    </header>

    {{-- Sidebar Options List --}}
    @php
        $sections = array(
            ['name' => 'Home','route' => 'home','icon' => 'ri-home-2-line'],
            ['name' => 'Notifications','route' => 'notifications','icon' => ' ri-mail-send-line']
        );
    @endphp

    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            @foreach ($sections as $s)
                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route($s['route']) }}">
                        <i class="{{$s['icon']}}"></i>
                        <span>{{$s['name']}}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </aside>

    {{-- Main Pages Content --}}
    <main id="main" class="main">

        <div class="pagetitle">
            <section class="wrapper">
                <div>{{$windTit}}</div>
            </section>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            {{-- Content Views Section --}}
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

</body>

<!-- Template Main JS File -->
<script src="{{url('js/main.js')}}"></script>
<script src="{{url('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<script type="text/javascript">
</script>

</html>
