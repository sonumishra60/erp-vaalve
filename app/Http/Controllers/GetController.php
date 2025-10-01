<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\masterdata;
use App\Models\mastermenu;
use App\Models\mstlocation;
use App\Models\mstcustomerlist;
use App\Models\userlist;
use App\Models\trans_cusbankinfo;
use App\Models\trans_customersalesperson;
use App\Models\mst_disConsignment;
use App\Models\trans_cusdocument;
use App\Models\mstproduct;
use App\Models\trans_itemStock;
use App\Models\trans_salesBankInfo;
use Illuminate\Support\Facades\Hash;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use DB;


class GetController extends BaseController
{

    public function getmasterroles()
    {

        $masterdata_role =  MasterData::where('status', 1)
            ->select('masterDataId', 'fieldName')
            ->whereIn('groupName', [2, 3])
            ->orderBy('fieldName', 'asc')
            ->get();

        $resp = $masterdata_role->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $masterdata_role]);
    }


    public function getroles($id)
    {

        $mastermenu_role =  mastermenu::where('status', 1)
            ->select('masterMenuId', 'name')
            ->where('masterDataId_fk', $id)
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();

        $resp = $mastermenu_role->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $mastermenu_role]);
    }

    public function getlocation()
    {

        $masterdata_location =  mstlocation::where('status', 1)
            ->select('cityId', 'cityName')
            ->whereNull('parentId')
            ->orderBy('cityName', 'asc')
            ->get();

        $resp = $masterdata_location->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $masterdata_location]);
    }

    public function getcity($id)
    {

        $mstlocation_city =  mstlocation::where('status', 1)
            ->select('cityId', 'cityName')
            ->where('parentId', $id)
            ->orderBy('cityName', 'asc')
            ->get();

        $resp = $mstlocation_city->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $mstlocation_city]);
    }

    public function getcustomertype()
    {

        $masterdata_customertype = $this->masterdata_customertype[0]->masterDataId;

        $mastermenu_customertype =  mastermenu::where('masterDataId_fk', $masterdata_customertype)
            ->where('status', 1)
            ->select(DB::raw('MIN(masterMenuId) as masterMenuId'), 'name')
            ->groupBy('name')
            ->orderBy('name', 'asc')
            ->get();

        $resp = $mastermenu_customertype->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $mastermenu_customertype]);
    }

    public function getdealertype()
    {

        $masterdata_dealertype = $this->masterdata_dealertype[0]->masterDataId;

        $mastermenu_dealertype =  mastermenu::where('masterDataId_fk', $masterdata_dealertype)
            ->select('masterMenuId', 'name')
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();

        $resp = $mastermenu_dealertype->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $mastermenu_dealertype]);
    }

    public function getgallerytype()
    {

        $masterdata_gallerytype = $this->masterdata_gallerytype[0]->masterDataId;

        $mastermenu_gallerytype = mastermenu::where('masterDataId_fk', $masterdata_gallerytype)
            ->where('status', 1)
            ->select('name', DB::raw('MAX(masterMenuId) as masterMenuId'))
            ->groupBy('name')
            ->orderBy('name', 'asc')
            ->get();


        $resp = $mastermenu_gallerytype->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $mastermenu_gallerytype]);
    }


    public function getbillingtype()
    {

        $masterdata_billingtype = $this->masterdata_billingtype[0]->masterDataId;

        $mastermenu_billingtype =  mastermenu::where('masterDataId_fk', $masterdata_billingtype)
            ->where('status', 1)
            ->select('masterMenuId', 'name')
            ->orderBy('name', 'asc')
            ->get();

        $resp = $mastermenu_billingtype->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $mastermenu_billingtype]);
    }


    public function getdistributortype()
    {

        $masterdata_dristributortype = $this->masterdata_distributortype[0]->masterDataId;

        $mastermenu_dristributortype =  mastermenu::where('masterDataId_fk', $masterdata_dristributortype)
            ->where('status', 1)
            ->select('masterMenuId', 'name')
            ->orderBy('name', 'asc')
            ->get();

        $resp = $mastermenu_dristributortype->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $mastermenu_dristributortype]);
    }

    public function getbusinesstype()
    {

        $masterdata_banktype = $this->masterdata_businesstype[0]->masterDataId;

        $mastermenu_banktype =  mastermenu::where('masterDataId_fk', $masterdata_banktype)
            ->where('status', 1)
            ->select('masterMenuId', 'name')
            ->orderBy('name', 'asc')
            ->get();

        $resp = $mastermenu_banktype->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $mastermenu_banktype]);
    }


    public function getbanktype()
    {

        $masterdata_banktype = $this->masterdata_banktype[0]->masterDataId;

        $masterdata_banktype =  mastermenu::where('masterDataId_fk', $masterdata_banktype)
            ->where('status', 1)
            ->select(DB::raw('MIN(masterMenuId) as masterMenuId'), 'name')
            ->groupBy('name')
            ->orderBy('name', 'asc')
            ->get();

        $resp = $masterdata_banktype->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $masterdata_banktype]);
    }

    public function getallusers()
    {

        $masterdata_salestype = $this->masterdata_salesuser[0]->masterDataId;

        $masterdata_saled_id = mastermenu::where('masterDataId_fk', $masterdata_salestype)
            ->where('status', 1)
            ->orderBy('masterMenuId', 'asc')
            ->pluck('masterMenuId');


        //$salesuser = userlist::whereIn('roleId_fk', $masterdata_saled_id)->get();
        $salesuser = userlist::where('staus', 184)->get();

        $resp = $salesuser->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $salesuser]);
    }


    public function getmainheads()
    {
        $masterdata_mainhead = $this->masterdata_mainheads[0]->masterDataId;

        $masterdata_mainhead =  mastermenu::where('masterDataId_fk', $masterdata_mainhead)
            ->where('status', 1)
            ->select('masterMenuId', 'name')
            ->orderBy('name', 'asc')
            ->get();

        $resp = $masterdata_mainhead->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $masterdata_mainhead]);
    }

    public function getallcluster()
    {
        $masterdata_cluster = $this->masterdata_cluster[0]->masterDataId;

        $masterdata_cluster =  mastermenu::where('masterDataId_fk', $masterdata_cluster)
            ->where('status', 1)
            ->select('masterMenuId', 'name')
            ->orderBy('name', 'asc')
            ->get();

        $resp = $masterdata_cluster->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $masterdata_cluster]);
    }


    public function gettransproter()
    {

        $masterdata_transproter = $this->masterdata_transproter[0]->masterDataId;

        $masterdata_transproter =  mastermenu::where('masterDataId_fk', $masterdata_transproter)
            ->where('status', 1)
            ->select('masterMenuId', 'name')
            ->orderBy('name', 'asc')
            ->get();

        $resp = $masterdata_transproter->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $masterdata_transproter]);
    }


    public function getallparentcategory()
    {
        $masterdata_category = $this->masterdata_category[0]->masterDataId;

        $masterdata_category =  mastermenu::where('masterDataId_fk', $masterdata_category)
            ->where('status', 1)
            ->select('masterMenuId', 'name')
            ->whereNull('parentId')
            ->orderBy('name', 'asc')
            ->get();

        $resp = $masterdata_category->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $masterdata_category]);
    }

    public function getallchildcategory($id)
    {

        $masterdata_category =  mastermenu::where('parentId', $id)
            ->where('status', 1)
            ->select('masterMenuId', 'name')
            ->orderBy('name', 'asc')
            ->get();

        $resp = $masterdata_category->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $masterdata_category]);
    }

    public function getallbrand()
    {
        $masterdata_brand = $this->masterdata_brand[0]->masterDataId;

        $masterdata_brand =  mastermenu::where('masterDataId_fk', $masterdata_brand)
            ->where('status', 1)
            ->whereNull('parentId')
            ->select('masterMenuId', 'name')
            ->orderBy('name', 'asc')
            ->get();

        $resp = $masterdata_brand->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $masterdata_brand]);
    }


    public function getcolor()
    {
        $masterdata_color = $this->masterdata_color[0]->masterDataId;

        $masterdata_color =  mastermenu::where('masterDataId_fk', $masterdata_color)
            ->where('status', 1)
            ->whereNull('parentId')
            ->select('masterMenuId', 'name')
            ->orderBy('name', 'asc')
            ->get();

        $resp = $masterdata_color->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $masterdata_color]);
    }

    public function getsalesuser()
    {

        $salesdata =  UserList::where('role_type', 3)
            ->where('staus', 184)
            ->select('userId', 'name')
            ->orderBy('name', 'asc')
            ->get();

        $resp = $salesdata->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $salesdata]);
    }

    public function getdistributor()
    {


        if (session('userinfo')->role_type == 2) {

            $customerdata = mstcustomerlist::selectRaw('MIN(customerId) as customerId, CustomerName, MIN(ownerName) as ownerName')
                ->where('status', 184)
                ->groupBy('CustomerName')
                ->orderBy('CustomerName', 'asc')
                ->get();


            // $customerdata = DB::table('mst_customerlist')
            // ->select('customerId', 'CustomerName', 'ownerName')
            // ->where('status','=',184)
            // ->groupBy('CustomerName')
            // ->get();

        } else {

            // $customerdata =  mstcustomerlist::select('customerId','CustomerName','ownerName')
            $customerdata = mstcustomerlist::selectRaw('MIN(mst_customerlist.customerId) as customerId, mst_customerlist.CustomerName, MIN(mst_customerlist.ownerName) as ownerName')
                ->join('trans_customersalesperson', 'trans_customersalesperson.customerId_fk', '=', 'mst_customerlist.customerId')
                ->where('trans_customersalesperson.userId_fk', session('userinfo')->userId)
                ->where('mst_customerlist.status', 184)
                ->groupBy('mst_customerlist.CustomerName')
                ->orderBy('mst_customerlist.CustomerName', 'asc')
                ->get();
        }

        $resp = $customerdata->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $customerdata]);
    }

    public function ordertype()
    {
        $masterdata_ordertype = $this->masterdata_ordertype[0]->masterDataId;

        $masterdata_ordertype =  mastermenu::where('masterDataId_fk', $masterdata_ordertype)
            ->select('masterMenuId', 'name')
            ->orderBy('name', 'asc')
            ->get();

        $resp = $masterdata_ordertype->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $masterdata_ordertype]);
    }

    public function payment_mode()
    {

        $masterdata_paymentmode = $this->masterdata_paymentmode[0]->masterDataId;

        $masterdata_paymentmode =  mastermenu::where('masterDataId_fk', $masterdata_paymentmode)
            ->where('status', 1)
            ->select('masterMenuId', 'name')
            ->orderBy('name', 'asc')
            ->get();

        $resp = $masterdata_paymentmode->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $masterdata_paymentmode]);
    }


    public function productimport()
    {
        $path = public_path('Item Master July 2024.xlsx');
        $rows = SimpleExcelReader::create($path)->getRows();

        foreach ($rows as $key => $row) {

            $currentDateTime = now();
            $dataEntrydate = strtotime($currentDateTime->toDateTimeString());

            // Process Brand
            $brand = $row['Brand'];
            $mstbrand_id = $this->masterdata_brand[0]->masterDataId;

            $masterdata_brand = mastermenu::where('masterDataId_fk', $mstbrand_id)
                ->where('status', 1)
                ->where('name', $brand)
                ->first();

            if ($masterdata_brand) {
                $branddata = $masterdata_brand->masterMenuId;
            } else {
                $accessAuthKey = sha1($brand . '' . $currentDateTime->toDateTimeString());
                $data = [
                    'name' => $brand,
                    'masterDataId_fk' => $mstbrand_id,
                    'dataEntrydate' => $dataEntrydate,
                    'accessAuthKey' => $accessAuthKey,
                    'status' => 1,
                ];
                $mastermenu = mastermenu::create($data);
                $branddata = $mastermenu->masterMenuId;
            }

            // Process Parent Category
            $pcategory = $row['Product Category'];
            $masterdata_category = $this->masterdata_category[0]->masterDataId;

            $masterdata_pcate = mastermenu::where('masterDataId_fk', $masterdata_category)
                ->where('status', 1)
                ->whereNull('parentId')
                ->where('name', $pcategory)
                ->first();

            if ($masterdata_pcate) {
                $pcategorydata = $masterdata_pcate->masterMenuId;
            } else {
                $accessAuthKey = sha1($pcategory . '' . $currentDateTime->toDateTimeString());
                $data = [
                    'name' => $pcategory,
                    'masterDataId_fk' => $masterdata_category,
                    'dataEntrydate' => $dataEntrydate,
                    'accessAuthKey' => $accessAuthKey,
                    'status' => 1,
                ];
                $mastermenu = mastermenu::create($data);
                $pcategorydata = $mastermenu->masterMenuId;
            }

            // Process Series (Child Category)
            $SERIES = $row['SERIES'];

            $masterdata_child_cate = mastermenu::where('masterDataId_fk', $masterdata_category)
                ->where('status', 1)
                ->where('parentId', $pcategorydata)
                ->where('name', $SERIES)
                ->first();

            if ($masterdata_child_cate) {
                $child_categorydata = $masterdata_child_cate->masterMenuId;
            } else {
                $accessAuthKey = sha1($SERIES . '' . $currentDateTime->toDateTimeString());
                $data = [
                    'parentId' => $pcategorydata,
                    'name' => $SERIES,
                    'masterDataId_fk' => $masterdata_category,
                    'dataEntrydate' => $dataEntrydate,
                    'accessAuthKey' => $accessAuthKey,
                    'status' => 1,
                ];
                $mastermenu = mastermenu::create($data);
                $child_categorydata = $mastermenu->masterMenuId;
            }

            // Process Color
            $Colour = $row['Colour'];
            $masterdata_color = $this->masterdata_color[0]->masterDataId;

            $masterdata_color_data = mastermenu::where('masterDataId_fk', $masterdata_color)
                ->where('status', 1)
                ->where('name', $Colour)
                ->first();

            if ($masterdata_color_data) {
                $colordata = $masterdata_color_data->masterMenuId;
            } else {
                $accessAuthKey = sha1($Colour . '' . $currentDateTime->toDateTimeString());
                $data = [
                    'name' => $Colour,
                    'masterDataId_fk' => $masterdata_color,
                    'dataEntrydate' => $dataEntrydate,
                    'accessAuthKey' => $accessAuthKey,
                    'status' => 1,
                ];
                $mastermenu = mastermenu::create($data);
                $colordata = $mastermenu->masterMenuId;
            }

            // Insert Product
            $productAuthKey = sha1($row['Product Name'] . '-' . $key . '-' . $currentDateTime->toDateTimeString());

            $data = [
                'categoryId_fk' => $pcategorydata,
                'brandId_fk' => $branddata,
                'subCategoryId_fk' => $child_categorydata,
                'productName' => $row['Product Name'],
                'cat_number' => $row['CAT Code'],
                'mrp' => $row['MRP'],
                'piece' => $row['Piece'],
                'boxPack' => $row['Box Packing'],
                'boxMRP' => $row['Box MRP'],
                'productColorId_fk' => $colordata,
                'dataEntryDate' => $dataEntrydate,
                'productAuthKey' => $productAuthKey,
                'status' => 1,
            ];

            $mstproduct = mstproduct::create($data);
        }

        //if($key == 66){

        return 'done';
        // }
    }

    public function customerimport()
    {


        //dd('hello');
        $path = public_path('Customer Master 28 August 2024.xlsx');
        $rows = SimpleExcelReader::create($path)->getRows();
        DB::beginTransaction();

        // dd(count($rows));

        foreach ($rows as $key => $row) {

            // echo 'key => '.$key.'<br>';
            // echo'<pre>'; 
            // print_r($row);
            // return false;

            try {

                $currentDateTime = now();
                $dataEntrydate = strtotime($currentDateTime->toDateTimeString());
                $customerAuthKey = sha1($row['Customer Name'] . $key . '' . $currentDateTime->toDateTimeString());
                $assignSelesAuthKey = sha1($row['Sales Incharge'] . '' . $currentDateTime->toDateTimeString());
                $bankAuthKeya = sha1($row['Bank Name'] . '' . $currentDateTime->toDateTimeString());
                $consignmentAuthKey = sha1($row['consignee name'] . '' . $currentDateTime->toDateTimeString());
                $documentAuthKey = sha1($row['aadhar card'] . '' . $currentDateTime->toDateTimeString());
                $pandocumentAuthKey = sha1($row['pan card'] . '' . $currentDateTime->toDateTimeString());
                $dealerType = '';
                $galleryType = '';
                $customerType = '';
                $customer_code = $row['Customer Code'];
                // dd($customer_code);
                $distributorstatus = isset($row['Status']) && $row['Status'] !== '' ? $row['Status'] : 'NA';
                $customer_name_ii = $row['Customer Name'];
                $customer_type =  isset($row['Customer Type']) && $row['Customer Type'] !== '' ? $row['Customer Type'] : 'NA';
                $consignee_name = $row['consignee name'];
                $dealer_type = isset($row['Dealer Type']) && $row['Dealer Type'] !== '' ? $row['Dealer Type'] : 'NA';
                $gallery_type = isset($row['Gallery Type']) && $row['Gallery Type'] !== '' ? $row['Gallery Type'] : 'NA';
                $address = $row['Address'];
                $city = $row['City'];
                $pincode = $row['Pincode'];
                $state = $row['State'];
                $email_id = $row['Email ID'];
                $mobile_no = $row['Mobile No.'];
                $mainheads = isset($row['Main Heads']) && $row['Main Heads'] !== '' ? $row['Main Heads'] : 'NA';
                $cluster_type  = isset($row['Cluster']) && $row['Cluster'] !== '' ? $row['Cluster'] : 'NA';
                $EmpCode = $row['Emp Code'];
                $sales_incharge  = $row['Sales Incharge'];
                $sales_email_id = $row['Sales Team Email ID'];
                $owner_name = $row['Owner Name'];
                $transport_name = $transporter_name =  isset($row['Transporter Name']) && $row['Transporter Name'] !== '' ? $row['Transporter Name'] : 'NA';
                // dd($transport_name);
                $bank_name  = $row['Bank Name'];
                $blank_cheque_number = $row['Blank Cheque No.'];
                $security_chq = $row['SECURITY CHQ'];
                $ltd_llp = $row['LTD / LLP'];
                $account_no = $row['Account No.'];
                $ifsc_code = $row['IFSC Code'];
                $security_amount = isset($row['Security Amount']) && trim($row['Security Amount']) !== '' ? $row['Security Amount'] : 0;
                $security_date = $row['Security Date'];
                $birth_date = $row['Birth Date'];
                $annivarsary_date = $row['Annivarsary Date'];
                $credit_limit = $row['Credit Limit'];
                $credit_period = $row['Credit Period'];
                $consignee_gstin = $row[' CONSIGNEE GSTIN  '];
                $aadhar_card = $row['aadhar card'];
                $pan_card = $row['pan card'];
                $remarks = $row['Remarks'];
                $first_year = $row['1st year'];
                $second_year = $row['2nd year'];
                $third_year = $row['3rd year'];
                $ex_fc_discount =  isset($row['EX FC DISCOUNT']) && trim($row['EX FC DISCOUNT']) !== '' ? multiplebyhundred($row['EX FC DISCOUNT']) : 0;
                $row['EX FC DISCOUNT'];
                $dealer_scheme_discount =  isset($row['Dealer Scheme Discount']) && trim($row['Dealer Scheme Discount']) !== '' ? multiplebyhundred($row['Dealer Scheme Discount']) : 0;
                $distributor_scheme_discount =   isset($row['Distributor Scheme Discount']) && trim($row['Distributor Scheme Discount']) !== '' ? multiplebyhundred($row['Distributor Scheme Discount']) : 0;
                //dd($distributor_scheme_discount);
                $distributor_discount = isset($row['Distributor  Discount']) && trim($row['Distributor  Discount']) !== '' ? multiplebyhundred($row['Distributor  Discount']) : 0;
                $retailer_ubs_scheme_discount = isset($row['retailers/ubs Scheme Discount']) && trim($row['retailers/ubs Scheme Discount']) !== '' ? multiplebyhundred($row['retailers/ubs Scheme Discount']) : 0;
                $distributor_dis = isset($row['DISTRIBUTOR']) && trim($row['DISTRIBUTOR']) !== '' ? multiplebyhundred($row['DISTRIBUTOR']) : 0;
                $dealer_Line_Discount = isset($row['Dealer Line Discount']) && trim($row['Dealer Line Discount']) !== '' ? multiplebyhundred($row['Dealer Line Discount']) : 0;
                $retailers_ubs_ss_scheme_Discount = isset($row['retailers/ubs ss Scheme Discount']) && trim($row['retailers/ubs ss Scheme Discount']) !== '' ? multiplebyhundred($row['retailers/ubs ss Scheme Discount']) : 0;
                $display_discount = isset($row['display discount']) && trim($row['display discount']) !== '' ? multiplebyhundred($row['display discount']) : 0;
                $assign_user = '';

                $totalDiscount = 1;
                $totalDiscount *= (1 - $ex_fc_discount / 100);
                $totalDiscount *= (1 - $dealer_scheme_discount / 100);
                $totalDiscount *= (1 - $distributor_scheme_discount / 100);
                $totalDiscount *= (1 - $distributor_discount / 100);
                $totalDiscount *= (1 - $retailer_ubs_scheme_discount / 100);
                $faucet_finaldiscount = (1 - $totalDiscount) * 100;

                $totalDiscountsin = 1;
                $totalDiscountsin *= (1 - $ex_fc_discount / 100);
                $totalDiscountsin *= (1 - $distributor_dis / 100);
                $totalDiscountsin *= (1 - $dealer_Line_Discount / 100);
                $sanitary_finaldiscount = (1 - $totalDiscountsin) * 100;



                // $('#final_faucet_discount').val(totalDiscount.toFixed(2));   






                $distributor_statusq = mastermenu::select('masterMenuId')->where('masterDataId_fk', 12)->where('name', $distributorstatus)->first();
                if ($distributor_statusq) {
                    $distributor_status = $distributor_statusq->masterMenuId;
                } else {

                    $statusAuthKey = sha1($distributor_status . '' . $currentDateTime->toDateTimeString());
                    $data = [
                        //'parentId' => $parentId,
                        'name' => $distributor_status,
                        'masterDataId_fk' => 12,
                        //'bannerImages'=>$bannerImages,
                        'dataEntrydate' => $dataEntrydate,
                        'accessAuthKey' => $statusAuthKey,
                        //'accessUrl'=>$accessUrl,
                        'status' => 1,
                    ];

                    $mastermenu = mastermenu::create($data);
                    $distributor_status = $mastermenu->masterMenuId;
                }



                $customer_typeq = mastermenu::select('masterMenuId')->where('masterDataId_fk', 9)->where('name', $customer_type)->where('status', 1)->first();
                if ($customer_typeq) {
                    $customer_type = $customer_typeq->masterMenuId;
                } else {

                    $customerAuthKey = sha1($customer_type . '' . $currentDateTime->toDateTimeString());
                    $data = [
                        //'parentId' => $parentId,
                        'name' => $customer_type,
                        'masterDataId_fk' => 9,
                        //'bannerImages'=>$bannerImages,
                        'dataEntrydate' => $dataEntrydate,
                        'accessAuthKey' => $customerAuthKey,
                        //'accessUrl'=>$accessUrl,
                        'status' => 1,
                    ];

                    $mastermenu = mastermenu::create($data);
                    $customer_type = $mastermenu->masterMenuId;
                }

                $dealerTypeq = mastermenu::select('masterMenuId')->where('masterDataId_fk', 4)->where('name', $dealer_type)->first();
                if ($dealerTypeq) {
                    $dealerType = $dealerTypeq->masterMenuId;
                } else {
                    $dealerAuthKey = sha1($dealer_type . '' . $currentDateTime->toDateTimeString());
                    $data = [
                        //'parentId' => $parentId,
                        'name' => $dealer_type,
                        'masterDataId_fk' => 4,
                        //'bannerImages'=>$bannerImages,
                        'dataEntrydate' => $dataEntrydate,
                        'accessAuthKey' => $dealerAuthKey,
                        //'accessUrl'=>$accessUrl,
                        'status' => 1,
                    ];

                    $mastermenu = mastermenu::create($data);
                    $dealerType = $mastermenu->masterMenuId;
                }

                $gallery_typeq = mastermenu::select('masterMenuId')->where('masterDataId_fk', 8)->where('name', $gallery_type)->first();
                if ($gallery_typeq) {
                    $gallery_type = $gallery_typeq->masterMenuId;
                } else {
                    $galleryAuthKey = sha1($customer_type . '' . $currentDateTime->toDateTimeString());
                    $data = [
                        //'parentId' => $parentId,
                        'name' => $dealer_type,
                        'masterDataId_fk' => 8,
                        //'bannerImages'=>$bannerImages,
                        'dataEntrydate' => $dataEntrydate,
                        'accessAuthKey' => $galleryAuthKey,
                        //'accessUrl'=>$accessUrl,
                        'status' => 1,
                    ];

                    $mastermenu = mastermenu::create($data);
                    $gallery_type = $mastermenu->masterMenuId;
                }

                //dd($transport_name);
                $transport_nameq = mastermenu::select('masterMenuId')->where('masterDataId_fk', 14)->where('name', $transport_name)->first();
                if ($transport_nameq) {
                    $transport_name = $transport_nameq->masterMenuId;
                } else {
                    $transportAuthKey = sha1($transport_name . '' . $currentDateTime->toDateTimeString());
                    $data = [
                        //'parentId' => $parentId,
                        'name' => $transport_name,
                        'masterDataId_fk' => 14,
                        //'bannerImages'=>$bannerImages,
                        'dataEntrydate' => $dataEntrydate,
                        'accessAuthKey' => $transportAuthKey,
                        //'accessUrl'=>$accessUrl,
                        'status' => 1,
                    ];
                    //dd($data);

                    $mastermenu = mastermenu::create($data);
                    $transport_name = $mastermenu->masterMenuId;
                }

                $city_mstlocation = mstlocation::select('cityId')->where('cityName', $city)->first();
                if ($city_mstlocation) {
                    $city = $city_mstlocation->cityId;
                } else {
                    $city = 0;
                }

                $state_mstlocation = mstlocation::select('cityId')->where('cityName', $state)->first();
                if ($state_mstlocation) {
                    $state = $state_mstlocation->cityId;
                } else {
                    $state = 0;
                }

                $clusterq = mastermenu::select('masterMenuId')->where('masterDataId_fk', 6)->where('name', $cluster_type)->first();
                if ($clusterq) {
                    $cluster  = $clusterq->masterMenuId;
                } else {
                    $clusterAuthKey = sha1($cluster_type . '' . $currentDateTime->toDateTimeString());
                    $data = [
                        //'parentId' => $parentId,
                        'name' => $cluster_type,
                        'masterDataId_fk' => 6,
                        //'bannerImages'=>$bannerImages,
                        'dataEntrydate' => $dataEntrydate,
                        'accessAuthKey' => $clusterAuthKey,
                        //'accessUrl'=>$accessUrl,
                        'status' => 1,
                    ];

                    $mastermenu = mastermenu::create($data);
                    $cluster = $mastermenu->masterMenuId;
                }


                $mainheadsq = mastermenu::select('masterMenuId')->where('masterDataId_fk', 5)->where('name', $mainheads)->first();
                if ($mainheadsq) {
                    $mainheads  = $mainheadsq->masterMenuId;
                } else {
                    $mainheadAuthKey = sha1($mainheads . '' . $currentDateTime->toDateTimeString());

                    $data = [
                        //'parentId' => $parentId,
                        'name' => $mainheads,
                        'masterDataId_fk' => 5,
                        //'bannerImages'=>$bannerImages,
                        'dataEntrydate' => $dataEntrydate,
                        'accessAuthKey' => $mainheadAuthKey,
                        //'accessUrl'=>$accessUrl,
                        'status' => 1,
                    ];

                    $mastermenu = mastermenu::create($data);
                    $mainheads = $mastermenu->masterMenuId;
                }


                $bank_nameq = mastermenu::select('masterMenuId')->where('masterDataId_fk', 7)->where('name', $bank_name)->first();

                if ($bank_nameq) {
                    $bank_name  = $bank_nameq->masterMenuId;
                } else {
                    $bankAuthKey = sha1($bank_name . '' . $currentDateTime->toDateTimeString());

                    $data = [
                        //'parentId' => $parentId,
                        'name' => $bank_name,
                        'masterDataId_fk' => 7,
                        //'bannerImages'=>$bannerImages,
                        'dataEntrydate' => $dataEntrydate,
                        'accessAuthKey' => $bankAuthKey,
                        //'accessUrl'=>$accessUrl,
                        'status' => 1,
                    ];

                    $mastermenu = mastermenu::create($data);
                    $bank_name = $mastermenu->masterMenuId;
                }




                // dd($EmpCode);
                $mst_user_list =  userlist::select('userId')->where('emp_code', $EmpCode)->orderby('userId', 'desc')->first();
                if ($mst_user_list) {
                    $assign_user = $mst_user_list->userId;
                }


                $data = [
                    'categoryNm' => $ltd_llp,
                    'dist_code' => $customer_code,
                    'customer_type' => $customer_type,
                    'CustomerName' => $customer_name_ii,
                    'consigneeName' => $consignee_name,
                    'dealerType' => $dealerType,
                    'galleryType' => $gallery_type,
                    'address' => $address,
                    'city' => $city,
                    'pincode' => $pincode,
                    'state' => $state,
                    //'district' => ,
                    //'zone' => $req->select_zone,
                    'email_id' => $email_id,
                    'mobileNo' => $mobile_no,
                    'mainHeads' => $mainheads,
                    'cluster' => $cluster,
                    // 'natureOfBuss' => $req->nature_of_business,
                    'ownerName' => $owner_name,
                    // 'ownerNumber' => $req->nature_mobile_no,
                    'transporterName' => $transport_name,
                    // 'receivedDate' => strtotime($req->bank_check_recieved_date),
                    'securityAmount' => $security_amount,
                    'chequeNo' => $blank_cheque_number,
                    //  'chequeDate' => $req->chequeDate,
                    'creditLimit' => $credit_limit,
                    'creditPeriod' => $credit_period,
                    'gstCertificate' => $consignee_gstin,
                    'securityChq' => $security_chq,
                    //    'amount' => $security_amount,
                    'faucet_ex_fc_disc' => $ex_fc_discount,
                    'faucet_dealer_scheme_discount' => $dealer_scheme_discount,
                    'faucet_distributor_scheme_discount' => $distributor_scheme_discount,
                    'faucet_distributor_disc' => $distributor_discount,
                    'faucet_retailer_ubs_scheme_disc' => $retailer_ubs_scheme_discount,
                    'faucet_finaldiscount' => $faucet_finaldiscount,
                    'sanitary_ex_sc_dicount' => $ex_fc_discount,
                    'sanitary_distributor_disc' => $distributor_dis,
                    'sanitary_dealer_line_discount' => $dealer_Line_Discount,
                    'sanitary_finaldiscount' => $sanitary_finaldiscount,
                    'display_discount' => $display_discount,
                    //'bankChq' => $chquebook_image,
                    'securityDepoPaymentMode' => 0,
                    // 'stateHead' => $req->state_head,
                    //'zoneHead' => $req->zonal_heads,
                    // 'remarks' => $req->ṛemarks,
                    // 'agreementImage' => serialize($agreementimg),
                    'dataEntryData' => $dataEntrydate,
                    'customerAuthKey' => $customerAuthKey,
                    'status' => $distributor_status,
                ];


                $mastermenu = mstcustomerlist::create($data);
                $customerId =  $mastermenu->customerId;

                if ($assign_user != '') {

                    $data_customersalesperson = [
                        'userId_fk' => $assign_user,
                        'customerId_fk' => $customerId,
                        'joinDate' => $dataEntrydate,
                        'assignSelesAuthKey' => $assignSelesAuthKey,
                        'status' => 1
                    ];

                    $customersalesperson = trans_customersalesperson::create($data_customersalesperson);
                }

                if ($consignee_name != '') {

                    $data_consignee = [
                        'customerId_fk' => $customerId,
                        'consignmentName' => $consignee_name,
                        'address' => $address,
                        'dataEntryDate' => $dataEntrydate,
                        'consignmentAuthKey' => $consignmentAuthKey,
                        'status' => 1
                    ];

                    $mst_disConsignment = mst_disConsignment::create($data_consignee);
                }


                if ($bank_name != '') {
                    $trans_cusbankinfo = [
                        'customerId_fk' => $customerId,
                        'bankId_fk' => $bank_name,
                        //'accountHolder' => $req->account_holder_name,
                        'accountNo' => $account_no,
                        //'accountTpe' => $req->bank_type,
                        'ifscCode' => $ifsc_code,
                        // 'blankChqueScanCopy' => serialize($imagePaths),
                        'dataEntryDate' => $dataEntrydate,
                        'bankAuthKeya' => $bankAuthKeya,
                        'status' => 1
                    ];

                    $cusbankinfo = trans_cusbankinfo::create($trans_cusbankinfo);
                }

                $documents = [
                    [
                        "customerId_fk" => $customerId,
                        "documentType_fk" => 192,
                        "documentNumber" => $aadhar_card,
                        // "docFrontImage" => $adahar_front_image,
                        // "docBackImage" => $adahar_back_image, 
                        "dataEntryDate" => $dataEntrydate,
                        "documentAuthKey" => $documentAuthKey
                    ],
                    [
                        "customerId_fk" => $customerId,
                        "documentType_fk" => 193,
                        "documentNumber" => $pan_card,
                        // "docFrontImage" => $pan_card_image,
                        // "docBackImage" => '', 
                        "dataEntryDate" => $dataEntrydate,
                        "documentAuthKey" => $pandocumentAuthKey
                    ]
                ];

                $trans_cusdocument = trans_cusdocument::insert($documents);
                DB::commit();

                return 'customer data import';
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['resp' => 2, 'Message' => $e->getMessage(), 'Line' => $e->getLine(),]);
            }
        }
    }


    public function userimport()
    {
        $path = public_path('sales person data.xlsx');
        $rows = SimpleExcelReader::create($path)->getRows();
        DB::beginTransaction();


        try {

            foreach ($rows as $key => $row) {

                // echo 'key => '.$key.'<br>';
                // echo'<pre>'; 
                // print_r($row);
                // return false;


                $emp_code  = $row['EMP code'];
                $name  = $row['Name'];
                $mobile  = $row['mobile'];
                $alternate_mobile  = $row['alternate mobile'];
                $email  = $row['email'];
                $state  = $row['state'];
                $city  = $row['city'];
                $address  = $row['address'];
                $Designation  = isset($row['Designation']) && $row['Designation'] !== '' ? $row['Designation'] : 'NA';
                $dob  = dateString($row['DOB']);
                $doa = datestring($row['DOA']);

                //dd($Designation);
                $Education  = $row['Education'];
                $Accountholdername  = $row['Account holder name'];
                $account_number  = $row['account number'];
                $bank_name  = $row['bank name'];
                $ifsc_code  = $row['ifsc code'];
                $adhar_number  = $row['adhar number'];
                $pan_number  = $row['pan number'];
                $Reporting_Head  = $row['Reporting Head'];
                $Job_experence  = $row['Job experence'];

                $currentDateTime = now();
                $dataEntrydate = strtotime($currentDateTime->toDateTimeString());
                $bankAuthKey = sha1($Accountholdername . '' . $currentDateTime->toDateTimeString());
                $userAuthKey = sha1($name . '' . $currentDateTime->toDateTimeString());


                $Designationq = mastermenu::select('masterMenuId')->where('masterDataId_fk', 3)->where('name', $Designation)->first();
                if ($Designationq) {

                    $Designation = $Designationq->masterMenuId;
                } else {

                    if ($Designation == '') {
                        $Designation  = 'NA';
                    }

                    $accessAuthKey = sha1($Designation . '' . $currentDateTime->toDateTimeString());
                    $data = [
                        //'parentId' => $parentId,
                        'name' => $Designation,
                        'masterDataId_fk' => 3,
                        //'bannerImages'=>$bannerImages,
                        'dataEntrydate' => $dataEntrydate,
                        'accessAuthKey' => $accessAuthKey,
                        //'accessUrl'=>$accessUrl,
                        'status' => 1,
                    ];

                    $mastermenu = mastermenu::create($data);
                    $Designation = $mastermenu->masterMenuId;
                }


                $city_mstlocation = mstlocation::select('cityId')->where('cityName', $city)->first();
                if ($city_mstlocation) {
                    $city = $city_mstlocation->cityId;
                } else {
                    $city = 0;
                }

                $state_mstlocation = mstlocation::select('cityId')->where('cityName', $state)->first();
                if ($state_mstlocation) {
                    $state = $state_mstlocation->cityId;
                } else {
                    $state = 0;
                }



                $userlist = UserList::select('userId')->where('emp_code', $emp_code)->where('name', $name)->first();
                if ($userlist) {
                    $reporting_head =  $userlist->userId;
                } else {
                    $reporting_head = 0;
                }


                $bank_name = mastermenu::select('masterMenuId')->where('masterDataId_fk', 7)->where('name', $bank_name)->first();

                if ($bank_name) {
                    $bank_name  = $bank_name->masterMenuId;
                } else {
                    //dd('$bank_name =>'.$bank_name);
                    if ($bank_name == '') {
                        $bank_name = 'NA';
                    }

                    $accessAuthKey = sha1($bank_name . '' . $currentDateTime->toDateTimeString());
                    $data = [
                        //'parentId' => $parentId,
                        'name' => $bank_name,
                        'masterDataId_fk' => 7,
                        //'bannerImages'=>$bannerImages,
                        'dataEntrydate' => $dataEntrydate,
                        'accessAuthKey' => $accessAuthKey,
                        //'accessUrl'=>$accessUrl,
                        'status' => 1,
                    ];

                    $mastermenu = mastermenu::create($data);
                    $bank_name = $mastermenu->masterMenuId;
                }

                //  dd('$bank_name =>'. $bank_name);

                $data = [
                    'role_type' => 3,
                    'emp_code' => $emp_code,
                    'roleId_fk' => $Designation,
                    'name' => $name,
                    'password' => Hash::make(1234),
                    'loginId' => $mobile,
                    'state' => $state,
                    'city' => $city,
                    'address' => $address,
                    'emailAddress' => $email,
                    //'profileImage' => $profileImage22,
                    'mobileNumber' => $mobile,
                    'alertnetNumber' => $alternate_mobile,
                    'dob' => $dob,
                    'doa' => $doa,
                    'aadhar_number' => $adhar_number,
                    'education' => $Education,
                    'pan_number' => $pan_number,
                    // 'aadhar_imageFront' => $filename,
                    //'aadharBackImage' => $filename2,
                    //'pancardImage' => $filename3,
                    'job_experience' => $Job_experence,
                    'reporting_head' => $reporting_head,
                    'joinDate' => $dataEntrydate,
                    'userAuthKey' => $userAuthKey,
                    'staus' => 1,
                ];

                $useradd = UserList::create($data);
                $userId = $useradd->userId;

                //if($bank_name != 0){

                $trans_salesBankInfo = [
                    'userId_fk' => $userId,
                    'bankId_fk' => $bank_name,
                    'accountHolder' => $Accountholdername,
                    'accountNo' => $account_number,
                    'ifscCode' =>  $ifsc_code,
                    'dataEntryDate' => $dataEntrydate,
                    'bankAuthKey' => $bankAuthKey,
                    'status' => 1,

                ];
                $trans_salesBankInfo = trans_salesBankInfo::create($trans_salesBankInfo);

                //  }


                // }


                // DB::commit();

            }


            DB::commit();

            return 'Data import Successfully';
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage(), 'Line' => $e->getLine()]);
        }
    }


    public function productimageimport()
    {
        $productoldimage  = DB::table('mst_productlist_old')->get();

        foreach ($productoldimage as $key => $val) {

            $product = mstproduct::where('cat_number', $val->cat_number)->first();

            if ($product) {
                $product->update([
                    'productImage' => $val->productImage
                ]);
            }
        }

        
    }


    public function purchasereturnall()
    {

       $masterdata_purchasereturn = $this->masterdata_purchasereturn[0]->masterDataId;

      //  dd($this->masterdata_purchasereturn);

        $mastermenu_purchasereturn =  mastermenu::where('masterDataId_fk', $masterdata_purchasereturn)
            ->select('masterMenuId', 'name')
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();

        $resp = $mastermenu_purchasereturn->isEmpty() ? 2 : 1;
        return response()->json(['resp' => $resp, 'data' => $mastermenu_purchasereturn]);
    }


    public function inventoryupdate()
    {


        //dd('hello');
        $path = public_path('Vaalve Opening stock sheet.xlsx');
        $rows = SimpleExcelReader::create($path)->getRows();

        foreach ($rows as $key => $row) {

            $catnumber = $row['Cat Number'];
            $Openingstockdate = $row['Opening Stock Date'] instanceof \DateTimeImmutable ? $row['Opening Stock Date']->format('Y-m-d') : $row['Opening Stock Date'];
            $OpeningStock = $row['Opening Stock'];


            $mstproduct = mstproduct::where('cat_number', $catnumber)->orderby('productId', 'ASC')->first();


            $productId = $mstproduct->productId;
            $currentDateTime = now();
            $dataEntrydate = strtotime($currentDateTime->toDateTimeString());
            $itemStockAuthKey = sha1($productId . $currentDateTime->toDateTimeString());

            $checkstockcount = trans_itemStock::where('productId_fk', $productId)->count();

            if ($checkstockcount == 0) {

                $stockdata = [
                    'productId_fk' => $productId,
                    'userId_fk' => session('userinfo')->userId,
                    'opening_stock_date' => strtotime($Openingstockdate),
                    'opening_stock' => $OpeningStock,
                    'itemStockAuthKey' => $itemStockAuthKey,
                    'entryDate' => $dataEntrydate,
                    'status' => 1
                ];

                $datainsert = trans_itemStock::insert($stockdata);
            } else {


                $datainsert = trans_itemStock::where('productId_fk', $productId)
                    ->update(['opening_stock_date' => strtotime($Openingstockdate), 'opening_stock' => $OpeningStock,]);
            }
        }

        echo 'Inventory Update Sucessfully';
    }
}
