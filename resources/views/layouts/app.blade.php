<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>School Mangement System</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="icon" type="image/x-icon" href="{{asset('images/favicon.ico')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">


    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">

    {{-- date range picker --}}
    {{-- <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}"> --}}

    {{-- data table --}}
    <!-- DataTable -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.css">

    @yield('styles')

</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
     <!-- Navbar -->
        @include('layouts.navbar')
        <!-- /.navbar -->

        <!-- Sidebar -->
        @include('layouts.sidebar')
        <!-- /.sidebar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            @yield('content')

        </div>

        {{-- @include('layouts.footer') --}}


        <!-- jQuery -->
        <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{asset('dist/js/adminlte.min.js')}}"></script>

        {{-- date range picker --}}
        {{-- <script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script> --}}

        {{-- datatable --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap4.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        
        <script>
                @if (Session::has('message'))
                    var type = "{{ Session::get('alert-type', 'info') }}"
                    switch (type) {
                        case 'info':

                            toastr.options.timeOut = 5000;
                            toastr.info("{{ Session::get('message') }}");
                           
                            break;
                        case 'success':

                            toastr.options.timeOut = 5000;
                            toastr.success("{{ Session::get('message') }}");
                           

                            break;
                        case 'warning':

                            toastr.options.timeOut = 5000;
                            toastr.warning("{{ Session::get('message') }}");
                           

                            break;
                        case 'error':

                            toastr.options.timeOut = 5000;
                            toastr.error("{{ Session::get('message') }}",);
                           

                            break;
                    }
                    {{Session::forget('message')}}
                @endif

                $('#examSubmit').click(function (e) {

                    $("#examResults").submit();

                });

        </script>


    </div>

    @yield('scripts')

</body>
</html>
