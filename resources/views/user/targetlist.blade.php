@extends('layouts.main')

@section('content')
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

                    <li class="breadcrumb-item text-dark">Target List</li>

                </ul>
                <!--end::Title-->
            </div>
            <div class="d-flex align-items-center mr-20px">
                <a href="{{ route('user.target') }}" class="btn btn-sm btn-primary"> Add Target</i></a>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->
            <div class="row   mb-xl-8">
                <div class="card">
                    <!--begin::Body-->
                    <div class="card-body py-3">

                        <div class="row">

                            <div class="col-md-10"></div>
                            <div class="col-md-2 mb-4">
                                {{-- <input type="text" name="year"  id="year"   placeholder="Select Year" class="form-control year_calender"> --}}
                            </div>
                        </div>
                        <!--begin::Table container-->
                        <div class="table-responsive ">
                            <!--begin::Table-->
                            <table class="table table-bordered  netab">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fw-bolder bg-light">

                                        <th class="w-50px text-center">Action</th>

                                        <th class="w-100px">
                                            <div class="floating-label-group">
                                                <input type="text" id="sales_person" class="form-control" required="">
                                                <label class="floating-label px">Sales Person.</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>
                                        <th class="w-100px">
                                            <div class="floating-label-group">
                                                <input type="text" id="reporting_01" class="form-control" required="">
                                                <label class="floating-label px">Reporting Manager 01</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>
                                        <th class="w-100px">
                                            <div class="floating-label-group">
                                                <input type="text" id="reporting_02" class="form-control" required="">
                                                <label class="floating-label px">Reporting Manager 02</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>
                                        <th class="w-100px">
                                            <div class="floating-label-group">
                                                <input type="text" id="reporting_03" class="form-control" required="">
                                                <label class="floating-label px">Reporting Manager 03</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>

                                        {!! $html2 !!}
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody id="tbody">

                                    {!! $html !!}
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>


                        <!--end::Table container-->
                    </div>
                    <!--begin::Body-->
                </div>
            </div>


        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
@endsection


@section('js')
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $(document).on('click', '.salestrash', function() {

                var datemon = $(this).data('id');

                $.ajax({
                    url: "{{ route('user.targetdelete') }}",
                    method: 'GET',
                    data: {
                        datemon: datemon,
                        type:'month'
                    },
                    success: function(response) {
                        if (response.status == 1) {

                            location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('error => ' + error);
                    }
                });


            });


            $(document).on('click', '.salesuserid', function() {

                var datemon = $(this).data('id');

                $.ajax({
                    url: "{{ route('user.targetdelete') }}",
                    method: 'GET',
                    data: {
                        datemon: datemon,
                        type:'userid'
                    },
                    success: function(response) {
                        if (response.status == 1) {

                            location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('error => ' + error);
                    }
                });


            });



            function searchData(searchParams) {

                $.ajax({
                    url: "{{ route('user.targetsearch') }}",
                    method: 'GET',
                    data: searchParams,
                    success: function(response) {
                        $('#tbody').empty()

                        $('#tbody').html(response);
                        //updatePagination(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('error => ' + error);
                    }
                });

            }

            $('.form-control').on('keyup', function() {
                //  alert();
                var sales_person = $('#sales_person').val().trim();
                var reporting_01 = $('#reporting_01').val().trim();
                var reporting_02 = $('#reporting_02').val().trim();
                var reporting_03 = $('#reporting_03').val().trim();

                var searchParams = {
                    sales_person: sales_person,
                    reporting_01: reporting_01,
                    reporting_02: reporting_02,
                    reporting_03: reporting_03,
                    // rowCount: 100,
                    // page: 1
                };
                searchData(searchParams);
            });

        });
    </script>
@endsection
