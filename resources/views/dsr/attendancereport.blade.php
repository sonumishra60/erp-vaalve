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
                <li class="breadcrumb-item text-dark">Attendance Report </li>
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
                                        <a href="#" class="btn btn-sm btn-primary search_xlsx1"
                                            data-report="1">Search</a>

                                        <a href="#" class="btn btn-sm btn-primary export_xlsx1"
                                            data-report="1">Export Xlsx</a>
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
                                            <input type="text" id="order_date_four" class="form-control form-control2"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">Date</label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>

                                    <th class="w-150px rounded-start">
                                        <div class="d-flex">
                                            Day
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="state"
                                                class="form-control form-control2 "
                                                autocomplete="off" required="">
                                            <label class="floating-label px">State </label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="employee_name"
                                                class="form-control form-control2 bank_check_recieved_date"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">First Name</label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="d-flex">
                                            Reporting Manager
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="d-flex">
                                            Reporting Manager Code
                                        </div>
                                    </th>

                                    <th class="w-190px rounded-start">
                                        <div class="d-flex">
                                            Designation Doer
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="employee_code" class="form-control form-control2"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">Employee Code </label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="employee_email" class="form-control form-control2"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">Employee Email </label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="employee_phone" class="form-control form-control2"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">Employee Phone </label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>



                                    <th class="w-100px rounded-start">
                                        <div class="d-flex">
                                            Type
                                        </div>
                                    </th>



                                    <th class="w-100px rounded-start">
                                        <div class="d-flex">
                                            Start Time/Check in home
                                        </div>
                                    </th>



                                    <th class="w-100px rounded-start">
                                        <div class="d-flex">
                                            End Time/Check Out home
                                        </div>
                                    </th>


                                    <th class="w-100px rounded-start">
                                        <div class="d-flex">
                                            First Visit
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="d-flex">
                                            Last Visit
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="d-flex">
                                            Total Visit
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="d-flex">
                                            FIRST & LAST VISIT DIFF
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="d-flex">
                                            Visit Time In Minutes
                                        </div>
                                    </th>


                                    <th class="w-100px rounded-start">
                                        <div class="d-flex">
                                            Login Address
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="d-flex">
                                            Logout Address
                                        </div>
                                    </th>


                                    <th class="w-100px rounded-start">
                                        <div class="d-flex">
                                            Distance Travel
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="d-flex">
                                            Reporting
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="d-flex">
                                            Late
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

@endsection

