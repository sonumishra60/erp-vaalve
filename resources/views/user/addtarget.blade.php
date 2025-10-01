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
                    <li class="breadcrumb-item text-dark">Add Target</li>

                </ul>
                <!--end::Title-->
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
                        <!--begin::Table container-->
                        <div class="table-responsive ">
                            <!--begin::Table-->
                            <table class="table table-bordered  netab">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fw-bolder bg-light">
                                        <th class="w-130px">Sales Person</th>
                                        <th class="w-130px">Reporting Manager 01</th>
                                        <th class="w-130px">Reporting Manager 02 </th>
                                        <th class="w-130px">Reporting Manager 03 </th>
                                        <th class="w-130px">
                                            <input type="text" name="year" id="year" placeholder="Select Year"
                                                value="" class="form-control year_calender" autocomplete="off">

                                            <div class="row">
                                                <div class="col-6 text-center mt-2">Primary</div>
                                                <div class="col-6 text-center mt-2">Secondary</div>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody id="tbody">

                                    @if (count($trans_targets_data) > 0)

                                        @foreach ($trans_targets_data as $key => $data)
                                            <tr>
                                                <td class="w-100px">
                                                <select class="form-select form-select-sm"
                                                        name="name1" data-control="select2"
                                                        data-placeholder=" ">

                                                <option value=""> Select User </option>
                                                @foreach ($salespersons as $key => $sales)
                                                            <option value="{{ $sales->userId }}"  @if ($sales->userId == $data->sales_userId_fk) selected @endif >{{ $sales->name }}</option>
                                                        @endforeach

                                              </select>
                                                   
                                                </td>
                                                <td class="w-100px">
                                                    <select class="form-select form-select-sm"
                                                        name="name2" data-control="select2"
                                                        data-placeholder=" ">

                                                <option value=""> Select User </option>
                                                @foreach ($salespersons as $key => $sales)
                                                            <option value="{{ $sales->userId }}"  @if ($sales->userId == $data->areaHead_userId_fk) selected @endif >{{ $sales->name }}</option>
                                                        @endforeach

                                              </select>
                                                </td>
                                                <td class="w-100px">
                                                    <select class="form-select form-select-sm"
                                                        name="name3" data-control="select2"
                                                        data-placeholder=" ">

                                                <option value=""> Select User </option>
                                                @foreach ($salespersons as $key => $sales)
                                                            <option value="{{ $sales->userId }}"  @if ($sales->userId == $data->stateHead_userId_fk) selected @endif >{{ $sales->name }}</option>
                                                        @endforeach

                                              </select>
                                                </td>
                                                <td class="w-100px">
                                                    <select class="form-select form-select-sm"
                                                    name="name4" data-control="select2"
                                                    data-placeholder=" ">

                                            <option value=""> Select User </option>
                                            @foreach ($salespersons as $key => $sales)
                                                        <option value="{{ $sales->userId }}"  @if ($sales->userId == $data->nationalHead_userId_fk) selected @endif >{{ $sales->name }}</option>
                                                    @endforeach

                                          </select>
                                                </td>
                                                <td class="w-100px text-center">
                                                    <div class="d-flex">
                                                        <input type="text" name="jan_pri" value=""   autocomplete="off" class="form-control fm-new mr-new">
                                                        <input type="text" name="jan_sec"  value=""   autocomplete="off" class="form-control fm-new">
                                                    </div>

                                                </td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="w-100px">
                                              
                                                <select class="form-select form-select-sm" name="name1"
                                                data-control="select2"
                                                data-placeholder=" ">
                                                <option value=""> Select User </option>
                                                @foreach ($salespersons as $key => $sales)
                                                            <option value="{{ $sales->userId }}"  >{{ $sales->name }}</option>
                                                        @endforeach
                                                        
                                            </select>

                                            </td>
                                            <td class="w-100px">
                                                <select class="form-select form-select-sm" name="name2"
                                                data-control="select2"
                                                data-placeholder=" ">
                                                <option value=""> Select User </option>
                                                @foreach ($salespersons as $key => $sales)
                                                            <option value="{{ $sales->userId }}"  >{{ $sales->name }}</option>
                                                        @endforeach
                                                        
                                            </select>
                                            </td>
                                            <td class="w-100px">
                                                <select class="form-select form-select-sm" name="name3"
                                                data-control="select2"
                                                data-placeholder=" ">
                                                <option value=""> Select User </option>
                                                @foreach ($salespersons as $key => $sales)
                                                            <option value="{{ $sales->userId }}"  >{{ $sales->name }}</option>
                                                        @endforeach
                                                        
                                            </select>
                                            </td>
                                            <td class="w-100px">
                                                <select class="form-select form-select-sm" name="name4"
                                                data-control="select2"
                                                data-placeholder=" ">
                                                <option value=""> Select User </option>
                                                @foreach ($salespersons as $key => $sales)
                                                            <option value="{{ $sales->userId }}"  >{{ $sales->name }}</option>
                                                        @endforeach
                                                        
                                            </select>
                                            </td>
                                            <td class="w-100px text-center">
                                                <div class="d-flex">
                                                    <input type="text" name="jan_pri" autocomplete="off"  class="form-control fm-new mr-new">
                                                    <input type="text" name="jan_sec" autocomplete="off" class="form-control fm-new">
                                                </div>

                                            </td>

                                        </tr>
                                    @endif

                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>

                        <div class="col-sm-12">



                            <button type="submit" class="btn btn-primary subtn saveForm  pull-right "
                                style="margin-right: 10px;">
                                <div class="spinner-border d-none distriloader" role="status">
                                </div>
                                Submit
                            </button>

                            <button type="submit" class="btn btn-primary addtargetaddmore pull-right"
                                style="margin-right: 10px;">Add More</button>
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


            $(document).on('click', '.addtargetaddmore', function(e) {

                $.ajax({
                    url: "{{ route('user.targetappend') }}",
                    type: 'GET',
                    success: function(response) {

                        $('#tbody').append(response);
                         
                        $('#tbody select').each(function() {
                            $(this).select2({
                                placeholder: "Select User",
                                width: 'resolve'  // Adjust width as needed
                            });
                        });
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Form submission failed.');
                    }
                });

            });


            $(document).on('click', '.removetr', function(e) {
                //alert();
                e.preventDefault(); // Prevent the default behavior of the anchor tag
                $(this).closest('tr').remove(); // Remove the closest parent with class "row"
            });

            $('.saveForm').on('click', function() {

                var year = $('#year').val();
                var formData = [];
                var isError = false;

                if (year == '') {
                    toastr.error('Select Year');
                    $('#year').css('border-color',
                        'red');

                    return false;
                } else {
                    $('#year').css('border-color', '');
                }

                $('tbody#tbody tr').each(function() {
                    var rowData = {};
                    var hasInput = false;
                    var hasSelect = false;
                    var rowError = false;

                    $(this).find('input').each(function() {
                        var name = $(this).attr('name');
                        var value = $(this).val();
                        if (value) {
                            hasInput = true;
                        }
                        rowData[name] = value;
                    });

                    $(this).find('select').each(function() {
                        var name = $(this).attr('name');
                        var value = $(this).val();
                        if (value) {
                            hasSelect = true;
                        }
                        rowData[name] = value;
                    });

                    if (!hasInput || !hasSelect) {
                        rowError = true;
                        isError = true;
                        // $(this).css('background-color',
                        // '#f8d7da');
                    } else {
                        $(this).css('background-color', '');
                    }

                    rowData['year'] = year;
                    formData.push(rowData);
                });

                if (isError) {
                    toastr.error('Each row must have at least one filled input and one selected option.');
                    return false; // Prevent form submission
                }

                // console.log(formData);
                // return false;
                $.ajax({
                    url: '{{ route('user.targetsubmit') }}',
                    type: 'POST',
                    data: {
                        data: formData
                    },
                    success: function(response) {

                        toastr.success('Data Insert Sucessfully');
                         var redirecturl = "{{ route('user.targetlist') }}";
                        window.location.href = redirecturl;
                    },
                    error: function(error) {
                        console.error('Error saving data:', error);
                    }
                });
            });

            $('#year').change(function() {

              var year = $(this).val();
              
              $.ajax({
                    url: "{{ route('check.target') }}",
                    method: 'GET',
                    data: {
                        year:year,
                    },
                    
                    success: function(response) {

                        console.log(response);

                        $('#tbody tr').each(function(index) {
                        // Get the corresponding response data for this row
                        var rowData = response[index];

                        //console.log('rowData =>'+ rowData);
                        
                        if (rowData) {
                            // Find the 'jan_pri' and 'jan_sec' inputs within the current row
                            $(this).find('input[name="jan_pri"]').val(rowData.primaryTarget);
                            $(this).find('input[name="jan_sec"]').val(rowData.secondaryTarget);
                        }
                    });

                    }
                });
       
              
            });




        });
    </script>
@endsection
