@extends('layouts.main')


@section('css')
    <style>
        /* -----------multi select--------- */

        .multi-select-container {
            display: inline-block;
            position: relative;
            width: 100%;
        }



        .multi-select-menu {
            position: absolute;
            left: 0;
            top: 0.8em;
            z-index: 1;
            float: left;
            min-width: 100%;
            background: #fff;
            margin: 1em 0;
            border: 1px solid #e4e6ef;
            display: none;

        }

        .multi-select-menuitem {
            display: block;
            font-size: 11px;
            padding: 0.2em 1em 0.0em 30px;
            white-space: nowrap;
            line-height: 23px;
        }

        .multi-select-legend {
            font-size: 0.875em;
            font-weight: bold;
            padding-left: 10px;
        }

        .multi-select-legend+.multi-select-menuitem {
            padding-top: 0.25rem;
        }

        .multi-select-menuitem+.multi-select-menuitem {
            padding-top: 0;
        }

        .multi-select-presets {
            border-bottom: 1px solid #ddd;
        }

        .multi-select-menuitem input {
            position: absolute;
            margin-top: 0.25em;
            margin-left: -20px;
        }

        .multi-select-button {
            display: inline-block;
            font-size: 11px;
            padding: 0.4em 0.6em;
            max-width: 100%;
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            vertical-align: -0.5em;
            background-color: #fff;
            border: 1px solid #e4e6ef;
            border-radius: 5px;
            cursor: default;
            color: #5e6278;

        }

        .multi-select-button:after {
            content: "";
            display: inline-block;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0.4em 0.4em 0 0.4em;
            border-color: #999 transparent transparent transparent;
            margin-left: 0.4em;
            vertical-align: 0.1em;
        }

        .multi-select-container--open .multi-select-menu {
            display: block;
        }

        .multi-select-container--open .multi-select-button:after {
            border-width: 0 0.4em 0.4em 0.4em;
            border-color: transparent transparent #999 transparent;
        }

        .multi-select-container--positioned .multi-select-menu {
            /* Avoid border/padding on menu messing with JavaScript width calculation */
            box-sizing: border-box;
        }

        .multi-select-container--positioned .multi-select-menu label {
            /* Allow labels to line wrap when menu is artificially narrowed */
            white-space: normal;
        }


        /* -------end multi select----------- */
    </style>
@endsection


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
                    <li class="breadcrumb-item text-dark">Add Location Data</li>

                </ul>
                <!--end::Title-->


            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            {{-- <div class="d-flex align-items-center mr-20px">
                <div class="toptx"> Indicates required fields (<span class="text-danger">*</span>)</div>
            </div> --}}
            <!--end::Actions-->
        </div>
        <!--end::Container-->
    </div>


    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->

            <div class="row mb-5 mb-xl-8">
                <div class="card">
                    <div class="card-header ">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Add City</span>
                        </h3>

                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body py-3">
                        <div class="row">
                            <div class="basic-form">
                                <form method="POST" action="#">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3 mb-3">
                                            <div class="float-select">
                                                <select class="form-select form-select-sm " id="city_statename"
                                                    data-control="select2" data-placeholder=" ">
                                                </select>
                                                <label class="new-labels"> Select State </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 mb-3">
                                            <div class="floating-label-group">
                                                <input type="text" id="locationname" class="form-control" required="">
                                                <label class="floating-label px">City</label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 mb-3">
                                            <a href="#" class="btn btn-sm btn-primary addcity">
                                                Save </a>
                                        </div>

                                    </div>

                                </form>
                            </div>

                        </div>

                    </div>
                    <!--begin::Body-->
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->

            <div class="row mb-5 mb-xl-8">
                <div class="card">
                    <div class="card-header ">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Add District</span>
                        </h3>

                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body py-3">
                        <div class="row">
                            <div class="basic-form">
                                <form method="POST" action="#">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3 mb-3">
                                            <div class="float-select">
                                                <select class="form-select form-select-sm" id="district_statename"
                                                    data-control="select2" data-placeholder=" ">
                                                </select>
                                                <label class="new-labels"> Select State </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 mb-3">
                                            <div class="float-select">
                                                <select class="form-select form-select-sm" id="district_cityname"
                                                    data-control="select2" data-placeholder=" ">
                                                </select>
                                                <label class="new-labels"> Select City </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 mb-3">
                                            <div class="floating-label-group">
                                                <input type="text" id="districtname" class="form-control"
                                                    required="">
                                                <label class="floating-label px">District</label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 mb-3">
                                            <a href="#"
                                                class="btn btn-sm btn-primary adddistrict">
                                                Save </a>
                                        </div>

                                    </div>

                                </form>
                            </div>

                        </div>

                    </div>
                    <!--begin::Body-->
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->

            <div class="row mb-5 mb-xl-8">
                <div class="card">
                    <div class="card-header ">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Add Zone</span>
                        </h3>

                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body py-3">
                        <div class="row">
                            <div class="basic-form">
                                <form method="POST" action="#">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3 mb-3">
                                            <div class="float-select">
                                                <select class="form-select form-select-sm statename" 
                                                    data-control="select2" id="zone_statename" data-placeholder=" ">
                                                </select>
                                                <label class="new-labels"> Select State </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 mb-3">
                                            <div class="float-select">
                                                <select class="form-select form-select-sm" id="zone_cityname"
                                                    data-control="select2" data-placeholder=" ">
                                                </select>
                                                <label class="new-labels"> Select City </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 mb-3">
                                            <div class="float-select">
                                                <select class="form-select form-select-sm" id="zone_district"
                                                    data-control="select2" data-placeholder=" ">
                                                </select>
                                                <label class="new-labels"> Select District </label>
                                            </div>
                                        </div>


                                    <div class="col-sm-2 mb-3">
                                            <div class="floating-label-group">
                                                <input type="text" id="zone" class="form-control"
                                                    required="">
                                                <label class="floating-label px">Zone</label>
                                            </div>
                                        </div>

                                        <div class="col-sm-2 mb-3">
                                            <a href="#" class="btn btn-sm btn-primary addzone">
                                                Save </a>
                                        </div>

                                    </div>

                                </form>
                            </div>

                        </div>

                    </div>
                    <!--begin::Body-->
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
@endsection