@section('js')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


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



        $('.search_xlsx1').on('click', function(event) {

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

                $.ajax({
                    url: "{{ route('attendancedata.export') }}",
                    method: 'POST',
                    data: {
                        fromDate: fromDate,
                        toDate: toDate
                    },
                    beforeSend: function() {
                        $('.search_xlsx1').text('Searching...').prop('disabled', true);
                    },
                    success: function(response) {
                        $('#tbody').empty();
                        var countdata = response.data.length;
                        if (countdata != 0) {

                            $('.tablecard').removeClass('d-none');
                            $('.search_xlsx1').text('Search')
                            var id = 1;
                            $.each(response.data, function(index, value) {

                                var tr = `<tr>
                                 <td>` + id++ + `</td>
                                  <td>` + value.jobStartDate + `</td>
                                  <td>` + value.day + `</td>
                                  <td>` + value.state + `</td>
                                  <td>` + value.name + `</td>
                                  <td>` + value.reporting_manager + `</td>
                                  <td>` + value.reporting_manager_code + ` </td>
                                  <td>` + value.designation_doer + `</td>
                                  <td>` + value.emp_code + `</td>
                                  <td>` + value.emailAddress + `</td>
                                  <td>` + value.mobileNumber + `</td>
                                  <td>PRESENT</td>
                                  <td> ` + value.starttime + ` </td>
                                  <td> ` + value.endtime + `</td>
                                  <td>` + value.first_visit + `</td>
                                  <td>` + value.last_visit + `</td>
                                  <td>` + value.totalvisits + `</td>
                                  <td>` + value.first_n_last_visit_diff_h + `</td>
                                  <td>` + value.first_n_last_visit_diff_i + `</td>
                                  <td>` + value.checkInLocationArea + `</td>
                                  <td>` + value.checkOutLocationArea + `</td>
                                  <td>` + value.distancetravelled + `</td>
                                  <td>` + value.reporting + `</td>
                                  <td>` + value.late + `</td>
                                </tr>`;
                                $('#tbody').append(tr);
                            });

                        } else {
                            var tr = `<tr>
                            <td class="text-center" colspan="24"> No Record Found</td>
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
                url: "{{ route('attendancedata.exportsearch') }}",
                method: 'post',
                data: searchParams,
                success: function(response) {
                    $('#tbody').empty();
                        var countdata = response.data.length;
                        if (countdata != 0) {

                            $('.tablecard').removeClass('d-none');
                            $('.search_xlsx1').text('Search')
                            var id = 1;
                            $.each(response.data, function(index, value) {

                                var tr = `<tr>
                                 <td>` + id++ + `</td>
                                  <td>` + value.jobStartDate + `</td>
                                  <td>` + value.day + `</td>
                                  <td>` + value.state + `</td>
                                  <td>` + value.name + `</td>
                                  <td>` + value.reporting_manager + `</td>
                                  <td>` + value.reporting_manager_code + ` </td>
                                  <td>` + value.designation_doer + `</td>
                                  <td>` + value.emp_code + `</td>
                                  <td>` + value.emailAddress + `</td>
                                  <td>` + value.mobileNumber + `</td>
                                  <td>PRESENT</td>
                                  <td> ` + value.starttime + ` </td>
                                  <td> ` + value.endtime + `</td>
                                  <td>` + value.first_visit + `</td>
                                  <td>` + value.last_visit + `</td>
                                  <td>` + value.totalvisits + `</td>
                                  <td>` + value.first_n_last_visit_diff_h + `</td>
                                  <td>` + value.first_n_last_visit_diff_i + `</td>
                                  <td>` + value.checkInLocationArea + `</td>
                                  <td>` + value.checkOutLocationArea + `</td>
                                  <td>` + value.distancetravelled + `</td>
                                  <td>` + value.reporting + `</td>
                                  <td>` + value.late + `</td>
                                </tr>`;
                                $('#tbody').append(tr);
                            });

                        } else {
                            var tr = `<tr>
                            <td class="text-center" colspan="24"> No Record Found</td>
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

            let fromDate = $('#attendance_from_1').val().trim();
            let toDate = $('#attendance_to_1').val().trim();
            var date_range = $('#order_date_four').val().trim();
            var employee_name = $('#employee_name').val().trim();
            var state = $('#state').val().trim();
            var employee_code = $('#employee_code').val().trim();
            var employee_email = $('#employee_email').val().trim();
            var employee_phone = $('#employee_phone').val().trim();

            //console.log(order_date);

            var searchParams = {
                fromDate: fromDate,
                toDate: toDate,
                date_range: date_range,
                employee_name: employee_name,
                state: state,
                employee_code: employee_code,
                employee_email: employee_email,
                employee_phone: employee_phone,
            };
            searchData(searchParams);
        });



        $('#order_date_four').on('apply.daterangepicker', function(ev, picker) {
            // Set the selected date range to the input field
            $(this).val(picker.startDate.format('DD-MMM-YYYY') + ' - ' + picker.endDate.format('DD-MMM-YYYY'));

           
            let fromDate = $('#attendance_from_1').val().trim();
            let toDate = $('#attendance_to_1').val().trim();
            var date_range = $('#order_date_four').val().trim();
            var employee_name = $('#employee_name').val().trim();
            var state = $('#state').val().trim();
            var employee_code = $('#employee_code').val().trim();
            var employee_email = $('#employee_email').val().trim();
            var employee_phone = $('#employee_phone').val().trim();

            //console.log(order_date);

            var searchParams = {
                fromDate: fromDate,
                toDate: toDate,
                date_range: date_range,
                employee_name: employee_name,
                state: state,
                employee_code: employee_code,
                employee_email: employee_email,
                employee_phone: employee_phone,
            };
            searchData(searchParams);
        });




    });
</script>
<script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
@endsection