<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mstproduct;
use App\Models\masterdata;
use App\Models\mastermenu;
use App\Models\mst_orderitem;
use App\Models\mst_orderlist;
use App\Models\mstcustomerlist;
use App\Models\trans_customersalesperson;
use App\Models\trans_salestarget;
use App\Models\mst_disConsignment;
use App\Models\mst_cateScheme;
use App\Models\mst_ledger;
use App\Models\UserList;
use App\Models\mst_inventory;
use App\Models\trans_salestargethistory;
use App\Jobs\whatsappmeassaap;
use App\Jobs\ordereditwhatsapp;
use App\Jobs\SendWhatsMessageJob;
use Illuminate\Support\Facades\DB;
use App\Models\trans_orderdispatch;
use App\Models\mst_orderinvoice;
use App\Jobs\GenerateOrderPDF;
use App\Jobs\GenerateOrderPDFWithId;
use App\Jobs\distributorwhatsappmessage;
use PDF;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\URL;

class OrderController extends BaseController
{

    public function index()
    {
        return view('order.index');
    }

    public function orderformdata(Request $req)
    {

        $orderitem = $req->orderitem;
        $ordercustomerid = $req->ordercustomerid;
        $mrptype = '';
        $masterdata_category = $this->masterdata_category[0]->masterDataId;
        $masterdata_category = mastermenu::where('masterDataId_fk', $masterdata_category)
            ->select('masterMenuId', 'name')
            ->whereNull('parentId')
            ->where('status', 1)
            ->orderBy('masterMenuId', 'desc')
            ->get();

        if ($ordercustomerid != '') {

            $customerData = mstcustomerlist::select('mst_mastermenu.name as customertype')
                ->join('mst_mastermenu', 'mst_customerlist.customer_type', '=', 'mst_mastermenu.masterMenuId')
                ->where('mst_customerlist.customerId', $ordercustomerid)->first();

            $customertype = strtolower($customerData->customertype);
        }

        $html = '';

        foreach ($masterdata_category as $pkey => $pvalue) {

            $html .= '<div class="accordion accordion-primary" id="accordion-' . $pkey . '">
											<div class="accordion-item accordion-bg">
											   <div class="accordion-header rounded-lg collapsed" id="heading' . $pkey . '" data-bs-toggle="collapse" data-bs-target="#collapse' . $pkey . '" aria-controls="collapse' . $pkey . '" aria-expanded="false" role="button">
												  <span class="accordion-header-icon"></span>
												 <span class="accordion-header-text fs-14">' . ucwords($pvalue->name) . '</span>
												 <span class="accordion-header-indicator"></span>
											   </div>
											   <div id="collapse' . $pkey . '" class="collapse" aria-labelledby="heading' . $pkey . '" data-bs-parent="#accordion-' . $pkey . '" style="">
												 <div class="accordion-body-text mt-1">';

            $masterdata_child_category = mastermenu::where('parentId', $pvalue->masterMenuId)
                ->select('masterMenuId', 'name')
                ->orderBy('masterMenuId', 'desc')
                ->where('status', 1)
                ->get();

            if (count($masterdata_child_category) == 0) {
                $html .= '<p class="text-center" > No series found</p>';
            }


            foreach ($masterdata_child_category as $ckey => $cvalue) {
                $html .= '
                <div class="row">
                            	<div class="" style="width:100%; ">
                                <div class="accordion accordion-primary" id="accordion-' . $pkey . '-' . $ckey . '">
                                            <div class="accordion-item accordion-bg2">
                                                <div class="accordion-header bg-acr2 rounded-lg collapsed d-flex"
                                                    id="headings' . $pkey . '-' . $ckey . '" data-bs-toggle="collapse"
                                                    data-bs-target="#collapses' . $pkey . '-' . $ckey . '" aria-controls="collapses' . $pkey . '-' . $ckey . '"
                                                    aria-expanded="false" role="button">
                                                    <span class="accordion-header-icon"></span>
                                                    <span class="accordion-header-text fs-14">' . ucwords(strtolower($cvalue->name)) . ' </span>
                                                    <span class="top-inp pull-right mo-display"><input type="text"
                                                            placeholder="Item Search" class="form-control item-search"></span>
                                                    <span class="accordion-header-indicator"></span>
                                                </div>
                                                <div id="collapses' . $pkey . '-' . $ckey . '" class="collapse" aria-labelledby="heading' . $pkey . '-' . $ckey . '"
                                                    data-bs-parent="#accordions-' . $pkey . '-' . $ckey . '" style="">

                                                    <div class="accordion-body-text">';

                $products = mstproduct::select('productId', 'subCategoryId_fk', 'productName', 'mrp', 'cat_number', 'dop_netprice', 'mop_netprice', 'startDate', 'endDate')->where('subCategoryId_fk', $cvalue->masterMenuId)->get();

                if (count($products) == 0) {
                    $html .= '<p class="text-center" > No Item found</p>';
                } else {

                    $html .= '<div class="mob-box mo-display">';;
                    foreach ($products as $pkey => $pvalue) {

                        $productName = strtolower($pvalue->productName);
                        $mrp = $pvalue->mrp;
                        $startDate = $pvalue->startDate > 0 ? $pvalue->startDate : null;
                        $endDate = $pvalue->endDate > 0 ? $pvalue->endDate : null;
                        $currentDate = time();

                        if (!empty($orderitem)) {

                            $itemqty = '';
                            $itemtotal = '';

                            if ($startDate && $endDate && $currentDate >= $startDate && $currentDate <= $endDate) {

                                if ($customertype == 'distributor' || $customertype == 'dealer') {

                                    if ($pvalue->dop_netprice != '') {

                                        $mrp = moneyFormatIndia($pvalue->dop_netprice) . '<span class="text-danger">*</span>';
                                        $mrptype = 'netrate';
                                    } else {
                                        $mrp = moneyFormatIndia($pvalue->mrp);
                                        $mrptype = 'mrp';
                                    }
                                } else if ($customertype == 'retailer' || $customertype == 'ubs') {

                                    if ($pvalue->mop_netprice != '') {

                                        $mrp = moneyFormatIndia($pvalue->mop_netprice) . '<span class="text-danger">*</span>';
                                        $mrptype = 'netrate';
                                    } else {
                                        $mrp = moneyFormatIndia($pvalue->mrp);
                                        $mrptype = 'mrp';
                                    }
                                } else {
                                    $mrp = moneyFormatIndia($pvalue->mrp);
                                    $mrptype = 'mrp';
                                }
                            } else {
                                $mrp = moneyFormatIndia($pvalue->mrp);
                                $mrptype = 'mrp';
                            }

                            foreach ($orderitem as $key => $itemval) {

                                if ($itemval['pcsRate'] != 0) {
                                    if ($itemval['productId_fk'] == $pvalue->productId) {

                                        $itemqty = $itemval['qty'];
                                        $itemtotal = $itemval['totalAmt'];
                                    }
                                }
                            }
                        }

                        $html .= '<div class="box-tb">
                                                                <div class="row">
                                                                    <div class="col-10 item-name"><strong> ' . ucwords($productName) . '(' . $pvalue->cat_number . ')</strong>
                                                                    </div>
                                                                    <div class="col-2 qt-box pl-0"><input
                                                                            class="form-control form-ctr2 mobileqty"
                                                                            inputmode="numeric" pattern="[0-9]*" 
                                                                            placeholder="Qty" value="' . @$itemqty . '"  type="text"></div>
                                                                </div>

                                                                <div class="row">
                                                                    <ul class="dptext2">
                                                                    <input type="hidden" class="productId" value="' . $pvalue->productId . '">
                                                                    <input type="hidden" class="mrptype" value="' . $mrptype . '">
                                                                     <input type="hidden" class="startdate" value="' . $startDate . '">
                                                                <input type="hidden" class="enddate" value="' . $endDate . '">
                                                                <input type="hidden" class="currentdate" value="' . $currentDate . '">
                                                                    <input type="hidden" class="seriesid" value="' . $pvalue->subCategoryId_fk . '">
                                                                    <input type="hidden" class="seriesName" value="' . ucwords(strtolower($cvalue->name)) . '">
                                                                    <input type="hidden" class="dealerdistributor_mrp" value="' . $pvalue->dop_netprice . '">
                                                                    <input type="hidden" class="retailer_ubs_mrp" value="' . $pvalue->mop_netprice . '">
                                                                    <input type="hidden" class="default_mrp" value="' . $pvalue->mrp . '">
                                                                        <li><strong>MRP:</strong> <span
                                                                                class="lig-tx price">' . $mrp . '</span></li>
                                                                        <li><strong>Amount:</strong> <span
                                                                                class="lig-tx amount">' . @$itemtotal . ' </span></li>
                                                                    </ul>
                                                                </div>
                                                            </div>';
                    }

                    $html .= '</div>

                                                        <div class="table-responsive desk-display">
                                                            
                                                            <table class="table table-bordered bold-border table-striped desk-mar">
                                                                <thead class="head-bord">
                                                                    <tr class="fw-bolder bg-light">
                                                                        <th class="w-250px rounded-start"
                                                                            style="color: #5e6278;">
                                                                            <div class="floating-label-group">
                                                                               <input type="text" class="form-control item-name-filter" autocomplete="off" autofocus required>
                                                                                <label class="floating-label px">Item
                                                                                    Name</label>
                                                                                <i class="fa fa-search"></i>
                                                                            </div>
                                                                        </th>

                                                                         <th class="w-50px rounded-start">
                                                                            Series
                                                                        </th>
                                                                        
                                                                        
                                                                        <th class="w-50px rounded-start text-right">
                                                                            Qty
                                                                        </th>

                                                                        <th class="w-50px rounded-start text-right">
                                                                            MRP
                                                                        </th>

                                                                        

                                                                        <th class="w-50px rounded-start text-right">
                                                                            Amount
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                              
                                                                <tbody>';

                    foreach ($products as $pkey => $pvalue) {

                        $productName = strtolower($pvalue->productName);



                        $startDate = $pvalue->startDate > 0 ? $pvalue->startDate : null;
                        $endDate = $pvalue->endDate > 0 ? $pvalue->endDate : null;
                        $currentDate = time();

                        if (!empty($orderitem)) {

                            $itemqty = '';
                            $itemtotal = '';

                            if ($startDate && $endDate && $currentDate >= $startDate && $currentDate <= $endDate) {

                                if ($customertype == 'distributor' || $customertype == 'dealer') {

                                    if ($pvalue->dop_netprice != '') {

                                        $mrp = moneyFormatIndia($pvalue->dop_netprice) . '<span class="text-danger">*</span>';
                                        $mrptype = 'netrate';
                                    } else {
                                        $mrp = moneyFormatIndia($pvalue->mrp);
                                        $mrptype = 'mrp';
                                    }
                                } else if ($customertype == 'retailer' || $customertype == 'ubs') {

                                    if ($pvalue->mop_netprice != '') {

                                        $mrp = moneyFormatIndia($pvalue->mop_netprice) . '<span class="text-danger">*</span>';
                                        $mrptype = 'netrate';
                                    } else {
                                        $mrp = moneyFormatIndia($pvalue->mrp);
                                        $mrptype = 'mrp';
                                    }
                                } else {
                                    $mrp = moneyFormatIndia($pvalue->mrp);
                                    $mrptype = 'mrp';
                                }
                            } else {
                                $mrp = moneyFormatIndia($pvalue->mrp);
                                $mrptype = 'mrp';
                            }

                            foreach ($orderitem as $key => $itemval) {

                                if ($itemval['pcsRate'] != 0) {
                                    if ($itemval['productId_fk'] == $pvalue->productId) {

                                        $itemqty = $itemval['qty'];
                                        $itemtotal = $itemval['totalAmt'];
                                    }
                                }
                            }
                        }



                        $html .= '<tr>
                                                                <input type="hidden" class="productId" value="' . $pvalue->productId . '">
                                                                <input type="hidden" class="mrptype" value="' . $mrptype . '">
                                                                <input type="hidden" class="startdate" value="' . $startDate . '">
                                                                <input type="hidden" class="enddate" value="' . $endDate . '">
                                                                <input type="hidden" class="currentdate" value="' . $currentDate . '">
                                                                <input type="hidden" class="seriesid" value="' . $pvalue->subCategoryId_fk . '">
                                                                <input type="hidden" class="seriesName" value="' . ucwords(strtolower($cvalue->name)) . '">
                                                                <input type="hidden" class="dealerdistributor_mrp" value="' . $pvalue->dop_netprice . '">
                                                                <input type="hidden" class="retailer_ubs_mrp" value="' . $pvalue->mop_netprice . '">
                                                                <input type="hidden" class="default_mrp" value="' . $pvalue->mrp . '">

                                                                <td class="w-250px rounded-start">' . ucwords($productName)  . ' </td>
                                                                <td class="w-50px rounded-start">' . $pvalue->cat_number . '</td>
                                                                <td
                                                                    class="w-50px rounded-start text-right">
                                                                    <input class="new-inp text-right qty"
                                                                     onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                     value="' . @$itemqty . '"
                                                                        type="text">
                                                                </td>
                                                                <td class="w-50px rounded-start text-right price "> ' . $mrp . '</td>
                                                            
                                                                <td class="w-50px rounded-start text-right amount">' . @$itemtotal . '</td>
                                                            </tr>';
                    }

                    $html .= '</tbody>
                                                            </table>
                                                        </div>';
                }

                $html .= '</div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>';
            }

            $html .= '</div>
                    </div>
                </div>
            </div>';
        }

        return response()->json(['html' => $html]);
    }

