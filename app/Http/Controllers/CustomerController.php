<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\mstcustomerlist;
use App\Models\trans_cusbankinfo;
use App\Models\trans_cusContactPerson;
use App\Models\trans_cusdocument;
use App\Models\mstlocation;
use App\Models\mst_orderlist;
use App\Models\mst_trunover;
use App\Models\UserList;
use App\Models\trans_customersalesperson;
use App\Models\mst_disConsignment;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CustomerController extends BaseController
{
  //

  public function index()
  {
    return view('customer.addcustomer');
  }

  public function FormSubmit(Request $req)
  {

    DB::beginTransaction();

    try {


      if ($req->customer_type == '310') {

        $prefix = 'UBS - ';

        $maxCode = mstcustomerlist::selectRaw('MAX(CAST(SUBSTRING(dist_code, LENGTH(?) + 1) AS UNSIGNED)) as max_code', [$prefix])
          ->where('dist_code', 'LIKE', $prefix . '%')
          ->first()
          ->max_code;
      } else if ($req->customer_type == '327') {
        $prefix = 'RET - ';
        $maxCode = mstcustomerlist::selectRaw('MAX(CAST(SUBSTRING(dist_code, LENGTH(?) + 1) AS UNSIGNED)) as max_code', [$prefix])
          ->where('dist_code', 'LIKE', $prefix . '%')
          ->first()
          ->max_code;
      } else {

        $prefix = 'VSL-';

        $maxCode = mstcustomerlist::selectRaw('MAX(CAST(SUBSTRING(dist_code, LENGTH(?) + 1) AS UNSIGNED)) as max_code', [$prefix])
          ->where('dist_code', 'LIKE', $prefix . '%')
          ->first()
          ->max_code;
      }

      $newCode = $prefix . str_pad($maxCode + 1, 4, '0', STR_PAD_LEFT);

      //dd($newCode);



      $currentDateTime = now();
      $contact_person_name = $req->contact_person_name;
      $customerAuthKey = sha1($req->customer_name . '' . $currentDateTime->toDateTimeString());
      $dataEntrydate = strtotime($currentDateTime->toDateTimeString());
      $assignSelesAuthKey = sha1($req->assign_user . '' . $currentDateTime->toDateTimeString());
      $bankAuthKeya = sha1($req->bank_name . '' . $currentDateTime->toDateTimeString());
      $documentAuthKey = sha1($req->adahar_number . '' . $currentDateTime->toDateTimeString());
      $pandocumentAuthKey = sha1($req->pan_number . '' . $currentDateTime->toDateTimeString());
      $consignmentAuthKey = sha1($req->consignee_name . '' . $currentDateTime->toDateTimeString());

      $imagePaths = [];
      $agreementimg = [];


      if ($req->hasFile('chquebook_image')) {

        $chquebook_image = 'chquebook' . time() . '.' . $req->chquebook_image->getClientOriginalExtension();
        $req->chquebook_image->move(public_path('document'), $chquebook_image);
      } else {
        $chquebook_image = '';
      }


      if ($req->hasFile('cheque_images')) {
        foreach ($req->file('cheque_images') as $key => $file) {
          $filename = 'cheque_' . $key . time() . '.' . $file->getClientOriginalExtension();
          $file->move(public_path('document'), $filename);
          $imagePaths[] = $filename; // Save filename in array to store in database later
        }
      }

      if ($req->hasFile('agreement_image')) {
        foreach ($req->file('agreement_image') as $key => $file) {
          $filename1 = 'agreement_' . $key . time() . '.' . $file->getClientOriginalExtension();
          $file->move(public_path('document'), $filename1);
          $agreementimg[] = $filename1; // Save filename in array to store in database later
        }
      }


      if ($req->hasFile('adahar_front_image')) {

        $adahar_front_image = 'ADHf' . time() . '.' . $req->adahar_front_image->getClientOriginalExtension();
        $req->adahar_front_image->move(public_path('document'), $adahar_front_image);
      } else {
        $adahar_front_image = '';
      }


      if ($req->hasFile('adahar_back_image')) {

        $adahar_back_image = 'ADHb' . time() . '.' . $req->adahar_back_image->getClientOriginalExtension();
        $req->adahar_back_image->move(public_path('document'), $adahar_back_image);
      } else {
        $adahar_back_image = '';
      }

      if ($req->hasFile('pan_card_image')) {

        $pan_card_image = 'PANf' . time() . '.' . $req->pan_card_image->getClientOriginalExtension();
        $req->pan_card_image->move(public_path('document'), $pan_card_image);
      } else {
        $pan_card_image = '';
      }

      $data = [
        'categoryNm' => $req->ltd_llp,
        'dist_code' => $newCode,
        'customer_type' => $req->customer_type,
        'CustomerName' => $req->customer_name,
        'consigneeName' => $req->consignee_name,
        'dealerType' => $req->dealer_type,
        'galleryType' => $req->gallery_type,
        'address' => $req->street,
        'city' => $req->select_city,
        'pincode' => $req->pin_code,
        'state' => $req->select_state,
        'district' => $req->select_district,
        'zone' => $req->select_zone,
        'shipping_address' => $req->shipping_street,
        'shipping_city' => $req->select_shipping_city,
        'shipping_pincode' => $req->shipping_pin_code,
        'shipping_state' => $req->select_shipping_state,
        'shipping_district' => $req->select_shipping_district,
        'shipping_zone' => $req->select_shipping_zone,
        'email_id' => $req->email_id,
        'mobileNo' => $req->phone_no,
        'mainHeads' => $req->mainheads,
        'cluster' => $req->cluster_type,
        'natureOfBuss' => $req->nature_of_business,
        'ownerName' => $req->nature_name,
        'ownerNumber' => $req->nature_mobile_no,
        'transporterName' => $req->tansproter,
        'receivedDate' => strtotime($req->bank_check_recieved_date),
        'securityAmount' => $req->security_amount,
        'chequeNo' => $req->cheque_number,
        'chequeDate' => $req->chequeDate,
        'creditLimit' => $req->credit_limit,
        'creditPeriod' => $req->credit_period,
        'gstCertificate' => $req->gst,
        'securityChq' => $req->security_check_detail,
        'amount' => $req->amount,
        'faucet_ex_fc_disc' => $req->faucet_ex_fc_disc,
        'faucet_dealer_scheme_discount' => $req->faucet_dealer_scheme_discount,
        'faucet_distributor_scheme_discount' => $req->faucet_distributor_scheme_discount,
        'faucet_distributor_disc' => $req->faucet_distributor_disc,
        'faucet_retailer_ubs_scheme_disc' => $req->faucet_retailer_ubs_scheme_disc,
        'faucet_finaldiscount' => $req->final_faucet_discount,
        'sanitary_ex_sc_dicount' => $req->ex_sc_dicount,
        'sanitary_distributor_disc' => $req->sanitary_distributor_disc,
        'sanitary_dealer_line_discount' => $req->sanitary_dealer_line_discount,
        'sanitary_finaldiscount' => $req->final_sanitary_discount,
        'display_discount' => $req->display_discount,
        'bankChq' => $chquebook_image,
        'securityDepoPaymentMode' => $req->blank_cheq,
        'stateHead' => $req->state_head,
        'zoneHead' => $req->zonal_heads,
        'remarks' => $req->ṛemarks,
        'agreementImage' => serialize($agreementimg),
        'dataEntryData' => $dataEntrydate,
        'customerAuthKey' => $customerAuthKey,
        'status' => $req->distributor_status ?? 184,
      ];

      $mastermenu = mstcustomerlist::create($data);

      $customerId = $mastermenu->customerId;


      if ($req->assign_user != '') {

        $data_customersalesperson = [
          'userId_fk' => $req->assign_user,
          'customerId_fk' => $customerId,
          'joinDate' => $dataEntrydate,
          'assignSelesAuthKey' => $assignSelesAuthKey,
          'status' => 1
        ];

        $customersalesperson = trans_customersalesperson::create($data_customersalesperson);
      }


      if ($req->consignee_name != '') {

        $data_consignee = [
          'customerId_fk' => $customerId,
          'consignmentName' => $req->consignee_name,
          'address' =>  $req->street,
          'dataEntryDate' => $dataEntrydate,
          'consignmentAuthKey' => $consignmentAuthKey,
          'status' => 1
        ];

        $customersalesperson = mst_disConsignment::create($data_consignee);
      }

      $trans_cusbankinfo = [
        'customerId_fk' => $customerId,
        'bankId_fk' => $req->bank_name,
        'accountHolder' => $req->account_holder_name,
        'accountNo' => $req->account_number,
        'accountTpe' => $req->bank_type,
        'ifscCode' => $req->ifsc_code,
        'blankChqueScanCopy' => serialize($imagePaths),
        'dataEntryDate' => $dataEntrydate,
        'bankAuthKeya' => $bankAuthKeya,
        'status' => 1
      ];

      $cusbankinfo = trans_cusbankinfo::create($trans_cusbankinfo);

      foreach ($contact_person_name as $key => $value) {
        $contact_person_degination = $req->contact_person_degination;
        $contact_person_email = $req->contact_person_email;
        $contact_mobile = $req->contact_mobile;
        $contactAuthKey = sha1($value . '' . $currentDateTime->toDateTimeString());


        if ($value != '') {
          $trans_cusContact = [
            'customerId_fk' => $customerId,
            'name' => $value,
            'degination' => $contact_person_degination[$key],
            'emailId' => $contact_person_email[$key],
            'phoneNumber' => $contact_mobile[$key],
            'contactAuthKey' => $contactAuthKey,
            'status' => 1,
          ];
          $cusbankinfo = trans_cusContactPerson::create($trans_cusContact);
        }
      }

      $turnover = [
        [
          'customerId_fk' => $customerId,
          'trunOverType_fk' => 226,
          'firstYear' => $req->one_year_company,
          'secondYear' => $req->two_year_company,
          'thirdYear' => $req->three_year_company,
          'status' => 1
        ],
        [
          'customerId_fk' => $customerId,
          'trunOverType_fk' => 227,
          'firstYear' => $req->one_year_vaalve,
          'secondYear' => $req->two_year_vaalve,
          'thirdYear' => $req->three_year_vaalve,
          'status' => 1
        ],
      ];
      $mst_trunover = mst_trunover::insert($turnover);

      $documents = [
        [
          "customerId_fk" => $customerId,
          "documentType_fk" => 192,
          "documentNumber" => $req->adahar_number,
          "docFrontImage" => $adahar_front_image,
          "docBackImage" => $adahar_back_image,
          "dataEntryDate" => $dataEntrydate,
          "documentAuthKey" => $documentAuthKey
        ],
        [
          "customerId_fk" => $customerId,
          "documentType_fk" => 193,
          "documentNumber" => $req->pan_number,
          "docFrontImage" => $pan_card_image,
          "docBackImage" => '',
          "dataEntryDate" => $dataEntrydate,
          "documentAuthKey" => $pandocumentAuthKey
        ]
      ];

      $trans_cusdocument = trans_cusdocument::insert($documents);

      DB::commit();

      $msg = $trans_cusdocument ? 'Data Insert Successfully' : 'Data Not Insert Successfully';
      $resp = $trans_cusdocument ? 1 : 2;

      return response()->json(['resp' => $resp, 'msg' => $msg]);
    } catch (\Exception $e) {
      DB::rollBack();

      // Log the exception message
      Log::error('FormSubmit Error: ' . $e->getMessage());

      // Return error response
      return response()->json(['resp' => 2, 'msg' => 'Data Not Insert Successfully', 'error' => $e->getMessage()]);
    }
  }

  public function CustomerEdit($id)
  {

    $customerdata = mstcustomerlist::where('customerAuthKey', $id)->first();

    $customer_id = $customerdata->customerId;
    $bankdata = trans_cusbankinfo::where('customerId_fk', $customer_id)->first();
    //dd($bankdata);
    $adhardata = trans_cusdocument::where('customerId_fk', $customer_id)->where("documentType_fk", 192)->first();
    $pandata = trans_cusdocument::where('customerId_fk', $customer_id)->where("documentType_fk", 193)->first();
    $customersalesperson = trans_customersalesperson::where('customerId_fk', $customer_id)->first();

    $vaalveturnover = mst_trunover::where('customerId_fk', $customer_id)->where('trunOverType_fk', 227)->first();
    $companyturnover = mst_trunover::where('customerId_fk', $customer_id)->where('trunOverType_fk', 226)->first();
    $contactperson = trans_cuscontactperson::where('customerId_fk', $customer_id)->get();
    //dd($adhardata);

    return view('customer.editcustomer', compact('customerdata', 'bankdata', 'pandata', 'adhardata', 'customersalesperson', 'companyturnover', 'vaalveturnover', 'contactperson'));
  }

  public function editsubmit(Request $req)
  {

    DB::beginTransaction();
    try {

      $currentDateTime = now();
      $contact_person_name = $req->contact_person_name;
      $customerAuthKey = sha1($req->customer_name . '' . $currentDateTime->toDateTimeString());
      $dataEntrydate = strtotime($currentDateTime->toDateTimeString());
      $assignSelesAuthKey = sha1($req->assign_user . '' . $currentDateTime->toDateTimeString());
      $bankAuthKeya = sha1($req->bank_name . '' . $currentDateTime->toDateTimeString());
      $documentAuthKey = sha1($req->adahar_number . '' . $currentDateTime->toDateTimeString());
      $pandocumentAuthKey = sha1($req->pan_number . '' . $currentDateTime->toDateTimeString());
      $consignmentAuthKey = sha1($req->consignee_name . '' . $currentDateTime->toDateTimeString());

      if ($req->hasFile('chquebook_image')) {
        $chquebook_image = 'chquebook' . time() . '.' . $req->chquebook_image->getClientOriginalExtension();
        $req->chquebook_image->move(public_path('document'), $chquebook_image);
      } else {
        $chquebook_image = $req->chquebook_image_old;
      }



      if ($req->hasFile('cheque_images')) {
        $imagePaths = [];
        foreach ($req->file('cheque_images') as $key =>  $file) {
          $filename = 'cheque_' . $key . time() . '.' . $file->getClientOriginalExtension();
          $file->move(public_path('document'), $filename);
          $imagePaths[] = $filename; // Save filename in array to store in database later
        }

        $img_paths = serialize($imagePaths);
      } else {
        $img_paths = $req->cheque_image_old;
      }

      if ($req->hasFile('agreement_image')) {
        $agreement_img = [];
        foreach ($req->file('agreement_image') as $key => $file) {
          $filename1 = 'agreement_' . $key .  time() . '.' . $file->getClientOriginalExtension();
          $file->move(public_path('document'), $filename1);
          $agreement_img[] = $filename1; // Save filename in array to store in database later
        }
        $agreementimg = serialize($agreement_img);
      } else {

        $agreementimg = $req->agreement_image_old;
      }

      if ($req->hasFile('adahar_front_image')) {
        $adahar_front_image = 'ADHf' . time() . '.' . $req->adahar_front_image->getClientOriginalExtension();
        $req->adahar_front_image->move(public_path('document'), $adahar_front_image);
      } else {
        $adahar_front_image = $req->adahar_front_image_old;
      }

      if ($req->hasFile('adahar_back_image')) {
        $adahar_back_image = 'ADHb' . time() . '.' . $req->adahar_back_image->getClientOriginalExtension();
        $req->adahar_back_image->move(public_path('document'), $adahar_back_image);
      } else {
        $adahar_back_image = $req->adahar_back_image_old;
      }

      if ($req->hasFile('pan_card_image')) {
        $pan_card_image = 'PANf' . time() . '.' . $req->pan_card_image->getClientOriginalExtension();
        $req->pan_card_image->move(public_path('document'), $pan_card_image);
      } else {
        $pan_card_image = $req->pan_card_image_old;
      }

      // $select_district = is_numeric($req->select_district) ? (int)$req->select_district : null;
      // $zone = $req->select_zone ?? '';
      $data = [
        'categoryNm' => $req->ltd_llp,
        'customer_type' => $req->customer_type,
        'CustomerName' => $req->customer_name,
        'consigneeName' => $req->consignee_name,
        'dealerType' => $req->dealer_type,
        'galleryType' => $req->gallery_type,
        'address' => $req->street,
        'city' => $req->select_city,
        'pincode' => $req->pin_code,
        'state' => $req->select_state,
        'district' => $req->select_district,
        'zone' =>  $req->select_zone,
        'shipping_address' => $req->shipping_street,
        'shipping_city' => $req->select_shipping_city,
        'shipping_pincode' => $req->shipping_pin_code,
        'shipping_state' => $req->select_shipping_state,
        'shipping_district' => $req->select_shipping_district,
        'shipping_zone' => $req->select_shipping_zone,
        'email_id' => $req->email_id,
        'mobileNo' => $req->phone_no,
        'mainHeads' => $req->mainheads,
        'cluster' =>  $req->cluster_type,
        'natureOfBuss' => $req->nature_of_business,
        'ownerName' => $req->nature_name,
        'ownerNumber' => $req->nature_mobile_no,
        'transporterName' => $req->tansproter,
        'receivedDate' => strtotime($req->bank_check_recieved_date),
        'securityAmount' => $req->security_amount,
        'chequeNo' => $req->cheque_number,
        'chequeDate' => $req->chequeDate,
        'creditLimit' => $req->credit_limit,
        'creditPeriod' => $req->credit_period,
        'gstCertificate' => $req->gst,
        'securityChq' => $req->security_check_detail,
        'amount' => $req->amount,
        'faucet_ex_fc_disc' => $req->faucet_ex_fc_disc,
        'faucet_dealer_scheme_discount' => $req->faucet_dealer_scheme_discount,
        'faucet_distributor_scheme_discount' => $req->faucet_distributor_scheme_discount,
        'faucet_distributor_disc' => $req->faucet_distributor_disc,
        'faucet_retailer_ubs_scheme_disc' => $req->faucet_retailer_ubs_scheme_disc,
        'faucet_finaldiscount' => $req->final_faucet_discount,
        'sanitary_ex_sc_dicount' => $req->ex_sc_dicount,
        'sanitary_distributor_disc' => $req->sanitary_distributor_disc,
        'sanitary_dealer_line_discount' => $req->sanitary_dealer_line_discount,
        'sanitary_finaldiscount' => $req->final_sanitary_discount,
        'display_discount' => $req->display_discount,
        'bankChq' => $chquebook_image,
        'securityDepoPaymentMode' => $req->blank_cheq,
        'stateHead' => $req->state_head,
        'zoneHead' => $req->zonal_heads,
        'agreementImage' => $agreementimg,
        'remarks' => $req->ṛemarks,
        'dataEntryData' => $dataEntrydate,
        //'customerAuthKey'=> $customerAuthKey,
        'status' => $req->distributor_status,
      ];

      $customerId = $req->customer_id;
      $mastermenu = mstcustomerlist::find($customerId);
      $mastermenu->update($data);

      // dd($mastermenu);

      $data_customersalesperson = [
        'userId_fk' => $req->assign_user,
        'customerId_fk' => $customerId,
        'joinDate' => $dataEntrydate,
        'assignSelesAuthKey' => $assignSelesAuthKey,
        'status' => 1
      ];


      trans_cusbankinfo::where('customerId_fk', $customerId)->delete();
      trans_cusdocument::where('customerId_fk', $customerId)->delete();
      mst_trunover::where('customerId_fk', $customerId)->delete();
      trans_cusContactPerson::where('customerId_fk', $customerId)->delete();
      mst_disConsignment::where('customerId_fk', $customerId)->delete();

      if ($req->assign_user != '') {
        trans_customersalesperson::where('customerId_fk', $customerId)->delete();
        $customersalesperson = trans_customersalesperson::create($data_customersalesperson);
      }

      $trans_cusbankinfo = [
        'customerId_fk' => $customerId,
        'bankId_fk' => $req->bank_name,
        'accountHolder' => $req->account_holder_name,
        'accountNo' => $req->account_number,
        'accountTpe' => $req->bank_type,
        'ifscCode' => $req->ifsc_code,
        'blankChqueScanCopy' => $img_paths,
        'dataEntryDate' => $dataEntrydate,
        'bankAuthKeya' =>  $bankAuthKeya,
        'status' => 1
      ];

      $cusbankinfo = trans_cusbankinfo::create($trans_cusbankinfo);

      if ($req->consignee_name != '') {

        $data_consignee = [
          'customerId_fk' => $customerId,
          'consignmentName' => $req->consignee_name,
          'address' =>  $req->street,
          'dataEntryDate' => $dataEntrydate,
          'consignmentAuthKey' => $consignmentAuthKey,
          'status' => 1
        ];

        $customersalesperson = mst_disConsignment::create($data_consignee);
      }

      $turnover = [
        [
          'customerId_fk' => $customerId,
          'trunOverType_fk' => 226,
          'firstYear' => $req->one_year_company,
          'secondYear' => $req->two_year_company,
          'thirdYear' => $req->three_year_company,
          'status' => 1
        ],

        [
          'customerId_fk' => $customerId,
          'trunOverType_fk' => 227,
          'firstYear' => $req->one_year_vaalve,
          'secondYear' => $req->two_year_vaalve,
          'thirdYear' => $req->three_year_vaalve,
          'status' => 1
        ],

      ];
      $mst_trunover = mst_trunover::insert($turnover);

      foreach ($contact_person_name as $key => $value) {

        $contact_person_degination = $req->contact_person_degination;
        $contact_person_email = $req->contact_person_email;
        $contact_mobile = $req->contact_mobile;
        $contactAuthKey = sha1($value . '' . $currentDateTime->toDateTimeString());

        if ($value != '') {

          $trans_cusContact = [
            'customerId_fk' => $customerId,
            'name' => $value,
            'degination' => $contact_person_degination[$key],
            'emailId' => $contact_person_email[$key],
            'phoneNumber' => $contact_mobile[$key],
            'contactAuthKey' => $contactAuthKey,
            'status' => 1,
          ];

          $cusbankinfo = trans_cusContactPerson::create($trans_cusContact);
        }
      }

      $documents = [
        [
          "customerId_fk" => $customerId,
          "documentType_fk" => 192,
          "documentNumber" => $req->adahar_number,
          "docFrontImage" => $adahar_front_image,
          "docBackImage" => $adahar_back_image,
          "dataEntryDate" => $dataEntrydate,
          "documentAuthKey" => $documentAuthKey
        ],
        [
          "customerId_fk" => $customerId,
          "documentType_fk" => 193,
          "documentNumber" => $req->pan_number,
          "docFrontImage" => $pan_card_image,
          "docBackImage" => '',
          "dataEntryDate" => $dataEntrydate,
          "documentAuthKey" => $pandocumentAuthKey
        ]
      ];

      $trans_cusdocument = trans_cusdocument::insert($documents);

      $msg = $trans_cusdocument ? 'Data update Successfully' : 'Data Not Update Successfully';
      $resp = $trans_cusdocument ? 1 : 2;

      DB::commit();

      return response()->json(['resp' => $resp, 'msg' => $msg]);
    } catch (\Exception $e) {

      //dd($e);
      // Rollback the transaction if any delete fails
      DB::rollBack();

      // Log the exception message
      Log::error('FormSubmit Error: ' . $e->getMessage());

      // Return error response
      return response()->json(['resp' => 2, 'msg' => 'Data Not Insert Successfully', 'error' => $e->getMessage()]);
    }
  }

  public function deltesubmit($id)
  {
    DB::beginTransaction();

    try {
      // Delete from all related tables

      trans_cusdocument::where('customerId_fk', $id)->delete();
      trans_cusbankinfo::where('customerId_fk', $id)->delete();
      trans_customersalesperson::where('customerId_fk', $id)->delete();
      mst_trunover::where('customerId_fk', $id)->delete();
      trans_cusContactPerson::where('customerId_fk', $id)->delete();
      mst_disConsignment::where('customerId_fk', $id)->delete();
      $mstcustomerlist = mstcustomerlist::where('customerId', $id)->delete();
      //   dd($mstcustomerlist);
      if ($mstcustomerlist) {
        DB::commit();
        return 1;
      }
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json(['error' => $e->getMessage()]);
    }
  }

  public function ubslist()
  {
    return view('customer.ubslist');
  }

  public function distributorlist()
  {
    return view('customer.distributorlist');
  }

  public function dealerlist()
  {
    return view('customer.dealerlist');
  }

  public function retailerlist()
  {
    return view('customer.retailerlist');
  }

  public function listdata(Request $req)
  {
    $rowCount = $req->input('rowCount');
    $page = $req->input('page');
    $customer_type = $req->input('customer_type');

    if (session('userinfo')->role_type == 2) {

      $customers = mstcustomerlist::where('customer_type', $customer_type)->orderBy('customerId', 'desc')
        ->paginate($rowCount, ['*'], 'page', $page);
    } else {

      $customers = mstcustomerlist::select('mst_customerlist.*')
        ->join('trans_customersalesperson', 'trans_customersalesperson.customerId_fk', '=', 'mst_customerlist.customerId')
        ->where('mst_customerlist.customer_type', $customer_type)
        ->where('trans_customersalesperson.userId_fk', session('userinfo')->userId)
        ->orderBy('mst_customerlist.customerId', 'desc')
        ->paginate($rowCount, ['*'], 'page', $page);
    }
    $data = [];

    foreach ($customers as $key => $val) {


      if ($val->state != '' && $val->state != 0) {
        $state  = getlocationdatabyid($val->state);
        $state = $state->cityName;
      } else {
        $state = '';
      }


      if ($val->city != '' && $val->city != 0) {
        $city  = getlocationdatabyid($val->city);
        $city = $city->cityName;
      } else {
        $city = '';
      }


      if ($val->district != '' && $val->district != 0) {
        $district  = getlocationdatabyid($val->district);
        $district = $district->cityName;
      } else {
        $district = '';
      }

      $mst_orderlist = mst_orderlist::select('orderDate')->where('customerId_fk',$val->customerId)->orderby('orderId','desc')->first();
      if($mst_orderlist){
        $daysDifference = Carbon::parse($mst_orderlist->orderDate)->diffInDays(now());

        $daysDifference =  $daysDifference;
      }else{
        $daysDifference = 'NA';

      }


      $mst_disConsignment = mst_disConsignment::select('consignmentName')->where('customerId_fk', $val->customerId)->first();

      $trans_customersalesperson = trans_customersalesperson::select('mst_user_list.name')
        ->join('mst_user_list', 'trans_customersalesperson.userId_fk', '=', 'mst_user_list.userId')
        ->where('trans_customersalesperson.customerId_fk', $val->customerId)
        ->first();


      if ($val->status  == '184') {

        $status = 'Active';
      } else {
        $status = 'Inactive';
      }


      $entry = [
        'customerId' => $val->customerId,
        'CustomerName' =>  $val->CustomerName ?? '',
        'email_id' => $val->email_id ?? '',
        'address' => $val->address ?? '',
        //'city' =>$city ?? '',
        //'district' => $district->cityName ?? '',
        //'state' =>$state,
        'customerAuthKey' => $val->customerAuthKey,
        'dist_code' => $val->dist_code,
        'consignee_name' => $mst_disConsignment->consignmentName  ?? '',
        'salesperson' => $trans_customersalesperson->name ?? '',
        'daysDifference' => $daysDifference,
        'status' => $status
      ];

      $data[] = $entry;
    }

    $response = [
      'data' => $data,
      'current_page' => $customers->currentPage(),
      'last_page' => $customers->lastPage()
    ];


    return response()->json($response);
  }

  public function customersearch(Request $req)
  {
    $rowCount = $req->input('rowCount');
    $page = $req->input('page');
    $cust_code = $req->input('cust_code');
    $consignee_name = $req->input('consignee_name');
    $company_name = $req->input('company_name');
    $email = $req->input('email');
    $customer_type = $req->input('customer_type');
    $address = $req->input('address');
    $status = $req->input('status');
    $sales_sperosn = $req->input('sales_sperosn');

    // Determine the status value
    $mystatus = strtolower($status) == 'active' ? '184' : '185';

    // Initialize the customer query
    $query = mstcustomerlist::select(
      'mst_customerlist.customerId',
      'mst_customerlist.dist_code',
      'mst_customerlist.CustomerName',
      'mst_customerlist.email_id',
      'mst_customerlist.address',
      'mst_customerlist.status',
      'mst_customerlist.customerAuthKey'
    );

    // // Apply join if the user's role type is 3
    // if (session('userinfo')->role_type == 3) {
    $query->Leftjoin('trans_customersalesperson', 'mst_customerlist.customerId', '=', 'trans_customersalesperson.customerId_fk');
    //   }

    // Apply filters
    $query->where('mst_customerlist.customer_type', $customer_type)
      ->orderBy('mst_customerlist.customerId', 'asc');

    if (!empty($cust_code)) {
      $query->where('mst_customerlist.dist_code', 'like', '%' . $cust_code . '%');
    }
    if (!empty($company_name)) {
      $query->where('mst_customerlist.CustomerName', 'like', '%' . $company_name . '%');
    }
    if (!empty($address)) {
      $query->where('mst_customerlist.address', 'like', '%' . $address . '%');
    }
    if (!empty($email)) {
      $query->where('mst_customerlist.email_id', 'like', '%' . $email . '%');
    }
    if (!empty($consignee_name)) {
      $query->where('mst_customerlist.consigneeName', 'like', '%' . $consignee_name . '%');
    }

    // Additional condition for specific user role
    if (session('userinfo')->role_type == 3) {
      $query->where('trans_customersalesperson.userId_fk', session('userinfo')->userId);
    }

    // If sales_sperosn is not empty, filter by sales_sperosn
    if (!empty($sales_sperosn)) {
      $UserList = UserList::where('name', 'like', '%' . $sales_sperosn . '%')
        ->pluck('userId')
        ->toArray();

      $query->whereIn('trans_customersalesperson.userId_fk', $UserList);
    }

    if (!empty($status)) {

      $query->where('mst_customerlist.status', $mystatus);
    }

    // Paginate the results
    $customers = $query->paginate($rowCount, ['*'], 'page', $page);

    $data = [];

    // Loop through each customer and fetch related data
    foreach ($customers as $val) {
      $mst_disConsignment = mst_disConsignment::select('consignmentName')
        ->where('customerId_fk', $val->customerId)
        ->first();

      $trans_customersalesperson = trans_customersalesperson::select('mst_user_list.name')
        ->join('mst_user_list', 'trans_customersalesperson.userId_fk', '=', 'mst_user_list.userId')
        ->where('trans_customersalesperson.customerId_fk', $val->customerId)
        ->first();

      // Convert status code to readable format
      $status = ($val->status == '184') ? 'Active' : 'Inactive';

      
      $mst_orderlist = mst_orderlist::select('orderDate')->where('customerId_fk',$val->customerId)->orderby('orderId','desc')->first();
      if($mst_orderlist){
        $daysDifference = Carbon::parse($mst_orderlist->orderDate)->diffInDays(now());

        $daysDifference =  $daysDifference;
      }else{
        $daysDifference = 'NA';

      }

      
      // Prepare the customer entry
      $entry = [
        'customerId' => $val->customerId,
        'CustomerName' => $val->CustomerName ?? '',
        'email_id' => $val->email_id ?? '',
        'address' => $val->address ?? '',
        'customerAuthKey' => $val->customerAuthKey,
        'dist_code' => $val->dist_code,
        'daysDifference' => $daysDifference,
        'consignee_name' => $mst_disConsignment->consignmentName ?? '',
        'salesperson' => $trans_customersalesperson->name ?? '',
        'status' => $status,
      ];

      $data[] = $entry;
    }

    // Prepare the response
    $response = [
      'data' => $data,
      'current_page' => $customers->currentPage(),
      'last_page' => $customers->lastPage(),
    ];

    return response()->json($response);
  }
}
