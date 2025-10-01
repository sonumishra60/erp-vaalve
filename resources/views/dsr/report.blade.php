@extends('layouts.main')

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack p-0 m-0">
            <!--begin::Page title-->
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <!--begin::Title-->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1 ml-10">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-300 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-dark">HR Report</li>
                </ul>
                <!--end::Title-->
            </div>
            <div class="d-flex align-items-center mr-20px">
                <div class="toptx"> Indicates required fields (<span class="text-danger">*</span>)</div>
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="row mb-5 mb-xl-8">
                <div class="card">
                    <div class="card-header ">
                        {{-- <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Basic Information</span>
                        </h3> --}}

                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <span style="font-weight: 500;">Attendance Report</span>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <div class="floating-label-group mb-3">
                                                <input type="text" id="attendance_from_1"
                                                    class="form-control dateselected" autocomplete="off">
                                                <label class="floating-label-new">From <span
                                                        class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="floating-label-group mb-3">
                                                <input type="text" id="attendance_to_1" class="form-control dateselected"
                                                    autocomplete="off">
                                                <label class="floating-label-new">To <span
                                                        class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="#" class="btn btn-sm btn-primary export_xlsx1"
                                                data-report="1">Export Xlsx</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <span style="font-weight: 500;">Detail Report </span>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <div class="floating-label-group mb-3">
                                                <input type="text" id="attendance_from_2"
                                                    class="form-control dateselected" autocomplete="off">
                                                <label class="floating-label-new">From <span
                                                        class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="floating-label-group mb-3">
                                                <input type="text" id="attendance_to_2" class="form-control dateselected"
                                                    autocomplete="off">
                                                <label class="floating-label-new">To <span
                                                        class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="#" class="btn btn-sm btn-primary export_xlsx2"
                                                data-report="2">Export Xlsx</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>




    <div id="overlay" class="overlay" style="display: none;">
        <div id="overlayContent" class="overlay-content">
            <span class="close">&times;</span>
            <img id="zoomedImg" src="" alt="Zoomed Image">
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.export_xlsx1').on('click', function(event) {
                event.preventDefault();

                let fromDate = $('#attendance_from_1').val().trim();
                let toDate = $('#attendance_to_1').val().trim();
                var error = 0;

                if (fromDate === '') {
                    toastr.error('Select From Date');
                    error = 1;
                }

                if (toDate === '') {
                    toastr.error('Select To Date');
                    error = 1;
                }

                if (error === 0) {
                    let url = `{{ route('attendance.export', ['from' => ':from', 'to' => ':to']) }}`;
                    url = url.replace(':from', encodeURIComponent(fromDate)).replace(':to',
                        encodeURIComponent(toDate));
                    window.location.href = url;
                }
            });

            $('.export_xlsx2').on('click', function(event) {
                event.preventDefault();

                let fromDate = $('#attendance_from_2').val().trim();
                let toDate = $('#attendance_to_2').val().trim();
                var error = 0;


                if (fromDate === '') {
                    toastr.error('Select From Date');
                    error = 1;
                }

                if (toDate === '') {
                    toastr.error('Select To Date');
                    error = 1;
                }

                if (error === 0) {
                    let url = `{{ route('dsr.export', ['from' => ':from', 'to' => ':to']) }}`;
                    url = url.replace(':from', encodeURIComponent(fromDate))
                 .replace(':to', encodeURIComponent(toDate));
                    window.location.href = url;
                }
            });


        });
    </script>
    <script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
@endsection
