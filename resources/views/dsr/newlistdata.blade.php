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
                <li class="breadcrumb-item text-dark">DSR - Daily Sales Report</li>
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

                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="col-md-4 ">

                                    @if (!empty($trans_emponjobs) && empty($trans_emponjobs->jobExistDate))
                                    @if (!$trans_clientvisit)
                                    <!-- Show only Check In button if no data -->
                                    <a href="#" class="btn btn-primary checkInbutton">Check In</a>

                                    <a href="#" class="btn btn-primary checkOutbutton d-none"
                                        data-toggle="modal" data-target="#myModal2">Check Out</a>
                                    @else
                                    <!-- Show buttons based on the presence of checkInDate and checkOutDate -->
                                    <a href="#"
                                        class="btn btn-primary checkInbutton {{ $trans_clientvisit->checkInDate && $trans_clientvisit->checkOutDate ? '' : 'd-none' }}"
                                        >Check In</a>
                                    <a href="#"
                                        class="btn btn-primary checkOutbutton {{ $trans_clientvisit->checkInDate && !empty($trans_clientvisit->checkOutDate) ? 'd-none' : '' }}"
                                        data-toggle="modal" data-target="#myModal2">Check Out</a>
                                    @endif
                                    @endif

                                </div>

                                <div class="col-md-4 text-center">
                                    Total Traveled Today {{ $sumkm }}.
                                </div>

                                <!-- <div class="col-md-4">

                                    <div class="d-flex align-items-center mr-20px gap-2 justify-content-end">
                                        <a href="#" class="btn btn-sm btn-primary pr-2 exist-dsr"> Existing Client</a>
                                        <a href="#" class="btn btn-sm btn-primary new-dsr">New Client</a>
                                    </div>
                                </div> -->

                            </div>


                        </div>

                    </div>

                </div>
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

                                    <th class="w-60px rounded-start">
                                        <div class="floating-label-group">Date</div>
                                    </th>

                                    <th class="w-50px rounded-start">
                                        <div class="floating-label-group">Check In</div>
                                    </th>

                                    <th class="w-50px rounded-start">
                                        <div class="floating-label-group">Check Out</div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">Dealer Name </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">phone Number </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">Owner Name</div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">Prospect Name</div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">Duration</div>
                                    </th>

                                    <th class="w-150px rounded-start">
                                        <div class="floating-label-group">CheckIn Address</div>
                                    </th>

                                    <th class="w-150px rounded-start">
                                        <div class="floating-label-group">CheckOut Address</div>
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


