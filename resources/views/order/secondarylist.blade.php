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

                <li class="breadcrumb-item text-dark">Secondary Order List</li>

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
                                            <input type="text" id="company_name" class="form-control form-control2"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">Company Name</label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>

                                    <th class="w-150px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="retailer_name" class="form-control form-control2"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">Retailer Name</label>
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
                                            <select id="category_order" class="form-select form-control2">
                                                <option value=""></option>
                                                <option value="Allied & Faucet">Allied & Faucet</option>
                                                <option value="Sanitaryware">Sanitaryware</option>
                                            </select>
                                            <label class="new-labels px">Category</label>
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
                                            <label class="floating-label px">T. Amount</label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="invoice_total_amout" class="form-control form-control2"
                                                autocomplete="off" required="">
                                            <label class="floating-label px">Inv. T. Amount</label>
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

<div class="modal fade" id="myModal" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Upload Invoice</h5>
                <a href="#" class="close btn btn-primary checkinclose" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <form id="form1">

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://unpkg.com/pdf-lib"></script>

<script>
    async function compressPDF(file) {
        if (file.type !== "application/pdf") return file; // Only compress PDFs

        const arrayBuffer = await file.arrayBuffer();
        const pdfDoc = await PDFLib.PDFDocument.load(arrayBuffer);

        pdfDoc.setTitle(file.name);
        const compressedPdfBytes = await pdfDoc.save({
            useObjectStreams: true
        });

        return new File([compressedPdfBytes], file.name, {
            type: "application/pdf"
        });
    }


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


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

    $(document).on('click', '.checkinclose', function() {

        $('#myModal').modal('hide');
    });

    $(document).on('click', '.upload_img', function(e) {
        e.preventDefault();
        var orderId = $(this).data('id');
        $.ajax({
            url: "{{ route('orders.invoice') }}",
            method: 'POST',
            data: {
                orderId: orderId
            },
            success: function(response) {

                var status = response.status;
                var showingdata = '';

                if (status > 0) {
                    var orderInvoiceHtml = `
        <table class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th>Created At</th>
                    <th>Created By</th>
                    <th>Amount</th>
                    <th>Invoice</th>
                </tr>
            </thead>
            <tbody>`;

                    // Loop through data array
                    response.data.forEach(function(invoiceData) {
                        var invoiceLinks = '';

                        // Loop through each invoice name and create links
                        invoiceData.invoiceNames.forEach(function(invoice) {
                            invoiceLinks += `<a href="{{ asset('uploads/invoices') }}/${invoice}" target="_blank">${invoice}</a><br>`;
                        });

                        // Append each row with invoice, amount, and created date
                        orderInvoiceHtml += `<tr>   <td>${invoiceData.createdBy}</td>
                                                    <td>${invoiceData.createdAt}</td>
                                                    <td>${invoiceData.totalAmount}</td>
                                                    <td>${invoiceLinks}</td>
                                            </tr>`;
                    });

                    orderInvoiceHtml += `</tbody></table>`;

                    showingdata = `<div class="">${orderInvoiceHtml}</div>`;

                }



                var modalhtml = ` <div class=" row">

                                        <div class="row existing-client">

                                            <div class="col-sm-3 d-flex">
                                            <div class="floating-label-group retailer_projectname">
                                                    <input type="hidden" name="orderId" id="orderId" value="` + orderId + `">
                                                    <input type="file" id="upload_invoice" class="form-control "   multiple>
                                                    <label class="new-labels"> Upload Invoice </label>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="floating-label-group retailer_projectname">
                                                    <input type="text" id="retailer_project_name" class="form-control "  onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" required=""
                                                        autocomplete="off">
                                                    <label class="floating-label px">Enter Amount </label>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                 <button type="button" class="btn btn-primary orderInvoicesubmit">Save</button>
                                            </div>

                                        </div>

                                        ` + showingdata + `
                                        
                                    </div>`;

                $('#form1').empty().append(modalhtml);
                $('#myModal').modal('show');

            },
            error: function(xhr, status, error) {
                console.error('error => ' + error);
            }
        });



    });


    $(document).on('click', '.orderInvoicesubmit', async function() { // Add `async` here
        let invoicetotalamount = $('#retailer_project_name').val().trim();
        let files = $('#upload_invoice')[0].files;
        let orderId = $('#orderId').val().trim();

        if (invoicetotalamount === '') {
            toastr.error('Enter Total Amount');
            return;
        }

        if (files.length === 0) {
            toastr.error('Please select at least one file!', 'Error');
            return;
        }

        let allowedTypes = ['application/pdf', 'application/zip'];
        let formData = new FormData();

        formData.append('invoicetotalamount', invoicetotalamount);
        formData.append('orderId', orderId);

        for (let i = 0; i < files.length; i++) {
            if (!allowedTypes.includes(files[i].type)) {
                toastr.error('Only PDF and ZIP files are allowed!', 'Error');
                return;
            }

            let compressedFile = await compressPDF(files[i]); // Ensure function is async
            formData.append('invoices[]', compressedFile);
        }

        $.ajax({
            url: "{{ route('upload.invoices') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                toastr.info('Uploading and compressing files... Please wait.');
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('Files uploaded successfully!');
                    $('#myModal').modal('hide');
                    fetchData(25, 1);
                } else {
                    toastr.error('Upload failed!');
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                toastr.error('An error occurred!');
            }
        });
    });



    function fetchData(rowCount, page) {

        $.ajax({
            url: "{{ route('order.listdatasecondary') }}",
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
                                     
                                    <td class="w-150px rounded-start">` + value.CustomerName + `</td>
                                    <td class="w-150px rounded-start">` + value.retailer_project_name + `</td>
                                     <td class="w-100px rounded-start"> ` + value.salesperson + `</td>
                                    <td class="w-100px text-end">` + value.orderDate + `</td>
                                    <td class="w-100px text-end">` + value.order_category + `</td>
                                    <td class="w-100px text-end">` + value.enterDiscount + `</td>
                                    <td class="w-100px text-end">` + value.totalAmt + `</td>
                                    <td class="w-100px text-end">` + value.discountAmt + `</td>
                                    <td class="w-100px text-end">` + value.taxAmt + `</td>
                                    <td class="w-100px text-end">` + value.grandAmt + `</td>
                                    <td class="w-100px text-end">` + value.invoicetotal + `</td>
                                     <td class="w-100px rounded-start"> <div class="text-centern tblicon">
                                        <a  class="upload_img" data-id="` + value
                            .orderId +
                            `" > <i class="fa fa-upload" aria-hidden="true"></i> </a>
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
            url: "{{ route('order.searchsecondary') }}",
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
                        var status = value.status;
                        var editicon = value.edit;
                        var orderDispatchId = value.orderDispatchId;
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
                                     
                                    <td class="w-150px rounded-start">` + value.CustomerName + `</td>
                                    <td class="w-150px rounded-start">` + value.retailer_project_name + `</td>
                                    <td class="w-100px rounded-start"> ` + value.salesperson + `</td>
                                    <td class="w-100px text-end">` + value.orderDate + `</td>
                                    <td class="w-100px text-end">` + value.order_category + `</td>
                                    <td class="w-100px text-end">` + value.enterDiscount + `</td>
                                    <td class="w-100px text-end">` + value.totalAmt + `</td>
                                    <td class="w-100px text-end">` + value.discountAmt + `</td>
                                    <td class="w-100px text-end">` + value.taxAmt + `</td>
                                     <td class="w-100px text-end">` + value.grandAmt + `</td>
                                     <td class="w-100px text-end">` + value.invoicetotal + `</td>
                                    <td class="w-100px rounded-start"> <div class="text-centern tblicon d-flex">
                                    <a class="upload_img" data-id="` + value
                            .orderId +
                            `"  > <i class="fa fa-upload" aria-hidden="true"></i> </a>
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

    $('.searchbtn').on('click', function() {

        var $button = $(this);
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var rowCount = 25;
        var page = 1;

        $.ajax({
            url: "{{ route('order.datesearch') }}",
            method: 'GET',
            data: {
                rowCount: rowCount,
                page: page,
                from_date: from_date,
                to_date: to_date
            },
            beforeSend: function() {
                $button.text('Searching...'); // Update button text
                $button.prop('disabled', true); // Disable the button during search

            },
            success: function(response) {
                $button.text('Search'); // Reset button text after success
                $button.prop('disabled', false); // Enable the button
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

                        var orderDispatchId = value.orderDispatchId;

                        var deleteButton = '';
                        // Check the roleType and append delete button if condition is met
                        if (roleType == 2) {
                            deleteButton = `<a class="delete" data-id="` + value.orderId +
                                `"> <i class="fa fa-trash text-danger"></i> </a>`;
                        }

                        if (orderDispatchId != null) {
                            var editutton = '';
                        } else {
                            var editutton = ` <a href="` + editurl +
                                `" title="Edit" ><i class="fas fa-pencil-alt text-primary"></i> </a>`;
                        }


                        var tr = ` <tr>
                                    <td class="w-50px rounded-start">` + id + `</td>
                                    <td class="w-100px rounded-start"> ` + value.orderNo + `</td>
                                    <td class="w-150px rounded-start">` + value.CustomerName + `</td>
                                    <td class="w-100px text-end">` + value.orderDate + `</td>
                                    <td class="w-100px text-end">` + value.totalAmt + `</td>
                                    <td class="w-100px text-end">` + value.discountAmt + `</td>
                                    <td class="w-100px text-end">` + value.taxAmt + `</td>
                                     <td class="w-100px text-end">` + value.grandAmt + `</td>
                                    <td class="w-100px rounded-start"> <div class="text-centern tblicon d-flex">
                                        <a class="upload_img" data-id="` + value
                            .orderId +
                            `" > <i class="fa fa-upload" aria-hidden="true"></i> </a>
                                        <a href="` + pdfurl + `" target="_blank" > <i class="fa fa-eye text-primary"></i> </a>
                                        
                                  ` + editutton + `` + deleteButton + `
                                     
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



    });

    $('.export-xlxs').on('click', function(e) {
        e.preventDefault();

        var order_no = $('#order_no').val().trim();
        var company_name = $('#company_name').val().trim();
        var retailer_name = $('#retailer_name').val().trim();
        var order_date = $('#order_date_two').val().trim();
        var amount = $('#amount').val().trim();
        var discount = $('#discount').val().trim();
        var gst_amt = $('#gst_amt').val().trim();
        var total_amout = $('#total_amout').val().trim();
        var order_p = 's';
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
            "&retailer_name=" + encodeURIComponent(retailer_name) +
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
        var retailer_name = $('#retailer_name').val().trim();
        var order_date = $('#order_date_two').val().trim();
        var category_order = $('#category_order').val().trim();
        var discount_percentage = $('#discount_percentage').val().trim();
        var amount = $('#amount').val().trim();
        var discount = $('#discount').val().trim();
        var gst_amt = $('#gst_amt').val().trim();
         var sales_sperosn = $('#sales_sperosn').val().trim();
        var total_amout = $('#total_amout').val().trim();
        var invoice_total_amout = $('#invoice_total_amout').val().trim();

        //console.log(order_date);

        var searchParams = {
            order_no: order_no,
            company_name: company_name,
            retailer_name: retailer_name,
            order_date: order_date,
            category_order: category_order,
             salesperson:sales_sperosn,
            discount_percentage: discount_percentage,
            amount: amount,
            discount: discount,
            gst_amt: gst_amt,
            total_amout: total_amout,
            invoice_total_amout: invoice_total_amout,
            rowCount: 25,
            page: 1
        };
        searchData(searchParams);
    });
</script>
@endsection