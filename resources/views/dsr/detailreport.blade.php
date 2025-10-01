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
                <li class="breadcrumb-item text-dark">Detail Report</li>
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
                    <div class="card-body">
                        <div class="row">
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
                                        <a href="#" class="btn btn-sm btn-primary search_xlsx2"
                                            data-report="2">Search</a>

                                        <a href="#" class="btn btn-sm btn-primary export_xlsx2"
                                            data-report="2">Export Xlsx</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>

            </div>


            <div class="card  tablecard d-none">
                <div class="card-body py-3">

                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table border table-striped">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fw-bolder bg-light">
                                    <th class="w-50px rounded-start" style="color: #5e6278;">
                                        S.No.
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="order_date_three" class="form-control form-control2 bank_check_recieved_date"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">Date</label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>

                                    <th class="w-150px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="employee_name" class="form-control form-control2"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">Employee Name</label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="employee_state"
                                                class="form-control form-control2"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">Employee State</label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="customer_code"
                                                class="form-control form-control2"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">Customer Code </label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="schedule_customer_name"
                                                class="form-control form-control2"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">Schedule Customer Name</label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>


                                    <th class="w-100px rounded-start">
                                        <!-- <div class="floating-label-group">
                                            <input type="text" id="retailor_name"
                                                class="form-control form-control2"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">Retailor Name</label>
                                            <i class="fa fa-search"></i>
                                        </div> -->

                                        <div class="d-flex">
                                        Retailor Name
                                        </div>
                                    </th>



                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="city" class="form-control form-control2"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">City</label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>

                                    <th class="w-190px rounded-start">
                                        <div class="d-flex">
                                            Schedule Call
                                        </div>

                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="d-flex">
                                            CheckIn
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="d-flex">
                                            CheckOut
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="d-flex">
                                            Timespent
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="d-flex">
                                            Activities
                                        </div>
                                    </th>

                                </tr>
                            </thead>

                            <tbody id="tbody">
                            </tbody>

                        </table>
                        <!--end::Table-->
                    </div>

                    <div class="pagen" id="pagination">
                    </div>
                    <!--end::Table container-->
                </div>
                <!--begin::Body-->
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
<script>
    $(document).ready(function() {



        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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

        $('.search_xlsx2').on('click', function(event) {

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

                $.ajax({
                    url: "{{ route('dsr.dataexport') }}",
                    method: 'POST',
                    data: {
                        fromDate: fromDate,
                        toDate: toDate
                    },
                    beforeSend: function() {
                        $('.search_xlsx2').text('Searching...').prop('disabled', true);
                    },
                    success: function(response) {
                        $('#tbody').empty();
                        var countdata = response.users.length;
                        // var countusersall = response.usersall.length;
                        if (countdata != 0) {

                            $('.tablecard').removeClass('d-none');
                            $('.search_xlsx2').text('Search').prop('disabled', false);
                            var id = 1;
                            var trusers = '';
                            $.each(response.users, function(index, value) {

                                trusers += `<tr>
                                                <td>` + id++ + `</td>
                                                <td>` + value.Date + `</td>
                                                <td>` + value.name + `</td>
                                                <td>` + value.state + `</td>
                                                <td>` + value.dist_code + `</td>
                                                <td>` + value.CustomerName + `</td>
                                                  <td>` + value.projectname + `</td>
                                                <td>` + value.city + ` </td>
                                                <td></td>
                                                <td>` + value.checkInDate + `</td>
                                                <td>` + value.checkOutDate + `</td>
                                                <td>` + value.time_spent + `</td>
                                                <td></td>
                                            </tr>`;


                            });


                            /** $.each(response.usersall, function(index, value) {

                                trusers += `<tr>
                                                 <td>` + id++ + `</td>
                                                <td>` + value.Date + `</td>
                                                <td>` + value.name + `</td>
                                                <td>` + value.state + `</td>
                                                <td>` + value.dist_code + `</td>
                                                <td>` + value.CustomerName + `</td>
                                                <td>` + value.city + ` </td>
                                                <td></td>
                                                <td>` + value.checkInDate + `</td>
                                                <td>` + value.checkOutDate + `</td>
                                                <td>` + value.time_spent + `</td>
                                                <td></td>
                                            </tr>`;

                            }); **/


                            $('#tbody').append(trusers);
                        } else {
                            var tr = `<tr>
                                        <td class="text-center" colspan="9"> No Record Found</td>
                                    </tr>`;

                            $('#tbody').append(tr);
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error('error => ' + error);
                    }
                });
            }




        });


        function searchData(searchParams) {

            $.ajax({
                url: "{{ route('dsr.dataexportsearch') }}",
                method: 'post',
                data: searchParams,
                success: function(response) {
                    $('#tbody').empty();
                    var countdata = response.users.length;
                    // var countusersall = response.usersall.length;
                    if (countdata != 0) {

                        $('.tablecard').removeClass('d-none');
                        var id = 1;
                        var trusers = '';
                        $.each(response.users, function(index, value) {

                            trusers += `<tr>
                                                <td>` + id++ + `</td>
                                                <td>` + value.Date + `</td>
                                                <td>` + value.name + `</td>
                                                <td>` + value.state + `</td>
                                                <td>` + value.dist_code + `</td>
                                                <td>` + value.CustomerName + `</td>
                                                <td>` + value.projectname + `</td>
                                                <td>` + value.city + ` </td>
                                                <td></td>
                                                <td>` + value.checkInDate + `</td>
                                                <td>` + value.checkOutDate + `</td>
                                                <td>` + value.time_spent + `</td>
                                                <td></td>
                                            </tr>`;


                        });


                        /*** $.each(response.usersall, function(index, value) {

                            trusers += `<tr>
                                                 <td>` + id++ + `</td>
                                                <td>` + value.Date + `</td>
                                                <td>` + value.name + `</td>
                                                <td>` + value.state + `</td>
                                                <td>` + value.dist_code + `</td>
                                                <td>` + value.CustomerName + `</td>
                                                <td>` + value.city + ` </td>
                                                <td></td>
                                                <td>` + value.checkInDate + `</td>
                                                <td>` + value.checkOutDate + `</td>
                                                <td>` + value.time_spent + `</td>
                                                <td></td>
                                            </tr>`;


                        }); ***/


                        $('#tbody').append(trusers);
                    } else {
                        var tr = `<tr>
                                        <td class="text-center" colspan="9"> No Record Found</td>
                                    </tr>`;

                        $('#tbody').append(tr);
                    }



                },
                error: function(xhr, status, error) {
                    console.error('error => ' + error);
                }
            });

        }


        $('.form-control2').on('keyup change', function() {
            //  alert();

            let fromDate = $('#attendance_from_2').val().trim();
            let toDate = $('#attendance_to_2').val().trim();
            var date_range = $('#order_date_three').val().trim();
            var employee_name = $('#employee_name').val().trim();
            var employee_state = $('#employee_state').val().trim();
            var customer_code = $('#customer_code').val().trim();
            var schedule_customer_name = $('#schedule_customer_name').val().trim();
            var city = $('#city').val().trim();
            var retailor_name = $('#retailor_name').val().trim();
            // var schedule_call = $('#schedule_call').val().trim();
            // var CheckIn = $('#CheckIn').val().trim();
            // var checkOut = $('#checkOut').val().trim();
            //var timespent = $('#timespent').val().trim();

            //console.log(order_date);

            var searchParams = {
                fromDate: fromDate,
                toDate: toDate,
                date_range: date_range,
                employee_name: employee_name,
                employee_state: employee_state,
                customer_code: customer_code,
                schedule_customer_name: schedule_customer_name,
                city: city,
                retailor_name:retailor_name
                //schedule_call: schedule_call,
                // CheckIn: CheckIn,
                // checkOut: checkOut,
                // timespent: timespent,
            };
            searchData(searchParams);
        });


        $('#order_date_three').on('apply.daterangepicker', function(ev, picker) {
            // Set the selected date range to the input field
            $(this).val(picker.startDate.format('DD-MMM-YYYY') + ' - ' + picker.endDate.format('DD-MMM-YYYY'));

            // Get values from the other fields
            let fromDate = $('#attendance_from_2').val().trim();
            let toDate = $('#attendance_to_2').val().trim();
            var date_range = $('#order_date_three').val().trim();
            var employee_name = $('#employee_name').val().trim();
            var employee_state = $('#employee_state').val().trim();
            var customer_code = $('#customer_code').val().trim();
            var schedule_customer_name = $('#schedule_customer_name').val().trim();
            var city = $('#city').val().trim();
            var retailor_name = $('#retailor_name').val().trim();
            //var schedule_call = $('#schedule_call').val().trim();
            // var CheckIn = $('#CheckIn').val().trim();
            // var checkOut = $('#checkOut').val().trim();
            // var timespent = $('#timespent').val().trim();

            //console.log(order_date);

            var searchParams = {
                fromDate: fromDate,
                toDate: toDate,
                date_range: date_range,
                employee_name: employee_name,
                employee_state: employee_state,
                customer_code: customer_code,
                schedule_customer_name: schedule_customer_name,
                city: city,
                retailor_name:retailor_name
                // schedule_call: schedule_call,
                // CheckIn: CheckIn,
                // checkOut: checkOut,
                // timespent: timespent,
            };

            searchData(searchParams);
        });



    });
</script>
<script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
@endsection