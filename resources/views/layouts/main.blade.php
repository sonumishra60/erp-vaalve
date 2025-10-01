<!DOCTYPE html>
<html lang="en">
<head>
    <base href="">
    <title>Dashboard | Vaalve</title>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <link rel="shortcut icon" href="{{ URL::asset('assets/media/logos/favicon.png')}}" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <link href="{{ URL::asset('assets/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/toastr.css')}}" rel="stylesheet" />
    @yield('css')
</head>
<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    <div class="d-flex flex-column flex-root box target">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
          
            <!--begin::Aside-->
            @include('layouts.sidebar')
            <!--end::Aside-->
         
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
               
                <!--begin::Header-->
                @include('layouts.header')
                <!--end::Header-->

                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    @yield('content')
                </div>
                <!--end::Content-->
                
                <!--begin::Footer-->
                <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
                    <!--begin::Container-->
                    <div
                        class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <!--begin::Copyright-->
                        <div class="text-dark order-2 order-md-1">
                            <span class="text-muted fw-bold me-1">Copyright © 2024 Designed & Developed by</span>
                            <a href="#" target="_blank" class="text-gray-800 text-hover-primary">MIS  Work</a>
                        </div>
                        <!--end::Copyright-->
                      
                        <!--begin::Menu-->

                        <!--end::Menu-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    
    @include('layouts.footer')
    @yield('js')
</body>
<!--end::Body-->

</html>
