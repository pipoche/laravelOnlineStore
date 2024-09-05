<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link rel="shortcut icon" href="{{ asset('dashboardassets/images/favicon.ico') }}">

    <link href="{{ asset('dashboardassets/libs/chartist/chartist.min.css') }}" rel="stylesheet">

    <!-- Bootstrap Css -->
    <link href="{{ asset('dashboardassets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css">
    <!-- Icons Css -->
    <link href="{{ asset('dashboardassets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{ asset('dashboardassets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css">

    
   @yield('dashboardcss')


</head>

<body data-sidebar="dark">
    <div id="layout-wrapper">


        @include('dashboard.dashboardnav')
        <!-- ========== Left Sidebar Start ========== -->
        @include('dashboard.dashboardside')




        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">



                    @yield('pagecontent')
                </div>
            </div>

            @include('dashboard.dashboardfooter')



        </div>
        <!-- end main content-->

    </div>



    <!-- JAVASCRIPT -->
    <script src="{{ asset('dashboardassets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dashboardassets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dashboardassets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('dashboardassets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('dashboardassets/libs/node-waves/waves.min.js') }}"></script>


    <!-- Peity chart-->
    <script src="{{ asset('dashboardassets/libs/peity/jquery.peity.min.js') }}"></script>

    <!-- Plugin Js-->
    <script src="{{ asset('dashboardassets/libs/chartist/chartist.min.js') }}"></script>
    <script src="{{ asset('dashboardassets/libs/chartist-plugin-tooltips/chartist-plugin-tooltip.min.js') }}"></script>

    <script src="{{ asset('dashboardassets/js/pages/dashboard.init.js') }}"></script>
    <script src="{{ asset('dashboardassets/js/app.js') }}"></script>

    <script src="{{ asset('dashboardassets/libs/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('dashboardassets/js/pages/form-advanced.init.js')}}"></script>



    @yield('dashboardscripts')



</body>

</html>
