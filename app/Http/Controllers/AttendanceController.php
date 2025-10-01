<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use App\Models\trans_emponjobs;
use App\Models\trans_clientvisit;
use App\Models\trans_visitlog;
use App\Models\mstlocation;
use Illuminate\Http\Request;
use App\Models\mst_dsrClient;
use App\Models\UserList;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class AttendanceController extends Controller
{
    public function index()
    {

        $userId = session('userinfo')->userId;
        $startDay = Carbon::today()->startOfDay();
        $endDay = Carbon::today()->endOfDay();

        //dd($startDay);

        $userattendance = trans_emponjobs::where('userId_fk', $userId)
            ->whereBetween('jobStartDate', [strtotime($startDay), strtotime($endDay)])
            ->first();


        $dsrattendance = trans_clientvisit::select('checkOutDate')->where('createById_fk', $userId)
            ->whereBetween('checkInDate', [strtotime($startDay), strtotime($endDay)])
            ->orderby('clientVisitId', 'desc')
            ->first();

        //  dd($dsrattendance);

        if ($dsrattendance == null) {

            $dsrattendance2 = mst_dsrClient::select('checkInDate', 'checkOutDate')->where('userId_fk', $userId)
                ->whereBetween('checkInDate', [strtotime($startDay), strtotime($endDay)])
                ->where('status', 1)
                ->orderBy('dsrClientId', 'desc')
                ->first();
        } else {

            $dsrattendance2 = mst_dsrClient::select('checkInDate', 'checkOutDate')->where('userId_fk', $userId)
                ->whereBetween('checkInDate', [strtotime($startDay), strtotime($endDay)])
                ->where('status', 1)
                ->orderBy('dsrClientId', 'desc')
                ->first();
        }


        return view('attendance.index', compact('userattendance', 'dsrattendance', 'dsrattendance2'));
    }

    public function submit(Request $request)
    {
        // Current date and time
        $currentDateTime = Carbon::now();
        $today_date = $currentDateTime->format('d-M-Y H:i:s');
        $visitLogAuthKey = sha1('attendance-checkin' . $currentDateTime->toDateTimeString());
        $meter_reading = $request->meter_reading;

        $meter_reading_upload = null;

        if ($request->hasFile('meter_reading_upload')) {
            $meter_reading_upload = 'checkout-meter-' . time() . '.' . $request->meter_reading_upload->getClientOriginalExtension();
            $request->meter_reading_upload->move(public_path('document'), $meter_reading_upload);
        }



        // Fetch the latitude and longitude from the request
        $latitude = trim($request->latitude);
        $longitude = trim($request->longitude);

        // Google Maps API Key
        $googleAPIKey = env('googleAPIKey');

        // Construct the API URL
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $latitude . ',' . $longitude . '&sensor=false&key=' . $googleAPIKey;

        // Initialize cURL
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // This option disables SSL certificate verification; use cautiously in production.

        // Execute cURL request and fetch response
        $json = curl_exec($ch);

        // Check for cURL errors
        if ($json === false) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return response()->json(['status' => 0, 'error' => 'Failed to fetch location: ' . $error_msg]);
        }

        // Close cURL session
        curl_close($ch);

        // Decode the JSON response
        $data = json_decode($json);

        // Default location area
        $locationArea = '';

        // Check if the API response is OK
        if (!empty($data) && $data->status == "OK") {
            // Extract the address components
            $locationComponents = $data->results[0]->address_components;

            // Construct the location string by combining the components
            $locationArea = implode(', ', array_map(function ($component) {
                return $component->long_name;
            }, $locationComponents));
        }



        // Data to be inserted into the database
        $data = [
            'userId_fk' => session('userinfo')->userId,
            'checkInLocationLatitude' => $latitude,
            'checkInLocationLongitude' => $longitude,
            'checkInLocationArea' => $locationArea, // Set the extracted location area
            'jobStartDate' => strtotime($today_date),
            'meterReading' => $meter_reading,
            'meterReadingImage' => $meter_reading_upload,
            'status' => 1,
        ];

        // Insert data into the database
        $trans_emponjobs = trans_emponjobs::insert($data);

        $datalog = [
            'userId_fk' => session('userinfo')->userId,
            'checkInType' => 'Check In (Attendance)',
            'visitLocation' => $locationArea,
            'visitLatitude' => $latitude,
            'visitLongitude' => $longitude,
            'km' => 0,
            'meterreading_cal' => $meter_reading,
            'visitDate' => strtotime($today_date),
            'visitLogAuthKey' => $visitLogAuthKey,
            'status' => 1

        ];

        $trans_visitlog = trans_visitlog::insert($datalog);

        // Return JSON response based on insertion success
        if ($trans_emponjobs) {
            return response()->json(['status' => 200, 'data' => $today_date, 'address' => $locationArea]);
        } else {
            return response()->json(['status' => 0]);
        }
    }


    public function checkout(Request $request)
    {

        $userId = session('userinfo')->userId;
        $currentDateTime = Carbon::now();
        $visitLogAuthKey = sha1('attendance-checkin' . $currentDateTime->toDateTimeString());

        $latitude = trim($request->latitude);
        $longitude = trim($request->longitude);
        $checkout_meter_reading = $request->checkout_meter_reading;

        $chekout_meter_reading_upload = null;

        if ($request->hasFile('chekout_meter_reading_upload')) {
            $chekout_meter_reading_upload = 'checkout-meter-' . time() . '.' . $request->chekout_meter_reading_upload->getClientOriginalExtension();
            $request->chekout_meter_reading_upload->move(public_path('document'), $chekout_meter_reading_upload);
        }


        $googleAPIKey = env('googleAPIKey');

        $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $latitude . ',' . $longitude . '&sensor=false&key=' . $googleAPIKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $json = curl_exec($ch);

        if ($json === false) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return response()->json(['status' => 0, 'error' => 'Failed to fetch location: ' . $error_msg]);
        }

        curl_close($ch);

        $data = json_decode($json);
        $locationArea = '';

        if (!empty($data) && $data->status == "OK") {
            $locationComponents = $data->results[0]->address_components;

            $locationArea = implode(', ', array_map(function ($component) {
                return $component->long_name;
            }, $locationComponents));
        }

        $currentDateTime = Carbon::now();
        $currentDateTime = $currentDateTime->format('d-M-Y H:i:s');

        $startDay = Carbon::today()->startOfDay();
        $endDay = Carbon::today()->endOfDay();

        $results = trans_emponjobs::where('userId_fk', $userId)
            ->whereBetween('jobStartDate', [strtotime($startDay), strtotime($endDay)])
            ->update(['checkOutLocationLatitude' => $latitude, 'checkOutLocationLongitude' => $longitude, 'checkOutLocationArea' => $locationArea, 'jobExistDate' => strtotime($currentDateTime), 'checkoutmeterReading' => $checkout_meter_reading, 'checkoutmeterReadingImage' => $chekout_meter_reading_upload]);

        $trans_visitlog_data = trans_visitlog::where('userId_fk', $userId)
            ->select('visitLatitude', 'visitLongitude')
            ->whereBetween('visitDate', [strtotime($startDay), strtotime($endDay)])
            ->orderby('visitId', 'desc')
            ->first();


        $km =  calculateDistance($trans_visitlog_data->visitLatitude, $trans_visitlog_data->visitLongitude, $latitude, $longitude);

        $datalog = [
            'userId_fk' => session('userinfo')->userId,
            'checkInType' => 'Check Out (Attendance)',
            'visitLocation' => $locationArea,
            'visitLatitude' => $latitude,
            'visitLongitude' => $longitude,
            'km' => $km,
            'meterreading_cal' => $checkout_meter_reading,
            'visitDate' => strtotime($currentDateTime),
            'visitLogAuthKey' => $visitLogAuthKey,
            'status' => 1
        ];

        $trans_visitlog = trans_visitlog::insert($datalog);

        if ($results) {
            return response()->json(['status' => 200, 'data' => $currentDateTime]);
        } else {
            return response()->json(['status' => 0]);
        }
    }

    public function listdata(Request $req)
    {
        // dd('ddqw');
        $rowCount = $req->input('rowCount');
        $page = $req->input('page');
        $userId = session('userinfo')->userId;
        $data = [];
        $oldtime = '';

        $startDay = Carbon::today()->startOfDay();
        $endDay = Carbon::today()->endOfDay();

        // First query with whereBetween
        $trans_emponjobs = trans_emponjobs::where('userId_fk', $userId)
            ->where('status', 1)
            ->whereBetween('jobStartDate', [strtotime($startDay), strtotime($endDay)])
            ->orderBy('empIdOnJobsId', 'desc')
            ->paginate($rowCount, ['empIdOnJobsId', 'jobStartDate', 'jobExistDate'], 'page', $page);

        foreach ($trans_emponjobs as $key => $val) {

            $start = $val->jobStartDate ? Carbon::parse($val->jobStartDate) : null;
            $end = $val->jobExistDate ? Carbon::parse($val->jobExistDate) : null;
            $duration = '';

            if ($start && $end) {
                $duration = $end->diff($start);
            }

            $formattedDuration = $duration ? $duration->format('%H:%I:%S') : 'N/A';

            $startOfDay = Carbon::createFromTimestamp($val->jobStartDate)->startOfDay();
            $endOfDay = Carbon::createFromTimestamp($val->jobStartDate)->endOfDay();

            $trans_visitlog = trans_visitlog::where('userId_fk', $userId)
                ->whereBetween('visitDate', [strtotime($startOfDay), strtotime($endOfDay)])
                ->sum('km');

            $entry = [
                'jobStartDate' => $val->jobStartDate ? date('H:i:s', $val->jobStartDate) : '',
                'jobExistDate' => $val->jobExistDate ? date('H:i:s', $val->jobExistDate) : '',
                'duration' => $formattedDuration,
                'date' => $val->jobStartDate ? date('d-M-Y', $val->jobStartDate) : '',
                'distance' => $trans_visitlog ? number_format($trans_visitlog, 2) . ' km' : '0 km',
                'empIdOnJobsId' => $val->empIdOnJobsId ?? ''
            ];

            $data[] = $entry;
        }

        // Second query with whereNotBetween
        $trans_emponjobs2 = trans_emponjobs::where('userId_fk', $userId)
            ->where('status', 1)
            ->whereNotBetween('jobStartDate', [strtotime($startDay), strtotime($endDay)])
            ->orderBy('empIdOnJobsId', 'desc')
            ->paginate($rowCount, ['empIdOnJobsId', 'jobStartDate', 'jobExistDate'], 'page', $page);

        foreach ($trans_emponjobs2 as $key => $val) {
            $start = $val->jobStartDate ? Carbon::parse($val->jobStartDate) : null;
            $end = $val->jobExistDate ? Carbon::parse($val->jobExistDate) : null;
            $duration = '';

            if ($end == null) {
                // $startOfDay2 = Carbon::createFromTimestamp($val->jobStartDate)->startOfDay();
                // $endOfDay2 = Carbon::createFromTimestamp($val->jobStartDate)->endOfDay();

                $date = Carbon::createFromTimestamp($val->jobStartDate);
                $startOfDay2 = $date->copy()->startOfDay();
                $endOfDay2 = $date->copy()->endOfDay();

                $trans_visitlog = trans_visitlog::select('visitDate')
                    ->where('userId_fk', $userId)
                    ->whereBetween('visitDate', [strtotime($startOfDay2), strtotime($endOfDay2)])
                    ->orderBy('visitId', 'desc')
                    ->first();

                //dd($trans_visitlog->visitDate);

                // Check if trans_visitlog is not null
                if ($trans_visitlog) {
                    $end = Carbon::parse($trans_visitlog->visitDate)->setTimezone('Asia/Kolkata');
                    $oldtime = $end->format('H:i:s');
                }

                //dd($end);
            }

            if ($start && $end) {
                $duration = $end->diff($start);
            }
            $formattedDuration = $duration ? $duration->format('%H:%I:%S') : 'N/A';

            $startOfDay = Carbon::createFromTimestamp($val->jobStartDate)->startOfDay();
            $endOfDay = Carbon::createFromTimestamp($val->jobStartDate)->endOfDay();

            $trans_visitlog = trans_visitlog::where('userId_fk', $userId)
                ->whereBetween('visitDate', [strtotime($startOfDay), strtotime($endOfDay)])
                ->sum('km');

            $entry = [
                'jobStartDate' => $val->jobStartDate ? date('H:i:s', $val->jobStartDate) : '',
                'jobExistDate' => $val->jobExistDate ? date('H:i:s', $val->jobExistDate) : $oldtime,
                'duration' => $formattedDuration,
                'date' => $val->jobStartDate ? date('d-M-Y', $val->jobStartDate) : '',
                'distance' => $trans_visitlog ? number_format($trans_visitlog, 2) . ' km' : '0 km',
                'empIdOnJobsId' => $val->empIdOnJobsId ?? ''
            ];

            $data[] = $entry;
        }

        return response()->json(['data' => $data]);
    }


    public function daydetail($id)
    {

        $trans_emponjobs = trans_emponjobs::where('empIdOnJobsId', $id)->first();
        if ($trans_emponjobs) {
            $trans_emponjobs = $trans_emponjobs->jobStartDate;
            return view('attendance.daydetails', compact('trans_emponjobs'));
        } else {
            return back()->with('error', 'Invalid Id');
        }
    }

    public function daydetaildata(Request $req)
    {
        $rowCount = $req->input('rowCount');
        $page = $req->input('page');
        $timestamp = $req->input('date');
        $date = Carbon::createFromTimestamp($timestamp);
        $startOfDay = $date->copy()->startOfDay();
        $endOfDay = $date->copy()->endOfDay();
        $userId = session('userinfo')->userId;
        $ckm = 0;
        $cmr = 0;
        $data = [];

        // Retrieve the collection of records
        $trans_visitlog = trans_visitlog::select(
            'trans_visitlog.checkInType',
            'trans_visitlog.visitLocation',
            'trans_visitlog.km',
            'trans_visitlog.meterreading_cal',
            'trans_visitlog.visitDate',
            'mst_customerlist.CustomerName'
        )
            ->leftjoin('trans_clientvisit', 'trans_visitlog.clientvisit_id_fk', '=', 'trans_clientvisit.clientVisitId')
            ->leftjoin('mst_customerlist', 'mst_customerlist.customerId', '=', 'trans_clientvisit.customerId_fk')
            ->where('trans_visitlog.userId_fk', $userId)
            ->whereBetween('trans_visitlog.visitDate', [strtotime($startOfDay), strtotime($endOfDay)])
            ->get();

        Session::put('merter_reading', 0);
        foreach ($trans_visitlog as $key => $visit) {

            $merter_reading = session('merter_reading');

            Session::put('merter_reading', $visit->meterreading_cal);


            if ($key == 0) {
                $km_as_per_meter_mr = 0;
            } else {

                if ($visit->meterreading_cal != 0) {

                    $km_as_per_meter_mr =  $visit->meterreading_cal - $merter_reading;
                } else {

                    //$km_as_per_meter_mr =  $visit->meterreading_cal - $merter_reading;
                    $km_as_per_meter_mr = $merter_reading;
                }
            }

            $cmr += $km_as_per_meter_mr;
            $ckm += $visit->km;
            $entry = [
                'time' => $visit->visitDate ? date('H:i:s', $visit->visitDate) : '',
                'customername' => $visit->CustomerName ? $visit->CustomerName : 'NA',
                'status' => $visit->checkInType ? $visit->checkInType : '',
                'address' => $visit->visitLocation ? $visit->visitLocation : '',
                'km' =>  number_format($visit->km, 2) . ' km',
                'meterreading_cal' =>  number_format($visit->meterreading_cal, 2),
                'ckm' => number_format($ckm, 2) . ' km',
                'cmr' =>  number_format($cmr, 2),
                'km_as_per_meter_mr' =>  number_format($km_as_per_meter_mr, 2),
            ];

            // Append the entry to the data array
            $data[] = $entry;
        }


        return response()->json(['data' => $data]);
    }




    public function attendancesheetexport($from, $to)
    {

        $sheetname = 'attendancename-' . $from . '-to-' . $to . '.xlsx';

        $from = strtotime($from);
        $to = strtotime($to);

        return Excel::download(new AttendanceExport($from, $to), $sheetname);
    }


    public function attendancedatasheetexport(Request $req)
    {

        $from = strtotime($req->fromDate);
        $to = strtotime($req->toDate);


        $fromDate = Carbon::parse($from)->addDay();
        $toDate = Carbon::parse($to)->addDay();

        $users = UserList::select('mst_user_list.*', 'trans_emponjobs.empIdOnJobsId', 'trans_emponjobs.jobStartDate', 'trans_emponjobs.jobExistDate', 'trans_emponjobs.checkInLocationArea', 'trans_emponjobs.checkOutLocationArea')
            ->leftJoin('trans_emponjobs', 'mst_user_list.userId', '=', 'trans_emponjobs.userId_fk')
            // ->whereBetween('trans_emponjobs.jobStartDate', [$this->from, $this->to])
            // ->where('mst_user_list.role_type', 3)
            ->when($fromDate->isSameDay($toDate), function ($query) use ($fromDate) {
                // If 'from' and 'to' dates are the same, filter for that specific day from start to end
                $query->whereBetween('trans_emponjobs.jobStartDate', [strtotime($fromDate->startOfDay()), strtotime($fromDate->endOfDay())]);
            }, function ($query) use ($fromDate,$toDate) {
                // Otherwise, filter between 'from' and 'to' date range
                $query->whereBetween('trans_emponjobs.jobStartDate', [strtotime($fromDate->startOfDay()), strtotime($toDate->endOfDay())]);
            })
            ->where('mst_user_list.staus', 184)
            ->orderby('trans_emponjobs.jobStartDate', 'asc')
            ->get();

      

        foreach ($users as $key => $user) {

            $reportdata =  UserList::select('name', 'emp_code as reporting_manager_code')->where('userId', $user->reporting_head)->first();
            //$region  = getmastermenudatabyid($user->userId);
            $designation_doer = getmastermenudatabyid($user->roleId_fk);

            $state = mstlocation::select('cityName')->where('cityId', $user->state)->first();

            $startOfDay = Carbon::createFromTimestamp($user->jobStartDate)->startOfDay();
            $endOfDay = Carbon::createFromTimestamp($user->jobStartDate)->endOfDay();

            $distancetravelled = trans_visitlog::where('userId_fk', $user->userId)
                ->whereBetween('visitDate', [strtotime($startOfDay), strtotime($endOfDay)])
                ->sum('km');


            $totalvisits = trans_visitlog::select('visitDate')->where('userId_fk', $user->userId)
                ->whereBetween('visitDate', [strtotime($startOfDay), strtotime($endOfDay)])
                ->where('checkInType', 'Check In')
                ->count();

            $firstvisit = trans_visitlog::select('visitDate')->where('userId_fk', $user->userId)
                ->whereBetween('visitDate', [strtotime($startOfDay), strtotime($endOfDay)])
                ->where('checkInType', 'Check In')
                ->orderby('visitId', 'asc')
                ->first();

            $lastvisit = trans_visitlog::select('visitDate')->where('userId_fk', $user->userId)
                ->whereBetween('visitDate', [strtotime($startOfDay), strtotime($endOfDay)])
                ->where('checkInType', 'Check In')
                ->orderby('visitId', 'desc')
                ->first();

            if (!empty($firstvisit->visitDate)) {
                $firstTime = date('H:i', $firstvisit->visitDate); // First visit time
                $firstDateTime = new DateTime($firstTime);
            } else {
                $firstDateTime = null;
            }


            if (!empty($lastvisit->visitDate)) {
                $secondTime = date('H:i', $lastvisit->visitDate); // Second visit time
                $secondDateTime = new DateTime($secondTime);
            } else {
                $secondDateTime = null;
            }

            if ($firstDateTime && $secondDateTime) {
                $interval = $firstDateTime->diff($secondDateTime);
            } else {
                $interval = null;
            }


            if (is_numeric($user->jobStartDate)) {
                // Convert timestamp to DateTime format
                $jobStartDate = (new DateTime())->setTimestamp($user->jobStartDate);
            } else {
                // Assume it's already a datetime string
                $jobStartDate = new DateTime($user->jobStartDate);
            }
            $tenAM = new DateTime($jobStartDate->format('Y-m-d') . ' 10:00:00'); // Set 10:00 AM on the same day

            if ($tenAM  >= $jobStartDate) {
                $Reporting =  "On time";
                $late = 0;
            } else {

                $intervaln = $jobStartDate->diff($tenAM);
                $differenceInMinutes = ($intervaln->h * 60) + $intervaln->i;

                $Reporting =  "Late";
                $late = $differenceInMinutes;
                //echo "Late by {$differenceInMinutes} minutes";
            }

           
            $user['checkOutLocationArea'] = $user->checkOutLocationArea ? $user->checkOutLocationArea : '';
            $user['starttime'] = $user->jobStartDate ?  date('d-m-Y h:i:s  A', $user->jobStartDate) : '';
            $user['endtime'] = $user->jobExistDate ? date('d-m-Y h:i:s  A', $user->jobExistDate) : '';
            $user['reporting_manager'] = $reportdata ? $reportdata['name'] : '';
            $user['day'] = $user->jobStartDate ? date('l', $user->jobStartDate) : '';
            $user['reporting_manager_code'] = $reportdata ? $reportdata['reporting_manager_code'] : '';
            $user['designation_doer'] = $designation_doer ? $designation_doer['name'] : '';
            $user['state'] = $state ? $state['cityName'] : '';
            $user['distancetravelled'] = $distancetravelled ? number_format($distancetravelled, 2) . ' km' : '0 km';
            $user['first_visit'] = $firstvisit && $firstvisit->visitDate ? date('h:i:s A',$firstvisit->visitDate) : '';
            $user['last_visit'] = $lastvisit && $lastvisit->visitDate ? date('h:i:s A', $lastvisit->visitDate) : '';
            $user['first_n_last_visit_diff_h'] =  $interval ? $interval->h : '';
            $user['first_n_last_visit_diff_i'] =  $interval ? $interval->i : '';
            $user['totalvisits'] =  $totalvisits ? $totalvisits : '';
            $user['reporting'] =  $Reporting;
            $user['late'] =  $late;
            $user['jobStartDate'] = $user->jobStartDate ?  date('d-M-Y', $user->jobStartDate) : '';
        }

        return response()->json(['data' => $users]);
    }


    public function attendancedatasheetexportsearch(Request $req){


        $from = strtotime($req->fromDate);
        $to = strtotime($req->toDate);

        $date_range = $req->input('date_range');

        if (!empty($date_range)) {
            $dates = explode(' - ', $date_range);
            $startDate = trim($dates[0]);
            $endDate = trim($dates[1]);

            $fromDate = Carbon::parse($startDate)->startOfDay();

        
            $toDate = Carbon::parse($endDate)->endOfDay();

           
        } else {
            $fromDate = Carbon::parse($from)->startOfDay();
            $toDate = Carbon::parse($to)->endOfDay();
        }

        $query_state = [];

        if (!empty($req->state)) {
            $query_state = mstlocation::whereNull('parentId')
                ->where('cityName', 'like', '%' . $req->state . '%')
                ->pluck('cityId')
                ->toArray();  // Ensure array format
        }




        $users = UserList::select('mst_user_list.*', 'trans_emponjobs.empIdOnJobsId', 'trans_emponjobs.jobStartDate', 'trans_emponjobs.jobExistDate', 'trans_emponjobs.checkInLocationArea', 'trans_emponjobs.checkOutLocationArea')
            ->leftJoin('trans_emponjobs', 'mst_user_list.userId', '=', 'trans_emponjobs.userId_fk')
            ->when($fromDate->isSameDay($toDate), function ($query) use ($fromDate) {
                $query->whereBetween('trans_emponjobs.jobStartDate', [strtotime($fromDate->startOfDay()), strtotime($fromDate->endOfDay())]);
            }, function ($query) use ($fromDate,$toDate) {
                $query->whereBetween('trans_emponjobs.jobStartDate', [strtotime($fromDate->startOfDay()), strtotime($toDate->endOfDay())]);
            })
            ->when($req->filled('employee_name'), function ($query) use ($req) {
                return $query->where('mst_user_list.name', 'LIKE', "%{$req->employee_name}%");
            })->when(!empty($query_state), function ($query) use ($query_state) {
                return $query->whereIn('mst_user_list.state', $query_state);
            })
            ->when($req->filled('employee_code'), function ($query) use ($req) {
                return $query->where('mst_user_list.emp_code', 'LIKE', "%{$req->employee_code}%");
            })
            ->when($req->filled('employee_email'), function ($query) use ($req) {
                return $query->where('mst_user_list.emailAddress', 'LIKE', "%{$req->employee_email}%");
            })
            ->when($req->filled('employee_phone'), function ($query) use ($req) {
                return $query->where('mst_user_list.loginId', 'LIKE', "%{$req->employee_phone}%");
            })
            ->where('mst_user_list.staus', 184)
            ->orderby('trans_emponjobs.jobStartDate', 'asc')
            ->get();

      

        foreach ($users as $key => $user) {

            $reportdata =  UserList::select('name', 'emp_code as reporting_manager_code')->where('userId', $user->reporting_head)->first();
            //$region  = getmastermenudatabyid($user->userId);
            $designation_doer = getmastermenudatabyid($user->roleId_fk);

            $state = mstlocation::select('cityName')->where('cityId', $user->state)->first();

            $startOfDay = Carbon::createFromTimestamp($user->jobStartDate)->startOfDay();
            $endOfDay = Carbon::createFromTimestamp($user->jobStartDate)->endOfDay();

            $distancetravelled = trans_visitlog::where('userId_fk', $user->userId)
                ->whereBetween('visitDate', [strtotime($startOfDay), strtotime($endOfDay)])
                ->sum('km');


            $totalvisits = trans_visitlog::select('visitDate')->where('userId_fk', $user->userId)
                ->whereBetween('visitDate', [strtotime($startOfDay), strtotime($endOfDay)])
                ->where('checkInType', 'Check In')
                ->count();

            $firstvisit = trans_visitlog::select('visitDate')->where('userId_fk', $user->userId)
                ->whereBetween('visitDate', [strtotime($startOfDay), strtotime($endOfDay)])
                ->where('checkInType', 'Check In')
                ->orderby('visitId', 'asc')
                ->first();

            $lastvisit = trans_visitlog::select('visitDate')->where('userId_fk', $user->userId)
                ->whereBetween('visitDate', [strtotime($startOfDay), strtotime($endOfDay)])
                ->where('checkInType', 'Check In')
                ->orderby('visitId', 'desc')
                ->first();

            if (!empty($firstvisit->visitDate)) {
                $firstTime = date('H:i', $firstvisit->visitDate); // First visit time
                $firstDateTime = new DateTime($firstTime);
            } else {
                $firstDateTime = null;
            }


            if (!empty($lastvisit->visitDate)) {
                $secondTime = date('H:i', $lastvisit->visitDate); // Second visit time
                $secondDateTime = new DateTime($secondTime);
            } else {
                $secondDateTime = null;
            }

            if ($firstDateTime && $secondDateTime) {
                $interval = $firstDateTime->diff($secondDateTime);
            } else {
                $interval = null;
            }


            if (is_numeric($user->jobStartDate)) {
                // Convert timestamp to DateTime format
                $jobStartDate = (new DateTime())->setTimestamp($user->jobStartDate);
            } else {
                // Assume it's already a datetime string
                $jobStartDate = new DateTime($user->jobStartDate);
            }
            $tenAM = new DateTime($jobStartDate->format('Y-m-d') . ' 10:00:00'); // Set 10:00 AM on the same day

            if ($tenAM  >= $jobStartDate) {
                $Reporting =  "On time";
                $late = 0;
            } else {

                $intervaln = $jobStartDate->diff($tenAM);
                $differenceInMinutes = ($intervaln->h * 60) + $intervaln->i;

                $Reporting =  "Late";
                $late = $differenceInMinutes;
                //echo "Late by {$differenceInMinutes} minutes";
            }

           
            $user['checkOutLocationArea'] = $user->checkOutLocationArea ? $user->checkOutLocationArea : '';
            $user['starttime'] = $user->jobStartDate ?  date('d-m-Y h:i:s  A', $user->jobStartDate) : '';
            $user['endtime'] = $user->jobExistDate ? date('d-m-Y h:i:s  A', $user->jobExistDate) : '';
            $user['reporting_manager'] = $reportdata ? $reportdata['name'] : '';
            $user['day'] = $user->jobStartDate ? date('l', $user->jobStartDate) : '';
            $user['reporting_manager_code'] = $reportdata ? $reportdata['reporting_manager_code'] : '';
            $user['designation_doer'] = $designation_doer ? $designation_doer['name'] : '';
            $user['state'] = $state ? $state['cityName'] : '';
            $user['distancetravelled'] = $distancetravelled ? number_format($distancetravelled, 2) . ' km' : '0 km';
            $user['first_visit'] = $firstvisit && $firstvisit->visitDate ? date('h:i:s A',$firstvisit->visitDate) : '';
            $user['last_visit'] = $lastvisit && $lastvisit->visitDate ? date('h:i:s A', $lastvisit->visitDate) : '';
            $user['first_n_last_visit_diff_h'] =  $interval ? $interval->h : '';
            $user['first_n_last_visit_diff_i'] =  $interval ? $interval->i : '';
            $user['totalvisits'] =  $totalvisits ? $totalvisits : '';
            $user['reporting'] =  $Reporting;
            $user['late'] =  $late;
            $user['jobStartDate'] = $user->jobStartDate ?  date('d-M-Y', $user->jobStartDate) : '';
        }

        return response()->json(['data' => $users]);



    }
}
