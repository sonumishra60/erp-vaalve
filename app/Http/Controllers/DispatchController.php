<?php

namespace App\Http\Controllers;
use App\Models\mst_orderitem;
use App\Models\mst_orderlist;
use App\Models\mstcustomerlist;
use App\Models\trans_salestarget;
use App\Models\trans_customersalesperson;
use App\Models\mst_disConsignment;
use App\Models\trans_orderdispatch;
use App\Models\trans_dispatch_item;

use DateTime;
use DB;
use Illuminate\Http\Request;

class DispatchController extends Controller
{
    
    
    public function pendingdispatch(){

        return view('dispatch.pending');
    }

    public function completedispatch(){

        return view('dispatch.complete');
    }

    public function dispatchlistdata(Request $req){
       
        //dd($req);
        $rowCount = $req->input('rowCount');
        $page = $req->input('page');
        $dispatchtype = $req->input('dispatchtype');

        if(session('userinfo')->role_type == 2){
           
                $orders = mst_orderlist::select('orderNo', 'customerId_fk','quantity','sales_person_id', 'orderDate', 'totalAmt', 'grandAmt', 'orderId', 'orderAuthKey')
                                ->orderBy('orderId', 'desc');
              
                if (!is_null($dispatchtype)) {
                    $orders->where('status',2);
                }else{
                    $orders->where('status',1);
                }

                $orders = $orders->paginate($rowCount, ['*'], 'page', $page);
      
        }else{
            $orders = mst_orderlist::select('mst_orderlist.orderNo','mst_orderlist.quantity', 'mst_orderlist.customerId_fk','sales_person_id', 'mst_orderlist.orderDate', 'mst_orderlist.totalAmt', 'mst_orderlist.discountAmt', 'mst_orderlist.taxAmt', 'mst_orderlist.pdf_filename', 'mst_orderlist.grandAmt', 'mst_orderlist.orderId', 'mst_orderlist.orderAuthKey')
            ->join('trans_customersalesperson', 'trans_customersalesperson.customerId_fk', '=', 'mst_orderlist.customerId_fk')
            ->where('trans_customersalesperson.userId_fk', session('userinfo')->userId)
            ->orderBy('mst_orderlist.orderId', 'desc');
        
            if (!is_null($dispatchtype)) {
                $orders->where('mst_orderlist.status',2);
            }else{
                $orders->where('mst_orderlist.status',1);
            }

            $orders = $orders->paginate($rowCount, ['*'], 'page', $page);
 
        }
        $data = [];
            foreach($orders as $key => $order) {

            $customername = getcustomerdatabyid($order->customerId_fk);
              
            $salesuserdata = salesuserdata($order->sales_person_id);

            //dd($salesuserdata);

            $dispatchedqty = trans_dispatch_item::where('orderId_fk', $order->orderId)
                                            ->sum('qty');
           
            //dd($salesuserdata);

                $entry = [
                    'orderNo' => $order->orderNo,
                    'CustomerName' =>  $customername->CustomerName ?? '',
                    'salespersonname' => $salesuserdata,
                    'salespersonname' => $salesuserdata,
                    'orderDate' => date('d-M-y',$order->orderDate),
                    'grandAmt' => moneyFormatIndia($order->grandAmt),
                    'quantity' => $order->quantity,
                    'orderId' => $order->orderId,
                    'dispatchedqty' => $dispatchedqty,
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


    public function pendingdispathsearch(Request $req){

        //  dd('ffwe');
          
          $rowCount = $req->input('rowCount');
          $page = $req->input('page');
          $order_no = $req->input('order_no');
          $company_name = $req->input('company_name');
          $order_date = $req->input('order_date');
          $total_amout = $req->input('total_amout');
          $total_qty = $req->input('total_qty');
          $dispatch_qty = $req->input('dispatch_qty');
  
          if(!empty($company_name)){
              $query_cat =  mstcustomerlist::where('CustomerName','like', '%' .$company_name.'%')->pluck('customerId');   
          }
  
          // if(!empty($total_qty)){
          //     $query_total = mst_orderitem::selectRaw('orderId_fk, SUM(qty) as total_qty')
          //     ->groupBy('orderId_fk')
          //     ->having('total_qty', 'like', '%' . $total_qty . '%')
          //     ->pluck('orderId_fk');
          
          // }
          
          if(!empty($dispatch_qty)){
              $query_dispatch_total = trans_dispatch_item::selectRaw('orderId_fk, SUM(qty) as total_qty')
              ->groupBy('orderId_fk')
              ->having('total_qty', 'like', '%' . $dispatch_qty . '%')
              ->pluck('orderId_fk');
          }
  
  
          $query = mst_orderlist::select('orderNo', 'customerId_fk','pdf_filename', 'quantity','orderDate', 'totalAmt', 'discountAmt', 'taxAmt', 'grandAmt', 'orderId', 'orderAuthKey')
          ->where('status',1)
          ->orderBy('orderId', 'desc');

          if(session('userinfo')->role_type == 3){
            $query->where('sales_person_id',session('userinfo')->userId);
          }
  
          if (!empty($company_name)) {
               $query->whereIn('customerId_fk', $query_cat);
          }
  
          if (!empty($total_qty)) {
              $query->where('quantity','like', '%' . $total_qty. '%');
         }
  
         if (!empty($dispatch_qty)) {
          $query->whereIn('orderId', $query_dispatch_total);
         }
          
          if (!empty($order_no)) {
              $query->where('orderNo', 'like', '%' . $order_no . '%');
          }
         
          if (!empty($order_date)) {
              $order_date = strtotime($order_date);
              $query->where('orderDate',$order_date);
          }
          if (!empty($total_amout)) {
              $query->where('grandAmt', 'like', '%' . $total_amout . '%');
          }
        
          $orders = $query->paginate($rowCount, ['*'], 'page', $page);
  
          //$orders = $query->tosql();
          //dd($orders);
  
          $data = [];
          foreach($orders as $key => $order) {
  
          $customername = getcustomerdatabyid($order->customerId_fk);
  
         
              $dispatchedqty = trans_dispatch_item::where('orderId_fk', $order->orderId)
              ->sum('qty');
  
              //dd($salesuserdata);
  
              $entry = [
              'orderNo' => $order->orderNo,
              'CustomerName' =>  $customername->CustomerName,
              'orderDate' => date('d-M-y',$order->orderDate),
              'grandAmt' => moneyFormatIndia($order->grandAmt),
              'quantity' => $order->quantity,
              'orderId' => $order->orderId,
              'dispatchedqty' => $dispatchedqty,
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
  

    public function completedispathsearch(Request $req){

      //  dd('ffwe');
        
        $rowCount = $req->input('rowCount');
        $page = $req->input('page');
        $order_no = $req->input('order_no');
        $company_name = $req->input('company_name');
        $order_date = $req->input('order_date');
        $total_amout = $req->input('total_amout');
        $total_qty = $req->input('total_qty');
        $dispatch_qty = $req->input('dispatch_qty');

        if(!empty($company_name)){
            $query_cat =  mstcustomerlist::where('CustomerName','like', '%' .$company_name.'%')->pluck('customerId');   
        }

        // if(!empty($total_qty)){
        //     $query_total = mst_orderitem::selectRaw('orderId_fk, SUM(qty) as total_qty')
        //     ->groupBy('orderId_fk')
        //     ->having('total_qty', 'like', '%' . $total_qty . '%')
        //     ->pluck('orderId_fk');
        
        // }
        
        if(!empty($dispatch_qty)){
            $query_dispatch_total = trans_dispatch_item::selectRaw('orderId_fk, SUM(qty) as total_qty')
            ->groupBy('orderId_fk')
            ->having('total_qty', 'like', '%' . $dispatch_qty . '%')
            ->pluck('orderId_fk');
        }


        $query = mst_orderlist::select('orderNo', 'customerId_fk','pdf_filename', 'quantity','orderDate', 'totalAmt', 'discountAmt', 'taxAmt', 'grandAmt', 'orderId', 'orderAuthKey')
        ->where('status',2)
        ->orderBy('orderId', 'desc');
        if(session('userinfo')->role_type == 3){
            $query->where('sales_person_id',session('userinfo')->userId);
          }

        if (!empty($company_name)) {
             $query->whereIn('customerId_fk', $query_cat);
        }

        if (!empty($total_qty)) {
            $query->where('quantity','like', '%' . $total_qty. '%');
       }

       if (!empty($dispatch_qty)) {
        $query->whereIn('orderId', $query_dispatch_total);
       }
        
        if (!empty($order_no)) {
            $query->where('orderNo', 'like', '%' . $order_no . '%');
        }
       
        if (!empty($order_date)) {
            $order_date = strtotime($order_date);
            $query->where('orderDate',$order_date);
        }
        if (!empty($total_amout)) {
            $query->where('grandAmt', 'like', '%' . $total_amout . '%');
        }
      
        $orders = $query->paginate($rowCount, ['*'], 'page', $page);

        //$orders = $query->tosql();
        //dd($orders);

        $data = [];
        foreach($orders as $key => $order) {

        $customername = getcustomerdatabyid($order->customerId_fk);

       
            $dispatchedqty = trans_dispatch_item::where('orderId_fk', $order->orderId)
            ->sum('qty');

            //dd($salesuserdata);

            $entry = [
            'orderNo' => $order->orderNo,
            'CustomerName' =>  $customername->CustomerName ?? '',
            'orderDate' => date('d-M-y',$order->orderDate),
            'grandAmt' => moneyFormatIndia($order->grandAmt),
            'quantity' => $order->quantity,
            'orderId' => $order->orderId,
            'dispatchedqty' => $dispatchedqty,
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


    public function completedispatchdetail($id){

        $order =  mst_orderlist::where('orderAuthKey',$id)->first();

        if($order){

            $trans_orderdispatch = trans_orderdispatch::select('orderDispatchId','orderId_fk','dispatchDate')->where('orderId_fk',$order->orderId)->get();
            $year = date('Y');
            $month = date('M');
    
            // dd($orderitem);
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
    
           //  dd($order);
       
             $orderconsignee = mst_disConsignment::select('cusConsigId','consignmentName')->where('customerId_fk',$order->customerId_fk)->get();
    
    
            $data = [];
            $productQtyMap = [];
            $freeproductQtyMap = [];

            //dd($trans_orderdispatch);
            
            foreach($trans_orderdispatch as $key => $val){
                
                $trans_dispatch_item = trans_dispatch_item::select(
                    'trans_dispatch_item.qty',
                    'trans_dispatch_item.orderId_fk',
                    'trans_dispatch_item.productId_fk',
                    'mst_productlist.productName',
                    'mst_productlist.cat_number',
                    'mst_mastermenu.name as serisname',
                    'mst_orderitem.pcsRate as productrate'
                )
                ->join('mst_productlist', 'trans_dispatch_item.productId_fk', '=', 'mst_productlist.productId')
                ->join('mst_orderitem', 'trans_dispatch_item.itemOrderId_fk', '=', 'mst_orderitem.itemOrderId') // Adjusted the join condition
                ->join('mst_mastermenu', 'mst_productlist.subCategoryId_fk', '=', 'mst_mastermenu.masterMenuId')
                ->where('trans_dispatch_item.orderDispatchId_fk', $val->orderDispatchId)
                ->get();
                
    
    
            if ($val->orderDispatchId < 10) {
                $zero = '000';
            } elseif ($val->orderDispatchId < 100) {
                $zero = '00';
            } elseif ($val->orderDispatchId < 1000) {
                $zero = '0';
            } elseif ($val->orderDispatchId < 10000) {
                $zero = '';
            }
    
            $dispatchNo = 'DIS'. $zero.''.$val->orderDispatchId;
    
            foreach($trans_dispatch_item as $ku => $item) {
              //  dd($trans_orderdispatch);
                // Fetch the order quantity for the current product
              
                         
            
    

            // If the product ID already exists, add the current dispatch quantity to the existing one
            if($item->productrate == 0){

                $free = 'free';

                $orderqty = mst_orderitem::select('qty')
                ->where('orderId_fk', $item->orderId_fk)
                ->where('productId_fk', $item->productId_fk)
                ->where('pcsRate', 0)
                ->where('status', 1)
                ->first();
          
                // If orderqty is null, set it to 0
            $orderqtyValue = $orderqty ? $orderqty->qty : 0;

            // Calculate the pending quantity
            $pendingqty = $orderqtyValue - $item->qty;


                if(isset($freeproductQtyMap[$item->productId_fk])) {
                    $freeproductQtyMap[$item->productId_fk]['dispatchqty'] += $item->qty;
                    $freeproductQtyMap[$item->productId_fk]['pendingqty'] = $orderqtyValue - $freeproductQtyMap[$item->productId_fk]['dispatchqty'];
                } else {
                       // Otherwise, initialize the values
                    $freeproductQtyMap[$item->productId_fk] = [
                        'dispatchqty' => $item->qty,
                        'pendingqty' => $pendingqty
                    ];
                }

                
               $pendingqty = $freeproductQtyMap[$item->productId_fk]['pendingqty'];


              



            }else{

                $free = '';

                
               $orderqty = mst_orderitem::select('qty')
               ->where('orderId_fk', $item->orderId_fk)
               ->where('productId_fk', $item->productId_fk)
               ->where('pcsRate','!=', 0)
               ->where('status', 1)
               ->first();

                
                // If orderqty is null, set it to 0
            $orderqtyValue = $orderqty ? $orderqty->qty : 0;

            // Calculate the pending quantity
            $pendingqty = $orderqtyValue - $item->qty;

            
                if(isset($productQtyMap[$item->productId_fk])) {
                    $productQtyMap[$item->productId_fk]['dispatchqty'] += $item->qty;
                    $productQtyMap[$item->productId_fk]['pendingqty'] = $orderqtyValue - $productQtyMap[$item->productId_fk]['dispatchqty'];
                } else {
                       // Otherwise, initialize the values
                    $productQtyMap[$item->productId_fk] = [
                        'dispatchqty' => $item->qty,
                        'pendingqty' => $pendingqty
                    ];
                }

               $pendingqty = $productQtyMap[$item->productId_fk]['pendingqty'];


            }
            
                $data[] = [
                    'dispatchNo' =>  $dispatchNo,
                    'dispatchdate' => date('d-M-Y', $val->dispatchDate),
                    'dispatchqty' => $item->qty,
                    'productName' => $item->productName,
                    'serisname' => $item->serisname,
                    'cat_number' => $item->cat_number,
                    'orderqty' => $orderqty ? $orderqty->qty : 0,
                    'pendingqty' => $pendingqty,
                    'free' => $free
                ];
            }
    
    
    
            }
    
            //dd($data);
    
    
    
            $orderconsignee = mst_disConsignment::select('cusConsigId','consignmentName')->where('customerId_fk',$order->customerId_fk)->get();
            return view('dispatch.newdispatch',compact('data','trans_orderdispatch','order','primaryTarget','mtd', 'orderconsignee'));
        }else{
            return back()->with('error', 'Order Not Found');
        }

    }

    public function dispatchdetail($id){

        $order =  mst_orderlist::where('orderAuthKey',$id)->first();

        if($order){
            
            $year = date('Y');
            $month = date('M');

            $orderitem =  mst_orderitem::select('mst_orderitem.*', 'mst_productlist.productName','mst_productlist.dop_netprice as netrate','mst_productlist.subCategoryId_fk','mst_productlist.cat_number','mst_mastermenu.name as serisname')
            ->join('mst_productlist', 'mst_orderitem.productId_fk', '=', 'mst_productlist.productId')
            ->join('mst_mastermenu', 'mst_productlist.subCategoryId_fk', '=', 'mst_mastermenu.masterMenuId')
            ->where('mst_orderitem.orderId_fk', $order->orderId)
            ->get();

            foreach($orderitem as $key => $val){

                $dispatchedqty = trans_dispatch_item::where('itemOrderId_fk', $val->itemOrderId)
                                        ->where('productId_fk', $val->productId_fk)
                                        ->sum('qty');

                $pendingqty =  $val->qty -  $dispatchedqty;
                $val->pendingqty = $pendingqty;
                $val->dispatchedqty = $dispatchedqty;

            }

            $trans_orderdispatch = trans_orderdispatch::select('remarks')->where('orderId_fk',$order->orderId)->orderby('orderDispatchId','desc')->first();


           // dd($orderitem);
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

          //  dd($order);
      
            $orderconsignee = mst_disConsignment::select('cusConsigId','consignmentName')->where('customerId_fk',$order->customerId_fk)->get();
            return view('dispatch.dispatchdetail',compact('orderitem','trans_orderdispatch','order','primaryTarget','mtd', 'orderconsignee'));
        }else{
            return back()->with('error', 'Order Not Found');
        }


    }


    public function dispatchsubmit(Request $req){
       
       // dd($req);
        try {
            DB::beginTransaction();
            $dispatchdata = $req->dispatchdata;
            $currentDateTime = now();
            $dataEntrydate = strtotime($currentDateTime->toDateTimeString());
            $dataEntrydate = strtotime($currentDateTime->toDateTimeString());
            $dispatchtAuthKey = sha1($req->orderId . $currentDateTime->toDateTimeString());

            $trans_orderdispatch_data = [
                'orderId_fk' => $req->orderId,
                'dispatchDate' => $dataEntrydate,
                'dispatchtAuthKey' => $dispatchtAuthKey,
                'remarks' => $req->dispatch_remarks,
                'status' =>1
            ];

            $trans_orderdispatch = trans_orderdispatch::create($trans_orderdispatch_data);
            $orderDispatchId = $trans_orderdispatch->orderDispatchId;


            foreach($dispatchdata as $key => $data){

                //dd($data['itemOrderId']);

                if($data['dispatch_qty'] > 0){
                    $dispatch_data = [
                        'itemOrderId_fk' => $data['itemOrderId'],
                        'orderDispatchId_fk' =>  $orderDispatchId,
                        'orderId_fk' => $req->orderId,
                        'productId_fk' => $data['productId'],
                        'qty' => $data['dispatch_qty'],
                        'status' => 1,
                    ];
    
                    $trans_dispatch_item = trans_dispatch_item::create($dispatch_data);

                }
               
            }

            if($req->button == 'Complete'){
                mst_orderlist::where('orderId',$req->orderId)->update(['status' => 2]);
            }



            if($trans_orderdispatch){ 
                    $msg = 1;
            }else{
                    $msg = 0;
            }

            DB::commit();
            return $msg;
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage(),'line' => $e->getLine()]);
        }

        


   


    }




}