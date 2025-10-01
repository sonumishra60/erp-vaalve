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
                    <li class="breadcrumb-item text-dark">Day Details</li>
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

    <input type="hidden" value="{{ $trans_emponjobs }}" id="trans_emponjobs">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="row mb-5 mb-xl-8">
                <div class="card">
                    <div class="card-body py-3">
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
                                            <div class="floating-label-group">Time</div>
                                        </th>

                                        <th class="w-100px rounded-start">
                                            <div class="floating-label-group">Status</div>
                                        </th>

                                        <th class="w-150px rounded-start">
                                            <div class="floating-label-group">Address</div>
                                        </th>

                                        <th class="w-100px rounded-start">
                                            <div class="floating-label-group">KM (as per system)</div>
                                        </th>
                                        <th class="w-100px rounded-start">
                                            <div class="floating-label-group">CKM</div>
                                        </th>
                                        
                                        <th class="w-100px rounded-start">
                                            <div class="floating-label-group">Meter Reading</div>
                                        </th>
                                        
                                        <th class="w-100px rounded-start">
                                            <div class="floating-label-group">KM (as per meter reading)</div>
                                        </th>

                                      


                                        <th class="w-100px rounded-start">
                                            <div class="floating-label-group">CMR</div>
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

            function fetchData(rowCount, page) {

                var trans_emponjobs = $('#trans_emponjobs').val();

                $.ajax({
                    url: "{{ route('attendance.daydetaildata') }}",
                    method: 'GET',
                    data: {
                        rowCount: rowCount,
                        page: page,
                        date: trans_emponjobs
                    },
                    success: function(response) {
                        var data = response.data;

                        $('#tbody').empty()
                        var countdata = response.data.length;
                        if (countdata != 0) {
                            $.each(data, function(index, value) {

                                var id = index + 1;

                                var customername = '';
                                if (value.customername != 'NA') {
                                    var customername = '(' + value.customername + ')';
                                }

                                var tr = ` <tr>
                                        <td class="w-50px rounded-start">` + id + `</td>
                                         
                                           <td class="w-50px rounded-start" >` + value.time + `</td>
                                           <td class="w-50px rounded-start" >` + value.status + ' ' + customername + `</td>
                                           <td class="w-150px rounded-start">` + value.address + `</td>
                                           <td class="w-100px rounded-start">` + value.km + `</td>
                                            <td class="w-100px rounded-start">` + value.ckm + `</td>
                                           <td class="w-100px rounded-start">` + value.meterreading_cal + `</td>
                                            <td class="w-100px rounded-start">` + value.km_as_per_meter_mr + `</td>
                                          
                                           <td class="w-100px rounded-start">` + value.cmr + `</td>
                                       
                                    </tr>`;
                                $('#tbody').append(tr);
                            });

                        } else {
                            var tr = `<tr>
                        <td class="text-center" colspan="8"> No Record Found</td>
                     </tr>`;

                            $('#tbody').append(tr);
                        }


                        updatePagination(response.data);
                    },
                    error: function(xhr, status, error) {
                        console.error('error => ' + error);
                    }
                });
            }

            function updatePagination(response) {

                var totalPages = response.last_page;
                var paginationHtml = '';
                for (var i = 1; i <= totalPages; i++) {
                    paginationHtml += '<li class="page-item' + (response.current_page === i ? ' active' : '') +
                        '"><a class="page-link" href="/admins/forms?page=' + i + '" data-page="' + i + '">' + i +
                        '</a></li>';
                }


                $('#pagination').html(paginationHtml);

                // Event listener for pagination links
                $('#pagination a').on('click', function(event) {
                    event.preventDefault();
                    var page = $(this).data('page');
                    var rowCount = $('#rowCount').val();
                    fetchData(10, page); // Fetch data for the clicked page
                });
            }

            fetchData(100, 1);

        });
    </script>
@endsection
