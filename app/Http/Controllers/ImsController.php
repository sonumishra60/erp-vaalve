<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http; // Add this line
use Carbon\Carbon;
use App\Models\mstproduct;
use App\Models\masterdata;
use App\Models\mastermenu;
use App\Models\mst_purchseList;
use App\Models\mst_itemPurchseList;
use App\Models\trans_itemStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\AttendanceDetailExport;
use Maatwebsite\Excel\Facades\Excel;

class ImsController extends BaseController
{

    public function imsformdata(Request $req)
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


                            if ($startDate && $endDate && $currentDate >= $startDate && $currentDate <= $endDate) {

                                if ($customertype == 'distributor' || $customertype == 'dealer') {
                                    $mrp = $pvalue->dop_netprice;
                                    $mrptype = 'netrate';
                                } else if ($customertype == 'retailer' || $customertype == 'ubs') {

                                    $mrp = $pvalue->mop_netprice;
                                    $mrptype = 'netrate';
                                } else {
                                    $mrp = $pvalue->mrp;
                                    $mrptype = 'mrp';
                                }
                            } else {
                                $mrp = moneyFormatIndia($pvalue->mrp);
                                $mrptype = 'mrp';
                            }

                            $itemqty = '';
                            $itemtotal = '';

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
                                                                        <li style="display:none;"><strong>MRP:</strong> <span
                                                                                class="lig-tx price">' . $mrp . '</span></li>
                                                                        <li style="display:none;" ><strong>Amount:</strong> <span
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

                                                                        <th class="w-50px rounded-start text-right d-none">
                                                                            MRP
                                                                        </th>

                                                                        

                                                                        <th class="w-50px rounded-start text-right d-none">
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
                                                                <td class="w-50px rounded-start text-right price d-none"> ' . $mrp . '</td>
                                                            
                                                                <td class="w-50px rounded-start text-right amount d-none">' . @$itemtotal . '</td>
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

