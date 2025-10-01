@extends('layouts.main')

<style>
    .datepicker{ z-index:9999!important; }
</style>

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
                        <a href="{{ route('home')}}" class="text-muted text-hover-primary">Home</a>
                    </li>

                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-300 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-dark">Add Product</li>
                </ul>
                <!--end::Title-->
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
                        <h3 class="card-title align-items-start flex-column"><span
                                class="card-label fw-bolder fs-3 mb-1">Product Information</span></h3>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body py-3">
                        <div class="row">
                            <div class="basic-form">
                                <form method="POST" action="#" id="">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3 ">
                                            <div class="float-select">
                                                <select class="form-select form-select-sm" id="parentcategory"
                                                    data-control="select2" data-placeholder="">
                                                </select>
                                                <label class="new-labels"> Select Category <span
                                                        class="text-danger">*</span></label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 mb-3">
                                            <div class="float-select">
                                                <select class="form-select form-select-sm" id="childcategory"
                                                    data-control="select2" data-placeholder=" ">
                                                </select>
                                                <label class="new-labels"> Select Series <span
                                                class="text-danger">*</span> </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="float-select">
                                                <select class="form-select form-select-sm" id="branddata"
                                                    data-control="select2" data-placeholder=" ">
                                                </select>
                                                <label class="new-labels"> Select Brand <span
                                                class="text-danger">*</span> </label>
                                            </div>
                                        </div>


                                        <div class="col-sm-3">
                                            <div class="float-select">
                                                <select class="form-select form-select-sm" id="colordata"
                                                    data-control="select2" data-placeholder=" ">
                                                </select>
                                                <label class="new-labels"> Select Color <span
                                                class="text-danger">*</span> </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="floating-label-group">
                                                <input type="text" id="cat_number" class="form-control" autocomplete="off" required="">
                                                <label class="floating-label px">CAT Number <span
                                                        class="text-danger">*</span> </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 mb-3">
                                            <div class="floating-label-group">
                                                <input type="text" id="Product" class="form-control" autocomplete="off"
                                                    required="">
                                                <label class="floating-label px">Product Name <span
                                                        class="text-danger">*</span> </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 mb-3">
                                            <div class="floating-label-group">
                                                <input type="text" id="productpiece" class="form-control"
                                                maxlength="10"
                                                     onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                    autocomplete="off" required="">
                                                <label class="floating-label px">Product piece <span
                                                class="text-danger">*</span> </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 mb-3">
                                            <div class="floating-label-group">
                                                <input type="text" id="mrp" class="form-control"
                                                 maxlength="10"
                                                     onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                    autocomplete="off" required="">
                                                <label class="floating-label px">MRP <span
                                                class="text-danger">*</span> </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 mb-3">
                                            <div class="floating-label-group">
                                                <input type="text" id="dop_netprice" class="form-control"
                                                 maxlength="10"
                                                     onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                    autocomplete="off" required="">
                                                <label class="floating-label px">Dealer/Distributor (DOP) </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 mb-3">
                                            <div class="floating-label-group">
                                                <input type="text" id="mop_netprice" class="form-control"
                                                 maxlength="10"
                                                     onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                    autocomplete="off" required="">
                                                <label class="floating-label px">Retailer/UBS (MOP)</label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 mb-3">
                                            <div class="floating-label-group">
                                                <input type="text" id="boxpack" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                autocomplete="off" required="">
                                                <label class="floating-label px">Box Pack <span
                                                class="text-danger">*</span> </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="floating-label-group">
                                                <input type="text" id="boxmrp" class="form-control" autocomplete="off"
                                                 maxlength="10"
                                                 onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46"
                                                 required="" >
                                                 <label class="floating-label px">Box MRP <span
                                                 class="text-danger">*</span> </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="floating-label-group">
                                                <input type="text" id="productCode" class="form-control"
                                                    autocomplete="off" required="">
                                                <label class="floating-label px">Product Code <span
                                                class="text-danger">*</span> </label>
                                            </div>
                                        </div>


                                        <div class="col-sm-3">
                                            <div class="floating-label-group">
                                                <input type="file" id="mastermenuimage" class="form-control"
                                                    required="">
                                                <label class="floating-label-img px">Product Image  <span
                                                class="text-danger">*</span> </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="floating-label-group">
                                                <input type="text" id="start_date" class="form-control simpledate"
                                                    value="" autocomplete="off"
                                                    required="">
                                                <label class="floating-label px"> Start Date  <span
                                                class="text-danger">*</span> </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="floating-label-group">
                                                <input type="text" id="end_date" class="form-control simpledate"
                                                    value="" autocomplete="off"
                                                    required="">
                                                <label class="floating-label px">End Date  <span
                                                class="text-danger">*</span> </label>
                                            </div>
                                        </div>


                                        <div class="col-sm-6">

                                          
                                            <div class="form-floating">
                                                <textarea class="form-control"  id="product_description"></textarea>
                                                        <label for="floatingTextarea" class="floatingTextarea">Remarks</label>
                                            </div>

                                        </div>

                                        <div class="col-sm-1 mb-3">
                                            <a href="#" class="btn btn-sm btn-primary mastermenusubmit">
                                                <div class="spinner-border text-light d-none distriloader" role="status"></div> Save </a>
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
        $(document).ready(function() {

            funparentcategory().done(function(masterdata) {
                var data = masterdata.data;
                var options = '<option value="" >Select Master Data</option>';
                $.each(data, function(key, value) {
                    options += '<option value="' + value.masterMenuId + '" >' + value.name +
                        '</option>';
                });
                $('#parentcategory').empty().append(options);
            });

            funcolor().done(function(masterdata) {
                var data = masterdata.data;
                var options = '<option value="" >Select Master Data</option>';
                $.each(data, function(key, value) {
                    options += '<option value="' + value.masterMenuId + '" >' + value.name +
                        '</option>';
                });
                $('#colordata').empty().append(options);
            });


            funbrand().done(function(masterdata) {
                var data = masterdata.data;
                var options = '<option value="" >Select Master Data</option>';
                $.each(data, function(key, value) {
                    options += '<option value="' + value.masterMenuId + '" >' + value.name +
                        '</option>';
                });

                $('#branddata').empty().append(options);
            });


            funmastercategory().done(function(masterparentcategory) {
                //  console.log(masterparentcategory);
                var data = masterparentcategory.data;
                var options = '<option value="" >Select Master Menu</option>';
                $.each(data, function(key, value) {
                    options += '<option value="' + value.masterMenuId + '" >' + value.name +
                        '</option>';
                });

                $('#mainmenudata').empty().append(options);
            });


            $('#parentcategory').on('change', function() {
                var categoryID = $(this).val();
                var url = `{{ route('childcategory.all', ':id') }}`.replace(':id', categoryID);
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        var arraylenghth = res.data.length;

                        if (arraylenghth > 0) {

                            var options = '<option value="" >Select Category</option>';
                            $.each(res.data, function(key, value) {
                                options += '<option value="' + value.masterMenuId +
                                    '" >' + value.name +
                                    '</option>';
                            });

                            $('#childcategory').empty().append(options);
                        }
                    }
                });


            });


            $('.mastermenusubmit').on('click', function() {
                
                var checkvalidation = 0;
                var parentcategory = $('#parentcategory').val();
                var childcategory = $('#childcategory').val();
                var branddata = $('#branddata').val();
                var colordata = $('#colordata').val();
                var Product = $('#Product').val();
                var productpiece = $('#productpiece').val();
                var boxpack = $('#boxpack').val();
                var boxmrp = $('#boxmrp').val();
                var cat_number = $('#cat_number').val();
                var mrp = $('#mrp').val();
                var dop_netprice = $('#dop_netprice').val();
                var mop_netprice = $('#mop_netprice').val();
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                var productCode = $('#productCode').val();
                var product_description = $('#product_description').val();
                var mastermenuimage = $('#mastermenuimage')[0].files[0];
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                if (parentcategory == '') {
                    toastr.error('Select Parent Category');
                    $('#parentcategory').css('border-color', 'red');
                    checkvalidation++;
                }else{
                    $('#parentcategory').css('border-color', '');
                }

                if (branddata == '') {
                    toastr.error('Select Brand');
                    $('#branddata').css('border-color', 'red');
                    checkvalidation++;
                }else{
                    $('#branddata').css('border-color', '');
                }

                if (start_date == '') {
                    toastr.error('Select Start Date');
                    $('#start_date').css('border-color', 'red');
                    checkvalidation++;
                }else{
                    $('#start_date').css('border-color', '');
                }

                if (end_date == '') {
                    toastr.error('Select End Date');
                    $('#end_date').css('border-color', 'red');
                    checkvalidation++;
                }else{
                    $('#end_date').css('border-color', '');
                }

                if (colordata == '') {
                    toastr.error('Select Color');
                    $('#colordata').css('border-color', 'red');
                    checkvalidation++;
                }else{
                    $('#colordata').css('border-color', '');
                }

                if (Product == '') {
                    toastr.error('Enter Product Name');
                    $('#Product').css('border-color', 'red');
                    checkvalidation++;
                }else{
                    $('#Product').css('border-color', '');
                }

                if (cat_number == '') {
                    toastr.error('Enter Cat Number');
                    $('#cat_number').css('border-color', 'red');
                    checkvalidation++;
                }else{
                    $('#cat_number').css('border-color', '');
                }


                if (mrp == '') {
                    toastr.error('Enter MRP');
                    $('#mrp').css('border-color', 'red');
                    checkvalidation++;
                }else{
                    $('#mrp').css('border-color', '');
                }


                if (productpiece == '') {
                    toastr.error('Enter Product piece');
                    $('#productpiece').css('border-color', 'red');
                    checkvalidation++;
                }else{
                    $('#productpiece').css('border-color', '');
                }

                if (boxpack == '') {
                    toastr.error('Enter box pack');
                    $('#boxpack').css('border-color', 'red');
                    checkvalidation++;
                }else{
                    $('#boxpack').css('border-color', '');
                }

                if (boxmrp == '') {
                    toastr.error('Enter box mrp');
                    $('#boxmrp').css('border-color', 'red');
                    checkvalidation++;
                }else{
                    $('#boxmrp').css('border-color', '');
                }

                if (productCode == '') {
                    toastr.error('Enter Product Code');
                    $('#productCode').css('border-color', 'red');
                    checkvalidation++;
                }else{
                    $('#productCode').css('border-color', '');
                }

                if (mastermenuimage == undefined) {
                    toastr.error('Select produt image');
                    $('#mastermenuimage').css('border-color', 'red');
                    checkvalidation++;
                }else{
                    $('#mastermenuimage').css('border-color', '');
                }

                // if (product_description == '') {
                //     toastr.error('Enter Remarks');
                //     $('#product_description').css('border-color', 'red');
                //     checkvalidation++;
                // }else{
                //     $('#product_description').css('border-color', '');
                // }

                if (checkvalidation == 0) {

                    $(this).prop('disabled', true);
                    $('.distriloader').removeClass('d-none');
                    var formData = new FormData();
                    formData.append('parentcategory', parentcategory);
                    formData.append('childcategory', childcategory);
                    formData.append('branddata', branddata);
                    formData.append('colordata', colordata);
                    formData.append('Product', Product);
                    formData.append('productpiece', productpiece);
                    formData.append('boxpack', boxpack);
                    formData.append('boxmrp', boxmrp);
                    formData.append('cat_number', cat_number);
                    formData.append('mrp', mrp);
                    formData.append('productCode', productCode);
                    formData.append('mastermenuimage', mastermenuimage);
                    formData.append('product_description', product_description);
                    formData.append('dop_netprice', dop_netprice);
                    formData.append('mop_netprice', mop_netprice);
                    formData.append('start_date', start_date);
                    formData.append('end_date', end_date);
                    formData.append('_token', csrfToken);
                   
                
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('product.addsubmit') }}",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $('.distriloader').addClass('d-none');

                            var resp = response.resp;
                            var msg = response.msg;
                            var redirecturl = "{{ route('product.list') }}";
                            if (resp === 1) {
                                toastr.success(msg);
                                window.location.href = redirecturl;
                            } else {
                                toastr.error(msg);
                            }


                        },
                        error: function(xhr, status, error) {
                            toastr.error('An error occurred while submitting the form.');
                        }
                    });
                }

            });


            

        });
    </script>
@endsection
