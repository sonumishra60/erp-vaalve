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

                    <li class="breadcrumb-item text-dark">Dispatch Detail</li>

                </ul>
                <!--end::Title-->


            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
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
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Basic Information</span>
                        </h3>
                    </div>
                    <div class="card-body py-3">
                        <div class="row">
                            <div class="basic-form">
                                <form method="POST" action=" " id="">
                                    <input type="hidden" name="order_id" id="order_id" value="{{ $order->orderId }}">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3 mb-1">
                                            <div class="float-select">
                                                <select id="alldistributor" class="form-select form-select-sm"
                                                    data-control="select2" data-placeholder=" "  disabled autocomplete="off">
                                                </select>
                                                <label class="new-labels"> Select Distributor Network <span class="text-danger">*</span> </label>
                                            </div>

                                            <div class="floating-label-group mb-3">
                                                <input type="text" id="discount" class="form-control "
                                                    onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                    value="{{ $order->enterDiscount }}" required="" readonly
                                                    autocomplete="off">
                                              
                                                <label class="floating-label-new">Discount(%) <span class="text-danger">*</span> </label>
                                            </div>


                                            <div class="floating-label-group mb-3">
                                                <input type="text" id="party_balance" class="form-control "
                                                    onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                    required=""  readonly autocomplete="off">
                                                <label class="floating-label px">Party Balance</label>
                                            </div>


                                            <div class="floating-label-group  mb-3">
                                                <input type="text" id="cash_discount" class="form-control "
                                                    onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                    value="{{ $order->casheDiscount }}" readonly autocomplete="off">
                                                <label class="floating-label px">Cash Discount</label>
                                            </div>


                                           

                                            <div class="form-floating mb-3">
                                                <textarea class="form-control" id="shipping_address" readonly>{{ $order->shppingAddress }}</textarea>
                                                <label for="floatingTextarea" class="floatingTextarea">Shipping
                                                    Address <span class="text-danger">*</span> </label>
                                            </div>

                                        </div>

                                        <div class="col-sm-3 mb-1">

                                            <div class="float-select">
                                                <select id="order_category" class="form-select form-select-sm"
                                                    data-control="select2" data-placeholder="" autocomplete="off" disabled >
                                                    <option value=""></option>
                                                    <option value="Allied & Faucet"
                                                        {{ $order->order_category == 'Allied & Faucet' ? 'selected' : '' }}>
                                                        Allied & Faucet</option>
                                                    <option value="Sanitaryware"
                                                        {{ $order->order_category == 'Sanitaryware' ? 'selected' : '' }}>
                                                        Sanitaryware</option>
                                                </select>
                                                <label class="new-labels">Category <span class="text-danger">*</span> </label>
                                            </div>


                                            <div class="floating-label-group mb-3">
                                                <input type="text" id="mtd_value" class="form-control "
                                                    onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                    value="{{ $mtd }}" required="" readonly autocomplete="off">
                                                <label class="floating-label-new">MTD Value</label>
                                            </div>



                                            <div class="float-select">
                                                <select id="bank_name" class="form-select form-select-sm"
                                                    data-control="select2" data-placeholder=" "disabled autocomplete="off">
                                                </select>
                                                <label class="new-labels">Bank Name</label>
                                            </div>


                                            <div class="floating-label-group"  style='height: 40px;'>
                                               
                                                <select id="payment_mode" class="form-select form-select-sm"
                                                    data-control="select2" data-placeholder=" " disabled autocomplete="off">
                                                </select>
                                                <label class="new-labels">Payment Mode <span class="text-danger">*</span> </label>
                                            </div>

                                            <div class="form-floating">
                                                <textarea class="form-control" id="Remarks" autocomplete="off" readonly>{{ $order->remarks }}</textarea>
                                                <label for="floatingTextarea" class="floatingTextarea">Remarks</label>
                                            </div>

                                        </div>

                                        <div class="col-sm-3">


                                            <div class="float-select">
                                                <select id="order_type" class="form-select form-select-sm"
                                                    data-control="select2" data-placeholder="" disabled autocomplete="off">
                                                </select>
                                                <label class="new-labels">Order Type <span class="text-danger">*</span> </label>
                                            </div>


                                            <div class="floating-label-group  mb-3">
                                                <input type="text" id="target_value" class="form-control"
                                                    onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                    value="{{ $primaryTarget }}" required="" readonly readonly
                                                    autocomplete="off">
                                                <label class="floating-label-new">Target Value <span class="text-danger">*</span> </label>
                                            </div>


                                           
                                            <div class="floating-label-group mb-3 retailer_projectname">

                                            @if(count($orderconsignee) == 0)
                                                <input type="text" id="retailer_project_name" readonly class="form-control "
                                                    required="" value="{{ $order->retailer_project_name }}"
                                                    autocomplete="off">
                                                <label class="floating-label px">Retailer/Project Name</label>

                                               @else

                                               <select id="retailer_project_name" class="form-select form-select-sm"
                                                data-control="select2" data-placeholder=" " disabled autocomplete="off">
                                                <option></option>

                                                @foreach($orderconsignee as $key => $val)
                                                    <option value="{{ $val->consignmentName}}"  {{ $val->consignmentName == $order->retailer_project_name ? 'selected' : '' }}   >{{ $val->consignmentName}}</option>
                                                @endforeach

                                                </select>
                                                <label class="new-labels">Retailer/Project Name <span class="text-danger">*</span></label>
                                               @endif
                                            </div>

                                            <div class="floating-label-group mb-3">
                                                <input type="text" id="cheque_numebr" class="form-control"
                                                    required="" value="{{ $order->chequeNumber }}"
                                                    readonly  autocomplete="off">
                                                <label class="floating-label px">Cheque Number</label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 mb-1">

                                            <div class="float-select">
                                                <select id="order_brand" class="form-select form-select-sm"
                                                    data-control="select2" data-placeholder="" disabled autocomplete="off">
                                                </select>
                                                <label class="new-labels">Brand <span class="text-danger">*</span> </label>
                                            </div>

                                            <div class="float-select">
                                                <select id="tansproter" class="form-select form-select-sm"
                                                    data-control="select2" data-placeholder="" autocomplete="off">
                                                </select>
                                                <label class="new-labels">Transport <span class="text-danger">*</span> </label>
                                            </div>

                                            <div class="floating-label-group mb-3">
                                                <input type="text" id="order_date"
                                                    value="{{ date('d-M-Y', $order->orderDate) }}" disabled class="form-control "
                                                    required="" autocomplete="off">
                                                <label class="floating-label-new">Order Date <span class="text-danger">*</span> </label>
                                            </div>

                                            <div class="floating-label-group mb-3 d-none">
                                                <input type="text" class="form-control bank_check_recieved_date"
                                                    id="deliverydate" autocomplete="off"
                                                    value="{{ date('d-M-Y', $order->deliveryDate) }}" readonly required="">
                                                <label class="floating-label px">Delivery Date <span class="text-danger">*</span></label>
                                            </div>


                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--begin::Body-->
                </div>
            </div>
           
            @if(count($data) > 0)
            <div class="row mb-5 mb-xl-8" id="item-info-section">
                <div class="card">
                    <div class="card-header ">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Item Information</span>
                        </h3>
                    </div>

                    @php
                        if($order->status == 2){

                            $ordercomplete = 'd-none';
                           
                }else{
                            // $orderpending = 'd-none';
                            $ordercomplete = '';
                }
                    @endphp

                    <div class="card-body py-3">
                        <div class="table-responsive desk-display">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr class="fw-bolder bg-light">
                                        <th class="min-w-150px rounded-start">Dispatch No</th>
                                        <th class="min-w-150px rounded-start">Dispatch Date</th>
                                        <th class="min-w-150px rounded-start">Series</th>
                                        <th class="min-w-300px rounded-start">Product Information </th>
                                        <th class="min-w-100px rounded-start">Order Qty</th>
                                        <th class="min-w-100px rounded-start">Dispatched Qty </th>
                                        <th class="min-w-100px rounded-start">pending Qty </th>
                                    </tr>
                                </thead>
                                <tbody id="product-list">
                                    @foreach ($data as $item)
                                        @php
                                        if($item['free'] == 'free'){
                                            $spanhtml = '<span class="badge badge-success">In Scheme</span>';
                                        }else{
                                            $spanhtml = '';
                                        }

                                        @endphp

                                        <tr>
                                          
                                            <td>{{ $item['dispatchNo'] }}</td>
                                            <td>{{ $item['dispatchdate'] }}</td>
                                            <td>{{ ucwords(strtolower($item['serisname'])) }}</td>
                                            <td>{{ ucwords(strtolower($item['productName'])) }}  {!! $spanhtml !!}</td>
                                           <td class="text-right dispatchedqty">{{ $item['orderqty'] }} </td>
                                           <td class="text-right dispatchedqty">{{ $item['dispatchqty'] }} </td>
                                           <td class="text-right dispatchedqty">{{ $item['pendingqty'] }} </td>
                                          
                                           
                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                        <div class="item-mobile">
                            <div class="mob-box mo-display">

                                <div id="product-list-mobile">

                                    @foreach ($data  as $item)
                                       

                                        <div class="box-tb">
                                            <div class="row">
                                                <div class="col-10 item-name">
                                                    <strong>{{ ucwords(strtolower($item['productName'])) }} ({{ $item['cat_number'] }})
                                                       </strong>
                                                </div>
                                                <div class="col-2 qt-box pl-0 "><input class="form-control form-ctr2 dispatch_qty"
                                                        value="{{ $item['dispatchqty'] }}"  readonly type="text"></div>
                                            </div>
                                            <div class="row">
                                                <ul class="dptext d-flex mlnew">
                                                    
                                                  
                                                    <li style="padding-right: 15px;"><strong>Dispatch No:</strong> <span
                                                            class="lig-tx">{{ $item['dispatchNo'] }} </span></li>

                                                  
                                                    <li style="padding-right: 15px;"><strong>Dispatch Date:</strong> <span
                                                        class="lig-tx pendingqty">{{ $item['dispatchdate'] }} </span></li>

                                                        <li style="padding-right: 15px;"><strong>Order Qty:</strong> <span
                                                            class="lig-tx">{{ $item['orderqty']  }} </span></li>
    
                                                            <li style="padding-right: 15px;"><strong>Pending Qty:</strong> <span
                                                                class="lig-tx">{{ $item['pendingqty'] }} </span></li>

                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endif
        </div>

        <!--end::Container-->
    </div>
