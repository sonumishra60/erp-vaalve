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
use App\Models\trans_salestargethistory;
use App\Jobs\whatsappmeassaap;
use App\Jobs\ordereditwhatsapp;
use Illuminate\Support\Facades\DB;
use App\Jobs\GenerateOrderPDF;
use App\Jobs\GenerateOrderPDFWithId;
use App\Jobs\distributorwhatsappmessage;
use PDF;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OrderController extends BaseController
{
    

    public function index(){
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
            ->where('status',1)
            ->orderBy('masterMenuId', 'desc')
            ->get();

            if($ordercustomerid != ''){

                $customerData = mstcustomerlist::select('mst_mastermenu.name as customertype')
                    ->join('mst_mastermenu', 'mst_customerlist.customer_type', '=', 'mst_mastermenu.masterMenuId')       
                    ->where('mst_customerlist.customerId',$ordercustomerid)->first();

                 $customertype = strtolower($customerData->customertype);
            }

        $html = '';

        foreach ($masterdata_category as $pkey => $pvalue) {
       
            $html .='<div class="accordion accordion-primary" id="accordion-' . $pkey . '">
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
                ->where('status',1)
                ->get();

                    if(count($masterdata_child_category) == 0){
                        $html .= '<p class="text-center" > No series found</p>';
                    }


            foreach ($masterdata_child_category as $ckey => $cvalue) {
                $html .= '
                <div class="row">
                            	<div class="" style="width:100%; ">
                                <div class="accordion accordion-primary" id="accordion-' . $pkey.'-'.$ckey . '">
                                            <div class="accordion-item accordion-bg2">
                                                <div class="accordion-header bg-acr2 rounded-lg collapsed d-flex"
                                                    id="headings' . $pkey.'-'.$ckey . '" data-bs-toggle="collapse"
                                                    data-bs-target="#collapses' . $pkey.'-'.$ckey . '" aria-controls="collapses' . $pkey.'-'.$ckey . '"
                                                    aria-expanded="false" role="button">
                                                    <span class="accordion-header-icon"></span>
                                                    <span class="accordion-header-text fs-14">' . ucwords(strtolower($cvalue->name)) . ' </span>
                                                    <span class="top-inp pull-right mo-display"><input type="text"
                                                            placeholder="Item Search" class="form-control item-search"></span>
                                                    <span class="accordion-header-indicator"></span>
                                                </div>
                                                <div id="collapses' . $pkey.'-'.$ckey . '" class="collapse" aria-labelledby="heading' . $pkey.'-'.$ckey . '"
                                                    data-bs-parent="#accordions-' . $pkey.'-'.$ckey . '" style="">

                                                    <div class="accordion-body-text">';

                                                    $products = mstproduct::select('productId','subCategoryId_fk','productName','boxMRP','cat_number','dop_netprice','mop_netprice')->where('subCategoryId_fk', $cvalue->masterMenuId)->get();

                                                    if(count($products) == 0){
                                                        $html .= '<p class="text-center" > No Item found</p>';
                                                    }else{

                                                        $html.='<div class="mob-box mo-display">';;
                                                         foreach ($products as $pkey => $pvalue) {
                                                            $productName = strtolower($pvalue->productName);

                                                            // if($pvalue->dop_netprice != ''){
                                                            //     $mrp = $pvalue->dop_netprice.'<span class="text-danger">*</span>';
                                                            //     $mrptype = 'netrate';  
                                                            // }else{
                                                            //     $mrp = $pvalue->boxMRP;
                                                            //     $mrptype = 'mrp';
                                                            // }

                                                            $mrp = $pvalue->boxMRP;

                                                            if(!empty($orderitem)){



                                                               

                                                //dd($customerData);

                                                    if($customertype == 'distributor' || $customertype == 'dealer'){
                                                        $mrp = $pvalue->dop_netprice;
                                                        $mrptype = 'netrate';
                                                    }else if($customertype == 'retailer' || $customertype == 'ubs'){

                                                        $mrp = $pvalue->mop_netprice;
                                                        $mrptype = 'netrate';
                                                    }else{
                                                        $mrp = $pvalue->boxMRP;
                                                        $mrptype = 'mrp';
                                                    }
                                            
                                                                $itemqty = '';
                                                                $itemtotal = '';

                                                                foreach($orderitem as $key => $itemval){

                                                                    if($itemval['pcsRate'] != 0){
                                                                        if($itemval['productId_fk'] == $pvalue->productId){

                                                                            $itemqty = $itemval['qty'];
                                                                            $itemtotal = $itemval['totalAmt'];
                                                                         }

                                                                     }
                                                                }


                                                            }
                                                           

                                                   $html .='<div class="box-tb">
                                                                <div class="row">
                                                                    <div class="col-10 item-name"><strong> ' . ucwords($productName) . ' ('. $pvalue->cat_number .')</strong>
                                                                    </div>
                                                                    <div class="col-2 qt-box pl-0"><input
                                                                            class="form-control form-ctr2 mobileqty"
                                                                            inputmode="numeric" pattern="[0-9]*" 
                                                                            placeholder="Qty" value="'. @$itemqty .'"  type="text"></div>
                                                                </div>

                                                                <div class="row">
                                                                    <ul class="dptext2">
                                                                    <input type="hidden" class="productId" value="'.$pvalue->productId .'">
                                                                    <input type="hidden" class="mrptype" value="'.$mrptype.'">
                                                                    <input type="hidden" class="seriesid" value="'.$pvalue->subCategoryId_fk.'">
                                                                    <input type="hidden" class="seriesName" value="'.ucwords(strtolower($cvalue->name)).'">
                                                                    <input type="hidden" class="dealerdistributor_mrp" value="'.$pvalue->dop_netprice.'">
                                                                    <input type="hidden" class="retailer_ubs_mrp" value="'.$pvalue->mop_netprice.'">
                                                                    <input type="hidden" class="default_mrp" value="'.$pvalue->boxMRP.'">
                                                                        <li><strong>MRP:</strong> <span
                                                                                class="lig-tx price">'. $mrp .'</span></li>
                                                                        <li><strong>Amount:</strong> <span
                                                                                class="lig-tx amount">'. @$itemtotal .' </span></li>
                                                                    </ul>
                                                                </div>
                                                            </div>';

                                                                 
                                                         }
                                                     
                                                     $html .='</div>

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
                                                              
                                                                <tbody>

                                                                    ';

                                     foreach ($products as $pkey => $pvalue) {
                                          $productName = strtolower($pvalue->productName);
                                       

                                        if(!empty($orderitem)){

                                            $itemqty = '';
                                            $itemtotal = '';

                                            //dd($customerData->customertype);

                                            if($customertype == 'distributor' || $customertype == 'dealer'){
                                               
                                               if($pvalue->dop_netprice != ''){

                                                   $mrp = moneyFormatIndia($pvalue->dop_netprice).'<span class="text-danger">*</span>';
                                                   $mrptype = 'netrate';
                                               }else{
                                                $mrp = moneyFormatIndia($pvalue->boxMRP);
                                                    $mrptype = 'mrp';
                                               }
                                              

                                            }else if($customertype == 'retailer' || $customertype == 'ubs'){
  
                                                if($pvalue->mop_netprice != ''){

                                                    $mrp = moneyFormatIndia($pvalue->mop_netprice).'<span class="text-danger">*</span>';
                                                    $mrptype = 'netrate';
                                                }else{
                                                    $mrp = moneyFormatIndia($pvalue->boxMRP);
                                                     $mrptype = 'mrp';
                                                }

                                            }else{
                                                $mrp = moneyFormatIndia($pvalue->boxMRP);
                                                $mrptype = 'mrp';
                                            }



                                            foreach($orderitem as $key => $itemval){

                                                if($itemval['pcsRate'] != 0){
                                                    if($itemval['productId_fk'] == $pvalue->productId){

                                                        $itemqty = $itemval['qty'];
                                                        $itemtotal = $itemval['totalAmt'];
                                                     }

                                                 }
                                            }
                                        }

                                    //    if($pvalue->netrate != ''){

                                    //     $mrp = number_format($pvalue->netrate, 2, '.', ',').'<span class="text-danger">*</span>';
                                    //     $mrptype = 'netrate';

                                    //    }else{
                                    //        $mrptype = 'mrp';
                                    //     }
                                       

                                             $html .= '<tr>
                                                                <input type="hidden" class="productId" value="'.$pvalue->productId .'">
                                                                <input type="hidden" class="mrptype" value="'.$mrptype.'">
                                                                <input type="hidden" class="seriesid" value="'.$pvalue->subCategoryId_fk.'">
                                                                <input type="hidden" class="seriesName" value="'.ucwords(strtolower($cvalue->name)).'">
                                                                <input type="hidden" class="dealerdistributor_mrp" value="'.$pvalue->dop_netprice.'">
                                                                <input type="hidden" class="retailer_ubs_mrp" value="'.$pvalue->mop_netprice.'">
                                                                <input type="hidden" class="default_mrp" value="'.$pvalue->boxMRP.'">

                                                                <td class="w-250px rounded-start">' . ucwords($productName)  . '</td>
                                                                <td class="w-50px rounded-start">'. $pvalue->cat_number .'</td>
                                                                <td
                                                                    class="w-50px rounded-start text-right">
                                                                    <input class="new-inp text-right qty"
                                                                     onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                     value="'. @$itemqty .'"
                                                                        type="text">
                                                                </td>
                                                                <td class="w-50px rounded-start text-right price "> '.$mrp.'</td>
                                                            
                                                                <td class="w-50px rounded-start text-right amount">'. @$itemtotal .'</td>
                                                            </tr>';
                                                 }

                                                $html .= '</tbody>
                                                            </table>
                                                        </div>';
                                                    }

                                                    $html .='</div>
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

            $sales_whatspp = getSeniorUserIds($req->sales_person_id,date('M'),date('Y'));
           
            $filteredSalesData = array_filter((array)$sales_whatspp, function ($value) {
                return !is_null($value);
            });


            $zero = $counter < 10 ? '000' : ($counter < 100 ? '00' : ($counter < 1000 ? '0' : ''));
            $orderNo = $monthChar . $month . $year . $zero . $counter;
            $orderAuthKey = sha1($orderNo . $currentDateTime->toDateTimeString());



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
                'orderAuthKey' => $orderAuthKey,
                'status' => 1
            ];

            $mst_orderlist = mst_orderlist::create($data);
            $orderId = $mst_orderlist->orderId;

            $productid = [];
            foreach ($products as $key => $val) {
                $orderitem = [
                    'customerId_fk' => $req->alldistributor,
                    'orderId_fk' => $orderId,
                    'productId_fk' => $val['productId'],
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
    
            foreach($serieccount as $key => $val) {
                $mst_cateScheme = mst_cateScheme::where('cateId_fk', $val->masterMenuId)
                                                ->where('numberOfItem', '<=', $val->totalQuantity)
                                                ->orderBy('schemeId', 'desc')
                                                ->first();
            
                if($mst_cateScheme) {
                    $minMrp = mstproduct::where('subCategoryId_fk', $mst_cateScheme->cateId_fk)->whereIn('productId',$productid)->min('mrp');
            
                    $freeproductdata = mstproduct::where('subCategoryId_fk', $mst_cateScheme->cateId_fk)
                                                 ->where('mrp', $minMrp)
                                                 ->whereIn('productId',$productid)
                                                 ->orderBy('productId', 'asc')
                                                 ->first();
            
                    // Add freeqty to the product data
                    $freeproductdata['freeqty'] = $mst_cateScheme->noOfFreeQty;
                    
                    $freeproduct[] = $freeproductdata;
                }
            }

            foreach($freeproduct as $key => $val){

                $orderitem = [
                    'customerId_fk' => $req->alldistributor,
                    'orderId_fk' => $orderId,
                    'productId_fk' => $val['productId'],
                    'qty' => $val['freeqty'],
                    'pcsRate' => 0,
                    'totalAmt' => 0,
                    'status' => 1
                ];
                mst_orderitem::create($orderitem);


            }

            if($mst_orderlist){ 
                    $msg = 1;
            }else{
                    $msg = 0;
            }



            foreach($filteredSalesData as $key => $values){

                if($req->sales_person_id == $values){

                    $ordertype = 0;
                }else{
                    $ordertype = 1;
                }

                 $secinor =   getSeniorUserIds($values,date('M'),date('Y'));

                 $filteredSecinor = array_filter((array)$secinor, function ($value) {
                    return !is_null($value);
                });
            
                $seniorUserIds = array_values($filteredSecinor);
                
                $salesachieveTargetAuthKey = sha1($orderNo .$values .$currentDateTime->toDateTimeString());

                 $trans_salestargethistory = [
                            'orderId_fk' => $orderId,
                            'sales_userId_fk' => $values,
                            'achievePrimaryTarget' => $req->subtotal,
                            'achieveSecondaryTarget' => 0,
                            'orderType' =>  $ordertype,
                            'seniorUserId' =>serialize($seniorUserIds),
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
            
            whatsappmeassaap::dispatch($sales_data);


            $distrubutor_what = [
                'customer_id' => $req->alldistributor,
                'orderAuthKey' => $orderAuthKey,
                'order_numebr' => $orderNo,
                
            ];

            distributorwhatsappmessage::dispatch($distrubutor_what);

            
            DB::commit();
            return $msg;

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['resp' => 2, 'msg' => 'Data Not Inserted Successfully', 'error' => $e->getMessage()]);
        }
    }

    public function schemecalculation(Request $req){

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
    
        foreach($aggregatedData as $key => $val) {
           // dd($val['seriesid']);
            $mst_cateScheme = mst_cateScheme::where('cateId_fk',$val['seriesid'])
                                            ->where('numberOfItem', '<=', $val['qty'])
                                            ->orderBy('schemeId', 'desc')
                                            ->first();


        
            if($mst_cateScheme) {

              

                $productidsString = explode(',', $val['cartproductIds']);

                $minMrp = mstproduct::where('subCategoryId_fk', $mst_cateScheme->cateId_fk)->whereIn('productId',$productidsString)->min('mrp');
        
                $freeproductdata = mstproduct::where('subCategoryId_fk', $mst_cateScheme->cateId_fk)
                                             ->where('mrp', $minMrp)
                                             ->whereIn('productId',$productidsString)
                                             ->orderBy('productId', 'asc')
                                             ->first();

                $mastermenuname = mastermenu::select('name')->where('masterMenuId',$freeproductdata->subCategoryId_fk)->first();
                //dd($freeproductdata);
        
                // Add freeqty to the product data
                $freeproductdata['freeqty'] = $mst_cateScheme->noOfFreeQty;
                $freeproductdata['seriesName'] = $mastermenuname->name;
                
                $freeproduct[] = $freeproductdata;
            }
        }


     return $freeproduct;

    }

  
    public function orderlist(){
        return view('order.list');
    }

    public function orderlistdata(Request $req){
       
        $rowCount = $req->input('rowCount');
        $page = $req->input('page');

        if(session('userinfo')->role_type == 2){
           
                $orders = mst_orderlist::select('orderNo', 'customerId_fk', 'orderDate', 'totalAmt', 'discountAmt', 'taxAmt', 'pdf_filename', 'grandAmt', 'orderId', 'orderAuthKey')
                ->where('status','!=', 0)
                ->orderBy('orderId', 'desc')
                ->paginate($rowCount, ['*'], 'page', $page);
      
        }else{
            $orders = mst_orderlist::select('mst_orderlist.orderNo', 'mst_orderlist.customerId_fk', 'mst_orderlist.orderDate', 'mst_orderlist.totalAmt', 'mst_orderlist.discountAmt', 'mst_orderlist.taxAmt', 'mst_orderlist.pdf_filename', 'mst_orderlist.grandAmt', 'mst_orderlist.orderId', 'mst_orderlist.orderAuthKey')
            ->join('trans_customersalesperson', 'trans_customersalesperson.customerId_fk', '=', 'mst_orderlist.customerId_fk')
            ->where('trans_customersalesperson.userId_fk', session('userinfo')->userId)
            //->where('mst_orderlist.status', 1)
            ->where('mst_orderlist.status','!=', 0)
            ->orderBy('mst_orderlist.orderId', 'desc')
            ->paginate($rowCount, ['*'], 'page', $page);

        }
        $data = [];
            foreach($orders as $key => $order) {

            $customername = getcustomerdatabyid($order->customerId_fk);

                $entry = [
                    'orderNo' => $order->orderNo,
                    'CustomerName' =>  $customername ? $customername->CustomerName : '',
                    'orderDate' => date('d-M-y',$order->orderDate),
                    'totalAmt' => number_format($order->totalAmt),
                    'discountAmt' => number_format($order->discountAmt),
                    'taxAmt' => number_format($order->taxAmt),
                    'grandAmt' => number_format($order->grandAmt),
                    'orderId' => $order->orderId,
                    'pdf_filename' => $order->pdf_filename,
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


    public function ordersearch(Request $req){

        $rowCount = $req->input('rowCount');
        $page = $req->input('page');
        $order_no = $req->input('order_no');
        $company_name = $req->input('company_name');
        $order_date = $req->input('order_date');
        $amount = $req->input('amount');
        $discount = $req->input('discount');
        $gst_amt = $req->input('gst_amt');
        $total_amout = $req->input('total_amout');

        if(!empty($company_name)){
            $query_cat =  mstcustomerlist::where('CustomerName','like', '%' .$company_name.'%')->pluck('customerId');   
        }
        $query = mst_orderlist::select('orderNo', 'customerId_fk','pdf_filename', 'orderDate', 'totalAmt', 'discountAmt', 'taxAmt', 'grandAmt', 'orderId', 'orderAuthKey')
        ->where('status', 1)
        ->orderBy('orderId', 'desc');

        if (!empty($company_name)) {
             $query->whereIn('customerId_fk', $query_cat);
        }
        if (!empty($order_no)) {
            $query->where('orderNo', 'like', '%' . $order_no . '%');
        }
        if (!empty($amount)) {
            $query->where('totalAmt', 'like', '%' . $amount . '%');
        }
        if (!empty($order_date)) {
            $order_date = strtotime($order_date);
            $query->where('orderDate',$order_date);
        }
        if (!empty($discount)) {
            $query->where('discountAmt', 'like', '%' . $discount . '%');
        }
        if (!empty($gst_amt)) {
            $query->where('taxAmt', 'like', '%' . $gst_amt . '%');
        }
        if (!empty($total_amout)) {
            $query->where('grandAmt', 'like', '%' . $total_amout . '%');
        }
      
        $orders = $query->paginate($rowCount, ['*'], 'page', $page);


        $data = [];
        foreach($orders as $key => $order) {

        $customername = getcustomerdatabyid($order->customerId_fk);

            $entry = [
                'orderNo' => $order->orderNo,
                'CustomerName' =>  $customername->CustomerName,
                'orderDate' => date('d-M-y',$order->orderDate),
                'totalAmt' => number_format($order->totalAmt),
                'discountAmt' => number_format($order->discountAmt),
                'taxAmt' => number_format($order->taxAmt),
                'grandAmt' => number_format($order->grandAmt),
                'orderId' => $order->orderId,
                'pdf_filename' => $order->pdf_filename,
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


    public function orderdelete($orderid){
        try {
          
            $orderitem = mst_orderitem::where('orderId_fk',$orderid)->update(['status' => 0]);
            $order = mst_orderlist::where('orderId',$orderid)->update(['status' => 0]);
        
            if($order){
              return 1;
            } 
  
        } catch (\Exception $e) {
           // dd($e);
            return back()->with('error', 'Failed to delete related data. Please try again.');
        }

    }

    public function OrderCustomerDiscount(Request $req){

        $distributor = $req->input('distributor');
        $year = date('Y');
        $month = date('M');
       
        $customerData = mstcustomerlist::select('mst_customerlist.CustomerName','mst_customerlist.faucet_ex_fc_disc','mst_customerlist.sanitary_ex_sc_dicount','mst_customerlist.sanitary_finaldiscount','mst_customerlist.faucet_finaldiscount','mst_mastermenu.name as customertype','mst_customerlist.display_discount')
                                        ->join('mst_mastermenu', 'mst_customerlist.customer_type', '=', 'mst_mastermenu.masterMenuId')       
                                        ->where('mst_customerlist.customerId',$distributor)->first();

        $trans_customersalesperson = trans_customersalesperson::select('userId_fk')->where('customerId_fk',$distributor)->orderby('cusSalesPersonId','desc')->first();
        $userId_fk = $trans_customersalesperson->userId_fk ?? 0;

        $trans_salestarget = trans_salestarget::select('primaryTarget','secondaryTarget')->where('monthNm',$month)->where('yearNo',$year)->where('sales_userId_fk',$userId_fk)->first();

        //dd($trans_salestarget);

        $mtd_first_date = '01-'.$month.'-'.$year;
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

        if($pendingTgt < 0){
            $pendingTgt = 0;
        }

        if(session('userinfo')->role_type == 2){

            $orderconsignee = mstcustomerlist::select('mst_customerlist.consigneeName as consignmentName','mst_customerlist.customerId as customerId','mst_customerlist.address')
            ->join('trans_customersalesperson', 'trans_customersalesperson.customerId_fk', '=', 'mst_customerlist.customerId')
            ->where('mst_customerlist.CustomerName',$customerData->CustomerName)
          //  ->where('trans_customersalesperson.userId_fk',$customerData->CustomerName)
            ->where('mst_customerlist.status',184)->get();

        }else{

            $orderconsignee = mstcustomerlist::select('mst_customerlist.consigneeName as consignmentName','mst_customerlist.customerId as customerId','mst_customerlist.address')
            ->join('trans_customersalesperson', 'trans_customersalesperson.customerId_fk', '=', 'mst_customerlist.customerId')
            ->where('mst_customerlist.CustomerName',$customerData->CustomerName)
            ->where('trans_customersalesperson.userId_fk', session('userinfo')->userId)
            ->where('mst_customerlist.status',184)->get();


        }
       
        if(count($orderconsignee) == 0){
            $orderconsignee = mstcustomerlist::select('consigneeName as consignmentName','customerId','address')->where('CustomerName',$customerData->CustomerName)->where('status',184)->get();
        }
        
                            
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
            'consigneecount' =>count($orderconsignee),
            'orderconsignee' => $orderconsignee
        ];

        return response()->json($data);

    }

  

    public function orderedit($id){

        $order =  mst_orderlist::where('orderAuthKey',$id)->first();
        if($order){
            $year = date('Y');
            $month = date('M');

            $customerdiscount = mstcustomerlist::select('faucet_ex_fc_disc','sanitary_ex_sc_dicount','sanitary_finaldiscount','faucet_finaldiscount','display_discount')->where('customerId',$order->customerId_fk)->first();
            $trans_customersalesperson = trans_customersalesperson::select('userId_fk')->where('customerId_fk',$order->customerId_fk)->orderby('cusSalesPersonId','desc')->first();
            $trans_salestarget = trans_salestarget::select('primaryTarget','secondaryTarget')->where('monthNm',$month)->where('yearNo',$year)->where('sales_userId_fk',$trans_customersalesperson->userId_fk)->first();
          
            $mtd_first_date = '01-'.$month.'-'.$year;
            $mtd_first_date = strtotime($mtd_first_date);
            
            // Calculate the last date of the month
            $lastDayOfMonth = new DateTime("$year-$month-01");
            $lastDayOfMonth->modify('last day of this month');
            $mtd_last_date = $lastDayOfMonth->format('d-m-Y');
        //  dd($mtd_last_date);
            $mtd_last_date = strtotime($mtd_last_date);


        $discountAmt = mst_orderlist::where('sales_person_id', $trans_customersalesperson->userId_fk)
        ->where('createDate', '>=', $mtd_first_date)
        ->where('createDate', '<=', $mtd_last_date)
        ->sum('discountAmt');
        
        $totalAmt = mst_orderlist::where('sales_person_id', $trans_customersalesperson->userId_fk)
                ->where('createDate', '>=', $mtd_first_date)
                ->where('createDate', '<=', $mtd_last_date)
                ->sum('totalAmt');

        $mtd = round($totalAmt - $discountAmt, 2);

        $primaryTarget = $trans_salestarget->primaryTarget ?? 0;
                           // dd($primaryTarget);
        $pendingTgt =  $primaryTarget - $mtd;

        if($pendingTgt < 0){
            $pendingTgt = 0;
        }

        $orderitem =  mst_orderitem::select('mst_orderitem.*', 'mst_productlist.productName','mst_productlist.dop_netprice','mst_productlist.mop_netprice','mst_productlist.subCategoryId_fk','mst_mastermenu.name as serisname')
                                            ->join('mst_productlist', 'mst_orderitem.productId_fk', '=', 'mst_productlist.productId')
                                            ->join('mst_mastermenu', 'mst_productlist.subCategoryId_fk', '=', 'mst_mastermenu.masterMenuId')
                                            ->where('mst_orderitem.orderId_fk', $order->orderId)
                                            ->get();

        
        //$orderconsignee = mst_disConsignment::select('cusConsigId','consignmentName')->where('customerId_fk',$order->customerId_fk)->get();
       
        $customerData = mstcustomerlist::select('mst_customerlist.CustomerName','mst_customerlist.faucet_ex_fc_disc','mst_customerlist.sanitary_ex_sc_dicount','mst_customerlist.sanitary_finaldiscount','mst_customerlist.faucet_finaldiscount','mst_mastermenu.name as customertype','mst_customerlist.display_discount')
        ->join('mst_mastermenu', 'mst_customerlist.customer_type', '=', 'mst_mastermenu.masterMenuId')       
        ->where('mst_customerlist.customerId',$order->customerId_fk)->first();

       // dd($customerdiscount);

        if(session('userinfo')->role_type == 2){

            $orderconsignee = mstcustomerlist::select('mst_customerlist.consigneeName as consignmentName','mst_customerlist.address')
            ->join('trans_customersalesperson', 'trans_customersalesperson.customerId_fk', '=', 'mst_customerlist.customerId')
            ->where('mst_customerlist.CustomerName',$customerData->CustomerName)
          //  ->where('trans_customersalesperson.userId_fk',$customerData->CustomerName)
            ->where('mst_customerlist.status',184)->get();

        }else{

            $orderconsignee = mstcustomerlist::select('mst_customerlist.consigneeName as consignmentName','mst_customerlist.address')
            ->join('trans_customersalesperson', 'trans_customersalesperson.customerId_fk', '=', 'mst_customerlist.customerId')
            ->where('mst_customerlist.CustomerName',$customerData->CustomerName)
            ->where('trans_customersalesperson.userId_fk', session('userinfo')->userId)
            ->where('mst_customerlist.status',184)->get();


        }
       
        if(count($orderconsignee) == 0){
            $orderconsignee = mstcustomerlist::select('consigneeName as consignmentName','address')->where('CustomerName',$customerData->CustomerName)->where('status',184)->get();
        }
        
      

        return view('order.orderedit',compact('order','orderitem','customerdiscount','primaryTarget','trans_customersalesperson','trans_salestarget','mtd','pendingTgt','orderconsignee'));
        }else{
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
               // dd('ghek');
                DB::beginTransaction();
        
                $currentDateTime = now();
                $dataEntrydate = strtotime($currentDateTime->toDateTimeString());
                $products = $req->products;
                $orderId = $req->order_id;


                $sales_whatspp = getSeniorUserIds($req->sales_person_id,date('M'),date('Y'));
           
                $filteredSalesData = array_filter((array)$sales_whatspp, function ($value) {
                    return !is_null($value);
                });

                $mst_salesorderdata  = mst_orderlist::select('orderNo','orderAuthKey')->where('orderId', $orderId)->first();
        
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
                'status' => 1
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
                            'pcsRate' => $val['pcsRate'],
                            'totalAmt' => $val['totalAmt'],
                            'status' => 1
                        ];
            
                        $mst_orderitem = mst_orderitem::create($orderitem);

                        $productid[] = $val['productId'];
                    
                }


                foreach($filteredSalesData as $key => $values){

                    if($req->sales_person_id == $values){
    
                        $ordertype = 0;
                    }else{
                        $ordertype = 1;
                    }
    
                     $secinor =   getSeniorUserIds($values,date('M'),date('Y'));
    
                     $filteredSecinor = array_filter((array)$secinor, function ($value) {
                        return !is_null($value);
                    });
                
                    $seniorUserIds = array_values($filteredSecinor);
                    
                    $salesachieveTargetAuthKey = sha1($mst_salesorderdata->orderNo .$values .$currentDateTime->toDateTimeString());
    
                     $trans_salestargethistory = [
                                'orderId_fk' => $orderId,
                                'sales_userId_fk' => $values,
                                'achievePrimaryTarget' => $req->subtotal,
                                'achieveSecondaryTarget' => 0,
                                'orderType' =>  $ordertype,
                                'seniorUserId' =>serialize($seniorUserIds),
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
                  if($mst_orderitem){ 
                    $msg = 1;
              }else{
                $msg = 0;
              }
                return $msg;
                
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['resp' => 2, 'msg' => 'Data Not Insert Successfully', 'error' => $e->getMessage(),'line' => $e->getLine()]);
            }
        }


        public function consigneedata(Request $req){

            //dd($req);
            $retailer_project_name = $req->retailer_project_name;
            $alldistributor = $req->alldistributor;

            $getcomp = mstcustomerlist::select('CustomerName')->where('customerId',$alldistributor)->where('status', 184)->first();

            $mstcustomerlistadd = mstcustomerlist::select('address','faucet_ex_fc_disc','faucet_dealer_scheme_discount','faucet_distributor_scheme_discount','faucet_distributor_disc','faucet_retailer_ubs_scheme_disc','sanitary_ex_sc_dicount','sanitary_distributor_disc','sanitary_dealer_line_discount','faucet_finaldiscount','sanitary_finaldiscount','display_discount')->where('CustomerName',$getcomp->CustomerName)->where('consigneeName',$retailer_project_name)->where('status', 184)->first();

          //  dd($mstcustomerlistadd);
            return $mstcustomerlistadd;

        }

        public function generatePDF($orderId){

            $orderdata = mst_orderlist::where('orderAuthKey',$orderId)->first();
            $orderItems = mst_orderitem::with('productitem')->where('orderId_fk',$orderdata->orderId)->get();
            $salesdata  = trans_salestargethistory::select('mst_user_list.name')
                                ->join('mst_user_list', 'mst_user_list.userId', '=', 'trans_salestargethistory.sales_userId_fk')
                                ->where('trans_salestargethistory.orderId_fk',$orderdata->orderId)
                                ->where('trans_salestargethistory.orderType',0)
                                ->first();
            
            $orderdata['salesname'] = $salesdata ? $salesdata->name : '';


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


        public function scheme(){

            $masterdata_category = $this->masterdata_category[0]->masterDataId;
        
            $series = mastermenu::select('masterMenuId','name')
                                ->where('masterDataId_fk',$masterdata_category)
                                ->whereNotNull('parentId')
                                ->orderBy('name','asc')
                                ->get();

            return view('order.scheme',compact('series'));
        }


        public function schemesubmit(Request $req){

            
            $currentDateTime = now();
            $dataEntrydate = strtotime($currentDateTime->toDateTimeString());
            $schemeAuthKey = sha1($req->series . $currentDateTime->toDateTimeString());

           $data = [
            'cateId_fk' => $req->series,
            'numberOfItem' => $req->number_of_item,
            'noOfFreeQty' => $req->number_of_free_item,
            'dataEntryDate' => $dataEntrydate,
            'schemeAuthKey' => $schemeAuthKey,
            'status' => 1

           ];
          $mst_cateScheme =  mst_cateScheme::create($data);

          $msg = $mst_cateScheme ? 'Data Insert Successfully' : 'Data Not Insert Successfully';
          $resp = $mst_cateScheme ? 1 : 2;
  
          return response()->json(['resp' => $resp, 'msg' => $msg]);

        }


        public function schemelist(){
            return view('order.schemelist');
        }

        public function schemelistdata(Request $req){

            //dd($req);

            $rowCount = $req->input('rowCount');
            $page = $req->input('page');
    
            $mst_cateScheme = mst_cateScheme::select('cateId_fk', 'schemeId', 'numberOfItem', 'noOfFreeQty', 'dataEntryDate', 'schemeAuthKey', 'status')
                                    ->where('status', 1)
                                    ->orderBy('schemeId', 'desc')
                                    ->paginate($rowCount, ['*'], 'page', $page);
            $data = [];
                foreach($mst_cateScheme as $key => $val) {
    
                $mastermenu = getmastermenudatabyid($val->cateId_fk);
    
                    $entry = [
                        'schemeId' => $val->schemeId,
                        'cateId_fk' =>  $mastermenu->name,
                        'numberOfItem' => $val->numberOfItem,
                        'noOfFreeQty' => $val->noOfFreeQty,
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



        public function sechmedelete($schemeId){
            try {
              
                $mst_cateScheme = mst_cateScheme::where('schemeId',$schemeId)->update(['status' => 0]);
        
                if($mst_cateScheme){
                  return 1;
                } 
      
            } catch (\Exception $e) {
               // dd($e);
                return back()->with('error', 'Failed to delete related data. Please try again.');
            }
    
        }

}