    public function ordersubmit(Request $req)
    {
        try {

            //dd($req);
            DB::beginTransaction();
            $currentDateTime = now();
            $dataEntrydate = strtotime($currentDateTime->toDateTimeString());
            $products = $req->products;
            $ordercount = mst_orderlist::count();
            $counter = $ordercount + 1;

            $year = date('y');
            $month = date('m');
            $date = date('d');

            $monthChar = chr(64 + intval($month));

            $sales_whatspp = getSeniorUserIds($req->sales_person_id, date('M'), date('Y'));

            $filteredSalesData = array_filter((array)$sales_whatspp, function ($value) {
                return !is_null($value);
            });


            $zero = $counter < 10 ? '000' : ($counter < 100 ? '00' : ($counter < 1000 ? '0' : ''));
            $orderNo = $monthChar . $month . $year . $zero . $counter;
            $orderAuthKey = sha1($orderNo . $currentDateTime->toDateTimeString());

            if ($req->order_type == '228') {

                $status = 3;
            } else {
                $status = 1;
            }


            $totalquantity = str_replace(',', '', $req->totalquantity);

            $data = [
                'customerId_fk' => $req->alldistributor,
                'order_category' => $req->order_category,
                'createById_fk' => session('userinfo')->userId,
                'brandId_fk' => $req->order_brand,
                'sales_person_id' => $req->sales_person_id,
                'orderNo' => $orderNo,
                'createDate' => $dataEntrydate,
                'orderDate' => strtotime($req->order_date),
                'deliveryDate' => strtotime($req->deliverydate),
                'paymentMode' => $req->payment_mode,
                'enterTargetValue' => $req->target_value,
                'enterDiscount' => $req->discount,
                'mtdValue' => $req->mtd_value,
                'pendingTGTValue' => $req->pending_tgt,
                'discountAmt' => $req->discountamount,
                'quantity' => $totalquantity,
                'totalAmt' => $req->subtotal,
                'taxAmt' => $req->formattedGstAmount,
                'grandAmt' => $req->grandtotal,
                'casheDiscount' => $req->cash_discount,
                'bankId_fk' => $req->bank_name,
                'retailer_project_name' => $req->retailer_project_name,
                'transportId_fk' => $req->tansproter,
                'chequeNumber' => $req->cheque_numebr,
                'orderType' => $req->order_type,
                'shppingAddress' => $req->shipping_address,
                'remarks' => $req->Remarks,
                'orderAuthKey' => $orderAuthKey,
                'status' => $status
            ];

            $mst_orderlist = mst_orderlist::create($data);
            $orderId = $mst_orderlist->orderId;

            $productid = [];
            foreach ($products as $key => $val) {
                $orderitem = [
                    'customerId_fk' => $req->alldistributor,
                    'orderId_fk' => $orderId,
                    'productId_fk' => $val['productId'],
                    'mrptype' => $val['mrptype'],
                    'qty' => $val['qty'],
                    'pcsRate' => $val['pcsRate'],
                    'totalAmt' => $val['totalAmt'],
                    'status' => 1
                ];
                mst_orderitem::create($orderitem);

                $productid[] =  $val['productId'];
            }


            $serieccount = mst_orderitem::select('mst_mastermenu.masterMenuId', 'mst_mastermenu.name as subCategoryName', DB::raw('SUM(mst_orderitem.qty) as totalQuantity'))
                ->join('mst_productlist', 'mst_orderitem.productId_fk', '=', 'mst_productlist.productId')
                ->join('mst_mastermenu', 'mst_productlist.subCategoryId_fk', '=', 'mst_mastermenu.masterMenuId')
                ->where('mst_orderitem.orderId_fk', $orderId)
                ->whereNull('mst_productlist.dop_netprice')
                ->whereNull('mst_productlist.mop_netprice')
                ->groupBy('mst_mastermenu.masterMenuId', 'mst_mastermenu.name')
                ->get();


            $freeproduct = [];

            foreach ($serieccount as $key => $val) {
                $mst_cateScheme = mst_cateScheme::where('cateId_fk', $val->masterMenuId)
                    ->where('numberOfItem', '<=', $val->totalQuantity)
                    ->where('startDate', '<=', time()) // Compare with current timestamp
                    ->where('endDate', '>=', time())   // Compare with current timestamp
                    ->where('status', '1')
                    ->orderBy('schemeId', 'desc')
                    ->first();

                if ($mst_cateScheme) {
                    $minMrp = mstproduct::where('subCategoryId_fk', $mst_cateScheme->cateId_fk)->whereIn('productId', $productid)->min('mrp');

                    $freeproductdata = mstproduct::where('subCategoryId_fk', $mst_cateScheme->cateId_fk)
                        ->where('mrp', $minMrp)
                        ->whereIn('productId', $productid)
                        ->orderBy('productId', 'asc')
                        ->first();

                    // Add freeqty to the product data
                    $freeproductdata['freeqty'] = $mst_cateScheme->noOfFreeQty;

                    $freeproduct[] = $freeproductdata;
                }
            }

            foreach ($freeproduct as $key => $val) {

                $orderitem = [
                    'customerId_fk' => $req->alldistributor,
                    'orderId_fk' => $orderId,
                    'productId_fk' => $val['productId'],
                    'qty' => $val['freeqty'],
                    'mrptype' => '',
                    'pcsRate' => 0,
                    'totalAmt' => 0,
                    'status' => 1
                ];
                mst_orderitem::create($orderitem);
            }

            if ($mst_orderlist) {
                $msg = 1;
            } else {
                $msg = 0;
            }

            if ($req->order_type == '228') {

                // $orderdata = [
                //   'phone_number' => 8585923403,
                // ];

                $customerdata = mstcustomerlist::select('CustomerName')
                    ->where('customerId', $req->alldistributor)
                    ->first();

                //$receiverMobileNo = '7290032768';
                $receiverMobileNo = '8585923403';


                // $msg1  = 'Hi *Mr. '.$userdata->name.'*,'.PHP_EOL. PHP_EOL;
                // $msg1 .= 'Please find below detials of the order form submitted. The Automatic Order# for the same is '.$orderNo.'.' .PHP_EOL. PHP_EOL;
                // $msg1 .='Feel free to call on +919999408444 for further details.';
                // $msg1 .='Thanks'.PHP_EOL;
                // $msg1 .='Team VAALVE';

                $pdfRoute = URL::route('order.pdf', ['id' => $orderAuthKey]);

                $msg1 = '*Display Order*' . PHP_EOL . PHP_EOL;
                $msg1 .= 'Please appove the below order : ' . PHP_EOL . PHP_EOL;
                $msg1 .= 'Order No : ' . $orderNo . PHP_EOL;
                $msg1 .= 'Order Link : ' . PHP_EOL . PHP_EOL;

                $msg1 .=  $pdfRoute . PHP_EOL . PHP_EOL;

                $msg1 .= 'Party Name : ' . $customerdata->CustomerName . PHP_EOL . PHP_EOL;
                $msg1 .= 'Please approved the same.' . PHP_EOL . PHP_EOL;
                $msg1 .= 'Thanks' . PHP_EOL;
                $msg1 .= 'Vaalve' . PHP_EOL;

                $attachment = '';

                //SendWhatsMessageJob::dispatch($receiverMobileNo, $msg1, $attachment);
            }

            foreach ($filteredSalesData as $key => $values) {

                if ($req->sales_person_id == $values) {

                    $ordertype = 0;
                } else {
                    $ordertype = 1;
                }

                $secinor =   getSeniorUserIds($values, date('M'), date('Y'));

                $filteredSecinor = array_filter((array)$secinor, function ($value) {
                    return !is_null($value);
                });

                $seniorUserIds = array_values($filteredSecinor);

                $salesachieveTargetAuthKey = sha1($orderNo . $values . $currentDateTime->toDateTimeString());

                $trans_salestargethistory = [
                    'orderId_fk' => $orderId,
                    'sales_userId_fk' => $values,
                    'achievePrimaryTarget' => $req->subtotal,
                    'achieveSecondaryTarget' => 0,
                    'orderType' =>  $ordertype,
                    'seniorUserId' => serialize($seniorUserIds),
                    'monthNm' => date('M'),
                    'yearNo' => date('Y'),
                    'dataEntryDate' => $dataEntrydate,
                    'salesachieveTargetAuthKey' => $salesachieveTargetAuthKey,
                    'status' => 1,
                ];

                $trans_salestargethistory =  trans_salestargethistory::insert($trans_salestargethistory);
            }


            $sales_data = [
                'sales_whatspp' => $sales_whatspp,
                'orderAuthKey' => $orderAuthKey,
                'current_order' => $req->grandtotal,
                'order_numebr' => $orderNo,
            ];

            //  whatsappmeassaap::dispatch($sales_data);


            $distrubutor_what = [
                'customer_id' => $req->alldistributor,
                'orderAuthKey' => $orderAuthKey,
                'order_numebr' => $orderNo,

            ];

            //   distributorwhatsappmessage::dispatch($distrubutor_what);


            DB::commit();
            return $msg;
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['resp' => 2, 'msg' => 'Data Not Inserted Successfully', 'error' => $e->getMessage()]);
        }
    }

    public function schemecalculation(Request $req)
    {

        $aggregatedData = [];
        $freeproduct = [];

        foreach ($req['productArray'] as $item) {
            //  dd($item);
            $seriesid = $item['seriesid'];
            $qty = $item['qty'];
            $cartproductId = $item['cartproductId'];

            // If the seriesid already exists in the aggregatedData array, add the qty
            if (isset($aggregatedData[$seriesid])) {
                $aggregatedData[$seriesid]['qty'] += $qty;
                $aggregatedData[$seriesid]['cartproductIds'] .= ',' . (int) $cartproductId;
            } else {

                $aggregatedData[$seriesid] = [
                    'seriesid' => $seriesid,
                    'qty' => $qty,
                    'cartproductIds' => (int) $cartproductId,
                ];
            }
        }


        //  dd($aggregatedData);

        foreach ($aggregatedData as $key => $val) {
            // dd($val['seriesid']);
            $mst_cateScheme = mst_cateScheme::where('cateId_fk', $val['seriesid'])
                ->where('numberOfItem', '<=', $val['qty'])
                ->where('startDate', '<=', time()) // Compare with current timestamp
                ->where('endDate', '>=', time())   // Compare with current timestamp
                ->where('status', '1')
                ->orderBy('schemeId', 'desc')
                ->first();

            //dd($mst_cateScheme);

            if ($mst_cateScheme) {



                $productidsString = explode(',', $val['cartproductIds']);

                $minMrp = mstproduct::where('subCategoryId_fk', $mst_cateScheme->cateId_fk)->whereIn('productId', $productidsString)->min('mrp');

                $freeproductdata = mstproduct::where('subCategoryId_fk', $mst_cateScheme->cateId_fk)
                    ->where('mrp', $minMrp)
                    ->whereIn('productId', $productidsString)
                    ->orderBy('productId', 'asc')
                    ->first();

                $mastermenuname = mastermenu::select('name')->where('masterMenuId', $freeproductdata->subCategoryId_fk)->first();
                //dd($freeproductdata);

                // Add freeqty to the product data
                $freeproductdata['freeqty'] = $mst_cateScheme->noOfFreeQty;
                $freeproductdata['seriesName'] = $mastermenuname->name;

                $freeproduct[] = $freeproductdata;
            }
        }


        return $freeproduct;
    }


    public function orderlist()
    {
        return view('order.list');
    }

    public function orderlistsecondary()
    {

        return view('order.secondarylist');
    }

    public function orderInvoicedetail(Request $req)
    {
        $orderId = $req->orderId;

        $orderinvoiceData = mst_orderinvoice::select('orderinvoiceId', 'createdby', 'invoiceName', 'totalAmount', 'createdAt')
            ->where('orderId_fk', $orderId)
            ->get();

        $status = $orderinvoiceData->isNotEmpty() ? 1 : 0;
        $data = [];

        if ($status) {
            foreach ($orderinvoiceData as $order) {
                $invoiceNames = @unserialize($order->invoiceName);

                // If unserialize fails, use the original string
                if (!is_array($invoiceNames)) {
                    $invoiceNames = [$order->invoiceName];
                }


                $entry = [
                    'invoiceNames' => $invoiceNames,
                    'totalAmount' => moneyFormatIndia($order->totalAmount),
                    'createdAt' => date('d-M-Y H:i:s', $order->createdAt),
                    'createdBy' => salesuserdata($order->createdby),
                ];

                $data[] = $entry;
            }
        }

        return response()->json([
            'status' => $status,
            'data' => $data,
        ]);
    }


    private function compressPDFWithoutLibrary($filePath)
    {
        // Open original file
        $originalContent = file_get_contents($filePath);

        // Reduce content quality (remove unnecessary metadata)
        $compressedContent = str_replace('/Title', '', $originalContent);
        $compressedContent = str_replace('/Author', '', $compressedContent);
        $compressedContent = str_replace('/Producer', '', $compressedContent);

        // Save compressed file
        file_put_contents($filePath, $compressedContent);
    }


    public function uploadInvoice(Request $req)
    {

        $orderId = $req->orderId;
        $invoicetotalamount = $req->invoicetotalamount;
        $currentDateTime = now();
        $dataEntrydate = strtotime($currentDateTime->toDateTimeString());

        $fileNames = [];

        if ($req->hasFile('invoices')) {
            foreach ($req->file('invoices') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = public_path('uploads/invoices/') . $filename;
                $file->move(public_path('uploads/invoices'), $filename);

                // Compress file before saving
                $this->compressPDFWithoutLibrary($filePath);

                $fileNames[] = $filename;
            }
        }


        // dd(serialize($fileNames));

        $mst_orderinvoice =   mst_orderinvoice::create([
            'orderId_fk' => $orderId,
            'totalAmount' => $invoicetotalamount,
            'invoiceName' => serialize($fileNames), // Store as serialized array
            'createdby' => session('userinfo')->userId,
            'createdAt' => $dataEntrydate,
            'status' => 1,
        ]);

        if ($mst_orderinvoice) {

            $json = [
                'success' => true,
                'message' => 'Files uploaded successfully!',
                'files' => $fileNames
            ];
        } else {
            $json = [
                'success' => false,
                'message' => 'Data not update!',
                'files' => $fileNames
            ];
        }

        return response()->json($json);
    }

    public function orderlistdatasecondary(Request $req)
    {

        $rowCount = $req->input('rowCount');
        $page = $req->input('page');

        if (session('userinfo')->role_type == 2) {

            $orders = mst_orderlist::select(
                'mst_orderlist.orderNo',
                'mst_orderlist.customerId_fk',
                'mst_orderlist.orderDate',
                'mst_orderlist.order_category',
                'mst_orderlist.enterDiscount',
                'mst_orderlist.totalAmt',
                'mst_orderlist.discountAmt',
                'mst_orderlist.taxAmt',
                'mst_orderlist.pdf_filename',
                'mst_orderlist.grandAmt',
                'mst_orderlist.retailer_project_name',
                'mst_orderlist.orderId',
                'mst_orderlist.orderAuthKey',
                'mst_orderlist.status',
                'mst_user_list.name as salesperson',
                DB::raw("(SELECT trans_orderdispatch.orderDispatchId FROM trans_orderdispatch WHERE trans_orderdispatch.orderId_fk = mst_orderlist.orderId LIMIT 1) as orderDispatchId")
            )
                ->join('mst_customerlist', 'mst_customerlist.customerId', '=', 'mst_orderlist.customerId_fk')
                ->join('mst_user_list', 'mst_user_list.userId', '=', 'mst_orderlist.sales_person_id')
                ->where('mst_orderlist.status', '!=', 0)
                ->where('mst_customerlist.consigneeName', '!=', null)
                ->whereColumn('mst_customerlist.CustomerName', '!=', 'mst_customerlist.consigneeName')
                ->orderBy('mst_orderlist.orderId', 'desc')
                ->paginate($rowCount, ['*'], 'page', $page);
        } else {

            $orders = mst_orderlist::select(
                'mst_orderlist.orderNo',
                'mst_orderlist.customerId_fk',
                'mst_orderlist.orderDate',
                'mst_orderlist.order_category',
                'mst_orderlist.enterDiscount',
                'mst_orderlist.totalAmt',
                'mst_orderlist.discountAmt',
                'mst_orderlist.taxAmt',
                'mst_orderlist.retailer_project_name',
                'mst_orderlist.pdf_filename',
                'mst_orderlist.grandAmt',
                'mst_orderlist.orderId',
                'mst_orderlist.orderAuthKey',
                'mst_orderlist.status',
                 'mst_user_list.name as salesperson',
                DB::raw("(SELECT trans_orderdispatch.orderDispatchId FROM trans_orderdispatch WHERE trans_orderdispatch.orderId_fk = mst_orderlist.orderId LIMIT 1) as orderDispatchId")
            )
                ->join('trans_customersalesperson', 'trans_customersalesperson.customerId_fk', '=', 'mst_orderlist.customerId_fk')
                ->join('mst_user_list', 'mst_user_list.userId', '=', 'mst_orderlist.sales_person_id')
                ->join('mst_customerlist', 'mst_customerlist.customerId', '=', 'mst_orderlist.customerId_fk')
                ->where('trans_customersalesperson.userId_fk', session('userinfo')->userId)
                ->where('mst_orderlist.status', '!=', 0)
                ->where('mst_customerlist.consigneeName', '!=', null)
                ->whereColumn('mst_customerlist.CustomerName', '!=', 'mst_customerlist.consigneeName')
                ->orderBy('mst_orderlist.orderId', 'desc')
                ->paginate($rowCount, ['*'], 'page', $page);
        }
        $data = [];
        foreach ($orders as $key => $order) {

            $customername = getcustomerdatabyid($order->customerId_fk);

            $yesterday = Carbon::yesterday();
            $orderDate = Carbon::createFromTimestamp($order->orderDate);

            if ($yesterday->gt($orderDate)) { // Compare using Carbon's `gt` method
                $edit = 0;
            } else {
                $edit = 1;
            }


            $invoicetotal = mst_orderinvoice::where('orderId_fk', $order->orderId)->sum('totalAmount');
            $invoicetotal = $invoicetotal > 0 ? moneyFormatIndia($invoicetotal) : 'NA';

            $entry = [
                'orderNo' => $order->orderNo,
                'CustomerName' =>  $customername ? $customername->CustomerName : '',
                'salesperson' => $order->salesperson ? $order->salesperson : '',
                'orderDate' => date('d-M-y', $order->orderDate),
                'order_category' => $order->order_category,
                'enterDiscount' => $order->enterDiscount . ' %',
                'totalAmt' => moneyFormatIndia($order->totalAmt),
                'discountAmt' => moneyFormatIndia($order->discountAmt),
                'taxAmt' => moneyFormatIndia($order->taxAmt),
                'grandAmt' => moneyFormatIndia($order->grandAmt),
                'orderId' => $order->orderId,
                'retailer_project_name' => $order->retailer_project_name,
                'pdf_filename' => $order->pdf_filename,
                'invoicetotal' => $invoicetotal,
                'orderDispatchId' => $order->orderDispatchId,
                'orderAuthKey' => $order->orderAuthKey,
                'status' => $order->status,
                'edit' => $edit

            ];

            $data[] = $entry;
        }

        $response = [
            'data' => $data,
            'current_page' => $orders->currentPage(),
            'last_page' => $orders->lastPage()
        ];


        return response()->json($response);
    }

    public function orderlistdata(Request $req)
    {

        $rowCount = $req->input('rowCount');
        $page = $req->input('page');

        if (session('userinfo')->role_type == 2) {

            $orders = mst_orderlist::select(
                'mst_orderlist.orderNo',
                'mst_orderlist.customerId_fk',
                'mst_orderlist.orderDate',
                'mst_orderlist.order_category',
                'mst_orderlist.enterDiscount',
                'mst_orderlist.totalAmt',
                'mst_orderlist.discountAmt',
                'mst_orderlist.taxAmt',
                'mst_orderlist.pdf_filename',
                'mst_orderlist.grandAmt',
                'mst_orderlist.orderId',
                'mst_orderlist.orderAuthKey',
                'mst_orderlist.status',
                 'mst_user_list.name as salesperson',
                DB::raw("(SELECT trans_orderdispatch.orderDispatchId FROM trans_orderdispatch WHERE trans_orderdispatch.orderId_fk = mst_orderlist.orderId LIMIT 1) as orderDispatchId")
            )
                ->join('mst_customerlist', 'mst_customerlist.customerId', '=', 'mst_orderlist.customerId_fk')
                 ->join('mst_user_list', 'mst_user_list.userId', '=', 'mst_orderlist.sales_person_id')
                ->where('mst_orderlist.status', '!=', 0)
                ->where(function ($query) {
                    $query->whereColumn('mst_customerlist.CustomerName', 'mst_customerlist.consigneeName')
                        ->orWhereNull('mst_customerlist.consigneeName');
                })
                ->orderBy('mst_orderlist.orderId', 'desc')
                ->paginate($rowCount, ['*'], 'page', $page);
        } else {

            $orders = mst_orderlist::select(
                'mst_orderlist.orderNo',
                'mst_orderlist.customerId_fk',
                'mst_orderlist.orderDate',
                'mst_orderlist.order_category',
                'mst_orderlist.enterDiscount',
                'mst_orderlist.totalAmt',
                'mst_orderlist.discountAmt',
                'mst_orderlist.taxAmt',
                'mst_orderlist.pdf_filename',
                'mst_orderlist.grandAmt',
                'mst_orderlist.orderId',
                'mst_orderlist.orderAuthKey',
                'mst_orderlist.status',
                 'mst_user_list.name as salesperson',
                DB::raw("(SELECT trans_orderdispatch.orderDispatchId FROM trans_orderdispatch WHERE trans_orderdispatch.orderId_fk = mst_orderlist.orderId LIMIT 1) as orderDispatchId")
            )
                ->join('trans_customersalesperson', 'trans_customersalesperson.customerId_fk', '=', 'mst_orderlist.customerId_fk')
                ->join('mst_customerlist', 'mst_customerlist.customerId', '=', 'mst_orderlist.customerId_fk')
                ->join('mst_user_list', 'mst_user_list.userId', '=', 'mst_orderlist.sales_person_id')
                ->where('trans_customersalesperson.userId_fk', session('userinfo')->userId)
                ->where('mst_orderlist.status', '!=', 0)
                ->where(function ($query) {
                    $query->whereColumn('mst_customerlist.CustomerName', 'mst_customerlist.consigneeName')
                        ->orWhereNull('mst_customerlist.consigneeName');
                })
                ->orderBy('mst_orderlist.orderId', 'desc')
                ->paginate($rowCount, ['*'], 'page', $page);
        }
        $data = [];
        foreach ($orders as $key => $order) {

            $customername = getcustomerdatabyid($order->customerId_fk);

            $yesterday = Carbon::yesterday();

            $orderDate = Carbon::createFromTimestamp($order->orderDate);

            if ($yesterday->gt($orderDate)) { // Compare using Carbon's `gt` method
                $edit = 0;
            } else {
                $edit = 1;
            }

            $entry = [
                'orderNo' => $order->orderNo,
                'CustomerName' =>  $customername ? $customername->CustomerName : '',
                'salesperson' => $order->salesperson ? : '',
                'orderDate' => date('d-M-y', $order->orderDate),
                'order_category' => $order->order_category,
                'enterDiscount' => $order->enterDiscount . ' %',
                'totalAmt' => number_format($order->totalAmt),
                'discountAmt' => number_format($order->discountAmt),
                'taxAmt' => number_format($order->taxAmt),
                'grandAmt' => number_format($order->grandAmt),
                'orderId' => $order->orderId,
                'pdf_filename' => $order->pdf_filename,
                'orderDispatchId' => $order->orderDispatchId,
                'orderAuthKey' => $order->orderAuthKey,
                'status' => $order->status,
                'edit' => $edit
            ];

            $data[] = $entry;
        }

        $response = [
            'data' => $data,
            'current_page' => $orders->currentPage(),
            'last_page' => $orders->lastPage()
        ];


        return response()->json($response);
    }

    public function ordersearchsecondary(Request $req)
    {
        $rowCount = $req->input('rowCount');
        $page = $req->input('page');
        $order_no = $req->input('order_no');
        $company_name = $req->input('company_name');
        $retailer_name = $req->input('retailer_name');
        $order_date = $req->input('order_date');
        $category_order = $req->input('category_order');
        $discount_percentage = $req->input('discount_percentage');
        $amount = $req->input('amount');
        $discount = $req->input('discount');
          $sales_sperosn = $req->input('salesperson');
        $gst_amt = $req->input('gst_amt');
        $total_amout = $req->input('total_amout');
        $invoice_total_amout = $req->input('invoice_total_amout');

        if (!empty($company_name)) {
            $query_cat = mstcustomerlist::where('CustomerName', 'like', '%' . $company_name . '%')->pluck('customerId');
        }

        $query = mst_orderlist::select(
            'mst_orderlist.orderId',
            'mst_orderlist.orderNo',
            'mst_orderlist.customerId_fk',
            'mst_orderlist.order_category',
            'mst_orderlist.enterDiscount',
            'mst_orderlist.pdf_filename',
            'mst_orderlist.orderDate',
            'mst_orderlist.totalAmt',
            'mst_orderlist.discountAmt',
            'mst_orderlist.taxAmt',
            'mst_orderlist.grandAmt',
            'mst_orderlist.orderAuthKey',
            'mst_orderlist.retailer_project_name',
            'mst_user_list.name as salesperson',
        )->join('mst_customerlist', 'mst_customerlist.customerId', '=', 'mst_orderlist.customerId_fk')
            ->join('mst_user_list', 'mst_user_list.userId', '=', 'mst_orderlist.sales_person_id')
            ->leftJoin('mst_orderinvoice', 'mst_orderinvoice.orderId_fk', '=', 'mst_orderlist.orderId')
            ->where('mst_orderlist.status', '!=', 0)
            ->whereNotNull('mst_orderlist.retailer_project_name')
            ->whereNotNull('mst_customerlist.consigneeName')
            ->whereColumn('mst_customerlist.CustomerName', '!=', 'mst_customerlist.consigneeName')
            //->groupBy('mst_orderlist.orderId')  // Ensuring unique order IDs
            ->orderBy('mst_orderlist.orderId', 'desc');

        if (session('userinfo')->role_type == 3) {
            $query->where('mst_orderlist.sales_person_id', session('userinfo')->userId);
        }

        if (!empty($company_name)) {
            $query->whereIn('mst_orderlist.customerId_fk', $query_cat);
        }
        if (!empty($retailer_name)) {
            $query->where('mst_orderlist.retailer_project_name', 'like', '%' . $retailer_name . '%');
        }
        if (!empty($invoice_total_amout)) {
            $query->where('mst_orderinvoice.totalAmount', 'like', '%' . $invoice_total_amout . '%');
        }
        if (!empty($order_no)) {
            $query->where('mst_orderlist.orderNo', 'like', '%' . $order_no . '%');
        }
        if (!empty($category_order)) {
            $query->where('mst_orderlist.order_category', 'like', '%' . $category_order . '%');
        }
         if (!empty($sales_sperosn)) {
            $UserList = UserList::where('name', 'like', '%' . $sales_sperosn . '%')
                ->pluck('userId')
                ->toArray();

            $query->whereIn('mst_orderlist.sales_person_id', $UserList);
        }

        if (!empty($discount_percentage)) {
            $query->where('mst_orderlist.enterDiscount', 'like', '%' . $discount_percentage . '%');
        }
        if (!empty($amount)) {
            $query->where('mst_orderlist.totalAmt', 'like', '%' . $amount . '%');
        }
        if (!empty($order_date)) {
            $dates = explode(' - ', $order_date);
            $startDate = strtotime(trim($dates[0]));
            $endDate = strtotime(trim($dates[1]));
            $query->whereBetween('mst_orderlist.orderDate', [$startDate, $endDate]);
        }
        if (!empty($discount)) {
            $query->where('mst_orderlist.discountAmt', 'like', '%' . $discount . '%');
        }
        if (!empty($gst_amt)) {
            $query->where('mst_orderlist.taxAmt', 'like', '%' . $gst_amt . '%');
        }
        if (!empty($total_amout)) {
            $query->where('mst_orderlist.grandAmt', 'like', '%' . $total_amout . '%');
        }

        // $query->groupBy('mst_orderlist.orderId');
        // Clone query before pagination for sum calculation
        // $totalInvoiceAmount = (clone $query)
        //     ->selectRaw('mst_orderlist.orderId, SUM(mst_orderinvoice.totalAmount) as totalInvoiceAmount')
        //     ->groupBy('mst_orderlist.orderId')
        //     ->pluck('totalInvoiceAmount', 'orderId');

        // Paginate results
        $orders = $query->paginate($rowCount, ['*'], 'page', $page);

        $data = [];
        foreach ($orders as $key => $order) {
            $customername = getcustomerdatabyid($order->customerId_fk);
            $yesterday = Carbon::yesterday();
            $orderDate = Carbon::createFromTimestamp($order->orderDate);

            $edit = $yesterday->gt($orderDate) ? 0 : 1;

            // Get sum of totalAmount for the order
            $invoicetotal = isset($totalInvoiceAmount[$order->orderId])
                ? moneyFormatIndia($totalInvoiceAmount[$order->orderId])
                : 'NA';

            $entry = [
                'orderNo' => $order->orderNo,
                'CustomerName' => $customername ? $customername->CustomerName : '',
                'salesperson' => $order->salesperson ? $order->salesperson : '',
                'orderDate' => date('d-M-y', $order->orderDate),
                'order_category' => $order->order_category,
                'enterDiscount' => $order->enterDiscount . ' %',
                'totalAmt' => moneyFormatIndia($order->totalAmt),
                'discountAmt' => moneyFormatIndia($order->discountAmt),
                'taxAmt' => moneyFormatIndia($order->taxAmt),
                'grandAmt' => moneyFormatIndia($order->grandAmt),
                'orderId' => $order->orderId,
                'retailer_project_name' => $order->retailer_project_name,
                'pdf_filename' => $order->pdf_filename,
                'invoicetotal' => $invoicetotal,
                'orderAuthKey' => $order->orderAuthKey,
                'status' => $order->status,
                'edit' => $edit
            ];

            $data[] = $entry;
        }

        $response = [
            'data' => $data,
            'current_page' => $orders->currentPage(),
            'last_page' => $orders->lastPage()
        ];

        return response()->json($response);
    }


    public function ordersearch(Request $req)
    {

        $rowCount = $req->input('rowCount');
        $page = $req->input('page');
        $order_no = $req->input('order_no');
        $company_name = $req->input('company_name');
        $order_date = $req->input('order_date');
        $category_order = $req->input('category_order');
        $discount_percentage = $req->input('discount_percentage');
        $amount = $req->input('amount');
        $sales_sperosn = $req->input('salesperson');
        $discount = $req->input('discount');
        $gst_amt = $req->input('gst_amt');
        $total_amout = $req->input('total_amout');

        if (!empty($company_name)) {
            $query_cat =  mstcustomerlist::where('CustomerName', 'like', '%' . $company_name . '%')->pluck('customerId');
        }
        $query = mst_orderlist::select('mst_orderlist.orderId',
            'mst_orderlist.orderNo',
            'mst_orderlist.customerId_fk',
            'mst_orderlist.order_category',
            'mst_orderlist.enterDiscount',
            'mst_orderlist.pdf_filename',
            'mst_orderlist.orderDate',
            'mst_orderlist.totalAmt',
            'mst_orderlist.discountAmt',
            'mst_orderlist.taxAmt',
            'mst_orderlist.grandAmt',
            'mst_orderlist.orderAuthKey',
            'mst_orderlist.retailer_project_name',
            'mst_user_list.name as salesperson',)
            ->join('mst_customerlist', 'mst_customerlist.customerId', '=', 'mst_orderlist.customerId_fk')
             ->join('mst_user_list', 'mst_user_list.userId', '=', 'mst_orderlist.sales_person_id')
            ->where('mst_orderlist.status', '!=', 0)
            ->where(function ($query) {
                $query->whereColumn('mst_customerlist.CustomerName', 'mst_customerlist.consigneeName')
                    ->orWhereNull('mst_customerlist.consigneeName');
            })
            ->orderBy('mst_orderlist.orderId', 'desc');

        if (session('userinfo')->role_type == 3) {
            $query->where('mst_orderlist.sales_person_id', session('userinfo')->userId);
        }

        if (!empty($company_name)) {
            $query->whereIn('mst_orderlist.customerId_fk', $query_cat);
        }
        if (!empty($order_no)) {
            $query->where('mst_orderlist.orderNo', 'like', '%' . $order_no . '%');
        }
        if (!empty($category_order)) {
            $query->where('mst_orderlist.order_category', 'like', '%' . $category_order . '%');
        }

        if (!empty($sales_sperosn)) {
            $UserList = UserList::where('name', 'like', '%' . $sales_sperosn . '%')
                ->pluck('userId')
                ->toArray();

            $query->whereIn('mst_orderlist.sales_person_id', $UserList);
        }

        if (!empty($discount_percentage)) {
            $query->where('mst_orderlist.enterDiscount', 'like', '%' . $discount_percentage . '%');
        }
        if (!empty($amount)) {
            $query->where('mst_orderlist.totalAmt', 'like', '%' . $amount . '%');
        }
        if (!empty($order_date)) {
            // $order_date = strtotime($order_date);
            // $query->where('orderDate', $order_date);

            $dates = explode(' - ', $order_date);
            // $startDate = Carbon::createFromFormat('d-M-Y', trim($dates[0]))->startOfDay();
            // $endDate = Carbon::createFromFormat('d-M-Y', trim($dates[1]))->endOfDay();

            $startDate = strtotime(trim($dates[0]));
            $endDate = strtotime(trim($dates[1]));
            // Add date range condition

            // dd('startDate =>'.$startDate);
            // dd('endDate =>'.$endDate);

            $query->whereBetween('mst_orderlist.orderDate', [$startDate, $endDate]);
        }
        if (!empty($discount)) {
            $query->where('mst_orderlist.discountAmt', 'like', '%' . $discount . '%');
        }
        if (!empty($gst_amt)) {
            $query->where('mst_orderlist.taxAmt', 'like', '%' . $gst_amt . '%');
        }
        if (!empty($total_amout)) {
            $query->where('mst_orderlist.grandAmt', 'like', '%' . $total_amout . '%');
        }

        $orders = $query->paginate($rowCount, ['*'], 'page', $page);


        // dd($orders);

        $data = [];
        foreach ($orders as $key => $order) {

            $customername = getcustomerdatabyid($order->customerId_fk);

            $trans_orderdispatch = trans_orderdispatch::select('orderDispatchId')->where('orderId_fk', $order->orderId)->first();

            $entry = [
                'orderNo' => $order->orderNo,
                'CustomerName' =>  $customername->CustomerName,
                'salesperson' => $order->salesperson ? $order->salesperson : '',
                'orderDate' => date('d-M-y', $order->orderDate),
                'order_category' => $order->order_category,
                'enterDiscount' => $order->enterDiscount . ' %',
                'totalAmt' => number_format($order->totalAmt),
                'discountAmt' => number_format($order->discountAmt),
                'taxAmt' => number_format($order->taxAmt),
                'grandAmt' => number_format($order->grandAmt),
                'orderId' => $order->orderId,
                'pdf_filename' => $order->pdf_filename,
                'orderDispatchId' => $trans_orderdispatch->orderDispatchId ?? 0,
                'orderAuthKey' => $order->orderAuthKey,
            ];

            $data[] = $entry;
        }


        $response = [
            'data' => $data,
            'current_page' => $orders->currentPage(),
            'last_page' => $orders->lastPage()
        ];


        return response()->json($response);
    }


    public function schemesearch(Request $req)
    {

        $rowCount = $req->input('rowCount');
        $page = $req->input('page');
        $num_of_free_item = $req->input('num_of_free_item');
        $number_of_item = $req->input('number_of_item');
        $scheme_list = $req->input('scheme_list');

        if (!empty($scheme_list)) {
            $query_cat =  mastermenu::where('name', 'like', '%' . $scheme_list . '%')
                ->whereNotNull('parentId')
                ->pluck('masterMenuId');
        }


        $query = mst_cateScheme::select('cateId_fk', 'schemeId', 'numberOfItem', 'noOfFreeQty', 'dataEntryDate',  'startDate', 'endDate', 'schemeAuthKey', 'status')
            ->where('status', 1)
            ->orderBy('schemeId', 'desc');

        if (!empty($scheme_list)) {
            $query->whereIn('cateId_fk', $query_cat);
        }
        if (!empty($number_of_item)) {
            $query->where('numberOfItem', 'like', '%' . $number_of_item . '%');
        }
        if (!empty($num_of_free_item)) {
            $query->where('noOfFreeQty', 'like', '%' . $num_of_free_item . '%');
        }

        $mst_cateScheme = $query->paginate($rowCount, ['*'], 'page', $page);
        $data = [];
        foreach ($mst_cateScheme as $key => $val) {

            $mastermenu = getmastermenudatabyid($val->cateId_fk);

            $startDate = $val->startDate > 0 ? $val->startDate : null;
            $endDate = $val->endDate > 0 ? $val->endDate : null;
            $currentDate = time(); // Current timestamp

            // Determine status based on current date
            if ($startDate && $endDate && $currentDate >= $startDate && $currentDate <= $endDate) {
                $status = 'Active';
            } else {
                $status = 'Inactive';
            }


            $entry = [
                'schemeId' => $val->schemeId,
                'cateId_fk' =>  $mastermenu->name,
                'numberOfItem' => $val->numberOfItem,
                'noOfFreeQty' => $val->noOfFreeQty,
                'startdate' => $val->startDate > 0 ? date('d-m-Y', $val->startDate) : '', // Show date if greater than 0
                'enddate' => $val->endDate > 0 ? date('d-m-Y', $val->endDate) : '', // Added a similar check for enddate
                'status_to' => $status,
                'dataEntryDate' => $val->dataEntryDate,
                'schemeAuthKey' => $val->schemeAuthKey,
                'status' => $val->status,
            ];

            $data[] = $entry;
        }

        $response = [
            'data' => $data,
            'current_page' => $mst_cateScheme->currentPage(),
            'last_page' => $mst_cateScheme->lastPage()
        ];


        return response()->json($response);
    }


    public function orderdelete($orderid)
    {
        try {

            $orderitem = mst_orderitem::where('orderId_fk', $orderid)->update(['status' => 0]);
            $order = mst_orderlist::where('orderId', $orderid)->update(['status' => 0]);

            if ($order) {
                return 1;
            }
        } catch (\Exception $e) {
            // dd($e);
            return back()->with('error', 'Failed to delete related data. Please try again.');
        }
    }

    public function orderdispatch($orderid)
    {
        try {

            $order = mst_orderlist::where('orderId', $orderid)->update(['status' => 1]);

            if ($order) {
                return 1;
            }
        } catch (\Exception $e) {
            // dd($e);
            return back()->with('error', 'Failed to delete related data. Please try again.');
        }
    }

    public function OrderCustomerDiscount(Request $req)
    {

        $distributor = $req->input('distributor');
        $year = date('Y');
        $month = date('M');

        $customerData = mstcustomerlist::select('mst_customerlist.CustomerName', 'mst_customerlist.faucet_ex_fc_disc', 'mst_customerlist.sanitary_ex_sc_dicount', 'mst_customerlist.sanitary_finaldiscount', 'mst_customerlist.faucet_finaldiscount', 'mst_mastermenu.name as customertype', 'mst_customerlist.display_discount')
            ->join('mst_mastermenu', 'mst_customerlist.customer_type', '=', 'mst_mastermenu.masterMenuId')
            ->where('mst_customerlist.customerId', $distributor)->first();

        $trans_customersalesperson = trans_customersalesperson::select('userId_fk')->where('customerId_fk', $distributor)->orderby('cusSalesPersonId', 'desc')->first();

        //dd($trans_customersalesperson);
        $userId_fk = $trans_customersalesperson->userId_fk ?? 0;

        $trans_salestarget = trans_salestarget::select('primaryTarget', 'secondaryTarget')->where('monthNm', $month)->where('yearNo', $year)->where('sales_userId_fk', $userId_fk)->where('status', 1)->first();

        //dd($trans_salestarget);

        $mtd_first_date = '01-' . $month . '-' . $year;
        $mtd_first_date = strtotime($mtd_first_date);

        // Calculate the last date of the month
        $lastDayOfMonth = new DateTime("$year-$month-01");
        $lastDayOfMonth->modify('last day of this month');
        $mtd_last_date = $lastDayOfMonth->format('d-m-Y');
        //  dd($mtd_last_date);
        $mtd_last_date = strtotime($mtd_last_date);

        $discountAmt = mst_orderlist::where('sales_person_id', $userId_fk)
            ->where('createDate', '>=', $mtd_first_date)
            ->where('createDate', '<=', $mtd_last_date)
            ->sum('discountAmt');

        $totalAmt = mst_orderlist::where('sales_person_id', $userId_fk)
            ->where('createDate', '>=', $mtd_first_date)
            ->where('createDate', '<=', $mtd_last_date)
            ->sum('totalAmt');


        $mtd = round($totalAmt - $discountAmt, 2);

        $primaryTarget = $trans_salestarget->primaryTarget ?? 0;
        $secondaryTarget = $trans_salestarget->secondaryTarget ?? 0;
        $pendingTgt = $primaryTarget - $mtd;

        if ($pendingTgt < 0) {
            $pendingTgt = 0;
        }

        if (session('userinfo')->role_type == 2) {

            $orderconsignee = mstcustomerlist::select('mst_customerlist.consigneeName as consignmentName', 'mst_customerlist.customerId as customerId', 'mst_customerlist.address')
                // ->join('trans_customersalesperson', 'trans_customersalesperson.customerId_fk', '=', 'mst_customerlist.customerId')
                ->where('mst_customerlist.CustomerName', $customerData->CustomerName)
                ->whereNotNull('mst_customerlist.consigneeName')
                //  ->where('trans_customersalesperson.userId_fk',$customerData->CustomerName)
                ->where('mst_customerlist.status', 184)->get();
        } else {

            $orderconsignee = mstcustomerlist::select('mst_customerlist.consigneeName as consignmentName', 'mst_customerlist.customerId as customerId', 'mst_customerlist.address')
                ->join('trans_customersalesperson', 'trans_customersalesperson.customerId_fk', '=', 'mst_customerlist.customerId')
                ->where('mst_customerlist.CustomerName', $customerData->CustomerName)
                ->whereNotNull('mst_customerlist.consigneeName')
                ->where('trans_customersalesperson.userId_fk', session('userinfo')->userId)
                ->where('mst_customerlist.status', 184)->get();
        }

        // dd($orderconsignee);

        // new code added here on 19-11-2024 start here
        if (strtolower($customerData->customertype) != 'ubs') {

            if (count($orderconsignee) == 0) {
                $orderconsignee = mstcustomerlist::select('consigneeName as consignmentName', 'customerId', 'address')->where('CustomerName', $customerData->CustomerName)->where('status', 184)->get();
                $orderconsignee = array(['consignmentName' => $customerData->CustomerName]);
            }
        }

        // new code added here on 19-11-2024 end here

        $data = [
            'faucet_ex_fc_disc' => $customerData->faucet_ex_fc_disc,
            'sanitary_ex_sc_dicount' => $customerData->sanitary_ex_sc_dicount,
            'sanitary_finaldiscount' => $customerData->sanitary_finaldiscount,
            'faucet_finaldiscount' => $customerData->faucet_finaldiscount,
            'salesperson' => $userId_fk,
            'display_discount' => $customerData->display_discount,
            'primary_target' => $primaryTarget,
            'secondry_target' => $secondaryTarget,
            'mtd' => $mtd,
            'customertype' => strtolower($customerData->customertype),
            'pendingTgt' => $pendingTgt,
            'consigneecount' => count($orderconsignee),
            'orderconsignee' => $orderconsignee
        ];

        return response()->json($data);
    }

    public function orderedit($id)
    {

        $order =  mst_orderlist::where('orderAuthKey', $id)->first();
        if ($order) {
            $year = date('Y');
            $month = date('M');

            $customerdiscount = mstcustomerlist::select('faucet_ex_fc_disc', 'CustomerName', 'sanitary_ex_sc_dicount', 'sanitary_finaldiscount', 'faucet_finaldiscount', 'display_discount')->where('customerId', $order->customerId_fk)->first();
            $order['CustomerName'] = $customerdiscount->CustomerName;

            //dd($order);
            $trans_customersalesperson = trans_customersalesperson::select('userId_fk')->where('customerId_fk', $order->customerId_fk)->orderby('cusSalesPersonId', 'desc')->first();
            $trans_salestarget = trans_salestarget::select('primaryTarget', 'secondaryTarget')->where('monthNm', $month)->where('yearNo', $year)->where('sales_userId_fk', @$trans_customersalesperson->userId_fk)->where('status', 1)->first();

            $mtd_first_date = '01-' . $month . '-' . $year;
            $mtd_first_date = strtotime($mtd_first_date);

            // Calculate the last date of the month
            $lastDayOfMonth = new DateTime("$year-$month-01");
            $lastDayOfMonth->modify('last day of this month');
            $mtd_last_date = $lastDayOfMonth->format('d-m-Y');
            //  dd($mtd_last_date);
            $mtd_last_date = strtotime($mtd_last_date);


            $discountAmt = mst_orderlist::where('sales_person_id', @$trans_customersalesperson->userId_fk)
                ->where('createDate', '>=', $mtd_first_date)
                ->where('createDate', '<=', $mtd_last_date)
                ->sum('discountAmt');

            $totalAmt = mst_orderlist::where('sales_person_id', @$trans_customersalesperson->userId_fk)
                ->where('createDate', '>=', $mtd_first_date)
                ->where('createDate', '<=', $mtd_last_date)
                ->sum('totalAmt');

            $mtd = round($totalAmt - $discountAmt, 2);

            $primaryTarget = $trans_salestarget->primaryTarget ?? 0;
            // dd($primaryTarget);
            $pendingTgt =  $primaryTarget - $mtd;

            if ($pendingTgt < 0) {
                $pendingTgt = 0;
            }

            $orderitem =  mst_orderitem::select('mst_orderitem.*', 'mst_productlist.productName', 'mst_productlist.dop_netprice', 'mst_productlist.mop_netprice', 'mst_productlist.subCategoryId_fk', 'mst_mastermenu.name as serisname')
                ->join('mst_productlist', 'mst_orderitem.productId_fk', '=', 'mst_productlist.productId')
                ->join('mst_mastermenu', 'mst_productlist.subCategoryId_fk', '=', 'mst_mastermenu.masterMenuId')
                ->where('mst_orderitem.orderId_fk', $order->orderId)
                ->get();


            //$orderconsignee = mst_disConsignment::select('cusConsigId','consignmentName')->where('customerId_fk',$order->customerId_fk)->get();

            $customerData = mstcustomerlist::select('mst_customerlist.CustomerName', 'mst_customerlist.faucet_ex_fc_disc', 'mst_customerlist.sanitary_ex_sc_dicount', 'mst_customerlist.sanitary_finaldiscount', 'mst_customerlist.faucet_finaldiscount', 'mst_mastermenu.name as customertype', 'mst_customerlist.display_discount')
                ->join('mst_mastermenu', 'mst_customerlist.customer_type', '=', 'mst_mastermenu.masterMenuId')
                ->where('mst_customerlist.customerId', $order->customerId_fk)->first();

            // dd($customerdiscount);

            if (session('userinfo')->role_type == 2) {

                $orderconsignee = mstcustomerlist::select('mst_customerlist.consigneeName as consignmentName', 'mst_customerlist.address')
                    ->where('mst_customerlist.CustomerName', $customerData->CustomerName)
                    ->where('mst_customerlist.status', 184)->get();
            } else {

                $orderconsignee = mstcustomerlist::select('mst_customerlist.consigneeName as consignmentName', 'mst_customerlist.address')
                    // ->join('trans_customersalesperson', 'trans_customersalesperson.customerId_fk', '=', 'mst_customerlist.customerId')
                    ->where('mst_customerlist.CustomerName', $customerData->CustomerName)
                    //->where('trans_customersalesperson.userId_fk', session('userinfo')->userId)
                    ->where('mst_customerlist.status', 184)->get();
            }

            if (strtolower($customerData->customertype) != 'ubs') {

                if (count($orderconsignee) == 0) {
                    $orderconsignee = mstcustomerlist::select('consigneeName as consignmentName', 'customerId', 'address')->where('CustomerName', $customerData->CustomerName)->where('status', 184)->get();
                    $orderconsignee = array(['consignmentName' => $customerData->CustomerName]);
                }
            }

            // new code added here on 19-11-2024 end here




            return view('order.orderedit', compact('order', 'orderitem', 'customerdiscount', 'primaryTarget', 'trans_customersalesperson', 'trans_salestarget', 'mtd', 'pendingTgt', 'orderconsignee'));
        } else {
            return back()->with('error', 'Order Not Found');
        }
    }

    public function removefile($filename)
    {
        $filePath = public_path('orderpdf/' . $filename);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }


    public function ordereditsubmit(Request $req)
    {
        try {
            //  dd($req);
            DB::beginTransaction();

            $currentDateTime = now();
            $dataEntrydate = strtotime($currentDateTime->toDateTimeString());
            $products = $req->products;
            $orderId = $req->order_id;


            $sales_whatspp = getSeniorUserIds($req->sales_person_id, date('M'), date('Y'));

            $filteredSalesData = array_filter((array)$sales_whatspp, function ($value) {
                return !is_null($value);
            });

            $mst_salesorderdata  = mst_orderlist::select('orderNo', 'orderAuthKey')->where('orderId', $orderId)->first();

            if ($req->order_type == '228') {

                $status = 3;
            } else {
                $status = 1;
            }

            $data = [
                'customerId_fk' => $req->alldistributor,
                'order_category' => $req->order_category,
                'createById_fk' => session('userinfo')->userId,
                'sales_person_id' => $req->sales_person_id,
                //'orderNo' => $orderNo,
                //'createDate' => $dataEntrydate,
                'brandId_fk' => $req->order_brand,
                'orderDate' => strtotime($req->order_date),
                'deliveryDate' => strtotime($req->deliverydate),
                'paymentMode' => $req->payment_mode,
                'enterTargetValue' => $req->target_value,
                'enterDiscount' => $req->discount,
                'mtdValue' => $req->mtd_value,
                'pendingTGTValue' => $req->pending_tgt,
                'discountAmt' => $req->discountamount,
                'quantity' => $req->totalquantity,
                'totalAmt' => $req->subtotal,
                'taxAmt' => $req->formattedGstAmount,
                'grandAmt' => $req->grandtotal,
                'casheDiscount' => $req->cash_discount,
                'bankId_fk' => $req->bank_name,
                'retailer_project_name' => $req->retailer_project_name,
                'transportId_fk' => $req->tansproter,
                'chequeNumber' => $req->cheque_numebr,
                'orderType' => $req->order_type,
                'shppingAddress' => $req->shipping_address,
                'remarks' => $req->Remarks,
                //'orderAuthKey' => $orderAuthKey,
                'status' => $status
            ];

            $mst_orderlist = mst_orderlist::where('orderId', $orderId)->update($data);

            // mst_orderitem::where('orderId_fk',$orderId)->delete();
            $deleted = DB::table('mst_orderitem')
                ->where('orderId_fk', $orderId)
                ->delete();

            $trans_salestargethistory = DB::table('trans_salestargethistory')
                ->where('orderId_fk', $orderId)
                ->delete();

            // if ($deleted) {
            //     dd('Order items deleted successfully');
            // } else {
            //     dd('Failed to delete order items for orderId: ' . $orderId);
            // }

            $productid = [];
            foreach ($products as $val) {
                $orderitem = [
                    'customerId_fk' => $req->alldistributor,
                    'orderId_fk' => $orderId,
                    'productId_fk' => $val['productId'],
                    'qty' => $val['qty'],
                    'mrptype' => $val['mrptype'] ?? '',
                    'pcsRate' => $val['pcsRate'],
                    'totalAmt' => $val['totalAmt'],
                    'status' => 1
                ];

                $mst_orderitem = mst_orderitem::create($orderitem);

                $productid[] = $val['productId'];
            }


            foreach ($filteredSalesData as $key => $values) {

                if ($req->sales_person_id == $values) {

                    $ordertype = 0;
                } else {
                    $ordertype = 1;
                }

                $secinor =   getSeniorUserIds($values, date('M'), date('Y'));

                $filteredSecinor = array_filter((array)$secinor, function ($value) {
                    return !is_null($value);
                });

                $seniorUserIds = array_values($filteredSecinor);

                $salesachieveTargetAuthKey = sha1($mst_salesorderdata->orderNo . $values . $currentDateTime->toDateTimeString());

                $trans_salestargethistory = [
                    'orderId_fk' => $orderId,
                    'sales_userId_fk' => $values,
                    'achievePrimaryTarget' => $req->subtotal,
                    'achieveSecondaryTarget' => 0,
                    'orderType' =>  $ordertype,
                    'seniorUserId' => serialize($seniorUserIds),
                    'monthNm' => date('M'),
                    'yearNo' => date('Y'),
                    'dataEntryDate' => $dataEntrydate,
                    'salesachieveTargetAuthKey' => $salesachieveTargetAuthKey,
                    'status' => 1,
                ];

                $trans_salestargethistory =  trans_salestargethistory::insert($trans_salestargethistory);
            }

            $sales_data = [
                'sales_whatspp' => $sales_whatspp,
                'orderAuthKey' => $mst_salesorderdata->orderAuthKey,
                'current_order' => $req->grandtotal,
                'order_numebr' => $mst_salesorderdata->orderNo,
            ];

            ordereditwhatsapp::dispatch($sales_data);



            DB::commit();
            if ($mst_orderitem) {
                $msg = 1;
            } else {
                $msg = 0;
            }
            return $msg;
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['resp' => 2, 'msg' => 'Data Not Insert Successfully', 'error' => $e->getMessage(), 'line' => $e->getLine()]);
        }
    }


    public function consigneedata(Request $req)
    {

        //dd($req);
        $retailer_project_name = $req->retailer_project_name;
        $alldistributor = $req->alldistributor;
        $getcomp = mstcustomerlist::select('CustomerName')->where('customerId', $alldistributor)->where('status', 184)->first();
        $mstcustomerlistadd = mstcustomerlist::select('address', 'customerId', 'faucet_ex_fc_disc', 'faucet_dealer_scheme_discount', 'faucet_distributor_scheme_discount', 'faucet_distributor_disc', 'faucet_retailer_ubs_scheme_disc', 'sanitary_ex_sc_dicount', 'sanitary_distributor_disc', 'sanitary_dealer_line_discount', 'faucet_finaldiscount', 'sanitary_finaldiscount', 'display_discount')->where('CustomerName', $getcomp->CustomerName)->where('consigneeName', $retailer_project_name)->where('status', 184)->first();

        $trans_customersalesperson =  trans_customersalesperson::select('userId_fk')->where('customerId_fk', $mstcustomerlistadd->customerId)->first();
        //  dd($mstcustomerlistadd);
        $mstcustomerlistadd['sales_person_id'] = $trans_customersalesperson->userId_fk ?? 0;
        return $mstcustomerlistadd;
    }

    public function generatePDF($orderId)
    {

        $orderdata = mst_orderlist::where('orderAuthKey', $orderId)->first();
        $orderItems = mst_orderitem::with('productitem')->where('orderId_fk', $orderdata->orderId)->get();


        //  old query  changed 21-05-2025 
        // $salesdata  = trans_salestargethistory::select('mst_user_list.name')
        //     ->join('mst_user_list', 'mst_user_list.userId', '=', 'trans_salestargethistory.sales_userId_fk')
        //     ->where('trans_salestargethistory.orderId_fk', $orderdata->orderId)
        //     ->where('trans_salestargethistory.orderType', 0)
        //     ->first();

        // $orderdata['salesname'] = $salesdata ? $salesdata->name : '';





        $data = [
            'orderdata' => $orderdata,
            'customerinfo' => getcustomerdatabyid($orderdata->customerId_fk),
            'orderItems' => $orderItems
        ];

        $fileName = $orderdata['orderNo'] . '-' . time() . '.pdf';
        $filePath = public_path('orderpdf/' . $fileName);

        $pdf = PDF::loadView('order.pdf', $data);
        $pdf->save($filePath);

        return response()->file($filePath);
    }


    public function scheme()
    {

        $masterdata_category = $this->masterdata_category[0]->masterDataId;

        $series = mastermenu::select('masterMenuId', 'name')
            ->where('masterDataId_fk', $masterdata_category)
            ->whereNotNull('parentId')
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();

        return view('order.scheme', compact('series'));
    }


    public function schemesubmit(Request $req)
    {


        $currentDateTime = now();
        $dataEntrydate = strtotime($currentDateTime->toDateTimeString());
        $schemeAuthKey = sha1($req->series . $currentDateTime->toDateTimeString());

        $data = [
            'cateId_fk' => $req->series,
            'numberOfItem' => $req->number_of_item,
            'noOfFreeQty' => $req->number_of_free_item,
            'startDate' => strtotime($req->start_date),
            'endDate' => strtotime($req->end_date),
            'dataEntryDate' => $dataEntrydate,
            'schemeAuthKey' => $schemeAuthKey,
            'status' => 1

        ];
        $mst_cateScheme =  mst_cateScheme::create($data);

        $msg = $mst_cateScheme ? 'Data Insert Successfully' : 'Data Not Insert Successfully';
        $resp = $mst_cateScheme ? 1 : 2;

        return response()->json(['resp' => $resp, 'msg' => $msg]);
    }

    public function schemelist()
    {
        return view('order.schemelist');
    }

    public function schemelistdata(Request $req)
    {

        //dd($req);

        $rowCount = $req->input('rowCount');
        $page = $req->input('page');

        $mst_cateScheme = mst_cateScheme::select('cateId_fk', 'schemeId', 'numberOfItem', 'noOfFreeQty', 'startDate', 'endDate', 'dataEntryDate', 'schemeAuthKey', 'status')
            ->where('status', 1)
            ->orderBy('schemeId', 'desc')
            ->paginate($rowCount, ['*'], 'page', $page);
        $data = [];
        foreach ($mst_cateScheme as $key => $val) {

            $mastermenu = getmastermenudatabyid($val->cateId_fk);

            $startDate = $val->startDate > 0 ? $val->startDate : null;
            $endDate = $val->endDate > 0 ? $val->endDate : null;
            $currentDate = time(); // Current timestamp

            // Determine status based on current date
            if ($startDate && $endDate && $currentDate >= $startDate && $currentDate <= $endDate) {
                $status = 'Active';
            } else {
                $status = 'Inactive';
            }

            //dd($status);

            $entry = [
                'schemeId' => $val->schemeId,
                'cateId_fk' =>  $mastermenu->name,
                'numberOfItem' => $val->numberOfItem,
                'noOfFreeQty' => $val->noOfFreeQty,
                'startdate' => $val->startDate > 0 ? date('d-M-Y', $val->startDate) : '', // Show date if greater than 0
                'enddate' => $val->endDate > 0 ? date('d-M-Y', $val->endDate) : '', // Added a similar check for enddate
                'status_to' => $status,
                'dataEntryDate' => $val->dataEntryDate,
                'schemeAuthKey' => $val->schemeAuthKey,
                'status' => $val->status,
            ];

            $data[] = $entry;
        }

        $response = [
            'data' => $data,
            'current_page' => $mst_cateScheme->currentPage(),
            'last_page' => $mst_cateScheme->lastPage()
        ];


        return response()->json($response);
    }

    public function sechmedelete($schemeId)
    {
        try {

            $mst_cateScheme = mst_cateScheme::where('schemeId', $schemeId)->update(['status' => 0]);

            if ($mst_cateScheme) {
                return 1;
            }
        } catch (\Exception $e) {
            // dd($e);
            return back()->with('error', 'Failed to delete related data. Please try again.');
        }
    }

    public function getorders()
    {

        $dateBefore31Days = Carbon::now()->subDays(31);
        $formattedDate = strtotime($dateBefore31Days->format('Y-m-d'));
        // dd($formattedDate);


        $mst_orderlist = mst_orderlist::select('orderNo')->where('createDate', '>=', $formattedDate)->where('status', '!=', 0)->get();


        if ($mst_orderlist->isEmpty()) {
            return response(['message' => 'No orders found'], 404);
        }

        // Return the response with status 200 and the retrieved data
        return response(['data' => $mst_orderlist], 200);
    }

    public function getorderdetail(Request $request)
    {
        // Fetch the order details
        $ordernumber = $request->get('orderNo');

        $mst_orderlist = mst_orderlist::where('orderNo', $ordernumber)
            ->where('status', '!=', 0)
            ->first();

        // Check if order details were found
        if (!$mst_orderlist) {
            return response(['message' => 'No orders found'], 404);
        }

        $data = [];
        $orderitem = [];

        // Fetch related data
        $customerdata = mstcustomerlist::select('CustomerName')
            ->where('customerId', $mst_orderlist->customerId_fk)
            ->first();

        $order_type = getmastermenudatabyid($mst_orderlist->orderType);
        $brand = getmastermenudatabyid($mst_orderlist->brandId_fk);
        $transport = getmastermenudatabyid($mst_orderlist->transportId_fk);
        $bankname = getmastermenudatabyid($mst_orderlist->bankId_fk);
        $payment_mode = getmastermenudatabyid($mst_orderlist->paymentMode);

        // Populate the response data
        $data['customername'] = $customerdata ? $customerdata->CustomerName : ''; // Handle possible null
        $data['category'] = $mst_orderlist->order_category ? $mst_orderlist->order_category : '';
        $data['order_type'] = $order_type ? $order_type->name : '';
        $data['brand'] = $brand ? $brand->name : '';
        $data['discount'] = $mst_orderlist->enterDiscount ? $mst_orderlist->enterDiscount : '';
        $data['transport'] = $transport ? $transport->name : '';
        $data['bankname'] = $bankname ? $bankname->name : '';
        $data['retailer_project_name'] = !empty($mst_orderlist->retailer_project_name) ? $mst_orderlist->retailer_project_name : '';
        $data['orderdate'] = $mst_orderlist->orderDate ? date('d-M-Y', $mst_orderlist->orderDate) : '';
        $data['cash_discount'] = $mst_orderlist->enterCashDiscount ? $mst_orderlist->enterCashDiscount : '';
        $data['payment_mode'] = $payment_mode ? $payment_mode->name : '';
        $data['check_number'] = $mst_orderlist->chequeNumber ? $mst_orderlist->chequeNumber : '';
        $data['shipping_address'] = $mst_orderlist->shppingAddress ? $mst_orderlist->shppingAddress : '';


        $mst_orderitem = mst_orderitem::where('orderId_fk', $mst_orderlist->orderId)->where('status', 1)->get();

        foreach ($mst_orderitem as $val) {

            $productname = mstproduct::select('categoryId_fk', 'subCategoryId_fk', 'cat_number', 'productName')->where('productId', $val->productId_fk)->first();
            $category = getmastermenudatabyid($productname->categoryId_fk);
            $series = getmastermenudatabyid($productname->subCategoryId_fk);

            $orderitem[] = [

                'productname' => $productname->productName,
                'cat_number' => $productname->cat_number,
                'category' => $category->name,
                'series' => $series->name,
                'qty' => $val->qty,
                'rate' => $val->pcsRate,
                'totalAmt' => $val->totalAmt,

            ];
        }


        // Order items are not yet populated
        $data['orderitems'] = $orderitem; // Update this with actual order items data if needed

        return response(['data' => $data], 200);
    }

    public function Ledger(Request $request)
    {

        $validated = $request->validate([
            'data' => 'required',
        ]);
        $rawData = $request->getContent();

        // Decode JSON into an associative array
        $decodedData = json_decode($rawData, true);

        $Ledgers = $decodedData['data']['Ledgers'];


        foreach ($Ledgers as $key => $myledger) {

            $Ledger_Name = $myledger['Ledger_Name'];

            $checkledger = mst_ledger::where('ledgerName', $Ledger_Name)->count();


            if ($checkledger > 0) {

                mst_ledger::where('ledgerName', $Ledger_Name)->delete();
            }


            $currentDateTime = now();
            $dataEntrydate = strtotime($currentDateTime->toDateTimeString());

            $data = [
                'ledgerName' => $Ledger_Name,
                'jsondata' => json_encode($myledger),
                'datetime' => $dataEntrydate,
                'status' => 1
            ];

            $mst_ledger = mst_ledger::create($data);
        }



        if (!$mst_ledger) {
            return response()->json(['message' => 'Insertion failed'], 500);
        }
        return response()->json([
            'message' => 'Data inserted successfully',
            'data' => $mst_ledger
        ], 200);
    }

    public function inventory(Request $request)
    {


        $validated = $request->validate([
            'data' => 'required',
        ]);
        $currentDateTime = now();
        $dataEntrydate = strtotime($currentDateTime->toDateTimeString());

        $inventorys = $request->getContent();

        $inventorys = json_decode($inventorys, true);

        $inventorys = $inventorys['data']['Inventory'];

        foreach ($inventorys as $key => $myinventory) {

            $PartNo = $myinventory['PartNo'];

            $checkinventory =  mst_inventory::where('partNo', $PartNo)->count();

            if ($checkinventory > 0) {

                mst_inventory::where('partNo', $PartNo)->delete();
            }

            $data = [
                'partNo' => $PartNo,
                'jsondata' => json_encode($myinventory),
                'datetime' => $dataEntrydate,
                'status' => 1
            ];



            $mst_inventory = mst_inventory::create($data);
        }


        if (!$mst_inventory) {
            return response()->json(['message' => 'Insertion failed'], 500);
        }
        return response()->json([
            'message' => 'Data inserted successfully',
            'data' => $mst_inventory
        ], 200);
    }


    public function orderdatesearch(Request $req)
    {
        $rowCount = $req->input('rowCount');
        $page = $req->input('page');
        $from_date = strtotime($req->input('from_date'));
        $to_date = strtotime($req->input('to_date'));

        if (session('userinfo')->role_type == 2) {

            $orders = mst_orderlist::select(
                'mst_orderlist.orderNo',
                'mst_orderlist.customerId_fk',
                'mst_orderlist.orderDate',
                'mst_orderlist.totalAmt',
                'mst_orderlist.discountAmt',
                'mst_orderlist.taxAmt',
                'mst_orderlist.pdf_filename',
                'mst_orderlist.grandAmt',
                'mst_orderlist.orderId',
                'mst_orderlist.orderAuthKey',
                DB::raw("(SELECT trans_orderdispatch.orderDispatchId FROM trans_orderdispatch WHERE trans_orderdispatch.orderId_fk = mst_orderlist.orderId LIMIT 1) as orderDispatchId")
            )
                ->where('mst_orderlist.status', '!=', 0)
                ->whereBetween('mst_orderlist.orderDate', [$from_date, $to_date])
                ->orderBy('mst_orderlist.orderId', 'desc')
                ->paginate($rowCount, ['*'], 'page', $page);
        } else {
            $orders = mst_orderlist::select(
                'mst_orderlist.orderNo',
                'mst_orderlist.customerId_fk',
                'mst_orderlist.orderDate',
                'mst_orderlist.totalAmt',
                'mst_orderlist.discountAmt',
                'mst_orderlist.taxAmt',
                'mst_orderlist.pdf_filename',
                'mst_orderlist.grandAmt',
                'mst_orderlist.orderId',
                'mst_orderlist.orderAuthKey',
                DB::raw("(SELECT trans_orderdispatch.orderDispatchId FROM trans_orderdispatch WHERE trans_orderdispatch.orderId_fk = mst_orderlist.orderId LIMIT 1) as orderDispatchId")
            )
                ->join('trans_customersalesperson', 'trans_customersalesperson.customerId_fk', '=', 'mst_orderlist.customerId_fk')
                ->where('trans_customersalesperson.userId_fk', session('userinfo')->userId)
                ->where('mst_orderlist.status', '!=', 0)
                ->whereBetween('mst_orderlist.orderDate', [$from_date, $to_date])
                ->orderBy('mst_orderlist.orderId', 'desc')
                ->paginate($rowCount, ['*'], 'page', $page);
        }
        $data = [];
        foreach ($orders as $key => $order) {

            $customername = getcustomerdatabyid($order->customerId_fk);

            $entry = [
                'orderNo' => $order->orderNo,
                'CustomerName' =>  $customername ? $customername->CustomerName : '',
                'orderDate' => date('d-M-y', $order->orderDate),
                'totalAmt' => number_format($order->totalAmt),
                'discountAmt' => number_format($order->discountAmt),
                'taxAmt' => number_format($order->taxAmt),
                'grandAmt' => number_format($order->grandAmt),
                'orderId' => $order->orderId,
                'pdf_filename' => $order->pdf_filename,
                'orderDispatchId' => $order->orderDispatchId,
                'orderAuthKey' => $order->orderAuthKey,
            ];

            $data[] = $entry;
        }

        $response = [
            'data' => $data,
            'current_page' => $orders->currentPage(),
            'last_page' => $orders->lastPage()
        ];


        return response()->json($response);
    }


    public function export(Request $request)
    {
        $orderNo = $request->input('order_no');
        $companyName = $request->input('company_name');
        $fromDate = $request->input('from_date') ? strtotime($request->input('from_date')) : null;
        $toDate = $request->input('to_date') ? strtotime($request->input('to_date')) : null;
        $amount = $request->input('amount');
        $discount = $request->input('discount');
        $order_p = $request->input('order_p');
        $gstAmt = $request->input('gst_amt');
        $totalAmount = $request->input('total_amout');

        // Pass all parameters to the OrdersExport class
        return Excel::download(new OrdersExport($orderNo, $order_p, $companyName, $fromDate, $toDate, $amount, $discount, $gstAmt, $totalAmount), 'orders.xlsx');
    }



    // public function jasondecode()
    // {

    //     //dd('fefe');





    //     // Decode the JSON
    //     $data = json_decode($json, true);

    //     // Total inventory count
    //     $totalInventoryCount = count($data['data']['Inventory']);

    //     // Count unique PartNo and store duplicates
    //     $partNoCounts = [];
    //     $duplicatePartNos = [];

    //     foreach ($data['data']['Inventory'] as $item) {
    //         $partNo = $item['PartNo'];

    //         // Count occurrences of PartNo
    //         if (isset($partNoCounts[$partNo])) {
    //             $partNoCounts[$partNo]++;
    //         } else {
    //             $partNoCounts[$partNo] = 1;
    //         }
    //     }

    //     // Collect duplicates
    //     foreach ($partNoCounts as $partNo => $count) {
    //         if ($count > 1) {
    //             $duplicatePartNos[] = $partNo;
    //         }
    //     }

    //     // Unique inventory count
    //     $uniqueInventoryCount = count(array_unique(array_column($data['data']['Inventory'], 'PartNo')));

    //     // Output the results
    //     echo "Total Inventory Count: $totalInventoryCount\n";
    //     echo "Unique Part Numbers Count: $uniqueInventoryCount\n";
    //     echo "Duplicate Part Numbers: " . implode(', ', $duplicatePartNos) . "\n";
    // }
}
