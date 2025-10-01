<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\UserList;
use App\Models\mstlocation;
use App\Models\trans_salestarget;
use App\Models\trans_salesBankInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends BaseController
{
    //

    public function index()
    {

        return view('user.addusers');
    }

    public function userformsubmit(Request $req)
    {

        DB::beginTransaction();

        try {
            $currentDateTime = now();
            $dataEntrydate = strtotime($currentDateTime->toDateTimeString());
            $bankAuthKey = sha1($req->customer_name . '' . $currentDateTime->toDateTimeString());
            $userAuthKey = sha1($req->name . '' . $currentDateTime->toDateTimeString());
            $nextEmpCode = $req->empcode;
            $name = $req->name;
            $mobile_no = $req->mobile_no;
            $alternate_mobile_no = $req->alternate_mobile_no;
            $email_id = $req->email_id;
            $role_type = $req->role_type;
            $role = $req->role;
            $statename = $req->statename;
            $city_id = $req->city_id;
            $password = Hash::make($req->password);
            $address = $req->address;
            $dob = $req->dob;
            $doa = $req->doa;
            $education = $req->education;
            $reporting_head = $req->reporting_head;
            $job_experence = $req->job_experence;
            $select_bank = $req->select_bank;
            $account_no = $req->account_no;
            $account_holder_name = $req->account_holder_name;
            $ifsc_code = $req->ifsc_code;
            $adahar_number = $req->adahar_number;
            $pan_number = $req->pan_number;
            $user_status = $req->user_status;
            $profileImage22 = '';
            $filename = '';
            $filename2 = '';
            $filename3 = '';



            /**** emp code auto generate code start here  ****/
            // $maxEmpCode = UserList::selectRaw('MAX(CAST(SUBSTRING(emp_code, 2) AS UNSIGNED)) as max_code')
            //                 ->first()
            //                 ->max_code;
            // $nextEmpCode = 'VO'.$maxEmpCode + 1;
            //dd($nextEmpCode);
            /**** emp code auto generate code end here  ****/


            if ($req->hasFile('profileimage')) {
                $profileimage = $req->file('profileimage');
                $profileImage22 = 'pro_' . time() . '.' . $profileimage->getClientOriginalExtension();
                $req->profileimage->move(public_path('profile_image'), $profileImage22);
            }

            if ($req->hasFile('adahar_front_image')) {
                $adaharFrontImage = $req->file('adahar_front_image');
                $filename = 'ADHRF_' . time() . '.' . $adaharFrontImage->getClientOriginalExtension();
                $req->adahar_front_image->move(public_path('document'), $filename);
            }

            if ($req->hasFile('adahar_back_image')) {
                $adaharBackImage = $req->file('adahar_back_image');
                $filename2 = 'ADHRB_' . time() . '.' . $adaharBackImage->getClientOriginalExtension();
                $req->adahar_back_image->move(public_path('document'), $filename2);
            }

            if ($req->hasFile('pan_card_image')) {
                $pan_card_image = $req->file('pan_card_image');
                $filename3 = 'PAN_' . time() . '.' . $pan_card_image->getClientOriginalExtension();
                $req->pan_card_image->move(public_path('document'), $filename3);
            }

            $data = [
                'emp_code' => $nextEmpCode,
                'role_type' => $role_type,
                'roleId_fk' => $role,
                'name' => $name,
                'password' => $password,
                'loginId' => $mobile_no,
                'state' => $statename,
                'city' => $city_id,
                'address' => $address,
                'emailAddress' => $email_id,
                'profileImage' => $profileImage22,
                'mobileNumber' => $mobile_no,
                'alertnetNumber' => $alternate_mobile_no,
                'dob' => strtotime($dob),
                'doa' => strtotime($doa),
                'aadhar_number' => $adahar_number,
                'education' => $education,
                'pan_number' => $pan_number,
                'aadhar_imageFront' => $filename,
                'aadharBackImage' => $filename2,
                'pancardImage' => $filename3,
                'job_experience' => $job_experence,
                'reporting_head' => $reporting_head,
                'joinDate' => $dataEntrydate,
                'userAuthKey' => $userAuthKey,
                'staus' => $user_status,
            ];

            $useradd = UserList::create($data);
            $userId = $useradd->userId;

            $trans_salesBankInfo = [
                'userId_fk' => $userId,
                'bankId_fk' => $select_bank,
                'accountHolder' => $account_holder_name,
                'accountNo' => $account_no,
                'ifscCode' => $ifsc_code,
                'dataEntryDate' => $dataEntrydate,
                'bankAuthKey' => $bankAuthKey,
                'status' => 1,

            ];
            $trans_salesBankInfo = trans_salesBankInfo::create($trans_salesBankInfo);

            DB::commit();

            $msg = $useradd ? 'Data Insert Successfully' : 'Data Not Insert Successfully';
            $resp = $useradd ? 1 : 2;
            return response()->json(['resp' => $resp, 'msg' => $msg]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function userlist()
    {
        return view('user.userlist');
    }

    public function useredit($id)
    {

        $userlist = UserList::where('userAuthKey', $id)->first();
        $user_Id = $userlist->userId;
        $trans_salesBankInfo = trans_salesBankInfo::where('userId_fk', $user_Id)->first();

        return view('user.useredit', compact('userlist', 'trans_salesBankInfo'));
    }

    public function listdata(Request $req)
    {
        $rowCount = $req->input('rowCount');
        $page = $req->input('page');

        $userlist = UserList::where('staus', '!=', 0)->orderBy('userId', 'desc')
            ->paginate($rowCount, ['*'], 'page', $page);
        $data = [];

        foreach ($userlist as $key => $val) {
            $startDate = '';
            $endDate = '';
            $state  = getlocationdatabyid($val->state);
            $city  = getlocationdatabyid($val->city);

            if ($val->staus  == '184') {

                $status = 'Active';
            } else {
                $status = 'Inactive';
            }
            $entry = [
                'userId' => $val->userId,
                'emp_code' => $val->emp_code ? $val->emp_code : '',
                'name' =>  $val->name,
                'mobileNumber' => $val->mobileNumber,
                'loginId' => $val->loginId,
                'emailAddress' => $val->emailAddress ?? '',
                'city' => $city->cityName ?? '',
                'state' => $state->cityName ?? '',
                'address' => $val->address ?? '',
                'status' => $status,
                'userAuthKey' => $val->userAuthKey,
            ];

            $data[] = $entry;
        }

        $response = [
            'data' => $data,
            'current_page' => $userlist->currentPage(),
            'last_page' => $userlist->lastPage()
        ];


        return response()->json($response);
    }

    public function userdelete($id)
    {
        DB::beginTransaction();
        try {
            trans_salesBankInfo::where('userId_fk', $id)->update(['status' => 0]);
            $userlist = UserList::where('userId', $id)->update(['staus' => 0]);
            // dd('dwefw');


            if ($userlist) {
                DB::commit();
                return 1;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete related data. Please try again.');
        }
    }


    public function editsubmit(Request $req)
    {
        DB::beginTransaction();
        try {
            // dd($req);
            $currentDateTime = now();
            $dataEntrydate = strtotime($currentDateTime->toDateTimeString());
            $bankAuthKey = sha1($req->customer_name . '' . $currentDateTime->toDateTimeString());
            $userAuthKey = sha1($req->name . '' . $currentDateTime->toDateTimeString());
            $empcode = $req->empcode;
            $name = $req->name;
            $mobile_no = $req->mobile_no;
            $alternate_mobile_no = $req->alternate_mobile_no;
            $email_id = $req->email_id;
            $role_type = $req->role_type;
            $role = $req->role;
            $statename = $req->statename;
            $city_id = $req->city_id;
            $password = Hash::make($req->password);
            $address = $req->address;
            $dob = $req->dob;
            $doa = $req->doa;
            $education = $req->education;
            $reporting_head = $req->reporting_head;
            $job_experence = $req->job_experence;
            $select_bank = $req->select_bank;
            $account_no = $req->account_no;
            $account_holder_name = $req->account_holder_name;
            $ifsc_code = $req->ifsc_code;
            $adahar_number = $req->adahar_number;
            $pan_number = $req->pan_number;
            $profile_img_old = $req->profile_img_old;
            $currentuserid = $req->currentuserid;
            $pancardImage_old = $req->pancardImage_old;
            $aadharBackImage_old = $req->aadharBackImage_old;
            $aadhar_imageFront_old = $req->aadhar_imageFront_old;
            $user_status = $req->user_status;


            if ($req->hasFile('profileimage')) {
                $profileimage = $req->file('profileimage');
                $profileImage22 = 'pro_' . time() . '.' . $profileimage->getClientOriginalExtension();
                $req->profileimage->move(public_path('profile_image'), $profileImage22);
            } else {

                $profileImage22 = $profile_img_old;
            }

            if ($req->hasFile('adahar_front_image')) {
                $adaharFrontImage = $req->file('adahar_front_image');
                $filename = 'ADHRF_' . time() . '.' . $adaharFrontImage->getClientOriginalExtension();
                $req->adahar_front_image->move(public_path('document'), $filename);
            } else {

                $filename = $aadhar_imageFront_old;
            }

            if ($req->hasFile('adahar_back_image')) {
                $adaharBackImage = $req->file('adahar_back_image');
                $filename2 = 'ADHRB_' . time() . '.' . $adaharBackImage->getClientOriginalExtension();
                $req->adahar_back_image->move(public_path('document'), $filename2);
            } else {
                $filename2 = $aadharBackImage_old;
            }

            if ($req->hasFile('pan_card_image')) {
                $pan_card_image = $req->file('pan_card_image');
                $filename3 = 'PAN_' . time() . '.' . $pan_card_image->getClientOriginalExtension();
                $req->pan_card_image->move(public_path('document'), $filename3);
            } else {
                $filename3 = $pancardImage_old;
            }

            $data = [
                'role_type' => $role_type,
                'roleId_fk' => $role,
                'emp_code' => $empcode,
                'name' => $name,
                'loginId' => $mobile_no,
                'state' => $statename,
                'city' => $city_id,
                'address' => $address,
                'emailAddress' => $email_id,
                'profileImage' => $profileImage22,
                'mobileNumber' => $mobile_no,
                'alertnetNumber' => $alternate_mobile_no,
                'dob' => strtotime($dob),
                'doa' => strtotime($doa),
                'aadhar_number' => $adahar_number,
                'education' => $education,
                'pan_number' => $pan_number,
                'aadhar_imageFront' => $filename,
                'aadharBackImage' => $filename2,
                'pancardImage' => $filename3,
                'job_experience' => $job_experence,
                'reporting_head' => $reporting_head,
                'joinDate' => $dataEntrydate,
                'staus' => $user_status,
                //'userAuthKey' => $userAuthKey,
                //'staus' => 1,
            ];

            if (!empty($req->password)) {
                $data['password'] = $password;
            }

            // dd($data);

            $userdata = UserList::find($currentuserid);
            $userdata->update($data);
            trans_salesBankInfo::where('userId_fk', $currentuserid)->delete();

            $trans_salesBankInfo = [
                'userId_fk' => $currentuserid,
                'bankId_fk' => $select_bank,
                'accountHolder' => $account_holder_name,
                'accountNo' => $account_no,
                'ifscCode' => $ifsc_code,
                'dataEntryDate' => $dataEntrydate,
                'bankAuthKey' => $bankAuthKey,
                'status' => 1,
            ];

            $trans_salesBankInfo = trans_salesBankInfo::create($trans_salesBankInfo);
            DB::commit();

            $msg = $useradd ? 'Data Edit Successfully' : 'Data Not Edit Successfully';
            $resp = $useradd ? 1 : 2;
            return response()->json(['resp' => $resp, 'msg' => $msg]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function usersearch(Request $req)
    {
        $rowCount = $req->input('rowCount');
        $page = $req->input('page');
        $user_name = $req->input('user_name');
        $email_id = $req->input('email_id');
        $emp_code = $req->input('emp_code');
        $phone_no = $req->input('phone_no');
        $address = $req->input('address');
        $state_city = $req->input('state_city');
        $status = $req->input('status');

        if (!empty($state_city)) {
            $query_cat =  mstlocation::where('cityName', 'like', '%' . $state_city . '%')->pluck('cityId');
        }

        $mystatus = stripos($status, 'active') !== false ? '184' : '185';

        $query = UserList::where('staus', '!=', 0)
            ->select('name', 'emailAddress', 'emp_code', 'loginId', 'address', 'userId', 'state', 'city', 'userAuthKey','staus')
            ->orderBy('userId', 'asc');

        if (!empty($emp_code)) {
            $query->where('emp_code', 'like', '%' . $emp_code . '%');
        }

        if (!empty($user_name)) {
            $query->where('name', 'like', '%' . $user_name . '%');
        }

        if (!empty($email_id)) {
            $query->where('emailAddress', 'like', '%' . $email_id . '%');
        }

        if (!empty($address)) {
            $query->where('address', 'like', '%' . $address . '%');
        }

        if (!empty($phone_no)) {
            $query->where('loginId', 'like', '%' . $phone_no . '%');
        }

        if (!empty($query_cat) && $query_cat->isNotEmpty()) {
            $query->where(function ($q) use ($query_cat) {
                $q->whereIn('state', $query_cat)
                    ->orWhereIn('city', $query_cat);
            });
        }


        if (!empty($status)) {

            $query->where('staus', $mystatus);
        }

        $query->orderby('userId', 'desc');
        $userlist = $query->paginate($rowCount, ['*'], 'page', $page);

        $data = [];

        foreach ($userlist as $key => $val) {

            $startDate = '';
            $endDate = '';
            $state  = getlocationdatabyid($val->state);
            $city  = getlocationdatabyid($val->city);

            $status = ($val->staus == '184') ? 'Active' : 'Inactive';

            $entry = [
                'userId' => $val->userId,
                'emp_code' => $val->emp_code,
                'name' =>  $val->name,
                'mobileNumber' => $val->loginId,
                'loginId' => $val->loginId,
                'emailAddress' => $val->emailAddress ?? '',
                'city' => $city->cityName ?? '',
                'state' => $state->cityName ?? '',
                'address' => $val->address,
                'status' => $status,
                'userAuthKey' => $val->userAuthKey,
            ];

            $data[] = $entry;
        }

        $response = [
            'data' => $data,
            'current_page' => $userlist->currentPage(),
            'last_page' => $userlist->lastPage()
        ];

        return response()->json($response);
    }

    public function usertarget()
    {

        $sales_master = $this->masterdata_salesuser[0]['masterDataId'];
        $salespersons = UserList::where('role_type', $sales_master)->get();
        $trans_targets_data = [];

        $latestMonthYear = trans_salestarget::select(DB::raw("monthYear"))
            ->where('status', '1')
            ->orderBy('salesTargetId', 'desc')
            ->orderByRaw("FIELD(monthNm, 'Dec', 'Nov', 'Oct', 'Sep', 'Aug', 'Jul', 'Jun', 'May', 'Apr', 'Mar', 'Feb', 'Jan')")
            ->first();

        //dd($latestMonthYear->monthYear);
        // echo $latestMonthYear->monthYear;
        // die();


        if ($latestMonthYear) {
            $latestMonthYear = $latestMonthYear->monthYear;
            $trans_targets_data = trans_salestarget::where(DB::raw("CONCAT(monthNm, '-', yearNo)"), $latestMonthYear)
                ->where('status', 1)
                ->get();
        }

        return view('user.addtarget', compact('salespersons', 'trans_targets_data', 'latestMonthYear'));
    }

    public function targetappend()
    {

        $sales_master = $this->masterdata_salesuser[0]['masterDataId'];
        $salespersons = UserList::where('role_type', $sales_master)->get();

        $options = '<option value=""> Select User </option>';
        foreach ($salespersons as $key => $sales) {
            $options .= '<option value="' . $sales->userId . '">' . $sales->name . '</option>';
        }


        $html = '<tr>
                                        <td class="w-100px">
                                            <select class="form-select form-select-sm" name="name1"
                                                data-control="select2"
                                                data-placeholder=" ">' . $options . '/select>
                                        </td>
                                        <td class="w-100px">
                                        <select class="form-select form-select-sm" name="name2"
                                                data-control="select2"
                                                data-placeholder=" ">' . $options . '/select>
                                        </td>
                                        <td class="w-100px">
                                           <select class="form-select form-select-sm" name="name3"
                                                data-control="select2"
                                                data-placeholder=" ">' . $options . '/select>
                                        </td>
                                        <td class="w-100px">
                                           <select class="form-select form-select-sm" name="name4"
                                                data-control="select2"
                                                data-placeholder=" ">' . $options . '/select>
                                        </td>
                                        <td class="w-100px text-center">
                                            <div  class="d-flex">
                                                <input type="text" name="jan_pri"
                                                            class="form-control fm-new mr-new">
                                                <input type="text" name="jan_sec"
                                                            class="form-control fm-new">
                                               
                                                            <div class="delt"><i class="fa fa-trash text-danger removetr"></i></div>
                                            </div>
                                        </td>
                                       
                                    </tr>';

        return $html;
    }

    public function targetsubmit(Request $req)
    {
        $currentDateTime = now();
        $dataEntryDate = strtotime($currentDateTime->toDateTimeString());
        $trans_salestargetinsert = false;

        foreach ($req->data as $key => $value) {

            $yearandmonth = explode("-", $value['year']);
            $month = $yearandmonth[0];
            $year = $yearandmonth[1];

            // Fetch existing records
            $trans_salestarget = trans_salestarget::where('yearNo', $year)
                ->where('monthNm', $month)
                ->where('sales_userId_fk', $value['name1'])
                ->orderby('salesTargetId', 'desc')
                ->get();

            if (!$trans_salestarget->isEmpty()) {
                // If records are found, delete them
                trans_salestarget::where('yearNo', $year)
                    ->where('monthNm', $month)
                    ->where('sales_userId_fk', $value['name1'])
                    ->delete();
            }

            // Insert new record
            $insert = [
                'sales_userId_fk' => $value['name1'],
                'areaHead_userId_fk' => $value['name2'],
                'stateHead_userId_fk' => $value['name3'],
                'nationalHead_userId_fk' => $value['name4'],
                'primaryTarget' => $value['jan_pri'],
                'secondaryTarget' => $value['jan_sec'],
                'monthNm' => $month,
                'yearNo' => $year,
                'monthYear' => $value['year'],
                'dataEntryDate' => $dataEntryDate,
                'salesTargetAuthKey' => sha1($month . $value['name1'] . $currentDateTime->toDateTimeString()),
                'status' => 1
            ];

            $trans_salestargetinsert = trans_salestarget::insert($insert);
        }

        // Check if insertion was successful
        if ($trans_salestargetinsert) {
            $msg = 1;
        } else {
            $msg = 0;
        }

        return $msg;
    }

    public function targetlist()
    {


        $trans_salestarget = trans_salestarget::select(
            'sales_userId_fk',
            DB::raw('MAX(areaHead_userId_fk) as areaHead_userId_fk'),
            DB::raw('MAX(stateHead_userId_fk) as stateHead_userId_fk'),
            DB::raw('MAX(nationalHead_userId_fk) as nationalHead_userId_fk')
        )
            ->where('status', 1)
            ->groupBy('sales_userId_fk')
            ->get();


        $html = '';
        $html2 = '';

        $trans_salestargetArray = $trans_salestarget->toArray();
        $lastKey = array_key_last($trans_salestargetArray);



        $monthYearTotals = [];
        foreach ($trans_salestarget as $key => $val) {


            $name1 = '';
            $name2 = '';
            $name3 = '';
            $name4 = '';

            if ($val->sales_userId_fk != '') {
                $name1 = salesuserdata($val->sales_userId_fk);
            } else {
                $name1 = 'NA';
            }

            if ($val->areaHead_userId_fk != '') {
                $name2 = salesuserdata($val->areaHead_userId_fk);
            } else {
                $name2 = 'NA';
            }


            if ($val->stateHead_userId_fk != '') {
                $name3 = salesuserdata($val->stateHead_userId_fk);
            } else {
                $name3 = 'NA';
            }

            if ($val->nationalHead_userId_fk != '') {
                $name4 = salesuserdata($val->nationalHead_userId_fk);
            } else {
                $name4 = 'NA';
            }

            $trans_targets = trans_salestarget::select(
                DB::raw("CONCAT(monthNm, '-', yearNo) as monthYear"),
                'monthNm',
                'yearNo'
            )
                ->where('status', '1')
                ->groupBy('monthYear', 'monthNm', 'yearNo')
                ->orderBy('yearNo')
                ->orderByRaw("FIELD(monthNm, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec') ASC")
                ->get();

            $html .= '<tr>
            <td class="w-50px text-center"><span  class="salesuserid" data-id="' . $val->sales_userId_fk . '"><i class="fa fa-trash text-danger" aria-hidden="true"></i></span></td>
                 <td class="w-100px">' . $name1 . '</td>
                 <td class="w-100px">' . $name2 . '</td>
                 <td class="w-100px">' . $name3 . '</td>
                 <td class="w-100px">' . $name4 . '</td>';



            foreach ($trans_targets as $target) {

                $monthYear = $target->monthNm . '-' . $target->yearNo;


                $checkdata = trans_salestarget::where('sales_userId_fk', $val->sales_userId_fk)
                    ->where('monthNm', $target->monthNm)
                    ->where('yearNo', $target->yearNo)
                    ->count();

                if ($checkdata == 0) {
                    $html .= '<td class="w-100px text-center"></td>';
                } else {

                    $primaryVal = primarytarget($val->sales_userId_fk, $target->monthNm, $target->yearNo);
                    $secondaryVal = secondarytarget($val->sales_userId_fk, $target->monthNm, $target->yearNo);


                    if (array_key_exists($monthYear, $monthYearTotals)) {
                        $monthYearTotals[$monthYear]['primary'] += $primaryVal;
                        $monthYearTotals[$monthYear]['secondary'] += $secondaryVal;
                    } else {
                        // If it doesn't exist, add the monthYear and initialize the values
                        $monthYearTotals[$monthYear] = [
                            'primary' => $primaryVal,
                            'secondary' => $secondaryVal
                        ];
                    }


                    $html .= '<td class="w-100px text-center">
                                     <div class="row">
                                         <div class="col-6">' . moneyFormatIndia(primarytarget($val->sales_userId_fk, $target->monthNm, $target->yearNo)) . '</div>
                                         <div class="col-6">' . moneyFormatIndia(secondarytarget($val->sales_userId_fk, $target->monthNm, $target->yearNo)) . '</div>
 
                                     </div>
                                 </td>';
                }
            }

            $html .= '</tr>';
        }

        foreach ($monthYearTotals as $monthYear => $totals) {

            $html2 .= '<th class="w-150px">
                            <span class="salestrash" data-id="' . $monthYear . '" ><i class="fa fa-trash text-danger" aria-hidden="true"></i></span>
                             <p class="text-center">' . $monthYear . '</p>
                             <div class="row">
                                 <div class="col-6 text-center">Primary <br> (' . moneyFormatIndia($totals['primary']) . ') </div>
                                 <div class="col-6 text-center">Secondary <br> (' . moneyFormatIndia($totals['secondary']) . ')</div>
                             </div>
                         </th>';
        }

        if ($html == '') {

            $html  = '<tr>
                                <td class="text-center" colspan="5"> No Data Found </td>
                      </tr>';
        }

        return view('user.targetlist', compact('html', 'html2'));
    }


    function checktarget(Request $req)
    {

        $year = $req->year;

        $trans_salestarget = trans_salestarget::where('monthYear', $year)->where('status', 1)->get();

        return $trans_salestarget;
    }

    public function checkempcode(Request $req)
    {

        $empcode = $req->empcode;

        $users = UserList::where('emp_code', $empcode)->count();

        return response(['count' => $users]);
    }

    public function usertargetsearch(Request $req)
    {

        // $rowCount = $req->input('rowCount');
        // $page = $req->input('page');
        $sales_person = $req->input('sales_person');
        $reporting_01 = $req->input('reporting_01');
        $reporting_02 = $req->input('reporting_02');
        $reporting_03 = $req->input('reporting_03');


        $query = trans_salestarget::select(
            'sales_userId_fk',
            DB::raw('MAX(areaHead_userId_fk) as areaHead_userId_fk'),
            DB::raw('MAX(stateHead_userId_fk) as stateHead_userId_fk'),
            DB::raw('MAX(nationalHead_userId_fk) as nationalHead_userId_fk')
        )
            ->where('status', 1)
            ->groupBy('sales_userId_fk');

        if (!empty($sales_person)) {

            $UserList =  UserList::where('name', 'like', '%' . $sales_person . '%')
                ->pluck('userId')
                ->implode(',');

            $query_salesIdArray = explode(',', $UserList);
            $query->whereIN('sales_userId_fk', $query_salesIdArray);
        }

        if (!empty($reporting_01)) {

            $UserList01 =  UserList::where('name', 'like', '%' . $reporting_01 . '%')
                ->pluck('userId')
                ->implode(',');

            $query_repo_01Array = explode(',', $UserList01);

            $query->whereIN('areaHead_userId_fk', $query_repo_01Array);
        }

        if (!empty($reporting_02)) {

            $UserList02 =  UserList::where('name', 'like', '%' . $reporting_02 . '%')
                ->pluck('userId')
                ->implode(',');

            $query_repo_02Array = explode(',', $UserList02);

            $query->whereIN('stateHead_userId_fk', $query_repo_02Array);
        }

        if (!empty($reporting_03)) {

            $UserList03 =  UserList::where('name', 'like', '%' . $reporting_03 . '%')
                ->pluck('userId')
                ->implode(',');

            $query_repo_03Array = explode(',', $UserList03);

            $query->whereIN('nationalHead_userId_fk', $query_repo_03Array);
        }


        $queryResults = $query->get();


        $html = '';
        $html2 = '';

        $trans_salestargetArray = $queryResults->toArray();
        $lastKey = array_key_last($trans_salestargetArray);


        $addedMonthYear = [];

        ///dd($queryResults);

        foreach ($queryResults as $key => $val) {


            $name1 = '';
            $name2 = '';
            $name3 = '';
            $name4 = '';

            if ($val->sales_userId_fk != '') {
                $name1 = salesuserdata($val->sales_userId_fk);
            } else {
                $name1 = 'NA';
            }

            if ($val->areaHead_userId_fk != '') {
                $name2 = salesuserdata($val->areaHead_userId_fk);
            } else {
                $name2 = 'NA';
            }


            if ($val->stateHead_userId_fk != '') {
                $name3 = salesuserdata($val->stateHead_userId_fk);
            } else {
                $name3 = 'NA';
            }

            if ($val->nationalHead_userId_fk != '') {
                $name4 = salesuserdata($val->nationalHead_userId_fk);
            } else {
                $name4 = 'NA';
            }

            $trans_targets = trans_salestarget::select(
                DB::raw("CONCAT(monthNm, '-', yearNo) as monthYear"),
                'monthNm',
                'yearNo'
            )
                ->where('status', '1')
                ->groupBy('monthYear', 'monthNm', 'yearNo')
                ->orderBy('yearNo')
                ->orderByRaw("FIELD(monthNm, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec') ASC")
                ->get();

            $html .= '<tr>
            <td class="w-50px text-center"><span  class="salesuserid" data-id="' . $val->sales_userId_fk . '"><i class="fa fa-trash text-danger" aria-hidden="true"></i></span></td>
                 <td class="w-100px">' . $name1 . '</td>
                 <td class="w-100px">' . $name2 . '</td>
                 <td class="w-100px">' . $name3 . '</td>
                 <td class="w-100px">' . $name4 . '</td>';

            foreach ($trans_targets as $target) {

                $monthYear = $target->monthNm . '-' . $target->yearNo;

                if (!in_array($monthYear, $addedMonthYear)) {
                    $addedMonthYear[] = $monthYear;
                }
                $checkdata = trans_salestarget::where('sales_userId_fk', $val->sales_userId_fk)
                    ->where('monthNm', $target->monthNm)
                    ->where('yearNo', $target->yearNo)
                    ->count();

                if ($checkdata == 0) {
                    $html .= '<td class="w-100px text-center"></td>';
                } else {

                    $html .= '<td class="w-100px text-center">
                                     <div class="row">
                                         <div class="col-6">' . number_format(primarytarget($val->sales_userId_fk, $target->monthNm, $target->yearNo)) . '</div>
                                         <div class="col-6">' . number_format(secondarytarget($val->sales_userId_fk, $target->monthNm, $target->yearNo)) . '</div>
                                     </div>
                                 </td>';
                }
            }

            $html .= '</tr>';

            //dd($html);
        }


        foreach ($addedMonthYear as $key => $val2) {

            $html2 .= '<th class="w-150px">
                             <p class="text-center">' . $val2 . '</p>
                             <div class="row">
                                 <div class="col-6 text-center">Primary </div>
                                 <div class="col-6 text-center">Secondary </div>
                             </div>
                         </th>';
        }

        if ($html == '') {

            $html  = '<tr>
                                <td class="text-center" colspan="4"> No Data Found </td>
                      </tr>';
        }



        return $html;
    }


    public function usertargetdelete(Request $request)
    {

        $datemon = $request->datemon;
        $type = $request->type;

        $trans_salestargetQuery = trans_salestarget::query();
        if ($type == 'month') {
            $trans_salestargetQuery->where('monthYear', $datemon);
        }
        if ($type == 'userid') {
            $trans_salestargetQuery->where('sales_userId_fk', $datemon);
        }
        $trans_salestarget = $trans_salestargetQuery->update(['status' => 0]);


        if ($trans_salestarget) {
            return response(['status' => 1]);
        } else {
            return response(['status' => 0]);
        }
    }
}