<div class="modal fade" id="myModal" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Check In</h5>
                <button type="button" class="close btn btn-primary checkinclose" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form1">
                    <div class="mb-1 row">

                        <div class="col-sm-6 mb-1">
                            <div class="float-select">
                                <input type="radio" class="client_type" name="client_type" value="New"> New Client
                                <input type="radio" class="client_type" name="client_type" value="Existing"> Existing Client
                            </div>
                        </div>

                        <div class="row existing-client d-none">

                            <div class="col-sm-6 mb-1">
                                <div class="float-select">
                                    <select id="alldistributor" class="form-select form-select-sm" data-control="select2"
                                        data-placeholder=" " autocomplete="off">
                                    </select>
                                    <label class="new-labels"> Select Distributor Network <span class="text-danger">*</span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-sm-6 mb-1">
                                <div class="floating-label-group mb-3 retailer_projectname">
                                    <input type="text" id="retailer_project_name" class="form-control " required=""
                                        autocomplete="off">
                                    <label class="floating-label px">Retailer/Project Name </label>
                                </div>
                            </div>

                            <div class="col-sm-6 mb-1">

                                <div class="float-select">
                                    <select class="form-select form-select-sm" id="assign_user" data-control="select2"
                                        data-placeholder=" ">
                                    </select>
                                    <label class="new-labels">Select Sales user<span class="text-danger">*</span> </label>
                                </div>
                            </div>

                            <div class="col-sm-3 mb-1 d-flex">
                                <!--begin::Image input-->
                                <div class="image-input image-input-empty" data-kt-image-input="true"
                                    style="background-image: url({{ URL::asset('assets/media/svg/files/blank-image.svg') }})">
                                    <!--begin::Image preview wrapper-->
                                    <div class="image-input-wrapper w-60px h-60px">
                                    </div>
                                    <!--end::Image preview wrapper-->

                                    <!--begin::Edit button-->
                                    <label
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                        data-bs-dismiss="click" title="Change avatar">
                                        <i class="bi bi-plus fs-7"></i>

                                        <!--begin::Inputs-->
                                        <input type="file" id="current_location_image" name="avatar"
                                            accept=".png, .jpg, .jpeg, .pdf," />
                                        <input type="hidden" name="avatar_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Edit button-->

                                    <!--begin::Cancel button-->
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                        data-bs-dismiss="click" title="Cancel avatar">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                    <!--end::Cancel button-->

                                    <!--begin::Remove button-->
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                        data-bs-dismiss="click" title="Remove avatar">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>


                                    <!--end::Remove button-->
                                </div>
                                <div class="check" style="line-height: 60px; padding-left: 5px; font-size: 11px;">
                                    Current Location Image </div>
                                <!--end::Image input-->

                            </div>

                        </div>
                        <div class="row new-client d-none">

                            <div class="col-sm-4 mb-1">
                                <div class="floating-label-group mb-3">
                                    <input type="text" id="dealer_name" class="form-control " required=""
                                        autocomplete="off">
                                    <label class="floating-label px">Dealer Name <span class="text-danger">*</span></label>
                                </div>
                            </div>

                            <div class="col-sm-4 mb-1">
                                <div class="floating-label-group mb-3 ">
                                    <input type="text" id="owner_name" class="form-control " required=""
                                        autocomplete="off">
                                    <label class="floating-label px">owner Name <span class="text-danger">*</span></label>
                                </div>
                            </div>


                            <div class="col-sm-4 mb-1">
                                <div class="floating-label-group mb-3">
                                    <input type="text" id="phone_number" class="form-control " onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="10" required=""
                                        autocomplete="off">
                                    <label class="floating-label px">Phone Number <span class="text-danger">*</span></label>
                                </div>
                            </div>

                            <div class="col-sm-4 mb-1 d-flex">

                                <div class="image-input image-input-empty" data-kt-image-input="true"
                                    style="background-image: url({{ URL::asset('assets/media/svg/files/blank-image.svg') }})">
                                    <div class="image-input-wrapper w-60px h-60px">
                                    </div>
                                    <label
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                        data-bs-dismiss="click" title="Change avatar">
                                        <i class="bi bi-plus fs-7"></i>
                                        <input type="file" id="visiting_card_image" name="avatar"
                                            accept=".png, .jpg, .jpeg, .pdf," />
                                        <input type="hidden" name="avatar_remove" />
                                    </label>
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                        data-bs-dismiss="click" title="Cancel avatar">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                        data-bs-dismiss="click" title="Remove avatar">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                </div>
                                <div class="check" style="line-height: 60px; padding-left: 5px; font-size: 11px;">Visiting card image <span class="text-danger">*</span> </div>
                            </div>

                            <div class="col-sm-4 mb-1 d-flex">

                                <div class="image-input image-input-empty" data-kt-image-input="true"
                                    style="background-image: url({{ URL::asset('assets/media/svg/files/blank-image.svg') }})">
                                    <div class="image-input-wrapper w-60px h-60px">
                                    </div>
                                    <label
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                        data-bs-dismiss="click" title="Change avatar">
                                        <i class="bi bi-plus fs-7"></i>
                                        <input type="file" id="counter_pic" name="avatar"
                                            accept=".png, .jpg, .jpeg, .pdf," />
                                        <input type="hidden" name="avatar_remove" />
                                    </label>
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                        data-bs-dismiss="click" title="Cancel avatar">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                        data-bs-dismiss="click" title="Remove avatar">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                </div>
                                <div class="check" style="line-height: 60px; padding-left: 5px; font-size: 11px;">Counter pic <span class="text-danger">*</span> </div>
                            </div>



                            <div class="col-sm-4 mb-1">
                                <div class="float-select">
                                    <select class="form-select form-select-sm"
                                        id="customer_type" data-control="select2"
                                        data-placeholder=" ">
                                    </select>
                                    <label class="new-labels"> Select
                                        Prospect <span class="text-danger">*</span>
                                    </label>
                                </div>
                            </div>

                        </div>

                    </div>
                    <button type="button" class="btn btn-primary checkinsavebutton">Save</button>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal2" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Check Out</h5>
                <button type="button" class="close btn btn-primary checkoutclose" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form2">
                    <div class="mb-1 row">

                        <!-- <div class="col-sm-2 mb-1">
                            <div class="floating-label-group mb-3 ">
                                <input type="text" id="checkout_meter_reading" class="form-control " oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required=""
                                    autocomplete="off">
                                <label class="floating-label px">Meter reading <span class="text-danger">*</span></label>
                            </div>
                        </div> -->


                        <!-- <div class="col-sm-3 mb-1 d-flex">
                         
                            <div class="image-input image-input-empty" data-kt-image-input="true"
                                style="background-image: url({{ URL::asset('assets/media/svg/files/blank-image.svg') }})">
                              
                                <div class="image-input-wrapper w-60px h-60px">
                                </div>
                              
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                    data-bs-dismiss="click" title="Change avatar">
                                    <i class="bi bi-plus fs-7"></i>

                                  
                                    <input type="file" id="chekout_meter_reading_upload" name="avatar"
                                        accept=".png, .jpg, .jpeg, .pdf," />
                                    <input type="hidden" name="avatar_remove" />
                                   
                                </label>
                              
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                    data-bs-dismiss="click" title="Cancel avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                               
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                    data-bs-dismiss="click" title="Remove avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>


                        
                            </div>
                            <div class="check" style="line-height: 60px; padding-left: 5px; font-size: 11px;">Meter reading Upload <span class="text-danger">*</span></div>
                     

                        </div> -->



                        <div class="col-sm-2 mb-1">
                            <div class="float-select">
                                <select id="order_receive" class="form-select form-select-sm" data-control="select2"
                                    data-placeholder=" " autocomplete="off">
                                    <option value="">Select Order Receive</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                <label class="new-labels"> Order Receive<span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-sm-2 mb-1">
                            <div class="float-select">
                                <select id="payment_receive" class="form-select form-select-sm"
                                    data-control="select2" data-placeholder=" " autocomplete="off">
                                    <option value="">Select Payment Receive</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                <label class="new-labels"> Payment Receive<span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>


                        <div class="col-sm-3 mb-1 paymentmode d-none">
                            <div class="float-select">
                                <select id="payment_mode" class="form-select form-select-sm" data-control="select2"
                                    data-placeholder=" " autocomplete="off">
                                </select>
                                <label class="new-labels"> Payment Mode<span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-sm-4 mb-1 amount d-none">
                            <div class="floating-label-group mb-3">
                                <input type="text" id="amount_no" class="form-control" required=""
                                    autocomplete="off">
                                <label class="floating-label px">Amount<span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <div class="col-sm-4 mb-1">
                            <div class="floating-label-group mb-3">
                                <input type="text" id="nextmeetingdate" class="form-control backdatenotselected"
                                    required="" autocomplete="off">
                                <label class="floating-label px">Next Meeting Date <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>

                    </div>
                    <button type="button" class="btn btn-primary checkoutbutton">Save</button>

                </form>
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

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/smoothness/jquery-ui.css">



