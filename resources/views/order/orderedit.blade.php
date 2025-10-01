@extends('layouts.main')

@section('css')

<style>
    #searchResultsmobile li {
        list-style: none;
    }
</style>

@endsection

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
                <li class="breadcrumb-item text-dark">Edit Order</li>

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
                                <input type="hidden" name="order_pdf" id="order_pdf" value="{{ $order->pdf_filename }}">

                                <div class="mb-1 row">
                                    <div class="col-sm-3 mb-1">
                                        <div class="float-select">
                                            <select id="alldistributor" class="form-select form-select-sm"
                                                data-control="select2" data-placeholder=" " disabled autocomplete="off">
                                            </select>
                                            <label class="new-labels"> Select Distributor Network <span class="text-danger">*</span> </label>
                                        </div>

                                        <div class="floating-label-group mb-3">


                                            <input type="text" id="discount" class="form-control "
                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                value="{{ 
        ($order->order_category == 'Allied & Faucet') 
            ? (($order->orderType == '229') 
                ? $customerdiscount->faucet_finaldiscount 
                : $customerdiscount->display_discount)
            : (($order->orderType == '229') 
                ? $customerdiscount->sanitary_finaldiscount 
                : $customerdiscount->display_discount)
    }}" required="" readonly
                                                autocomplete="off">

                                            <input type='hidden' name="faucet_ex_fc_disc" id="faucet_ex_fc_disc"
                                                value="{{ $customerdiscount->faucet_ex_fc_disc }}">
                                            <input type='hidden' name="sanitary_ex_sc_dicount"
                                                id="sanitary_ex_sc_dicount"
                                                value="{{ $customerdiscount->sanitary_ex_sc_dicount }}">
                                            <input type='hidden' name="sanitary_finaldiscount"
                                                value="{{ $customerdiscount->sanitary_finaldiscount }}"
                                                id="sanitary_finaldiscount">
                                            <input type='hidden' name="faucet_finaldiscount"
                                                value="{{ $customerdiscount->faucet_finaldiscount }}"
                                                id="faucet_finaldiscount">
                                            <input type='hidden' name="sales_person"
                                                value="{{ $trans_customersalesperson->userId_fk }}"
                                                id="sales_person_id">
                                            <input type='hidden' name="pendingtgt" value="{{ $pendingTgt }}"
                                                id="pending_tgt">
                                            <input type='hidden' name="display_discount" value="{{ $customerdiscount->display_discount }}" id="display_discount">
                                            <input type='hidden' name="consigneecount" id="consigneecount" value="{{ count($orderconsignee) }}">
                                            <input type='hidden' name="consigneecustomer" id="consigneecustomer" value="{{$order->customerId_fk}}">
                                            <label class="floating-label-new">Discount(%) <span class="text-danger">*</span> </label>
                                        </div>


                                        <div class="floating-label-group mb-3">
                                            <input type="text" id="party_balance" class="form-control "
                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                required="" autocomplete="off">
                                            <label class="floating-label px">Party Balance</label>
                                        </div>


                                        <div class="floating-label-group  mb-3">
                                            <input type="text" id="cash_discount" class="form-control "
                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                value="{{ $order->casheDiscount }}" required="" autocomplete="off">
                                            <label class="floating-label px">Cash Discount</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" id="shipping_address">{{ $order->shppingAddress }}</textarea>
                                            <label for="floatingTextarea" class="floatingTextarea">Shipping
                                                Address <span class="text-danger">*</span> </label>
                                        </div>

                                    </div>

                                    <div class="col-sm-3 mb-1">

                                        <div class="float-select">
                                            <select id="order_category" class="form-select form-select-sm"
                                                data-control="select2" data-placeholder="" autocomplete="off" disabled>
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
                                                data-control="select2" data-placeholder=" " autocomplete="off">
                                            </select>
                                            <label class="new-labels">Bank Name</label>
                                        </div>


                                        <div class="floating-label-group" style='height: 40px;'>

                                            <select id="payment_mode" class="form-select form-select-sm"
                                                data-control="select2" data-placeholder=" " autocomplete="off">
                                            </select>
                                            <label class="new-labels">Payment Mode <span class="text-danger">*</span> </label>
                                        </div>

                                        <div class="form-floating">
                                            <textarea class="form-control" id="Remarks" autocomplete="off">{{ $order->remarks }}</textarea>
                                            <label for="floatingTextarea" class="floatingTextarea">Remarks</label>
                                        </div>

                                    </div>

                                    <div class="col-sm-3">


                                        <div class="float-select">
                                            <select id="order_type" class="form-select form-select-sm"
                                                data-control="select2" data-placeholder="" autocomplete="off" disabled>
                                            </select>
                                            <label class="new-labels">Order Type <span class="text-danger">*</span> </label>
                                        </div>


                                        <div class="floating-label-group  mb-3">
                                            <input type="text" id="target_value" class="form-control"
                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                value="{{ $primaryTarget }}" required="" readonly
                                                autocomplete="off">
                                            <label class="floating-label-new">Target Value <span class="text-danger">*</span> </label>
                                        </div>



                                        <div class="floating-label-group mb-3 retailer_projectname">

                                            @if(count($orderconsignee) <= 1)
                                                <input type="text" id="retailer_project_name" class="form-control "
                                                required="" value="{{ $order->retailer_project_name }}" readonly
                                                autocomplete="off">
                                                <label class="floating-label-new">Retailer/Project Name</label>

                                                @else

                                                <select id="retailer_project_name" class="form-select form-select-sm"
                                                    data-control="select2" data-placeholder=" " autocomplete="off">
                                                    <option></option>

                                                    @foreach($orderconsignee as $key => $val)
                                                    <option value="{{ $val->consignmentName}}" {{ $val->consignmentName == $order->retailer_project_name ? 'selected' : '' }}>{{ $val->consignmentName}}</option>
                                                    @endforeach

                                                </select>
                                                <label class="new-labels">Retailer/Project Name </label>
                                                @endif
                                        </div>

                                        <div class="floating-label-group mb-3">
                                            <input type="text" id="cheque_numebr" class="form-control"
                                                required="" value="{{ $order->chequeNumber }}"
                                                autocomplete="off">
                                            <label class="floating-label px">Cheque Number</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 mb-1">

                                        <div class="float-select">
                                            <select id="order_brand" class="form-select form-select-sm"
                                                data-control="select2" data-placeholder="" autocomplete="off">
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
                                                value="{{ date('d-M-Y', $order->deliveryDate) }}" required="">
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

        <div class="row mb-5 mb-xl-8 product_infromation">
            <div class="card">
                <div class="card-header ">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Product Information</span>
                    </h3>
                    <input type="text" class="form-control" id="myInput2" oninput="debounceSearch()" placeholder="Search..." title="Search in table">
                </div>
                <div class="card-body">

                    <div>
                        <table id="searchResults" class="table table-bordered bold-border table-striped desk-mar">

                        </table>
                    </div>

                    <div id="searchResultsmobile">
                    </div>
                    <div class="row productshow">
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5 mb-xl-8" id="item-info-section">
            <div class="card">
                <div class="card-header ">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Item Information</span>
                    </h3>
                </div>
                <div class="card-body py-3">
                    <div class="table-responsive desk-display">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr class="fw-bolder bg-light">
                                    <th class="min-w-150px rounded-start">Series</th>
                                    <th class="min-w-300px rounded-start">Product Information </th>
                                    <th class="min-w-100px text-center">Qty</th>
                                    <th class="min-w-100px text-right">MRP</th>
                                    {{-- <th class="min-w-100px text-center">Disc (%)</th> --}}
                                    <th class="min-w-100px text-center">Amount</th>

                                </tr>
                            </thead>
                            <tbody id="product-list">
                                @foreach ($orderitem as $item)

                                @php
                                if($item->netrate != '') {
                                $mrp = number_format($item->netrate, 2, '.', ',') . '<span class="text-danger">*</span>';

                                } else {
                                $mrp = number_format($item->pcsRate, 2, '.', ',');

                                }

                                if($item->mrptype == 'netrate') {
                                $mrptype = 'netrate';
                                $astrick = '<span class="text-danger">*</span>';
                                }else{
                                $mrptype = 'mrp';
                                $astrick = '';
                                }


                                @endphp
                                @if($item->pcsRate != 0)
                                <tr data-product-id="{{ $item->productId_fk }}">
                                    <input type="hidden" value="{{ $item->productId_fk }}" class="cartproductId">
                                    <input type="hidden" value="{{ $item->qty }}" class="qty">
                                    <input type="hidden" value="{{ $mrptype }}" class="mrptype">
                                    <input type="hidden" value="{{ $item->subCategoryId_fk }}" class="seriesid">
                                    <input type="hidden" value="{{ $item->pcsRate }}" class="pcsRate">
                                    <input type="hidden" value="{{ $item->totalAmt }}" class="totalAmt">
                                    <td>{{ ucwords(strtolower($item->serisname)) }} </td>
                                    <td>{{ ucwords(strtolower($item->productName)) }} </td>
                                    <td class="text-right quantity">{{ $item->qty }}</td>
                                    <td class="text-right">{!! $mrp !!} {!! $astrick !!}</td>
                                    <td class="text-right amount">{{ number_format($item->totalAmt, 2, '.', ',') }}</td>

                                </tr>
                                @endif

                                @endforeach

                            </tbody>

                            <tbody id="free-product-list">
                                @foreach ($orderitem as $item)

                                @php
                                if($item->netrate != '') {
                                $mrp = $item->netrate . '<span class="text-danger">*</span>';

                                } else {
                                $mrp = $item->pcsRate;

                                }


                                if($item->mrptype == 'netrate') {
                                $mrptype = 'netrate';
                                $astrick = '<span class="text-danger">*</span>';
                                }else{
                                $astrick = '';
                                $mrptype = 'mrp';
                                }



                                @endphp

                                @if($item->pcsRate == 0)

                                <tr data-product-id="{{ $item->productId_fk }}">
                                    <input type="hidden" value="{{ $item->productId_fk }}" class="cartproductId">
                                    <input type="hidden" class="mrptype" value="{{ $item->productId_fk }}">
                                    <input type="hidden" value="{{ $item->qty }}" class="qty">
                                    <input type="hidden" value="{{ $mrptype }}" class="mrptype">
                                    <input type="hidden" value="{{ $item->subCategoryId_fk }}" class="seriesid">
                                    <input type="hidden" value="{{ $item->pcsRate }}" class="pcsRate">
                                    <input type="hidden" value="{{ $item->totalAmt }}" class="totalAmt">
                                    <td>{{ ucwords(strtolower($item->serisname)) }} </td>
                                    <td>{{ ucwords(strtolower($item->productName)) }} <span class="badge badge-success scheme" style='font-size:7px'>In Scheme</span> </td>
                                    <td class="text-right quantity">{{ $item->qty }}</td>
                                    <td class="text-right">{!! $mrp !!} {!! $astrick !!}</td>
                                    <td class="text-right amount">{{ number_format($item->totalAmt, 2, '.', ',') }}</td>

                                </tr>

                                @endif

                                @endforeach

                            </tbody>

                            <tfoot class="bdr-top">
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Total
                                            Quantity</strong></td>
                                    <td class="text-right totalquantity"> {{ $order->quantity }}</td>

                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Amount</strong></td>
                                    <td class="text-right subtotal"> ₹
                                        {{ number_format($order->totalAmt, 2, '.', ',') }}
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Discount</strong></td>
                                    <td class="text-right discountamount"> ₹
                                        {{ number_format($order->discountAmt, 2, '.', ',') }}
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Value</strong></td>
                                    @php
                                    $disamount = $order->totalAmt - $order->discountAmt;
                                    $formattedDisamount = number_format($disamount, 2, '.', ',');
                                    @endphp
                                    <td class="text-right amountafterdiscount"> ₹ {{ $formattedDisamount }}</td>

                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>GST@18%</strong></td>
                                    <td class="text-right gstamount"> ₹
                                        {{ number_format($order->taxAmt, 2, '.', ',') }}
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Grand Total</strong></td>
                                    <td class="text-right grandtotal"> ₹
                                        {{ number_format($order->grandAmt, 2, '.', ',') }}
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Target Value</strong></td>
                                    @php
                                    $primaryTarget = $trans_salestarget ? moneyFormatIndia($primaryTarget ) : 0
                                    @endphp
                                    <td class="text-right targetvalue"> ₹ {{ $primaryTarget }}</td>

                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right "><strong>MTD</strong></td>
                                    <td class="text-right mtd_val"> ₹ {{ moneyFormatIndia($mtd) }} </td>

                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right "><strong>Pending TGT</strong></td>
                                    <td class="text-right pendingtgt"> ₹ {{ moneyFormatIndia($pendingTgt) }}</td>

                                </tr>
                            </tfoot>
                        </table>

                    </div>

                    <div class="item-mobile">
                        <div class="mob-box mo-display">

                            <div id="product-list-mobile">

                                @foreach ($orderitem as $item)

                                @php
                                if($item->netrate != '') {
                                $mrp = $item->netrate . '<span class="text-danger">*</span>';
                                $mrptype = 'netrate';
                                } else {
                                $mrp = $item->pcsRate;
                                $mrptype = 'mrp';
                                }



                                if($item->mrptype == 'netrate') {
                                $astrick = '<span class="text-danger">*</span>';
                                }else{
                                $astrick = '';
                                }

                                @endphp

                                @if($item->pcsRate != 0)
                                <div class="box-tb">

                                    <!-- <td>{{ ucwords(strtolower($item->serisname)) }} </td>
                                            <td>{{ ucwords(strtolower($item->productName)) }} <span class="badge badge-success">In Scheme</span> </td> -->

                                    <div class="row">
                                        <div class="col-10 item-name"><strong>{{ ucwords(strtolower($item->productName)) }}</strong>
                                        </div>
                                        <div class="col-2 qt-box pl-0"><input class="form-control form-ctr2 qty"
                                                value="{{ $item->qty }}" readonly type="text"></div>
                                    </div>
                                    <div class="row">
                                        <ul class="dptext d-flex mlnew">
                                            <input type="hidden" value="{{ $item->productId_fk }}" class="cartproductId">
                                            <input type="hidden" value="{{ $item->qty }}" class="qty">
                                            <input type="hidden" value="{{ $item->pcsRate }}" class="pcsRate">
                                            <input type="hidden" value="{{ $mrptype }}" class="mrptype">
                                            <input type="hidden" value="{{ $item->totalAmt }}" class="totalAmt">
                                            <input type="hidden" value="{{ $item->subCategoryId_fk }}" class="seriesid">

                                            <li style="padding-right: 15px;"><strong>Series:</strong> <span
                                                    class="lig-tx">{{ ucwords(strtolower($item->serisname)) }} </span></li>

                                            <li style="padding-right: 15px;"><strong>MRP:</strong> <span
                                                    class="lig-tx">{!! $mrp !!} {!! $astrick !!} </span></li>
                                            <li style="padding-right: 15px;" class="pdnew">
                                                <strong>Amount:</strong>{{ number_format($item->totalAmt, 2, '.', ',') }}
                                            </li>



                                        </ul>
                                    </div>
                                </div>
                                @endif

                                @endforeach

                            </div>

                            <div id="free-product-list-mobile">

                                @foreach ($orderitem as $item)

                                @php
                                if($item->netrate != '') {
                                $mrp = $item->netrate . '<span class="text-danger">*</span>';
                                $mrptype = 'netrate';
                                } else {
                                $mrp = $item->pcsRate;
                                $mrptype = 'mrp';
                                }
                                @endphp

                                @if($item->pcsRate == 0)
                                <div class="box-tb">

                                    <!-- <td>{{ ucwords(strtolower($item->serisname)) }} </td>
                                            <td>{{ ucwords(strtolower($item->productName)) }} <span class="badge badge-success">In Scheme</span> </td> -->

                                    <div class="row">
                                        <div class="col-10 item-name"><strong>{{ ucwords(strtolower($item->productName)) }} <span class="badge badge-success scheme" style='font-size:7px'>In Scheme</span> </strong>
                                        </div>
                                        <div class="col-2 qt-box pl-0"><input class="form-control form-ctr2 qty"
                                                value="{{ $item->qty }}" readonly type="text"></div>
                                    </div>
                                    <div class="row">
                                        <ul class="dptext d-flex mlnew">
                                            <input type="hidden" value="{{ $item->productId_fk }}" class="cartproductId">
                                            <input type="hidden" value="{{ $item->qty }}" class="qty">
                                            <input type="hidden" value="{{ $item->pcsRate }}" class="pcsRate">
                                            <input type="hidden" value="{{ $mrptype }}" class="mrptype">
                                            <input type="hidden" value="{{ $item->totalAmt }}" class="totalAmt">
                                            <input type="hidden" value="{{ $item->subCategoryId_fk }}" class="seriesid">


                                            <li><strong>Series:</strong> <span
                                                    class="lig-tx">{{ ucwords(strtolower($item->serisname)) }} </span></li>

                                            <li><strong>MRP:</strong> <span
                                                    class="lig-tx">{!! $mrp !!} </span></li>
                                            <li class="pdnew">
                                                <strong>Amount:</strong>{{ number_format($item->totalAmt, 2, '.', ',') }}
                                            </li>



                                        </ul>
                                    </div>
                                </div>
                                @endif

                                @endforeach

                            </div>


                            <div class="box-tb totalsvalue mt-5 border-0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-striped table-bordered ">
                                            <tbody>
                                                <tr>
                                                    <td colspan="5" class="text-left"><strong>Total
                                                            Quantity</strong></td>
                                                    <td class="text-right mobtotalqty"> {{ $order->quantity }} </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="text-left"><strong>Amount</strong></td>
                                                    <td class="text-right mobtotalamount"> ₹
                                                        {{ number_format($order->totalAmt, 2, '.', ',') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="text-left"><strong>Discount</strong>
                                                    </td>
                                                    <td class="text-right mobdiscountamount"> ₹
                                                        {{ number_format($order->discountAmt, 2, '.', ',') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="text-left"><strong>Value</strong></td>
                                                    <td class="text-right mobamountafterdiscount"> ₹
                                                        {{ $formattedDisamount }}
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="text-left"><strong>GST@18%</strong></td>
                                                    <td class="text-right mobgstamount"> ₹
                                                        {{ number_format($order->taxAmt, 2, '.', ',') }}
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="text-left"><strong>Grand Total</strong>
                                                    </td>
                                                    <td class="text-right mobgrandtotal"> ₹
                                                        {{ number_format($order->grandAmt, 2, '.', ',') }}
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="text-left"><strong>Target Value</strong>
                                                    </td>
                                                    <td class="text-right mobtargetvalue"> {{ $trans_salestarget->primaryTarget ?? 0; }} </td>

                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="text-left"><strong>MTD</strong></td>
                                                    <td class="text-right mobmtd_val"> {{ $mtd }}</td>

                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="text-left"><strong>Pending TGT</strong>
                                                    </td>
                                                    <td class="text-right mobpendingtgt"> {{ $pendingTgt }} </td>

                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>


                                </div>
                            </div>


                        </div>
                    </div>

                    <a href="#" class="btn btn-sm btn-primary pull-right ordersubmit"> Save <div
                            class="spinner-border d-none distriloader" role="status">
                        </div> </a>
                </div>
            </div>
        </div>


    </div>

    <!--end::Container-->
</div>
@endsection

@section('js')
<script>
    function isMobileDevice() {
        return window.innerWidth <= 768;
    }

    let debounceTimer;

    function debounceSearch() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(search, 200); // Adjust delay as needed
    }



    if (isMobileDevice()) {
        document.addEventListener("input", function(event) {
            if (event.target.classList.contains("mobileqty")) {
                let searchBox = event.target.closest(".box-tb"); // Get the searched item box
                let productId = searchBox.querySelector(".productId")?.value; // Get product ID

                if (!productId) return; // Exit if product ID is not found

                // Find the corresponding item in the original product list (excluding search results)
                let originalBox = [...document.querySelectorAll(".box-tb")].find(box =>
                    box.querySelector(".productId")?.value === productId &&
                    !box.closest("#searchResultsmobile") // Ensure it's not inside search results
                );

                if (originalBox) {
                    let qtyValue = event.target.value.trim();
                    let originalQtyInput = originalBox.querySelector(".mobileqty");

                    if (originalQtyInput) {
                        originalQtyInput.value = qtyValue; // Update qty in original list
                    }

                    // Get price and calculate amount
                    let price = parseFloat(originalBox.querySelector(".price")?.innerText.trim()) || 0;
                    let amount = qtyValue ? (parseInt(qtyValue) * price).toFixed(2) : "";

                    // Update amount in both search results and original list
                    let originalAmount = originalBox.querySelector(".amount");
                    let searchAmount = searchBox.querySelector(".amount");

                    if (originalAmount) originalAmount.innerText = amount;
                    if (searchAmount) searchAmount.innerText = amount;
                }
            }
        });

        function search() {
            var input = document.getElementById("myInput2");
            var filter = input.value.toUpperCase().trim();
            var items = document.querySelectorAll(".box-tb"); // Select all product boxes
            let searchResults = document.getElementById("searchResultsmobile"); // Search result container

            // Clear previous search results
            searchResults.innerHTML = "";

            // If input is empty, show all items and return
            if (filter === "") {
                items.forEach(function(item) {
                    item.style.display = ""; // Show all items
                });
                return;
            }

            items.forEach(function(item) {
                var productNameElement = item.querySelector(".item-name strong"); // Get product name
                var txtValue = productNameElement ? productNameElement.textContent || productNameElement.innerText : "";

                if (txtValue.toUpperCase().includes(filter)) {
                    let clone = item.cloneNode(true); // Clone matching item
                    searchResults.appendChild(clone); // Append to search results div
                }
            });
        }

    } else {

        document.addEventListener("input", function(event) {
            if (event.target.classList.contains("qty")) {
                let searchRow = event.target.closest("tr"); // Get the row in searchResults
                let originalTable = document.querySelector(".productshow"); // Original table
                let productId = searchRow.querySelector(".productId").value; // Get product ID

                // Find the corresponding row in the original table
                let originalRow = [...originalTable.getElementsByTagName("tr")].find(row =>
                    row.querySelector(".productId")?.value === productId
                );

                if (originalRow) {
                    let qtyValue = event.target.value.trim();
                    originalRow.querySelector(".qty").value = qtyValue; // Update qty in original row

                    // Get price and calculate amount
                    let price = parseFloat(originalRow.querySelector(".price").innerText.trim()) || 0;
                    let amount = qtyValue ? (parseInt(qtyValue) * price).toFixed(2) : "";

                    originalRow.querySelector(".amount").innerText = amount; // Update amount in original row
                    searchRow.querySelector(".amount").innerText = amount; // Update amount in searchResults
                }
            }
        });

        function search() {
                var input = document.getElementById("myInput2");
                var filter = input.value.toUpperCase().trim();
                var table = document.querySelector(".productshow"); // Select table container
                var rows = table.getElementsByTagName("tr"); // Get all table rows
                let searchResults = document.getElementById("searchResults");

                // Clear previous search results
                searchResults.innerHTML = "";

                // If input is empty, reset table and return
                if (filter === "") {
                    for (let i = 0; i < rows.length; i++) {
                        rows[i].style.display = ""; // Show all rows
                    }
                    return;
                }

                for (var i = 0; i < rows.length; i++) {
                    var txtValue = "";
                    var cells = rows[i].getElementsByTagName("td"); // Get all table cells in the row

                    // Check if any parent accordion has 'd-none'
                    let skipRow = false;
                    let parent = rows[i].closest(".accordion");

                    while (parent) {
                        if (parent.classList.contains("d-none")) {
                            skipRow = true;
                            break; // Stop checking once we find a hidden accordion
                        }
                        parent = parent.parentElement.closest(".accordion");
                    }

                    if (skipRow) {
                        continue; // Skip this row if any parent accordion is hidden
                    }

                    // Combine text from all table cells in the row
                    for (var j = 0; j < cells.length; j++) {
                        var cellText = cells[j].textContent || cells[j].innerText;
                        txtValue += cellText.replace(/,/g, '').trim(); // Remove commas and trim spaces
                    }

                    if (txtValue.toUpperCase().includes(filter)) {
                        let clone = rows[i].cloneNode(true); // Clone matching row
                        searchResults.appendChild(clone); // Append to search results div
                    }
                }
            }
    }



    fungetalldistributor().done(function(response) {
        var data = response.data;
        var distributor_order = '{{ $order->CustomerName }}'.replace(/&amp;/g, '&');
        //console.log('distributor_order => ' + distributor_order);
        var options = '<option value="">Select Distributor</option>';

        $.each(data, function(key, value) {
            // Use the trim method correctly
            if (value.CustomerName == null) {
                return
            }
            var selected = (value.CustomerName.trim() == distributor_order.trim()) ? 'selected' : '';
            options += '<option value="' + value.customerId + '" ' + selected + '>' + value.CustomerName + '</option>';
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
        var transportname = '{{ $order->transportId_fk }}';
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
        var ordertype = '{{ $order->orderType }}';
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
        console.log('brand_id =>' + brand_id);
        var options = '<option value="" >Select Brand</option>';
        $.each(data, function(key, value) {
            var selected = (value.masterMenuId == brand_id) ? 'selected' : '';
            options += '<option value="' + value.masterMenuId + '"  ' + selected + '>' + value.name + '</option>';
        });

        $('#order_brand').empty().append(options);

    });

    function capitalizeFirstLetter(string) {
        if (!string) return ''; // Check if the string is empty
        return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
    }

    function ordercategoryfun() {

        var order_category = "{{ $order->order_category}}";

        console.log('order_category =>' + order_category);

        $('.product_infromation').removeClass('d-none');

        if (order_category == 'Sanitaryware') {
            console.log('Sanitaryware');
            $('#accordion-0').addClass('d-none');
            $('#accordion-1').addClass('d-none');
            $('#accordion-2').removeClass('d-none');
        } else {
            console.log('allied');
            $('#accordion-0').removeClass('d-none');
            $('#accordion-1').removeClass('d-none');
            $('#accordion-2').addClass('d-none');

        }

    }

    $(document).ready(function() {


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
                    // console.log(response);

                    var faucet_ex_fc_disc = response.faucet_ex_fc_disc;
                    var sanitary_ex_sc_dicount = response.sanitary_ex_sc_dicount;
                    var sanitary_finaldiscount = response.sanitary_finaldiscount;
                    var faucet_finaldiscount = response.faucet_finaldiscount;
                    var display_discount = response.display_discount;
                    var salesperson = response.salesperson;
                    var primary_target = response.primary_target;
                    var mtd = response.mtd;
                    var pendingTgt = response.pendingTgt;
                    var consigneecount = response.consigneecount;
                    var orderconsignee = response.orderconsignee;

                    $('#faucet_ex_fc_disc').val(faucet_ex_fc_disc);
                    $('#sanitary_ex_sc_dicount').val(sanitary_ex_sc_dicount);
                    $('#sanitary_finaldiscount').val(sanitary_finaldiscount);
                    $('#faucet_finaldiscount').val(faucet_finaldiscount);
                    $('#sales_person_id').val(salesperson);
                    $('#display_discount').val(display_discount);
                    $('#target_value').val(primary_target);
                    $('#mtd_value').val(mtd);
                    $('#pending_tgt').val(pendingTgt);
                    $('#consigneecount').val(consigneecount);

                    if (consigneecount <= 1) {

                        var consignmentName = orderconsignee[0].consignmentName ? orderconsignee[0].consignmentName : '';
                        var conignaddress = orderconsignee[0].address ? orderconsignee[0].address : '';

                        var html = ` <input type="text" id="retailer_project_name" class="form-control "
                                                        required=""  value="` + consignmentName + `"
                                                        autocomplete="off">
                                                    <label class="floating-label px">Retailer/Project Name </label>`;

                        $('#shipping_address').val(conignaddress);

                    } else {

                        var html = `<select id="retailer_project_name" class="form-select form-select-sm"
                            data-control="select2" data-placeholder=" " autocomplete="off">
                            <option></option>
                            `;

                        $.each(orderconsignee, function(key, value) {
                            html += `<option value="${value.consignmentName}">${value.consignmentName}</option>`;
                        });

                        html += `</select>
                            <label class="new-labels">Retailer/Project Name <span class="text-danger">*</span></label>`;

                    }

                    $('.retailer_projectname').html(html);

                    if (order_category != '') {

                        if (order_category == 'Allied & Faucet' & order_type == '228') {

                            var faucet_ex_fc_disc = parseFloat($('#faucet_ex_fc_disc').val()) || 0;
                            var display_discount = parseFloat($('#display_discount').val()) || 0;
                            let totalDiscount = 1;
                            totalDiscount *= (1 - display_discount / 100);
                            totalDiscount *= (1 - faucet_ex_fc_disc / 100);
                            totalDiscount = (1 - totalDiscount) * 100;
                            var discount = totalDiscount.toFixed(2);

                        } else if (order_category == 'Allied & Faucet' & order_type == '229') {

                            var discount = $('#faucet_finaldiscount').val();

                        } else if (order_category == 'Sanitaryware' & order_type == '228') {

                            var sanitary_ex_sc_dicount = parseFloat($('#sanitary_ex_sc_dicount').val()) || 0;
                            var display_discount = parseFloat($('#display_discount').val()) || 0;
                            let totalDiscount = 1;
                            totalDiscount *= (1 - display_discount / 100);
                            totalDiscount *= (1 - sanitary_ex_sc_dicount / 100);
                            totalDiscount = (1 - totalDiscount) * 100;
                            var discount = totalDiscount.toFixed(2);

                        } else if (order_category == 'Sanitaryware' & order_type == '229') {

                            var discount = $('#sanitary_finaldiscount').val();

                        }




                        $('#discount').val(discount);

                        updateSubtotalmobile();
                        updateSubtotal();

                    }


                    updateSubtotalmobile();
                    updateSubtotal();

                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });

        });

        $(document).on('change', '#retailer_project_name', function() {

            var retailer_project_name = $(this).val();
            var alldistributor = $('#alldistributor').val();
            var order_type = $('#order_type').val();
            var order_category = $('#order_category').val();

            $.ajax({
                type: 'POST',
                url: '{{ route("order.consigneedata") }}',
                data: {
                    retailer_project_name: retailer_project_name,
                    alldistributor: alldistributor
                },
                success: function(response) {

                    console.log(response);

                    $('#shipping_address').val(response.address);
                    $('#faucet_ex_fc_disc').val(response.faucet_ex_fc_disc);
                    $('#sanitary_ex_sc_dicount').val(response.sanitary_ex_sc_dicount);
                    $('#sanitary_finaldiscount').val(response.sanitary_finaldiscount);
                    $('#faucet_finaldiscount').val(response.faucet_finaldiscount);
                    $('#display_discount').val(response.display_discount);
                    $('#sales_person_id').val(response.sales_person_id);
                    $('#consigneecustomer').val(response.customerId);


                    // if (order_category != '') {

                    //     if (order_category == 'Allied & Faucet' & order_type == '228') {

                    //         var faucet_ex_fc_disc = parseFloat($('#faucet_ex_fc_disc').val()) || 0;
                    //         var display_discount = parseFloat($('#display_discount').val()) || 0;
                    //         let totalDiscount = 1;
                    //         totalDiscount *= (1 - display_discount / 100);
                    //         totalDiscount *= (1 - faucet_ex_fc_disc / 100);
                    //         totalDiscount = (1 - totalDiscount) * 100;
                    //         var discount = totalDiscount.toFixed(2);

                    //     } else if (order_category == 'Allied & Faucet' & order_type == '229') {

                    //         var discount = $('#faucet_finaldiscount').val();

                    //     } else if (order_category == 'Sanitaryware' & order_type == '228') {

                    //         var sanitary_ex_sc_dicount = parseFloat($('#sanitary_ex_sc_dicount').val()) || 0;
                    //         var display_discount = parseFloat($('#display_discount').val()) || 0;
                    //         let totalDiscount = 1;
                    //         totalDiscount *= (1 - display_discount / 100);
                    //         totalDiscount *= (1 - sanitary_ex_sc_dicount / 100);
                    //         totalDiscount = (1 - totalDiscount) * 100;
                    //         var discount = totalDiscount.toFixed(2);

                    //     } else if (order_category == 'Sanitaryware' & order_type == '229') {
                    //         var discount = $('#sanitary_finaldiscount').val();
                    //     }



                    //     $('#discount').val(discount);

                    //     updateSubtotalmobile();
                    //     updateSubtotal();

                    // }
                },
                error: function(xhr, status, error) {
                    $('.productshow').html('<p>An error occurred: ' + error + '</p>');
                }
            });

        });


        $(document).on('change', '#order_type', function() {

            var order_type = $(this).val();
            var order_category = $('#order_category').val();

            if (order_category != '') {

                if (order_category == 'Allied & Faucet' & order_type == '228') {

                    var faucet_ex_fc_disc = parseFloat($('#faucet_ex_fc_disc').val()) || 0;
                    var display_discount = parseFloat($('#display_discount').val()) || 0;
                    let totalDiscount = 1;
                    totalDiscount *= (1 - display_discount / 100);
                    totalDiscount *= (1 - faucet_ex_fc_disc / 100);
                    totalDiscount = (1 - totalDiscount) * 100;
                    var discount = totalDiscount.toFixed(2);

                } else if (order_category == 'Allied & Faucet' & order_type == '229') {

                    var discount = $('#faucet_finaldiscount').val();

                } else if (order_category == 'Sanitaryware' & order_type == '228') {

                    var sanitary_ex_sc_dicount = parseFloat($('#sanitary_ex_sc_dicount').val()) || 0;
                    var display_discount = parseFloat($('#display_discount').val()) || 0;
                    let totalDiscount = 1;
                    totalDiscount *= (1 - display_discount / 100);
                    totalDiscount *= (1 - sanitary_ex_sc_dicount / 100);
                    totalDiscount = (1 - totalDiscount) * 100;
                    var discount = totalDiscount.toFixed(2);

                } else if (order_category == 'Sanitaryware' & order_type == '229') {

                    var discount = $('#sanitary_finaldiscount').val();

                }

                $('#discount').val(discount);
                updateSubtotalmobile();
                updateSubtotal();

            }
        });



        $(document).on('change', '#order_category', function() {

            var order_category = $(this).val();
            var order_type = $('#order_type').val();

            //console.log('order_type => ' + order_type)

            if (order_type != '') {

                if (order_category == 'Allied & Faucet' & order_type == '228') {

                    var faucet_ex_fc_disc = parseFloat($('#faucet_ex_fc_disc').val()) || 0;
                    var display_discount = parseFloat($('#display_discount').val()) || 0;
                    let totalDiscount = 1;
                    totalDiscount *= (1 - display_discount / 100);
                    totalDiscount *= (1 - faucet_ex_fc_disc / 100);
                    totalDiscount = (1 - totalDiscount) * 100;
                    var discount = totalDiscount.toFixed(2);

                } else if (order_category == 'Allied & Faucet' & order_type == '229') {

                    var discount = $('#faucet_finaldiscount').val();

                } else if (order_category == 'Sanitaryware' & order_type == '228') {

                    var sanitary_ex_sc_dicount = parseFloat($('#sanitary_ex_sc_dicount').val()) || 0;
                    var display_discount = parseFloat($('#display_discount').val()) || 0;
                    let totalDiscount = 1;
                    totalDiscount *= (1 - display_discount / 100);
                    totalDiscount *= (1 - sanitary_ex_sc_dicount / 100);
                    totalDiscount = (1 - totalDiscount) * 100;
                    var discount = totalDiscount.toFixed(2);

                } else if (order_category == 'Sanitaryware' & order_type == '229') {
                    var discount = $('#sanitary_finaldiscount').val();
                }

                $('#discount').val(discount);
                updateSubtotalmobile();
                updateSubtotal();

            }



        });


        $('#order_category').on('change', function() {

            var order_category = $(this).val();

            $('.product_infromation').removeClass('d-none');

            if (order_category == 'Allied & Faucet') {

                $('#accordion-0').removeClass('d-none');
                $('#accordion-1').removeClass('d-none');
                $('#accordion-2').addClass('d-none');

            } else {

                $('#accordion-0').addClass('d-none');
                $('#accordion-1').addClass('d-none');
                $('#accordion-2').removeClass('d-none')
            }


        });


        function productload() {

            var orderformdata = "{{ route('order.formdata') }}"
            var ordercustomerid = "{{ $order->customerId_fk }}"; // Correctly embed the route
            var orderitem = {!!json_encode($orderitem) !!};

            $.ajax({
                type: 'post',
                url: orderformdata,
                data: {
                    orderitem: orderitem,
                    ordercustomerid: ordercustomerid
                },
                success: function(response) {
                    $('.productshow').html(response.html);

                    setTimeout(function() {
                        ordercategoryfun();
                    }, 100); // Delay in milliseconds

                },
                error: function(xhr, status, error) {
                    $('.productshow').html('<p>An error occurred: ' + error + '</p>');
                }
            });
        }

        productload();



        $(document).on('input', '.item-name-filter', function() {
            var value = $(this).val().toLowerCase();
            var $table = $(this).closest('table');
            $table.find('tbody tr').filter(function() {
                $(this).toggle($(this).find('td:nth-child(2)').text().toLowerCase().indexOf(
                    value) > -1);
            });
        });

        $(document).on('input', '.item-search', function() {
            var searchText = $(this).val().toLowerCase();
            $(this).closest('.accordion-body-text').find('.item-name').each(function() {
                var itemText = $(this).text().toLowerCase();
                var boxTb = $(this).closest('.box-tb');
                if (itemText.includes(searchText)) {
                    boxTb.show();
                } else {
                    boxTb.hide();
                }
            });
        });


        $(document).on('click', '.ordersubmit', function() {
            Swal.fire({
                title: 'Do you want to update your order?',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {

                    var checkvalidation = 0;
                    var order_id = $('#order_id').val();

                    var consigneecount = $('#consigneecount').val();
                    if (consigneecount > 1) {
                        var alldistributor = $('#consigneecustomer').val();
                    } else {

                        var alldistributor = $('#alldistributor').val();
                    }

                    //var alldistributor = $('#alldistributor').val();
                    var discount = $('#discount').val();
                    var mtd_value = $('#mtd_value').val();
                    var order_pdf = $('#order_pdf').val();
                    var order_date = $('#order_date').val();
                    var target_value = $('#target_value').val();
                    var party_balance = $('#party_balance').val();
                    var retailer_project_name = $('#retailer_project_name').val();
                    var order_type = $('#order_type').val();
                    var cash_discount = $('#cash_discount').val();
                    var bank_name = $('#bank_name').val();
                    var cheque_numebr = $('#cheque_numebr').val();
                    var tansproter = $('#tansproter').val();
                    var deliverydate = $('#deliverydate').val();
                    var payment_mode = $('#payment_mode').val();
                    var shipping_address = $('#shipping_address').val();
                    var Remarks = $('#Remarks').val();
                    var sales_person_id = $('#sales_person_id').val();
                    var order_category = $('#order_category').val();
                    var pending_tgt = $('#pending_tgt').val();
                    var order_brand = $('#order_brand').val();

                    if (alldistributor == '') {
                        toastr.error('Select Distributor');
                        $('#alldistributor').css('border-color', 'red');
                        checkvalidation++;
                    } else {
                        $('#alldistributor').css('border-color', '');
                    }

                    if (discount == '') {
                        toastr.error('Enter Discount');
                        $('#discount').css('border-color', 'red');
                        checkvalidation++;
                    } else {
                        $('#discount').css('border-color', '');
                    }

                    if (payment_mode == '') {
                        toastr.error('Enter Payment Mode ');
                        $('#payment_mode').css('border-color', 'red');
                        checkvalidation++;
                    } else {
                        $('#payment_mode').css('border-color', '');
                    }

                    if (order_brand == '') {
                        toastr.error('Select Brand');
                        $('#order_brand').css('border-color', 'red');
                        checkvalidation++;
                    } else {
                        $('#order_brand').css('border-color', '');
                    }

                    if (order_date == '') {
                        toastr.error('Enter Order Date');
                        $('#order_date').css('border-color', 'red');
                        checkvalidation++;
                    } else {
                        $('#order_date').css('border-color', '');
                    }

                    // if (target_value == '') {
                    //     toastr.error('Enter target value');
                    //     $('#target_value').css('border-color', 'red');
                    //     checkvalidation++;
                    // } else {
                    //     $('#target_value').css('border-color', '');
                    // }

                    // if (party_balance == '') {
                    //     toastr.error('Enter party balance');
                    //     $('#party_balance').css('border-color', 'red');
                    //     checkvalidation++;
                    // } else {
                    //     $('#party_balance').css('border-color', '');
                    // }

                    // if (retailer_project_name == '') {
                    //     toastr.error('Enter retailer product');
                    //     $('#retailer_project_name').css('border-color', 'red');
                    //     checkvalidation++;
                    // } else {
                    //     $('#retailer_project_name').css('border-color', '');
                    // }

                    if (order_type == '') {
                        toastr.error('Select Order Type');
                        $('#order_type').css('border-color', 'red');
                        checkvalidation++;
                    } else {
                        $('#order_type').css('border-color', '');
                    }

                    // if (cash_discount == '') {
                    //     toastr.error('Enter Cash Discount');
                    //     $('#cash_discount').css('border-color', 'red');
                    //     checkvalidation++;
                    // } else {
                    //     $('#cash_discount').css('border-color', '');
                    // }

                    // if (bank_name == '') {
                    //     toastr.error('Select Bank Name');
                    //     $('#bank_name').css('border-color', 'red');
                    //     checkvalidation++;
                    // } else {
                    //     $('#bank_name').css('border-color', '');
                    // }

                    // if (cheque_numebr == '') {
                    //     toastr.error('Enter Cheque Number');
                    //     $('#cheque_numebr').css('border-color', 'red');
                    //     checkvalidation++;
                    // } else {
                    //     $('#cheque_numebr').css('border-color', '');
                    // }

                    if (tansproter == '') {
                        toastr.error('Select Transporter');
                        $('#tansproter').css('border-color', 'red');
                        checkvalidation++;
                    } else {
                        $('#tansproter').css('border-color', '');
                    }

                    // if (deliverydate == '') {
                    //     toastr.error('Enter Delivery date');
                    //     $('#deliverydate').css('border-color', 'red');
                    //     checkvalidation++;
                    // } else {
                    //     $('#deliverydate').css('border-color', '');
                    // }

                    if (payment_mode == '') {
                        toastr.error('Select Payment Mode');
                        $('#payment_mode').css('border-color', 'red');
                        checkvalidation++;
                    } else {
                        $('#payment_mode').css('border-color', '');
                    }

                    if (shipping_address == '') {
                        toastr.error('Enter Shipping Address');
                        $('#shipping_address').css('border-color', 'red');
                        checkvalidation++;
                    } else {
                        $('#shipping_address').css('border-color', '');
                    }

                    // if (Remarks == '') {
                    //     toastr.error('Enter remarks');
                    //     $('#Remarks').css('border-color', 'red');
                    //     checkvalidation++;
                    // } else {
                    //     $('#Remarks').css('border-color', '');
                    // }

                    let totalQty = 0;
                    let totalAmount = 0;

                    const products = [];

                    if (isMobileDevice()) {
                        $('#product-list-mobile ul').each(function() {
                            const productId = $(this).find('.cartproductId').val();
                            const qty = $(this).find('.qty').val();
                            const pcsRate = $(this).find('.pcsRate').val();
                            const mrptype = $(this).find('.mrptype').val();
                            const totalAmt = $(this).find('.totalAmt').val();
                            products.push({
                                productId: productId,
                                qty: qty,
                                mrptype: mrptype,
                                pcsRate: pcsRate,
                                totalAmt: totalAmt
                            });
                            totalAmount += totalAmt;
                        });

                        $('#free-product-list-mobile ul').each(function() {
                            const productId = $(this).find('.cartproductId').val();
                            const qty = $(this).find('.qty').val();
                            const mrptype = $(this).find('.mrptype').val();
                            const pcsRate = $(this).find('.pcsRate').val();
                            const totalAmt = $(this).find('.totalAmt').val();
                            products.push({
                                productId: productId,
                                qty: qty,
                                mrptype: mrptype,
                                pcsRate: pcsRate,
                                totalAmt: totalAmt
                            });
                            totalAmount += totalAmt;
                        });



                        var totalquantity = $('.box-tb.totalsvalue .mobtotalqty').text();
                        var subtotal = $('.box-tb.totalsvalue .mobtotalamount').text().replace(
                            /[^\d.-]/g, '');
                        var discountamount = $('.box-tb.totalsvalue .mobdiscountamount').text()
                            .replace(/[^\d.-]/g, '');
                        var amountafterdiscount = $(
                            '.box-tb.totalsvalue .mobamountafterdiscount').text().replace(
                            /[^\d.-]/g, '');
                        var formattedGstAmount = $('.box-tb.totalsvalue .mobgstamount').text()
                            .replace(/[^\d.-]/g, '');
                        var grandtotal = $('.box-tb.totalsvalue .mobgrandtotal').text().replace(
                            /[^\d.-]/g, '');



                    } else {

                        $('#product-list tr').each(function() {
                            const productId = $(this).find('.cartproductId').val();
                            const qty = $(this).find('.qty').val();
                            const pcsRate = $(this).find('.pcsRate').val();
                            const totalAmt = parseFloat($(this).find('.totalAmt').val());
                            const mrptype = $(this).find('.mrptype').val();

                            products.push({
                                productId: productId,
                                qty: qty,
                                mrptype: mrptype,
                                pcsRate: pcsRate,
                                totalAmt: totalAmt
                            });

                            totalAmount += totalAmt;
                        });

                        $('#free-product-list tr').each(function() {
                            const productId = $(this).find('.cartproductId').val();
                            const qty = $(this).find('.qty').val();
                            const pcsRate = $(this).find('.pcsRate').val();
                            const totalAmt = parseFloat($(this).find('.totalAmt').val());

                            products.push({
                                productId: productId,
                                qty: qty,
                                pcsRate: pcsRate,
                                totalAmt: totalAmt
                            });
                        });





                        var totalquantity = $('.bdr-top .totalquantity').text();
                        var subtotal = $('.bdr-top .subtotal').text().replace(/[^\d.-]/g, '');
                        var discountamount = $('.bdr-top .discountamount').text().replace(
                            /[^\d.-]/g, '');
                        var amountafterdiscount = $('.bdr-top .amountafterdiscount').text()
                            .replace(/[^\d.-]/g, '');
                        var formattedGstAmount = $('.bdr-top .gstamount').text().replace(
                            /[^\d.-]/g, '');
                        var grandtotal = $('.bdr-top .grandtotal').text().replace(/[^\d.-]/g,
                            '');
                    }


                    if (checkvalidation == 0) {
                        const data = {
                            alldistributor: alldistributor,
                            discount: discount,
                            mtd_value: mtd_value,
                            order_date: order_date,
                            target_value: target_value,
                            party_balance: party_balance,
                            totalQty: totalQty,
                            totalAmount: totalAmount,
                            retailer_project_name: retailer_project_name,
                            order_type: order_type,
                            cash_discount: cash_discount,
                            bank_name: bank_name,
                            cheque_numebr: cheque_numebr,
                            tansproter: tansproter,
                            deliverydate: deliverydate,
                            payment_mode: payment_mode,
                            shipping_address: shipping_address,
                            Remarks: Remarks,
                            products: products,
                            totalquantity: totalquantity,
                            subtotal: subtotal,
                            discountamount: discountamount,
                            amountafterdiscount: amountafterdiscount,
                            formattedGstAmount: formattedGstAmount,
                            grandtotal: grandtotal,
                            order_id: order_id,
                            sales_person_id: sales_person_id,
                            pending_tgt: pending_tgt,
                            order_category: order_category,
                            order_pdf: order_pdf,
                            order_brand: order_brand

                        };

                        $('.distriloader').removeClass('d-none');

                        $.ajax({
                            type: 'POST',
                            url: "{{ route('order.editsubmit') }}",
                            data: data,
                            success: function(response) {
                                $('.distriloader').addClass('d-none');
                                // var resp = response.resp;
                                // var msg = response.msg;
                                var redirecturl = "{{ route('order.list') }}";
                                if (response == 1) {
                                    toastr.success('Order edit sucessfully');
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
                    }
                }
            });
        });

    });


    $(document).on('input', '.qty, .mobileqty', function() {

        var order_type = $('#order_type').val();

        if (order_type == "228") {

            if (parseFloat($(this).val()) > 1) {
                $(this).val(1); // Reset the value to 1
            }

            var qty = 1;

        } else {
            var qty = parseFloat($(this).val()) || 0;
        }

        if (isMobileDevice()) {
            var $box = $(this).closest('.box-tb');
            var qty = parseFloat($(this).val()) || 0;
            var productId = $box.find('.productId').val().trim();
            var seriesName = $box.find('.seriesName').val().trim();
            var price = parseFloat($box.find('.price').text().replace(/[^0-9.-]+/g, "")) || 0;
            //  var discount = parseFloat($box.find('.discount').text().replace('%', '').trim()) || 0;
            //var amount = qty * price * (1 - discount / 100);
            var starticon = '';
            var mrptype = $box.find('.mrptype').val();
            var seriesid = $box.find('.seriesid').val();
            var seriesName = $box.find('.seriesName').val();
            var totalAmount = qty * price;
            // var discountAmt = totalAmount * (discount / 100);
            // var netAmt = totalAmount - discountAmt;

            $box.find('.amount').text(totalAmount.toFixed(2));

            if ($('#item-info-section').is(':hidden')) {
                $('#item-info-section').show();
            }

            if (mrptype == 'netrate') {
                starticon = '<span class="text-danger">*</span>';
            }

            var existingRow = $('#product-list-mobile').find('.cartproductId[value="' + productId + '"]')
                .closest('.box-tb'); // Change 'box-tb' to '.box-tb'

            var productlist = `<div class="box-tb">
                 
                    <div class="row">
                        <div class="col-10 item-name"><strong>${$box.find('.item-name strong').text()}</strong>
                        </div>
                        <div class="col-2 qt-box pl-0"><input class="form-control form-ctr2 qty"
                                value="${qty}" readonly type="text"></div>
                    </div>
                    <div class="row">
                        <ul class="dptext d-flex mlnew">
                            <input type="hidden" value="${productId}" class="cartproductId">
                                <input type="hidden" value="${qty}" class="qty">
                                <input type="hidden" value="${price}" class="pcsRate">
                                <input type="hidden" value="${mrptype}" class="mrptype">
                                 <input type="hidden" value="${seriesid}" class="seriesid">
                                <input type="hidden" value="${totalAmount}" class="totalAmt">

                            <li><strong>Series:</strong> <span class="lig-tx">` + seriesName + `</span></li>
                            <li><strong>MRP:</strong> <span class="lig-tx">${price +''+starticon}</span></li>
                            <li class="pdnew"><strong>Amount:</strong>${totalAmount.toFixed(2)}</li>
                            
                        </ul>
                    </div>
                </div>`;

            if (existingRow.length > 0) {
                if (qty <= 0 || qty == '') {
                    existingRow.remove(); // Remove the existing row if qty <= 0 or qty is empty
                } else {
                    existingRow.replaceWith(productlist); // Update the existing row
                }
            } else {
                if (qty > 0 && qty !== '') {
                    $('#product-list-mobile').append(productlist); // Append the new row if qty > 0 and qty is not empty
                }
            }

            updateSubtotalmobile();

        } else {

            var $row = $(this).closest('tr');
            var qty = parseFloat($(this).val()) || 0;
            var productId = parseFloat($row.find('.productId').val()) || 0;
            var priceText = $row.find('.price').text().replace(/,/g, ''); // Remove commas
            var price = parseFloat(priceText) || 0;
            var discount = parseFloat($row.find('.discount').text().replace('%', '').trim()) || 0;
            var mrptype = $row.find('.mrptype').val();
            var seriesid = $row.find('.seriesid').val();
            //console.log(mrptype);
            var totalAmount = qty * price;
            var starticon = '';
            // var discountAmt = totalAmount * (discount / 100);
            var totalprice = price.toFixed(2);
            var priceshow = totalprice.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            var seriesName = $row.find('.seriesName').val();

            // var netAmt = totalAmount - discountAmt;

            var totalamountDecimals = totalAmount.toFixed(2);
            var totalamountSubtotal = totalamountDecimals.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            $row.find('.amount').text(totalamountSubtotal);

            if ($('#item-info-section').is(':hidden')) {
                $('#item-info-section').show();
            }

            if (mrptype == 'netrate') {
                starticon = '<span class="text-danger">*</span>';
            }

            var existingRow = $('#product-list').find('.cartproductId[value="' + productId + '"]')
                .closest('tr');

            var productlist = `
                        <tr data-product-id="${productId}" >
                           <input type="hidden" value="${productId}" class="cartproductId">
                            <input type="hidden" value="${qty}" class="qty">
                            <input type="hidden" value="${price}" class="pcsRate">
                            <input type="hidden" value="${mrptype}" class="mrptype">
                             <input type="hidden" value="${seriesid}" class="seriesid">
                            <input type="hidden" value="${totalAmount}" class="totalAmt">
                            <td>` + seriesName + `</td>
                            <td>${$row.find('td:nth-child(11)').text()}</td>
                            <td class="text-right quantity">${qty}</td>
                            <td class="text-right">${priceshow+''+starticon}</td>
                            <td class="text-right amount">${totalamountSubtotal}</td>
                           
                        </tr>`;

            // if (existingRow.length > 0) {
            //     existingRow.replaceWith(productlist); // Update the existing row
            // } else {
            //     $('#product-list').append(productlist); // Append the new row
            // }


            if (existingRow.length > 0) {

                if (qty <= 0 || qty == '') {
                    existingRow.remove(); // Remove the existing row if qty <= 0 or qty is empty
                } else {
                    console.log('not blank =>' + qty);
                    existingRow.replaceWith(productlist); // Update the existing row
                }
            } else {

                if (qty > 0 && qty !== '') {
                    $('#product-list').append(productlist); // Append the new row if qty > 0 and qty is not empty
                }
            }

            updateSubtotal();
        }
    });

    updateSubtotal();
    updateSubtotalmobile();

    $(document).on('click', '.delete-icon', function() {
        $(this).closest('tr').remove();
        updateSubtotal();
    });

    $(document).on('click', '.delete-icon-mob', function() {
        $(this).closest('.box-tb').remove();
        updateSubtotalmobile();
    });

    function numberFormat(number, decimals, dec_point, thousands_sep) {
        number = number.toFixed(decimals);

        var parts = number.split('.');
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_sep);

        return parts.join(dec_point);
    }


    function moneyFormatIndia(amount) {
        // Remove commas from the amount
        amount = amount.toString().replace(/,/g, '');

        // Convert the amount to a number with two decimal places
        let formatted = parseFloat(amount).toFixed(2);

        // Apply the Indian number format
        let parts = formatted.split('.');
        let integerPart = parts[0];
        let decimalPart = parts.length > 1 ? '.' + parts[1] : '';

        let lastThreeDigits = integerPart.slice(-3);
        let otherDigits = integerPart.slice(0, -3);

        if (otherDigits !== '') {
            lastThreeDigits = ',' + lastThreeDigits;
        }

        let result = otherDigits.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThreeDigits + decimalPart;

        return result;
    }



    function updateSubtotalmobile() {
        var subtotal = 0;
        var totalqty = 0;
        var discountsubtotal = 0;
        var productArray = [];
        var discountAmount = 0;

        $('#product-list-mobile ul').each(function() {
            var amount = parseFloat($(this).find('.totalAmt').val()) || 0;
            var quantity = parseFloat($(this).find('.qty').val()) || 0;
            var cartproductId = $(this).find('.cartproductId').val();
            var seriesid = $(this).find('.seriesid').val();
            var mrptype = $(this).find('.mrptype').val();
            subtotal += amount;
            var discount = parseFloat($('#discount').val()) || 0;

            if (mrptype == 'mrp') {
                discountsubtotal += amount;

                productArray.push({
                    cartproductId: cartproductId,
                    qty: quantity,
                    seriesid: seriesid
                });
                discountAmount += amount * (discount / 100);
            } else {
                discountsubtotal += amount;
                //discountsubtotal += amount;
                discountAmount += 0;
                // var discountAmount = amount * (discount / 100);
            }
        });


        $('#product-list-mobile ul').each(function() {
            var quantity = parseFloat($(this).find('.qty').val()) || 0;
            totalqty += quantity;
        });

        $('#free-product-list-mobile ul').each(function() {
            var quantity1 = parseFloat($(this).find('.qty').val()) || 0;
            totalqty += quantity1;
            // console.log('free product quantity => '+quantity1);
            // console.log('free product totalqty => '+totalqty);
        });




        var target_value = parseFloat($('#target_value').val()) || 0;
        var mtd_value = parseFloat($('#mtd_value').val()) || 0;
        var pending_tgt = parseFloat($('#pending_tgt').val()) || 0;



        // var discountAmount = discountsubtotal * (discount / 100);
        var finalTotal = discountsubtotal - discountAmount;

        var gstRate = 0.18;
        var gstAmount = finalTotal * gstRate;
        var grandTotal = finalTotal + gstAmount;

        $('.box-tb.totalsvalue .mobtotalqty').text(moneyFormatIndia(totalqty));

        // var subtotalWithDecimals = subtotal.toFixed(2);
        // var formattedSubtotal = subtotalWithDecimals.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $('.box-tb.totalsvalue .mobtotalamount').text('₹ ' + moneyFormatIndia(subtotal));

        // var discountAmountWithDecimals = discountAmount.toFixed(2);
        // var formattedDiscountAmount = discountAmountWithDecimals.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $('.box-tb.totalsvalue .mobdiscountamount').text('₹ ' + moneyFormatIndia(discountAmount));

        // var finalTotalWithDecimals = finalTotal.toFixed(2);
        // var formattedFinalTotal = finalTotalWithDecimals.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $('.box-tb.totalsvalue .mobamountafterdiscount').text('₹ ' + moneyFormatIndia(finalTotal));

        // var gstAmountWithDecimals = gstAmount.toFixed(2);
        // var formattedGstAmount = gstAmountWithDecimals.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $('.box-tb.totalsvalue .mobgstamount').text('₹ ' + moneyFormatIndia(gstAmount));

        // var grandTotalWithDecimals = grandTotal.toFixed(2);
        // var formattedGrandTotal = grandTotalWithDecimals.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $('.box-tb.totalsvalue .mobgrandtotal').text('₹ ' + moneyFormatIndia(grandTotal));

        // target_value = numberFormat(target_value, 0, '.', ',');
        // mtd_value = numberFormat(mtd_value, 0, '.', ',');
        // pending_tgt = numberFormat(pending_tgt, 0, '.', ','); ;

        $('.box-tb.totalsvalue .mobtargetvalue').text('₹ ' + moneyFormatIndia(target_value));
        $('.box-tb.totalsvalue .mobmtd_val').text('₹ ' + moneyFormatIndia(mtd_value));
        $('.box-tb.totalsvalue .mobpendingtgt').text('₹ ' + moneyFormatIndia(pending_tgt));

        var productArrayLength = productArray.length;

        if (productArrayLength > 0) {
            $.ajax({
                type: 'POST',
                url: "{{ route('scheme.calculation') }}",
                data: {
                    productArray: productArray,
                    _token: $('meta[name="csrf-token"]').attr('content'),

                },
                success: function(response) {

                    $('#free-product-list-mobile').empty();

                    $.each(response, function(index, value) {

                        var div = `<div class="box-tb">
                                
                                    <div class="row">
                                        <div class="col-10 item-name"><strong>` + value.productName + ` <span class="badge badge-success scheme" style='font-size:7px' >In Scheme</span> </strong>
                                        </div>
                                        <div class="col-2 qt-box pl-0"><input class="form-control form-ctr2 qty" value="` + value.freeqty + `" readonly="" type="text"></div>
                                    </div>
                                    <div class="row">
                                        <ul class="dptext d-flex mlnew">
                                            <input type="hidden" value="` + value.productId + `"  class="cartproductId">
                                                <input type="hidden" value="` + value.freeqty + `" class="qty">
                                                <input type="hidden" value="0" class="pcsRate">
                                            
                                                <input type="hidden" value="` + value.subCategoryId_fk + `" class="seriesid">
                                                <input type="hidden" value="0" class="totalAmt">
                                            
                                             <li style='padding-right:15px'><strong>Series :</strong> <span class="lig-tx">` + capitalizeFirstLetter(value.seriesName) + `</span></li>
                                            <li style='padding-right:15px' ><strong>MRP:</strong> <span class="lig-tx">0</span></li>
                                            <li style='padding-right:15px'  class="pdnew"><strong>Amount:</strong>0</li>
                                           
                                        </ul>
                                    </div>
                                </div>`;


                        $('#free-product-list-mobile').append(div);

                    });



                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });




        }


    }



    function updateSubtotal() {
        var subtotal = 0;
        var discountsubtotal = 0;
        var productArray = [];
        var discountAmount = 0;

        $('#product-list tr').each(function() {

            var cartproductId = $(this).find('.cartproductId').val();
            var seriesid = $(this).find('.seriesid').val();
            var qty = $(this).find('.qty').val();
            // var amount = parseFloat($(this).find('.amount').text()) || 0;
            var amountText = $(this).find('.amount').text().replace(/,/g, '');
            var amount = parseFloat(amountText) || 0;
            var mrptype = $(this).find('.mrptype').val();

            // console.log('amount =>'+amount);
            subtotal += amount;
            var discount = parseFloat($('#discount').val()) || 0;

            if (mrptype == 'mrp') {

                discountsubtotal += amount;
                productArray.push({
                    cartproductId: cartproductId,
                    qty: qty,
                    seriesid: seriesid
                });

                discountAmount += amount * (discount / 100);

            } else {
                discountsubtotal += amount;
                //discountsubtotal += amount;
                discountAmount += 0;
                // var discountAmount = amount * (discount / 100);
            }

        });



        var totalqty = 0;

        $('#product-list tr').each(function() {
            var quantity = parseFloat($(this).find('.quantity').text()) || 0;
            totalqty += quantity;
        });

        var target_value = parseFloat($('#target_value').val()) || 0;
        var mtd_value = parseFloat($('#mtd_value').val()) || 0;
        var pending_tgt = parseFloat($('#pending_tgt').val()) || 0;


        var finalTotal = discountsubtotal - discountAmount;

        var gstRate = 0.18;
        var gstAmount = finalTotal * gstRate;
        var grandTotal = finalTotal + gstAmount;

        $('.bdr-top .totalquantity').text(totalqty);

        // var subtotalWithDecimals = subtotal.toFixed(2);
        // var formattedSubtotal = subtotalWithDecimals.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $('.bdr-top .subtotal').text('₹ ' + moneyFormatIndia(subtotal));

        // var discountAmountWithDecimals = discountAmount.toFixed(2);
        // var formattedDiscountAmount = discountAmountWithDecimals.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $('.bdr-top .discountamount').text('₹ ' + moneyFormatIndia(discountAmount));

        // var finalTotalWithDecimals = finalTotal.toFixed(2);
        // var formattedFinalTotal = finalTotalWithDecimals.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $('.bdr-top .amountafterdiscount').text('₹ ' + moneyFormatIndia(finalTotal));

        // var gstAmountWithDecimals = gstAmount.toFixed(2);
        // var formattedGstAmount = gstAmountWithDecimals.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $('.bdr-top .gstamount').text('₹ ' + moneyFormatIndia(gstAmount));

        // var grandTotalWithDecimals = grandTotal.toFixed(2);
        // var formattedGrandTotal = grandTotalWithDecimals.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        $('.bdr-top .grandtotal').text('₹ ' + moneyFormatIndia(grandTotal));

        // target_value = numberFormat(target_value, 0, '.', ',');
        // mtd_value = numberFormat(mtd_value, 0, '.', ',');
        // pending_tgt = numberFormat(pending_tgt, 0, '.', ','); ;

        $('.bdr-top .targetvalue').text('₹ ' + moneyFormatIndia(target_value));
        $('.bdr-top .mtd').text('₹ ' + moneyFormatIndia(mtd_value));
        $('.bdr-top .pendingtgt').text('₹ ' + moneyFormatIndia(pending_tgt));

        var productArrayLength = productArray.length;

        if (productArrayLength > 0) {
            $.ajax({
                type: 'POST',
                url: "{{ route('scheme.calculation') }}",
                data: {
                    productArray: productArray
                },
                success: function(response) {

                    $('#free-product-list').empty();

                    $.each(response, function(index, value) {

                        var tr = `<tr data-product-id="464">
                           <input type="hidden" value="` + value.productId + `" class="cartproductId">
                            <input type="hidden" value="` + value.freeqty + `" class="qty">
                            <input type="hidden" value="0" class="pcsRate">
                            
                             <input type="hidden" value="` + value.subCategoryId_fk + `" class="seriesid">
                            <input type="hidden" value="0" class="totalAmt">
                             <td>` + capitalizeFirstLetter(value.seriesName) + `</td>
                            <td>` + capitalizeFirstLetter(value.productName) + ` <span class="badge badge-success scheme" style='font-size:7px' >In Scheme</span> </td>
                            <td class="text-right quantity">` + value.freeqty + `</td>
                            <td class="text-right">0</td>
                            <td class="text-right amount">0</td>
                            
                        </tr>`;


                        $('#free-product-list').append(tr);

                        totalqty1 = 0;
                        $('#product-list tr').each(function() {
                            var quantity = parseFloat($(this).find('.quantity').text()) || 0;
                            totalqty1 += quantity;
                        });

                        $('#free-product-list tr').each(function() {
                            var quantity1 = parseFloat($(this).find('.quantity').text()) || 0;
                            totalqty1 += quantity1;

                        });
                        $('.bdr-top .totalquantity').text(totalqty1);

                    });



                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });

        }

    }

    // $(document).on('input change', 'input, select', function() {
    //     updateSubtotalmobile();
    //     updateSubtotal();
    // });

    $(document).on('click', '.edit-icon', function() {
        var productId = $(this).closest('tr').data('product-id');

        if (isMobileDevice()) {
            var $box = $('.productId[value="' + productId + '"]').closest('.box-tb');
        } else {
            var $box = $('.productId[value="' + productId + '"]').closest('tr');
        }

        // Find the closest accordions
        var $accordions = $box.parents('.accordion');
        if ($accordions.length > 0) {
            // Iterate through each accordion
            $accordions.each(function() {
                var $accordion = $(this);
                if (!$accordion.find('.collapse').hasClass('show')) {
                    $accordion.find('.collapse').collapse('show');
                }
            });
        }

        setTimeout(function() {
            var $qtyInput = isMobileDevice() ? $box.find('.mobileqty') : $box.find('.qty');
            $qtyInput.focus();
        }, 300); // Delay to ensure accordion animation completes before focusing
    });

    //     document.addEventListener("DOMContentLoaded", function() {


    //         setTimeout(function() {
    //     ordercategoryfun();
    // }, 5000); // Delay in milliseconds
    //     });

    //});
</script>
@endsection