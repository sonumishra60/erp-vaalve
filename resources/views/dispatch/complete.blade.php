@extends('layouts.main')

@section('content')
    <div class="toolbar" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack p-0 m-0">
            <!--begin::Page title-->
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1 ml-10">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home')}}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-300 w-5px h-2px"></span>
                    </li>

                    <li class="breadcrumb-item text-dark">Complete Dispatch</li>

                </ul>
                <!--end::Title-->
            </div>

            
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">

            <div class="row mb-xl-8">
                <div class="card">
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
                                                <input type="text" id="order_no" class="form-control" autocomplete="off" required="">
                                                <label class="floating-label px">Order No.</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>

{{-- 
                                        <th class="w-100px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="order_no" class="form-control" autocomplete="off" required="">
                                                <label class="floating-label px">Sales Person</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th> --}}


                                        <th class="w-150px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="company_name" class="form-control" autocomplete="off" required="">
                                                <label class="floating-label px">Company Name</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>

                                        <th class="w-100px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="order_date" class="form-control  bank_check_recieved_date"  autocomplete="off" required="">
                                                <label class="floating-label px">Order Date</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>


                                        <th class="w-100px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="total_amout" class="form-control" autocomplete="off" required="">
                                                <label class="floating-label px">Total Amount</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>

                                        <th class="w-100px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="total_qty" class="form-control" autocomplete="off" required="">
                                                <label class="floating-label px">Total Qty</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>

                                        <th class="w-100px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="dispatch_qty" class="form-control" autocomplete="off" required="">
                                                <label class="floating-label px">Dispatch Qty</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>


                                        <th class="w-100px rounded-start">
                                            <div class="d-flex">
                                                Action
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
        <!--end::Container-->
    </div>
@endsection

