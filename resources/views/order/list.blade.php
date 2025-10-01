@extends('layouts.main')

@section('content')
<!-- <style>
                                    .new-labels {
                                    background: #fff;
                                    padding-left: 2px;
                                    padding-right: 2px;
                                    margin: 0px;
                                    position: relative;
                                    top: -34px;
                                    left: 6px;
                                    font-size: 11px;
                                    color: #5e6278;
                                }
                                </style> -->
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
                    <a href="{{ route('home') }}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-300 w-5px h-2px"></span>
                </li>

                <li class="breadcrumb-item text-dark">Primary Order List</li>

            </ul>
            <!--end::Title-->
        </div>

        <div class="d-flex align-items-center mr-20px gap-2">
            <a href="{{ route('order.index') }}" class="btn btn-sm btn-primary pr-2"> Add Order</i></a>
            <a href="#" class="btn btn-sm btn-primary export-xlxs">Export Xlsx</a>

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
                                            <input type="text" id="order_no" class="form-control form-control2"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">Order No.</label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>

                                    <th class="w-150px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="sales_sperosn" class="form-control form-control2" required="">
                                            <label class="floating-label px">Sales Person</label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>

                                    <th class="w-150px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="company_name" class="form-control form-control2"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">Company Name</label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="order_date_two"
                                                class="form-control form-control2 bank_check_recieved_date"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">Order Date</label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">
                                            <!-- <input type="text" id="category_order"
                                                                                    class="form-control form-control2 bank_check_recieved_date"
                                                                                    autocomplete="off" required=""> -->

                                            <select id="category_order" class="form-select form-control2">
                                                <option value=""></option>
                                                <option value="Allied & Faucet">Allied & Faucet</option>
                                                <option value="Sanitaryware">Sanitaryware</option>
                                            </select>


                                            <label class="new-labels">Category</label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="discount_percentage"
                                                class="form-control form-control2 bank_check_recieved_date"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">Discount (%)</label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="amount" class="form-control form-control2"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">Amount</label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>

                                    <th class="w-190px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="discount" class="form-control form-control2"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">Discount</label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="gst_amt" class="form-control form-control2"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">GST Amt</label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="total_amout" class="form-control form-control2"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">Total Amount</label>
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
       var url = "{{ route('order.delete', ': id ') }}";
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

    $(document).on('click', '.dispatch_order', function() {
        event.preventDefault();
        var id = $(this).data('id');
          var url = "{{ route('order.dispatch', ':id') }}";
        url = url.replace(':id', id);
        swal({
                title: "Are you sure?",
                text: "To dispatch this order?",
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
            url: "{{ route('order.listdata') }}",
            method: 'GET',
            data: {
                rowCount: rowCount,
                page: page
            },
            success: function(response) {
                $('#tbody').empty();
                var countdata = response.data.length;
                if (countdata != 0) {
                    var startIndex = (page - 1) * rowCount;
                    $.each(response.data, function(index, value) {
                        var id = startIndex + index + 1;
                        var editurl = "{{ route('order.edit', ':id') }}";
                        editurl = editurl.replace(':id', value.orderAuthKey);
                        var statecity = value.state + ' ' + value.city
                        var counter = value.customerId;
                        var pdfurl = "{{ route('order.pdf', ':id') }}";
                        pdfurl = pdfurl.replace(':id', value.orderAuthKey);
                        var roleType = "{{ session('userinfo')->role_type }}";
                        var userId = "{{ session('userinfo')->userId }}";
                        var orderDispatchId = value.orderDispatchId;
                        var status = value.status;
                        var editicon = value.edit;
                        var deleteButton = '';
                        var display_order = '';
                        // Check the roleType and append delete button if condition is met
                        if (roleType == 2) {
                            deleteButton = `<a class="delete" data-id="` + value.orderId +
                                `"> <i class="fa fa-trash text-danger"></i> </a>`;

                            if (status == 3) {

                                var display_order = `<a class="dispatch_order" data-id="` + value
                                    .orderId +
                                    `"> <i class="fa fa-truck text-primary"" aria-hidden="true"></i>  </a>`;
                            }
                        }

                        if (userId == 373) {
                            if (status == 3) {

                                var display_order = `<a class="dispatch_order" data-id="` + value
                                    .orderId +
                                    `"> <i class="fa fa-truck text-primary"" aria-hidden="true"></i>  </a>`;
                            }
                        }



                        if (orderDispatchId != null) {
                            var editutton = '';
                        } else {

                            var editutton = '';
                            if (editicon == 1) {

                                var editutton = ` <a href="` + editurl +
                                    `" title="Edit" ><i class="fas fa-pencil-alt text-primary"></i> </a>`;
                            }
                        }




                        var tr = ` <tr>
                                    <td class="w-50px rounded-start">` + id + `</td>
                                    <td class="w-100px rounded-start"> ` + value.orderNo + `</td>
                                     <td class="w-100px rounded-start"> ` + value.salesperson + `</td>
                                    <td class="w-150px rounded-start">` + value.CustomerName + `</td>
                                    <td class="w-100px text-end">` + value.orderDate + `</td>
                                    <td class="w-100px text-end">` + value.order_category + `</td>
                                    <td class="w-100px text-end">` + value.enterDiscount + `</td>
                                    <td class="w-100px text-end">` + value.totalAmt + `</td>
                                    <td class="w-100px text-end">` + value.discountAmt + `</td>
                                    <td class="w-100px text-end">` + value.taxAmt + `</td>
                                     <td class="w-100px text-end">` + value.grandAmt + `</td>
                                    <td class="w-100px rounded-start"> <div class="text-centern tblicon d-flex">

                                        <a href="` + pdfurl + `" target="_blank" > <i class="fa fa-eye text-primary"></i> </a>
                                        
                                  ` + editutton + `` + deleteButton + ` ` + display_order + `
                                     
                                    </div></td>
                                     
                                </tr>`;
                        $('#tbody').append(tr);
                    });

                } else {
                    var tr = `<tr>
                                    <td class="text-center" colspan="9"> No Record Found</td>
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
            fetchData(25, page); // Fetch data for the clicked page
        });
    }

    fetchData(25, 1);

    function searchData(searchParams) {

        $.ajax({
            url: "{{ route('order.search') }}",
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
                       var pdfurl = "{{ route('order.pdf', ':id') }}";
                        pdfurl = pdfurl.replace(':id', value.orderAuthKey);
                          var roleType = "{{ session('userinfo')->role_type }}";
                        var userId = "{{ session('userinfo')->userId }}";
                        var orderDispatchId = value.orderDispatchId;
                        var status = value.status;
                        var editicon = value.edit;
                        var deleteButton = '';
                        var display_order = '';
                        // Check the roleType and append delete button if condition is met
                        if (roleType == 2) {

                            deleteButton = `<a class="delete" data-id="` + value.orderId +
                                `"> <i class="fa fa-trash text-danger"></i> </a>`;

                            if (status == 3) {

                                var display_order = `<a class="dispatch_order" data-id="` + value
                                    .orderId +
                                    `"> <i class="fa fa-truck text-primary"" aria-hidden="true"></i>  </a>`;
                            }
                        }


                        // // add condition user wise 
                        if (userId == 373) {
                            if (status == 3) {

                                var display_order = `<a class="dispatch_order" data-id="` + value
                                    .orderId +
                                    `"> <i class="fa fa-truck text-primary"" aria-hidden="true"></i>  </a>`;
                            }
                        }



                        if (orderDispatchId == 0) {

                            var editutton = '';
                            if (editicon == 1) {

                                var editutton = ` <a href="` + editurl +
                                    `" title="Edit" ><i class="fas fa-pencil-alt text-primary"></i> </a>`;
                            }
                        } else {

                            var editutton = '';
                        }


                        var tr = ` <tr>
                                    <td class="w-50px rounded-start">` + id + `</td>
                                    <td class="w-100px rounded-start"> ` + value.orderNo + `</td>
                                     <td class="w-100px rounded-start"> ` + value.salesperson + `</td>
                                    <td class="w-150px rounded-start">` + value.CustomerName + `</td>
                                    <td class="w-100px text-end">` + value.orderDate + `</td>
                                      <td class="w-100px text-end">` + value.order_category + `</td>
                                    <td class="w-100px text-end">` + value.enterDiscount + `</td>
                                    <td class="w-100px text-end">` + value.totalAmt + `</td>
                                    <td class="w-100px text-end">` + value.discountAmt + `</td>
                                    <td class="w-100px text-end">` + value.taxAmt + `</td>
                                     <td class="w-100px text-end">` + value.grandAmt + `</td>
                                    <td class="w-100px rounded-start"> <div class="text-centern tblicon d-flex">
                                            <a href="` + pdfurl + `" target="_blank" > <i class="fa fa-eye text-primary"></i> </a>
                                        ` + editutton + ` ` + deleteButton + ` ` + display_order + `
                                    </div></td>
                                     
                                </tr>`;
                        $('#tbody').append(tr);
                    });

                } else {
                    var tr = `<tr>
                                    <td class="text-center" colspan="9"> No Record Found</td>
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

   

    $('.export-xlxs').on('click', function(e) {
        e.preventDefault();

        var order_no = $('#order_no').val().trim();
        var company_name = $('#company_name').val().trim();
        var order_date = $('#order_date_two').val().trim();
        var amount = $('#amount').val().trim();
        var discount = $('#discount').val().trim();
        var gst_amt = $('#gst_amt').val().trim();
        var total_amout = $('#total_amout').val().trim();
        var order_p = 'p';
        var from_date = '';
        var to_date = '';

        if (order_date) {
            var dates = order_date.split(' - ');
            from_date = dates[0].trim();
            to_date = dates[1].trim();
        }

        window.location.href = "{{ route('orders.export') }}?" +
            "order_no=" + encodeURIComponent(order_no) +
            "&order_p=" + encodeURIComponent(order_p) +
            "&company_name=" + encodeURIComponent(company_name) +
            "&from_date=" + encodeURIComponent(from_date) +
            "&to_date=" + encodeURIComponent(to_date) +
            "&amount=" + encodeURIComponent(amount) +
            "&discount=" + encodeURIComponent(discount) +
            "&gst_amt=" + encodeURIComponent(gst_amt) +
            "&total_amout=" + encodeURIComponent(total_amout);

        // if (from_date && to_date) {

        // } else {
        //     alert('Please select both From and To dates');
        // }
    });



    $('.form-control2').on('keyup change', function() {
        //  alert();
        var order_no = $('#order_no').val().trim();
        var company_name = $('#company_name').val().trim();
        var order_date = $('#order_date_two').val().trim();
        var category_order = $('#category_order').val().trim();
        var discount_percentage = $('#discount_percentage').val().trim();
        var amount = $('#amount').val().trim();
        var sales_sperosn = $('#sales_sperosn').val().trim();
        var discount = $('#discount').val().trim();
        var gst_amt = $('#gst_amt').val().trim();
        var total_amout = $('#total_amout').val().trim();

        //console.log(order_date);

        var searchParams = {
            order_no: order_no,
            company_name: company_name,
            order_date: order_date,
            category_order: category_order,
            discount_percentage: discount_percentage,
            amount: amount,
            salesperson:sales_sperosn,
            discount: discount,
            gst_amt: gst_amt,
            total_amout: total_amout,
            rowCount: 25,
            page: 1
        };
        searchData(searchParams);
    });
</script>
@endsection