@section('js')
    <script>
        
        funlocation().done(function(response) {
            var data = response.data;
            var options = '<option value="" >Select State</option>';
            $.each(data, function(key, value) {
                options += '<option value="' + value.cityId + '" >' + value.cityName +
                    '</option>';
            });

            $('#city_statename').empty().append(options);
            $('#district_statename').empty().append(options);
            $('#zone_statename').empty().append(options);
        });

        $(document).ready(function() {

            $('#district_statename').change(function() {
                var statname_id = $(this).val();
                if (statname_id) {
                    funcitybysate(statname_id).done(function(roles) {
                        var data = roles.data;
                        var options = '<option value="">Select City Name</option>';
                        $.each(data, function(key, value) {
                            options += '<option value="' + value.cityId + '">' + value
                                .cityName + '</option>';
                        });
                        $('#district_cityname').empty().append(options);
                    });
                } else {
                    $('#district_cityname').empty().append('<option value="">Select Role</option>');
                }
            });

            $('#zone_statename').change(function() {
                var statname_id = $(this).val();
                if (statname_id) {
                    funcitybysate(statname_id).done(function(roles) {
                        var data = roles.data;
                        var options = '<option value="">Select City Name</option>';
                        $.each(data, function(key, value) {
                            options += '<option value="' + value.cityId + '">' + value
                                .cityName + '</option>';
                        });
                        $('#zone_cityname').empty().append(options);
                    });
                } else {
                    $('#zone_cityname').empty().append('<option value="">Select Role</option>');
                }
            });

            $('#zone_cityname').change(function() {
                var statname_id = $(this).val();
                if (statname_id) {
                    funcitybysate(statname_id).done(function(roles) {
                        var data = roles.data;
                        var options = '<option value="">Select District Name</option>';
                        $.each(data, function(key, value) {
                            options += '<option value="' + value.cityId + '">' + value
                                .cityName + '</option>';
                        });
                        $('#zone_district').empty().append(options);
                    });
                } else {
                    $('#zone_district').empty().append('<option value="">Select District</option>');
                }
            });

            $('.addcity').on('click', function() {
                var locationname = $('#locationname').val();
                var statename = $('#city_statename').val();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                if (locationname == '') {
                    toastr.error('Enter Location');
                }

                if (locationname != '') {
                    $(this).prop('disabled', true);
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('location.submit') }}", // Replace with your server endpoint
                        data: {
                            location: locationname,
                            statename: statename,
                            _token: csrfToken
                        },
                        success: function(response) {
                            // console.log(response.msg); 
                            var resp = response.resp;
                            var msg = response.msg;

                            if (resp === 1) {
                                toastr.success(msg);
                                location.reload();
                            } else {
                                toastr.error(msg);
                            }

                        }
                    });

                }


            });

            $('.adddistrict').on('click', function() {
                var districtname = $('#districtname').val();
                var statename = $('#district_cityname').val();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                if (districtname == '') {
                    toastr.error('Enter District Name');
                }

                if (districtname != '') {

                    $(this).prop('disabled', true);

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('location.submit') }}", // Replace with your server endpoint
                        data: {
                            location: districtname,
                            statename: statename,
                            _token: csrfToken
                        },
                        success: function(response) {
                            // console.log(response.msg); 
                            var resp = response.resp;
                            var msg = response.msg;

                            if (resp === 1) {
                                toastr.success(msg);
                                location.reload();
                            } else {
                                toastr.error(msg);
                            }

                        }
                    });

                }


            });

            $('.addzone').on('click', function() {
                var zone = $('#zone').val();
                var statename = $('#zone_district').val();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                if (zone == '') {
                    toastr.error('Enter District Name');
                }

                if (zone != '') {
                    $(this).prop('disabled', true);

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('location.submit') }}", // Replace with your server endpoint
                        data: {
                            location: zone,
                            statename: statename,
                            _token: csrfToken
                        },
                        success: function(response) {
                            // console.log(response.msg); 
                            var resp = response.resp;
                            var msg = response.msg;

                            if (resp === 1) {
                                toastr.success(msg);
                                location.reload();
                            } else {
                                toastr.error(msg);
                            }

                        }
                    });

                }


            });



        });
    </script>
@endsection