<script>
    $(document).on('click', '.checkInbutton', function() {
        $('#myModal').modal('show');

        var dealers = @json($mst_dsrClient);

        console.log(dealers);
        $('#myModal').on('shown.bs.modal', function() {
            console.log("Modal Opened, Initializing Autocomplete");

            if (Array.isArray(dealers) && dealers.length > 0) {
                $("#dealer_name").autocomplete({
                    source: dealers,
                    appendTo: "#myModal"
                });
                //console.log("Autocomplete Initialized");
            }
        });

    });
</script>


<script>
    funcustomertype().done(function(mastercustomertype) {
        var data = mastercustomertype.data;
        var options = '<option value="" >Select Customer Type</option>';
        $.each(data, function(key, value) {
            options += '<option value="' + value.masterMenuId + '" >' + value.name + '</option>';
        });
        $('#customer_type').empty().append(options);
    });

    fungetalldistributor().done(function(response) {
        var data = response.data;
        var options = '<option value="" >Select Distributor</option>';
        $.each(data, function(key, value) {
            options += '<option value="' + value.customerId + '" >' + value.CustomerName +
                '</option>';
        });

        $('#alldistributor').empty().append(options);
    });

    funallsalesusers().done(function(mastersalesusers) {
        var data = mastersalesusers.data;
        var userid = "{{ session('userinfo')->userId }}";

        var options = '<option value="" >Select sales user</option>';
        $.each(data, function(key, value) {

            if (userid == value.userId) {
                return; // This works like 'continue'
            }

            options += '<option value="' + value.userId + '" >' + value.name + '</option>';
        });
        $('#assign_user').empty().append(options);
    });

    fungetpaymnetmode().done(function(response) {
        var data = response.data;
        var options = '<option value="" >Select payment mode</option>';
        $.each(data, function(key, value) {
            options += '<option value="' + value.masterMenuId + '" >' + value.name + '</option>';
        });
        $('#payment_mode').empty().append(options);
    });

    $(document).ready(function() {

        $(document).on('change', 'input[name="client_type"]', function() {
            if ($(this).val() === "New") {
                $('.new-client').removeClass('d-none');
                $('.existing-client').addClass('d-none');
            } else {
                $('.existing-client').removeClass('d-none');
                $('.new-client').addClass('d-none');
            }
        });

        $(document).on('click', '.productimg', function() {
            //alert();
            var imgSrc = $(this).attr('src');
            $('#zoomedImg').attr('src', imgSrc);
            $('#overlay').fadeIn();
        });

        // Close modal when close button or overlay background is clicked
        $('.overlay, .close').click(function() {
            $('#overlay').fadeOut();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('change', '#alldistributor', function() {

            var distributor = $(this).val();

            var order_type = $('#order_type').val();
            var order_category = $('#order_category').val();

            $.ajax({
                type: 'GET',
                url: "{{ route('order.customerdiscount') }}",
                data: {
                    distributor: distributor
                },
                success: function(response) {
                    var consigneecount = response.consigneecount;
                    var orderconsignee = response.orderconsignee;
                    if (consigneecount <= 1) {

                        if (consigneecount == 1) {

                            var consignmentName = orderconsignee[0].consignmentName ?
                                orderconsignee[0].consignmentName : '';
                            var conignaddress = orderconsignee[0].address ? orderconsignee[
                                0].address : '';
                        } else {
                            var consignmentName = '';
                            var conignaddress = '';
                        }

                        var html = ` <input type="text" id="retailer_project_name" class="form-control "
                                  required=""  value="` + consignmentName + `"
                                    readonly autocomplete="off">
                              <label class="floating-label-new">Retailer/Project Name </label>`;


                    } else {

                        var html = `<select id="retailer_project_name" class="form-select form-select-sm"
                                            data-control="select2" data-placeholder=" " autocomplete="off">`;

                        $.each(orderconsignee, function(key, value) {
                            html +=
                                `<option value="${value.consignmentName}">${value.consignmentName}</option>`;
                        });

                        html +=
                            `</select>
                                    <label class="new-labels">Retailer/Project Name <span class="text-danger">*</span></label>`;
                        $('#retailer_project_name').select2({
                            placeholder: "Select User",
                            width: 'resolve' // Adjust width as needed
                        });
                    }

                    $('.retailer_projectname').html(html);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });

        });

        $('#myModal').on('hidden.bs.modal', function() {
            // Clear all input fields inside the form
            $(this).find('form')[0].reset();
            $(this).find('select').val('').trigger('change');
            $(this).find('.image-input-wrapper').css('background-image', 'none');
            $(this).find('input[type="file"]').val('');
            $(this).find('input[type="text"]').val('');
            $('.existing-client').addClass('d-none');
            $('.new-client').addClass('d-none');
        });

        $('#myModal2').on('hidden.bs.modal', function() {
            // Clear all input fields inside the form
            $(this).find('form')[0].reset();
            $(this).find('select').val('').trigger('change');
            $(this).find('.image-input-wrapper').css('background-image', 'none');
            $(this).find('input[type="file"]').val('');
            $(this).find('input[type="text"]').val('');
        });

        $('#payment_receive').on('change', function() {

            var paymentreceive = $(this).val();

            if (paymentreceive == '1') {
                $('.amount').removeClass('d-none');
                $('.paymentmode').removeClass('d-none');

            } else {
                $('.amount').addClass('d-none');
                $('.paymentmode').addClass('d-none');
            }

        });


        function compressImage(file, maxSizeKB, quality = 0.7) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();

                // Read the file as a Data URL
                reader.readAsDataURL(file);

                reader.onload = function(event) {
                    const img = new Image();
                    img.src = event.target.result;

                    img.onload = function() {
                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');

                        // Calculate scale factor to fit within the target size
                        const scaleFactor = Math.sqrt(maxSizeKB * 1024 / file.size);
                        canvas.width = img.width * scaleFactor;
                        canvas.height = img.height * scaleFactor;

                        // Draw the resized image onto the canvas
                        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                        // Compress the image as JPEG
                        const compressedDataUrl = canvas.toDataURL('image/jpeg', quality);

                        // Convert to a Blob
                        fetch(compressedDataUrl)
                            .then(res => res.blob())
                            .then(blob => resolve(blob))
                            .catch(err => reject(err));
                    };

                    img.onerror = function() {
                        reject(new Error('Failed to load image for compression.'));
                    };
                };

                reader.onerror = function() {
                    reject(new Error('Failed to read file.'));
                };
            });
        }


        $(document).on('click', '.checkinsavebutton', function(e) {
            e.preventDefault();
            var $checkInButton = $('.checkinsavebutton');

            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    async (position) => {

                            try {
                                // Success callback
                                var checkvalidation = 0;
                                var client_type = $('input[name="client_type"]:checked').val();
                                var meter_reading = 0;
                              //  var meter_reading_upload = $('#meter_reading_upload')[0].files[0];
                                var alldistributor = $('#alldistributor').val();
                                var retailer_project_name = $('#retailer_project_name').val();
                                var assign_user = $('#assign_user').val();
                                var current_location_image = $('#current_location_image')[0].files[0];
                                var dealer_name = $('#dealer_name').val();
                                var owner_name = $('#owner_name').val();
                                var phone_number = $('#phone_number').val();
                                var visiting_card_image = $('#visiting_card_image')[0].files[0];
                                var counter_pic = $('#counter_pic')[0].files[0];
                                var customer_type = $('#customer_type').val();

                                  // Compress images (if selected)
                                //const meter_reading_upload1 = meter_reading_upload ? await compressImage(meter_reading_upload, 30) : null;
                                const current_location_image1 = current_location_image ? await compressImage(current_location_image, 30) : null;
                                const visiting_card_image1 = visiting_card_image ? await compressImage(visiting_card_image, 30) : null;
                                const counter_pic1 = counter_pic ? await compressImage(counter_pic, 30) : null;


                                const latitude = position.coords.latitude;
                                const longitude = position.coords.longitude;

                                // Validation checks

                                if (client_type == undefined) {
                                    $('.client_type').css('border-color', 'red');
                                    $('.client_type').css('border', '1px solid red');
                                    toastr.error('Select Client Type');
                                    checkvalidation++;
                                }

                                // if (meter_reading == '') {
                                //     $('#meter_reading').css('border-color', 'red');
                                //     $('#meter_reading').css('border', '1px solid red');
                                //     toastr.error('Enter meter Reading');
                                //     checkvalidation++;
                                // }

                                // if (meter_reading_upload == undefined) {
                                //     $('input[name="meter_reading_upload"]').css('border-color', 'red');
                                //     toastr.error('Upload Meter reading');
                                //     checkvalidation++;
                                // }

                                if (client_type == "Existing") {

                                    if (alldistributor == '') {
                                        $('#alldistributor').css('border-color', 'red');
                                        toastr.error('Select Distributor Type');
                                        checkvalidation++;
                                    } else {
                                        $('#alldistributor').css('border-color', '');
                                    }

                                    if (retailer_project_name == '') {
                                        $('#retailer_project_name').css('border-color', 'red');
                                        toastr.error('Enter Retailer Project Name');
                                        checkvalidation++;
                                    } else {
                                        $('#retailer_project_name').css('border-color', '');
                                    }

                                    if (assign_user == '') {
                                        $('#assign_user').css('border-color', 'red');
                                        toastr.error('Select Sales User');
                                        checkvalidation++;
                                    } else {
                                        $('#assign_user').css('border-color', '');
                                    }

                                } else if (client_type == "New") {


                                    if (dealer_name == '') {
                                        $('#dealer_name').css('border-color', 'red');
                                        toastr.error('Enter Dealer Name');
                                        checkvalidation++;
                                    } else {
                                        $('#dealer_name').css('border-color', '');
                                    }

                                    if (owner_name == '') {
                                        $('#owner_name').css('border-color', 'red');
                                        toastr.error('Enter Owner Name');
                                        checkvalidation++;
                                    } else {
                                        $('#owner_name').css('border-color', '');
                                    }

                                    if (phone_number == '') {
                                        $('#phone_number').css('border-color', 'red');
                                        toastr.error('Enter Phone Number');
                                        checkvalidation++;
                                    } else {
                                        $('#phone_number').css('border-color', '');
                                    }

                                    if (customer_type == '') {
                                        $('#customer_type').css('border-color', 'red');
                                        toastr.error('Enter Customer Type');
                                        checkvalidation++;
                                    } else {
                                        $('#customer_type').css('border-color', '');
                                    }

                                    if (visiting_card_image == undefined) {
                                        $('#visiting_card_image').css('border-color', 'red');
                                        toastr.error('Upload visiting Card');
                                        checkvalidation++;
                                    } else {
                                        $('#visiting_card_image').css('border-color', '');
                                    }

                                    if (counter_pic == undefined) {

                                        $('#counter_pic').css('border-color', 'red');
                                        toastr.error('Upload Counter Pic');
                                        checkvalidation++;
                                    } else {

                                        $('#counter_pic').css('border-color', '');

                                    }


                                }



                                if (checkvalidation > 0) {
                                    return false;
                                }

                                $checkInButton.prop('disabled', true);

                                // Create FormData object for file upload

                                var formData = new FormData();
                                formData.append('latitude', latitude);
                                formData.append('longitude', longitude);

                                if (client_type == "Existing") {

                                    formData.append('alldistributor', alldistributor);
                                    formData.append('retailer_project_name', retailer_project_name);
                                    formData.append('assign_user', assign_user);
                                    if (current_location_image1) {
                                        formData.append('current_location_image', current_location_image1, current_location_image.name);
                                    }

                                } else {

                                    formData.append('dealer_name', dealer_name);
                                    formData.append('owner_name', owner_name);
                                    formData.append('phone_number', phone_number);
                                    formData.append('customer_type', customer_type);
                                    if (visiting_card_image1) {
                                        formData.append('visiting_card_image', visiting_card_image1, visiting_card_image.name);
                                    }
                                    if (counter_pic1) {
                                        formData.append('counter_pic', counter_pic1, counter_pic.name);
                                    }
                                }

                                formData.append('client_type', client_type);
                                formData.append('meter_reading', meter_reading);
                                // if (meter_reading_upload1) {
                                //     formData.append('meter_reading_upload', meter_reading_upload1, meter_reading_upload.name);
                                // }


                                $.ajax({
                                    url: '{{ route('dsr.checkinsubmit') }}',
                                    type: 'POST',
                                    data: formData,
                                    processData: false, // Prevents jQuery from converting data into query string
                                    contentType: false, // Prevents setting default content type to application/x-www-form-urlencoded
                                    beforeSend: function() {
                                        $checkInButton.text('Saving...');
                                    },
                                    success: function(response) {
                                        $checkInButton.text('Save');
                                        $checkInButton.prop('disabled', false);
                                        let data = typeof response === 'string' ? JSON.parse(
                                            response) : response;
                                        if (data.status === 200) {
                                            toastr.success('Check In Insert Successfully');
                                            $('.checkinclose').trigger('click');
                                            $('#myModal').modal('hide');
                                            $('.checkInbutton').addClass('d-none');
                                            $('.checkOutbutton').removeClass('d-none');

                                            fetchData(100, 1);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        $checkInButton.text('Check In');
                                        $(this).prop('disabled', false);
                                        console.error('Error sending location:', error);
                                    }
                                });

                            } catch (error) {
                                console.error('Error during image compression or form submission:', error);
                                toastr.error('An error occurred. Please try again later.');
                            }
                        },
                        (error) => {
                            // Error callback

                            console.log('check in error => ' + error);

                            if (error.code === error.PERMISSION_DENIED) {
                                toastr.error(
                                    "Location access denied. Please enable location services and try again."
                                );
                            } else if (error.code === error.POSITION_UNAVAILABLE) {
                                toastr.error(
                                    "Location information is unavailable. Please try again later.");
                            } else if (error.code === error.TIMEOUT) {
                                toastr.error("Location request timed out. Please try again.");
                            } else {
                                toastr.error("An unknown error occurred while fetching location.");
                            }
                            console.error("Error getting location:", error.message);
                        }, {
                            enableHighAccuracy: true, // Use GPS if available
                            timeout: 5000, // Timeout after 5 seconds
                            maximumAge: 0 // No cached location
                        }
                );
            } else {
                toastr.error("Geolocation is not supported by this browser.");
            }
        });

        $(document).on('click', '.checkoutbutton', function() {

            var $checkoutbutton = $('.checkoutbutton');

            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    async (position) => {
                        var checkvalidation = 0;
                        var checkout_meter_reading = 0;
                       // var chekout_meter_reading_upload = $('#chekout_meter_reading_upload')[0].files[0];
                        var order_receive = $('#order_receive').val();
                        var payment_receive = $('#payment_receive').val();
                        var amount_no = $('#amount_no').val();
                        var payment_mode = $('#payment_mode').val();
                        var nextmeetingdate = $('#nextmeetingdate').val();
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;

                        // if (checkout_meter_reading == '') {
                        //     $('#checkout_meter_reading').css('border-color', 'red');
                        //     $('#checkout_meter_reading').css('border', '1px solid red');
                        //     toastr.error('Enter meter Reading');
                        //     checkvalidation++;
                        // }

                        // if (chekout_meter_reading_upload == undefined) {
                        //     $('input[name="chekout_meter_reading_upload"]').css('border-color', 'red');
                        //     toastr.error('Upload Meter reading');
                        //     checkvalidation++;
                        // }


                        if (order_receive == '') {
                            $('#order_receive').css('border-color', 'red');
                            toastr.error('Select Order Recive');
                            checkvalidation++;
                        } else {
                            $('#order_receive').css('border-color', '');
                        }

                        if (payment_receive == '') {
                            $('#payment_receive').css('border-color', 'red');
                            toastr.error('Select payment receive');
                            checkvalidation++;
                        } else {
                            $('#payment_receive').css('border-color', '');
                        }
                        if (payment_receive == '1' && amount_no == '') {
                            $('#amount_no').css('border-color', 'red');
                            toastr.error('Enter amount');
                            checkvalidation++;
                        } else {
                            $('#amount_no').css('border-color', '');
                        }

                        if (payment_receive == '1' && payment_mode == '') {
                            $('#payment_mode').css('border-color', 'red');
                            toastr.error('Select Payment Mode');
                            checkvalidation++;
                        } else {
                            $('#payment_mode').css('border-color', '');
                        }

                        if (nextmeetingdate == '') {
                            $('#nextmeetingdate').css('border-color', 'red');
                            toastr.error('Select Next Payment date');
                            checkvalidation++;
                        } else {
                            $('#nextmeetingdate').css('border-color', '');
                        }


                        if (checkvalidation > 0) {
                            return false;
                        }
                      //  const chekout_meter_reading_upload1 = chekout_meter_reading_upload ? await compressImage(chekout_meter_reading_upload, 30) : null;

                        $checkoutbutton.prop('disabled', true);

                        var formData = new FormData();
                        formData.append('latitude', latitude);
                        formData.append('longitude', longitude);
                        formData.append('order_receive', order_receive);
                        formData.append('payment_receive', payment_receive);
                        formData.append('amount_no', amount_no);
                        formData.append('payment_mode', payment_mode);
                        formData.append('nextmeetingdate', nextmeetingdate);
                        formData.append('checkout_meter_reading', checkout_meter_reading);
                        // if (chekout_meter_reading_upload1) {
                        //             formData.append('chekout_meter_reading_upload', chekout_meter_reading_upload1, chekout_meter_reading_upload.name);
                        //         }

                        
                        $.ajax({
                            url: '{{ route('dsr.checkoutsubmit') }}',
                            type: 'POST',
                            data: formData,
                            processData: false, // Important: Prevents jQuery from converting data into query string
                            contentType: false, // Important: Prevents setting default content type to application/x-www-form-urlencoded
                            beforeSend: function() {
                                $checkoutbutton.text('Saving...');
                            },
                            success: function(response) {
                                $checkoutbutton.text('Save');
                                $checkoutbutton.prop('disabled', false);

                                let data = typeof response === 'string' ? JSON.parse(
                                    response) : response;

                                if (data.status === 200) {
                                    toastr.success('Checkout Insert Successfully');
                                    $('.checkoutclose').trigger('click');
                                    $('.checkInbutton').removeClass('d-none');
                                    $('.checkOutbutton').addClass('d-none');


                                    fetchData(100, 1);
                                }
                            },
                            error: function(xhr, status, error) {
                                $checkoutbutton.text('Check Out');
                                $(this).prop('disabled', false);
                                console.error('Error sending location:', error);
                            }
                        });




                    },
                    (error) => {
                        // Error callbacks
                        if (error.code === error.PERMISSION_DENIED) {
                            toastr.error(
                                "Location access denied. Please enable location services and try again."
                            );
                        } else if (error.code === error.POSITION_UNAVAILABLE) {
                            toastr.error(
                                "Location information is unavailable. Please try again later.");
                        } else if (error.code === error.TIMEOUT) {
                            toastr.error("Location request timed out. Please try again.");
                        } else {
                            toastr.error("An unknown error occurred while fetching location.");
                        }
                        console.error("Error getting location:", error.message);
                    }, {
                        enableHighAccuracy: true, // Use GPS if available
                        timeout: 5000, // Timeout after 5 seconds
                        maximumAge: 0 // No cached location
                    }
                );
            } else {
                toastr.error("Geolocation is not supported by this browser.");
            }

        });

        function fetchData(rowCount, page) {

            $.ajax({
                url: "{{ route('dsr.newlistdata') }}",
                method: 'GET',
                data: {
                    rowCount: rowCount,
                    page: page
                },
                success: function(response) {
                    var data = response.data;

                    $('#tbody').empty()
                    var countdata = response.data.length;
                    if (countdata != 0) {
                        $.each(data, function(index, value) {

                            var id = index + 1;

                            if (value.locationImage != null) {
                                var imgae = `{{ URL::asset('document/') }}/` + value
                                    .locationImage;
                            } else {
                                var imgae = 'NA';
                            }

                            var tr = ` <tr>
                                        <td class="w-50px rounded-start">` + id + `</td>
                                        <td class="w-60px rounded-start">` + value.date + `</td>
                                        <td class="w-50px rounded-start productimg" src="` + imgae + `">` + value
                                .checkintime + `</td>
                                        <td class="w-50px rounded-start">` + value.checkouttime + `</td>
                                        <td class="w-100px rounded-start">` + value.distributor + `</td>
                                        <td class="w-100px rounded-start">` + value.phoneNumber + `</td>
                                         <td class="w-100px rounded-start">` + value.ownerName + `</td>
                                          <td class="w-100px rounded-start">` + value.prospect + `</td>
                                        <td class="w-100px rounded-start">` + value.duration + `</td>
                                        <td class="w-150px rounded-start">` + value.checkinaddress + `</td>
                                        <td class="w-150px rounded-start">` + value.checkoutaddress + `</td>
                                    </tr>`;
                            $('#tbody').append(tr);
                        });

                    } else {
                        var tr = `<tr>
                        <td class="text-center" colspan="11"> No Record Found</td>
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


        // $('.new-dsr').on('click', function(e) {

        //     $.ajax({
        //         url: "{{ route('dsr.newlistdata') }}",
        //         method: 'GET',
        //         data: {
        //             rowCount: 1000,
        //             page: 1
        //         },
        //         success: function(response) {
        //             var data = response.data;

        //             $('#tbody').empty()
        //             var countdata = response.data.length;
        //             if (countdata != 0) {
        //                 $.each(data, function(index, value) {

        //                     var id = index + 1;

        //                     if (value.locationImage != null) {
        //                         var imgae = `{{ URL::asset('document/') }}/` + value
        //                             .locationImage;
        //                     } else {
        //                         var imgae = 'NA';
        //                     }

        //                     var tr = ` <tr>
        //                                 <td class="w-50px rounded-start">` + id + `</td>
        //                                 <td class="w-60px rounded-start">` + value.date + `</td>
        //                                 <td class="w-50px rounded-start productimg" src="` + imgae + `">` + value
        //                         .checkintime + `</td>
        //                                 <td class="w-50px rounded-start">` + value.checkouttime + `</td>
        //                                 <td class="w-100px rounded-start">` + value.distributor + `</td>
        //                                 <td class="w-100px rounded-start">` + value.projectname + `</td>
        //                                 <td class="w-100px rounded-start">` + value.duration + `</td>
        //                                 <td class="w-150px rounded-start">` + value.checkinaddress + `</td>
        //                                 <td class="w-150px rounded-start">` + value.checkoutaddress + `</td>
        //                             </tr>`;
        //                     $('#tbody').append(tr);
        //                 });

        //             } else {
        //                 var tr = `<tr>
        //                 <td class="text-center" colspan="9"> No Record Found</td>
        //             </tr>`;

        //                 $('#tbody').append(tr);
        //             }


        //             updatePagination(response.data);
        //         },
        //         error: function(xhr, status, error) {
        //             console.error('error => ' + error);
        //         }
        //     });


        // });





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
<script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
@endsection