@section('js')
    <script>
        $(document).on('click', '.delete', function() {
            event.preventDefault();
            var id = $(this).data('id');
            var url = '{{ route('order.delete', ':id') }}';
            url = url.replace(':id', id);
            swal({
                    title: "Are you sure?",
                    text: "To delete this record?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    buttons: {
                        cancel: "No",
                        confirm: "Yes",
                    },
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: url,
                            type: 'GET',
                            beforeSend: function() {
                                $('.spinner-cls').show();
                            },
                            success: function(data) {
                                $('.spinner-cls').hide();
                                if (data == 0) {
                                    toastr.error('Your record has not been deleted!');
                                } else {
                                    toastr.success('Your record has been deleted!');
                                }

                               location.reload();
                            },
                            error: function(xhr, status, error) {
                                $('.spinner-cls').hide();
                                toastr.error('Some error occurred please try again');
                            }
                        });
                    }
                });
        });

        function fetchData(rowCount, page) {

            $.ajax({
                url: "{{ route('dispatch.listdata') }}",
                method: 'GET',
                data: {
                    rowCount: rowCount,
                    page: page,
                    dispatchtype:'complete'
                },
                success: function(response) {
                    $('#tbody').empty();
                    var countdata = response.data.length;
                    if (countdata != 0) {
                        $.each(response.data, function(index, value) {
                            var id = index + 1;
                            var editurl = "{{ route('order.edit', ':id') }}";
                            editurl = editurl.replace(':id', value.orderAuthKey);
                            var statecity = value.state + ' ' + value.city
                            var counter = value.customerId;
                            var dispatchdetail = "{{ route('dispatch.completedetail', ':id')  }}";
                            dispatchdetail = dispatchdetail.replace(':id', value.orderAuthKey);

                            // <a href="` + editurl + `" title="Edit" ><i class="fas fa-pencil-alt text-primary"></i> </a>
                            // <a class="delete" data-id="` + value.orderId + `">  <i class="fa fa-trash text-danger"></i>  </a>

                            
                            // <td class="w-150px rounded-start">` + value.salespersonname + `</td>

                            var tr = ` <tr>
                                    <td class="w-50px rounded-start">` + id + `</td>
                                    <td class="w-100px rounded-start"> ` + value.orderNo +`</td>
                                    <td class="w-150px rounded-start">` + value.CustomerName + `</td>
                                    <td class="w-100px text-end">` + value.orderDate + `</td>
                                    <td class="w-100px text-end">` + value.grandAmt + `</td>
                                    <td class="w-100px text-end">` + value.quantity + `</td>
                                     <td class="w-100px text-end">`+value.dispatchedqty +` </td>
                                    <td class="w-100px rounded-start"> <div class="text-centern tblicon">
                                        <a href="`+ dispatchdetail +`" > <i class="fa fa-eye text-primary"></i> </a>
                                    </div></td>
                                     
                                </tr>`;
                            $('#tbody').append(tr);
                        });

                    } else {
                        var tr = `<tr>
                                    <td class="text-center" colspan="8"> No Record Found</td>
                                 </tr>`;

                        $('#tbody').append(tr);
                    }


                    updatePagination(response);
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

        fetchData(10, 1);


        function searchData(searchParams) {

            $.ajax({
                url: "{{ route('dispatch.completesearch') }}",
                method: 'GET',
                data: searchParams,
                success: function(response) {
                    $('#tbody').empty();
                    var countdata = response.data.length;
                    if (countdata != 0) {
                        $.each(response.data, function(index, value) {
                            var id = index + 1;
                            var editurl = "{{ route('order.edit', ':id') }}";
                            editurl = editurl.replace(':id', value.orderAuthKey);
                            var statecity = value.state + ' ' + value.city
                            var counter = value.customerId;
                            var pdfurl = "{{ URL::asset('orderpdf') }}/" + value.pdf_filename;

                            // <td class="w-150px rounded-start">` + value.CustomerName + `</td>

                            var tr = ` <tr>
                                    <td class="w-50px rounded-start">` + id + `</td>
                                  <td class="w-100px rounded-start"> ` + value.orderNo +`</td>
                                    <td class="w-150px rounded-start">` + value.CustomerName + `</td>
                                    <td class="w-100px text-end">` + value.orderDate + `</td>
                                    <td class="w-100px text-end">` + value.grandAmt + `</td>
                                    <td class="w-100px text-end">` + value.quantity + `</td>
                                     <td class="w-100px text-end">`+value.dispatchedqty +` </td>
                                    <td class="w-100px rounded-start"> <div class="text-centern tblicon">
                                            <a href="`+ pdfurl +`" target="_blank" > <i class="fa fa-eye text-primary"></i> </a>
                                        <a href="` + editurl + `" title="Edit" ><i class="fas fa-pencil-alt text-primary"></i> </a>
                                     <a  class="delete" data-id="` + value.orderId + `">  <i class="fa fa-trash text-danger"></i>  </a>
                                    </div></td>
                                     
                                </tr>`;
                            $('#tbody').append(tr);
                        });

                    } else {
                        var tr = `<tr>
                                    <td class="text-center" colspan="8"> No Record Found</td>
                                 </tr>`;

                        $('#tbody').append(tr);
                    }


                    updatePagination(response);
                },
                error: function(xhr, status, error) {
                    console.error('error => ' + error);
                }
            });

        }


        $('.form-control').on('keyup change', function() {
            //  alert();
            var order_no = $('#order_no').val().trim();
            var company_name = $('#company_name').val().trim();
            var order_date = $('#order_date').val().trim();
            var total_amout = $('#total_amout').val().trim();
            var total_qty = $('#total_qty').val().trim();
            var dispatch_qty = $('#dispatch_qty').val().trim();
            //console.log(order_date);

            var searchParams = {
                order_no: order_no,
                company_name: company_name,
                order_date: order_date,
                total_amout: total_amout,
                total_qty: total_qty,
                dispatch_qty: dispatch_qty,
                rowCount: 10,
                page: 1
            };
            searchData(searchParams);
        });

    </script>
@endsection