    public function imsformdatasubmit(Request $req)
    {

        try {

            // dd($req);
            DB::beginTransaction();
            $currentDateTime = now();
            $dataEntrydate = strtotime($currentDateTime->toDateTimeString());
            $products = $req->products;
            $purchseAuthKey = sha1($req->vendor_name . $currentDateTime->toDateTimeString());
            $status = 1;

            $data = [
                'purchseDate' => strtotime($req->purchase_date),
                'vendorName' => $req->vendor_name,
                'purcheseType' => $req->purchase_return,
                'remarks' => $req->Remarks,
                'dataEntryDate' => $dataEntrydate,
                'purchseAuthKey' => $purchseAuthKey,
                'totalqty' => $req->totalquantity,
                'status' => $status
            ];

            $mst_purchseList = mst_purchseList::create($data);

            $purchaseId = $mst_purchseList->purchaseId;

            foreach ($products as $key => $val) {

                $itemPurchseAuthKey = sha1($purchaseId . $val['productId'] . $currentDateTime->toDateTimeString());

                $orderitem = [
                    'purchaseId_fk' => $purchaseId,
                    'ItemId_fk' => $val['productId'],
                    'qty' => $val['qty'],
                    'purchaseDate' => strtotime($req->purchase_date),
                    'dataEntryDate' => $dataEntrydate,
                    'itemPurchseAuthKey' => $itemPurchseAuthKey,
                    'status' => 1
                ];

                mst_itemPurchseList::create($orderitem);
            }

            if ($mst_purchseList) {
                $msg = 1;
            } else {
                $msg = 0;
            }

            DB::commit();
            return $msg;
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['resp' => 2, 'msg' => 'Data Not Inserted Successfully', 'error' => $e->getMessage()]);
        }
    }


    public function index()
    {
        return view('ims.imsinward');
    }


    public function addinward()
    {

        return view('ims.addinward');
    }

    public function inwardlistdata(Request $req)
    {

        $rowCount = $req->input('rowCount');
        $page = $req->input('page');

        $mst_purchseList = mst_purchseList::select('purchseDate', 'vendorName', 'purcheseType', 'purchseAuthKey', 'totalqty')
            ->where('mst_purchseList.status', '!=', 0)
            ->orderBy('mst_purchseList.purchaseId', 'desc')
            ->paginate($rowCount, ['*'], 'page', $page);

        $data = [];
        foreach ($mst_purchseList as $key => $order) {

            $purcheseType = getmastermenudatabyid($order->purcheseType);

            $entry = [
                'purchseDate' => date('d-M-y', $order->purchseDate),
                'vendorName' => $order->vendorName,
                'purcheseType' => $purcheseType->name,
                'vendorName' => $order->vendorName,
                'totalqty' => $order->totalqty,
            ];

            $data[] = $entry;
        }

        $response = [
            'data' => $data,
            'current_page' => $mst_purchseList->currentPage(),
            'last_page' => $mst_purchseList->lastPage()
        ];


        return response()->json($response);
    }

    public function imslist()
    {

        return view('ims.list');
    }

    public function imslistdata(Request $req)
    {

        //dd($req);

        $rowCount = $req->input('rowCount');
        $page = $req->input('page');
        $totalInward = '';
        $totalOutward = '';
        $todaystock = '';


        $mastermenu = mstproduct::where('status', 1)
            ->orderBy('productId', 'asc')
            ->paginate($rowCount, ['productId', 'cat_number', 'productColorId_fk', 'subCategoryId_fk', 'productCode', 'productName', 'categoryId_fk', 'brandId_fk', 'productImage', 'productAuthKey'], 'page', $page);

        $data = [];

        foreach ($mastermenu as $key => $val) {

            // dd($val->productColorId_fk);
            $category = getmastermenudatabyid($val->categoryId_fk);
            $brand = getmastermenudatabyid($val->brandId_fk);
            $series = getmastermenudatabyid($val->subCategoryId_fk);
            $color = getmastermenudatabyid($val->productColorId_fk);

            $trans_itemStock = trans_itemStock::select('opening_stock_date', 'opening_stock')->where('productId_fk', $val->productId)->first();

            if (!empty($trans_itemStock->opening_stock_date)) {

                $startOfDay = Carbon::createFromTimestamp($trans_itemStock->opening_stock_date)->startOfDay();

                $totalInwardsql = mst_itemPurchseList::selectRaw('SUM(qty) as total_qty')
                    ->where('purchaseDate', '>=', strtotime($startOfDay))
                    ->where('ItemId_fk', $val->productId)
                    ->first();


                $totalInward = $totalInwardsql->total_qty;
                $totalOutward = 0;
            }

            $opening_stock = $trans_itemStock ? ($trans_itemStock->opening_stock ? (float) $trans_itemStock->opening_stock : 0) : 0;
            $totalInward = (float) $totalInward;
            $totalOutward = (float) $totalOutward;

            $todaystock = $opening_stock + $totalInward - $totalOutward;


            $entry = [
                'productId' => $val->productId,
                'productCode' => $val->cat_number,
                'productName' => $val->productName,
                'series' => $series->name,
                'categoryId_fk' => $category->name,
                'productImage' => $val->productImage,
                'brandId_fk' => $brand->name,
                'productColorId_fk' => $color->name,
                'opening_stock_date' => $trans_itemStock ? ($trans_itemStock->opening_stock_date ? date('d-M-Y', $trans_itemStock->opening_stock_date) : '') : '',
                'opening_stock' => $trans_itemStock ? ($trans_itemStock->opening_stock ? moneyFormatIndia($trans_itemStock->opening_stock) : '') : '',
                'totalInward' => $totalInward ? moneyFormatIndia($totalInward) : '',
                'totalOutward' => $totalOutward ? moneyFormatIndia($totalOutward) : '',
                'todaystock' => $todaystock ?  moneyFormatIndia($todaystock) : '',
                'productAuthKey' => $val->productAuthKey,


            ];

            $data[] = $entry;
        }

        $response = [
            'data' => $data,
            'current_page' => $mastermenu->currentPage(),
            'last_page' => $mastermenu->lastPage()
        ];

        return response()->json(['data' => $response]);
    }


    public function openingdatasave(Request $req)
    {

        //dd($req);

        $productId = $req->productId;
        $newOpeningStockDate = strtotime($req->newOpeningStockDate);
        $newOpeningStock = $req->newOpeningStock;
        $currentDateTime = now();
        $dataEntrydate = strtotime($currentDateTime->toDateTimeString());
        $itemStockAuthKey = sha1($req->productId . $currentDateTime->toDateTimeString());

        $checkstockcount = trans_itemStock::where('productId_fk', $productId)->count();

        if ($checkstockcount == 0) {

            $stockdata = [
                'productId_fk' => $productId,
                'userId_fk' => session('userinfo')->userId,
                'opening_stock_date' => $newOpeningStockDate,
                'opening_stock' => $newOpeningStock,
                'itemStockAuthKey' => $itemStockAuthKey,
                'entryDate' => $dataEntrydate,
                'status' => 1
            ];

            $datainsert = trans_itemStock::insert($stockdata);
        } else {

            $datainsert = trans_itemStock::where('productId_fk', $productId)
                ->update(['opening_stock_date' => $newOpeningStockDate, 'opening_stock' => $newOpeningStock,]);
        }

        if ($datainsert) {

            $msg = 1;
        } else {
            $msg = 0;
        }

        return $msg;
    }


    public function imsproductsearch(Request $req)
    {

        $rowCount = $req->input('rowCount');
        $page = $req->input('page');
        $brand = $req->input('brand');
        $cat_code = $req->input('cat_code');
        $category = $req->input('category');
        $series = $req->input('series');
        $product_name = $req->input('product_name');
        $opening_stock_date = strtotime($req->input('opening_stock_date'));
        $color = $req->input('color');
        $totalInward  = '';
        $totalOutward = '';
        $todaystock = '';




        if (!empty($category)) {
            $masterdata_category = $this->masterdata_category[0]->masterDataId;
            $query_cat =  mastermenu::where('name', 'like', '%' . $category . '%')
                ->where('masterDataId_fk', $masterdata_category)
                ->whereNull('parentId')
                ->pluck('masterMenuId')
                ->implode(',');
        }

        if (!empty($brand)) {
            $masterdata_brand = $this->masterdata_brand[0]->masterDataId;
            $query_brand =  mastermenu::where('name', 'like', '%' . $brand . '%')
                ->where('masterDataId_fk', $masterdata_brand)
                ->pluck('masterMenuId')
                ->implode(',');
        }


        if (!empty($series)) {
            $masterdata_category = $this->masterdata_category[0]->masterDataId;
            // $query_seriec =  mastermenu::where('name','like', '%' . $series . '%')
            //             ->whereNotNull('parentId')
            //             ->where('masterDataId_fk',$masterdata_category)
            //             ->first('masterMenuId');

            $query_seriec = mastermenu::where('name', 'like', '%' . $series . '%')
                ->whereNotNull('parentId')
                ->where('masterDataId_fk', $masterdata_category)
                ->pluck('masterMenuId')
                ->implode(',');


            // dd($query_seriec);
        }


        if (!empty($color)) {
            $masterdata_color = $this->masterdata_color[0]->masterDataId;
            $query_color =  mastermenu::where('name', 'like', '%' . $color . '%')
                ->where('masterDataId_fk', $masterdata_color)
                ->pluck('masterMenuId')
                ->implode(',');
        }


        $query = mstproduct::select('mst_productlist.productId', 'mst_productlist.cat_number', 'mst_productlist.productColorId_fk',  'mst_productlist.subCategoryId_fk', 'mst_productlist.productCode', 'mst_productlist.productName', 'mst_productlist.categoryId_fk', 'mst_productlist.brandId_fk', 'mst_productlist.productImage', 'mst_productlist.productAuthKey', 'trans_itemStock.opening_stock_date', 'trans_itemStock.opening_stock')
            ->leftJoin('trans_itemStock', 'trans_itemStock.productId_fk', '=', 'mst_productlist.productId')
            ->orderBy('productId', 'asc');


        if (!empty($cat_code)) {
            $query->where('mst_productlist.cat_number', 'like', '%' . $cat_code . '%');
        }

        if (!empty($category)) {
            $query_catIdArray = explode(',', $query_cat);
            $query->whereIn('mst_productlist.categoryId_fk', $query_catIdArray);
        }

        if (!empty($series)) {
            $query_seriesIdArray = explode(',', $query_seriec);
            //$query_seriesId = $query_seriec ? $query_seriec->masterMenuId : 0;
            $query->whereIn('mst_productlist.subCategoryId_fk', $query_seriesIdArray);
        }

        if (!empty($brand)) {
            $query_brandIdArray = explode(',', $query_cat);
            // $brandId = $query_brand ? $query_brand->masterMenuId : 0;
            $query->whereIn('mst_productlist.brandId_fk', $query_brandIdArray);
        }

        if (!empty($color)) {

            $query_colorIdArray = explode(',', $query_color);
            //  $colorId = $query_color ? $query_color->masterMenuId : 0;
            $query->whereIn('mst_productlist.productColorId_fk', $query_colorIdArray);
        }

        if (!empty($product_name)) {
            $query->where('mst_productlist.productName', 'like', '%' . $product_name . '%');
        }


        if (!empty($opening_stock_date)) {

            $startOfDay = Carbon::createFromTimestamp($opening_stock_date)->startOfDay();
            $endOfDay = Carbon::createFromTimestamp($opening_stock_date)->endOfDay();

            //dd('startOfDay => '.$startOfDay .' endOfDay => '.$endOfDay);

            $query->whereBetween('trans_itemStock.opening_stock_date', [strtotime($startOfDay), strtotime($endOfDay)]);
        }

        $mastermenu = $query->paginate($rowCount, ['*'], 'page', $page);


        $data = [];

        foreach ($mastermenu as $key => $val) {

            // dd($val->productColorId_fk);
            $category = getmastermenudatabyid($val->categoryId_fk);
            $brand = getmastermenudatabyid($val->brandId_fk);
            $series = getmastermenudatabyid($val->subCategoryId_fk);
            $color = getmastermenudatabyid($val->productColorId_fk);

            if (!empty($opening_stock_date)) {

                $startOfDay = Carbon::createFromTimestamp($opening_stock_date)->startOfDay();

                $totalInwardsql = mst_itemPurchseList::selectRaw('SUM(qty) as total_qty')
                    ->where('purchaseDate', '>=', strtotime($startOfDay))
                    ->where('ItemId_fk', $val->productId)
                    ->first();


                //$
                $totalInward = $totalInwardsql->total_qty;
                $totalOutward = 0;
                $todaystock = $totalInward - $totalOutward;
            }


            $opening_stock = $val->opening_stock_date ? ($val->opening_stock_date ? (float) $val->opening_stock_date : 0) : 0;
            $totalInward = (float) $totalInward;
            $totalOutward = (float) $totalOutward;

            $todaystock = $opening_stock + $totalInward - $totalOutward;


            $entry = [
                'productId' => $val->productId,
                'productCode' => $val->cat_number,
                'productName' => $val->productName,
                'series' => $series->name ?? '',
                'categoryId_fk' => $category->name,
                'productImage' => $val->productImage,
                'brandId_fk' => $brand->name,
                'productColorId_fk' => $color->name,
                'opening_stock_date' => $val->opening_stock_date ? ($val->opening_stock_date ? date('d-M-Y', $val->opening_stock_date) : '') : '',
                'opening_stock' => $val->opening_stock_date ? ($val->opening_stock ? moneyFormatIndia($val->opening_stock) : '') : '',
                'totalInward' => $totalInward ? moneyFormatIndia($totalInward) : '',
                'totalOutward' => $totalOutward ? moneyFormatIndia($totalOutward) : '',
                'todaystock' => $todaystock ?  moneyFormatIndia($todaystock) : '',
                'productAuthKey' => $val->productAuthKey,
            ];

            $data[] = $entry;
        }

        $response = [
            'data' => $data,
            'current_page' => $mastermenu->currentPage(),
            'last_page' => $mastermenu->lastPage()
        ];

        return response()->json(['data' => $response]);
    }

    public function gettotalinward(Request $req){

        //dd($req);

        $productId = $req->productId;
        $openingstockdate = strtotime($req->openingstockdate);
        $totalqty = 0;

        $startOfDay = Carbon::createFromTimestamp($openingstockdate)->startOfDay();

        $totalInwardsql = mst_itemPurchseList::select('mst_itemPurchseList.ItemId_fk','mst_itemPurchseList.qty','mst_itemPurchseList.purchaseDate','mst_productlist.productName')
                        ->leftJoin('mst_productlist', 'mst_itemPurchseList.ItemId_fk', '=', 'mst_productlist.productId')
                        ->where('purchaseDate', '>=', strtotime($startOfDay))
                        ->where('ItemId_fk', $productId)
                        ->get();

                        $html = '<table class="table border table-striped">
                        <thead>
                            <tr>
                                <th> <b>Product Name</b></th>
                                <th> ' . $totalInwardsql[0]["productName"] . ' </th>
                            </tr>
                            <tr>
                                <th>Opening Stock</th>
                                <th>Qty</th>
                            </tr>
                        </thead>
                        <tbody>';
            
            $totalqty = 0; // Initialize total quantity before loop
            
            foreach ($totalInwardsql as $val) {
                $totalqty += $val['qty'];
                $html .= '
                            <tr>
                                <td>' . date('d-M-Y', $val['purchaseDate']) . '</td>
                                <td>' . $val['qty'] . '</td>
                            </tr>';
            }
            
            // Append the total row after looping
            $html .= '
                            <tr>
                                <td>Total</td>
                                <td>' . $totalqty . '</td>
                            </tr>
                        </tbody>
                    </table>';
            
            return $html;
            





    }


    public function datauploadform(){





    }





}