@endsection

@section('js')
    <script>

        function isMobileDevice() {
            return window.innerWidth <= 768;
        }

        function capitalizeFirstLetter(string) {
            if (!string) return ''; // Check if the string is empty
            return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
        }

        function ordercategoryfun(){

            var order_category = "{{ $order->order_category}}";

            //console.log('order_category =>'+ order_category);

            $('.product_infromation').removeClass('d-none');

            if (order_category == 'Sanitaryware') {
                //console.log('Sanitaryware');
                $('#accordion-0').addClass('d-none');
                $('#accordion-1').addClass('d-none');
                $('#accordion-2').removeClass('d-none');
            } else {
               // console.log('allied');
                $('#accordion-0').removeClass('d-none');
                $('#accordion-1').removeClass('d-none');
                $('#accordion-2').addClass('d-none');
            
            }

        }

        fungetalldistributor().done(function(response) {
            var data = response.data;
            var distributor_order = {{ $order->customerId_fk }}
            var options = '<option value="" >Select Distributor</option>';
            $.each(data, function(key, value) {
                var selected = (value.customerId == distributor_order) ? 'selected' : '';
                options += '<option value="' + value.customerId + '" ' + selected + ' >' + value
                    .CustomerName +
                    '</option>';
            });
            $('#alldistributor').empty().append(options);
        });

        funbanktype().done(function(masterdistributor) {
            var data = masterdistributor.data;
            var bankname = '{{ $order->bankId_fk }}';
            var options = '<option value="" >Select Nature Business</option>';
            $.each(data, function(key, value) {
                var selected = (value.masterMenuId == bankname) ? 'selected' : '';
                options += '<option value="' + value.masterMenuId + '" ' + selected + ' >' + value.name +
                    '</option>';
            });
            $('#bank_name').empty().append(options);
        });


        funtransproter().done(function(response) {
            var data = response.data;
            var transportname = {{ $order->transportId_fk }}
            var options = '<option value="" >Select Transproter</option>';
            $.each(data, function(key, value) {
                var selected = (value.masterMenuId == transportname) ? 'selected' : '';
                options += '<option value="' + value.masterMenuId + '" ' + selected + ' >' + value.name +
                    '</option>';
            });
            $('#tansproter').empty().append(options);
        });

        fungetordertype().done(function(response) {
            var data = response.data;
            var ordertype = {{ $order->orderType }}
            var options = '<option value="" >Select Order type</option>';
            $.each(data, function(key, value) {
                var selected = (value.masterMenuId == ordertype) ? 'selected' : '';
                options += '<option value="' + value.masterMenuId + '"  ' + selected + '>' + value.name +
                    '</option>';
            });
            $('#order_type').empty().append(options);
        });

        fungetpaymnetmode().done(function(response) {
            var data = response.data;
            var paymentmode = '{{ $order->paymentMode }}';
            var options = '<option value="" >Select payment mode</option>';
            $.each(data, function(key, value) {
                var selected = (value.masterMenuId == paymentmode) ? 'selected' : '';
                options += '<option value="' + value.masterMenuId + '"  ' + selected + '>' + value.name +
                    '</option>';
            });
            $('#payment_mode').empty().append(options);
        });

        funbrand().done(function(response) {
            var data = response.data;
            var brand_id = '{{ $order->brandId_fk }}';
            console.log('brand_id =>'+brand_id);
            var options = '<option value="" >Select Brand</option>';
            $.each(data, function(key, value) {
                var selected = (value.masterMenuId == brand_id) ? 'selected' : '';
                options += '<option value="' + value.masterMenuId + '"  ' + selected + '>' + value.name +'</option>';
            });

            $('#order_brand').empty().append(options);

        });

        

        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('.dispatch_qty').on('input', function() {
                if (isMobileDevice()) {
                    $row = $(this).closest('.box-tb'); // Use the closest <ul> element in mobile view
                        console.log('mobile');
                } else {
                    $row = $(this).closest('tr'); // Use the closest <tr> element in desktop view
                        console.log('desktop');
                }

                var pendingQty = parseInt($row.find('.pendingqty').text().trim(), 10) || 0;
                var dispatchQty = parseInt($(this).val().trim(), 10) || 0;

             //   console.log('pendingQty => '+pendingQty);
                // Check if dispatch quantity exceeds pending quantity
                if (dispatchQty > pendingQty) {
                    toastr.error('Dispatch quantity cannot exceed pending quantity.');
                    // Disable the buttons
                    $('.dispatchbutton').prop('disabled', true);
                } else {
                    // Enable the buttons if the condition is met
                    $('.dispatchbutton').prop('disabled', false);
                }
            });



            $(document).on('click', '.dispatchbutton', function() {
            
                var button = $(this).data('id');
                var order_id = $('#order_id').val();
                var dispatch_remarks = $('#dispatch_remarks').val();
                const dispatchdata = [];

                if (isMobileDevice()) {

                    $('#product-list-mobile .box-tb').each(function() {
                        const productId = $(this).find('.cartproductId').val();
                        const qty = $(this).find('.qty').val();
                        const dispatch_qty = $(this).find('.dispatch_qty').val();
                        const itemOrderId = $(this).find('.itemOrderId').val();

                        dispatchdata.push({
                            productId: productId,
                            qty: qty,
                            dispatch_qty:dispatch_qty,
                            itemOrderId:itemOrderId
                        });
                        
                    });

                }else{

                    $('#product-list tr').each(function() {
                        const productId = $(this).find('.cartproductId').val();
                        const qty = $(this).find('.qty').val();
                        const dispatch_qty = $(this).find('.dispatch_qty').val();
                        const itemOrderId = $(this).find('.itemOrderId').val();
                        dispatchdata.push({
                            productId: productId,
                            qty: qty,
                            dispatch_qty:dispatch_qty,
                            itemOrderId:itemOrderId
                        });
                    });

                }

                const data = {
                        button:button,
                        orderId:order_id,
                        dispatch_remarks:dispatch_remarks,
                        dispatchdata:dispatchdata       
                        };

                        $.ajax({
                            type: 'POST',
                            url: "{{ route('dispatch.submit') }}",
                            data: data,
                            success: function(response) {
                                $('.distriloader').addClass('d-none');
                                // var resp = response.resp;
                                // var msg = response.msg;
                                var redirecturl = "{{ route('pending.dispatch') }}";
                                if (response == 1) {
                                    toastr.success('Dispatch sucessfully');
                                    window.location.href = redirecturl;
                                } else {
                                    toastr.error('Order not insert');
                                }

                                // location.reload();
                            },
                            error: function(xhr, status, error) {
                                toastr.error(
                                    'An error occurred while submitting the form.'
                                );
                            }
                        });

            });

         });


        




        
    </script>
@endsection
