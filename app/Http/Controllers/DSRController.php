<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http; // Add this line
use App\Models\trans_clientvisit;
use App\Models\trans_visitlog;
use App\Models\trans_emponjobs;
use App\Models\mst_dsrClient;
use App\Models\UserList;
use App\Models\mstlocation;
use App\Models\mstcustomerlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\AttendanceDetailExport;
use Maatwebsite\Excel\Facades\Excel;

class DSRController extends Controller
{
    public function index()
    {

        $userId = session('userinfo')->userId;
        $sumkm = '0 km';

        $currentDateTime = Carbon::now();
        $startDay = Carbon::today()->startOfDay();
        $endDay = Carbon::today()->endOfDay();


        $mst_dsrClient = mst_dsrClient::where('userId_fk', $userId)
            ->pluck('name')
            ->unique();

        //dd($mst_dsrClient);

        $trans_emponjobs = trans_emponjobs::select('jobExistDate')->where('userId_fk', $userId)
            ->whereBetween('jobStartDate', [strtotime($startDay), strtotime($endDay)])
            ->first();

        $trans_clientvisit = trans_clientvisit::select('checkInDate', 'checkOutDate')->where('createById_fk', $userId)
            ->whereBetween('checkInDate', [strtotime($startDay), strtotime($endDay)])
            ->where('status', 1)
            ->orderBy('clientVisitId', 'desc')
            ->first();

        // dd($trans_clientvisit);

        if ($trans_clientvisit == null) {

            $trans_clientvisit = mst_dsrClient::select('checkInDate', 'checkOutDate')->where('userId_fk', $userId)
                ->whereBetween('checkInDate', [strtotime($startDay), strtotime($endDay)])
                ->where('status', 1)
                ->orderBy('dsrClientId', 'desc')
                ->first();
        }



        $trans_emponjobs2 = trans_emponjobs::where('userId_fk', $userId)
            ->where('status', 1)
            ->whereBetween('jobStartDate', [strtotime($startDay), strtotime($endDay)])
            ->orderBy('empIdOnJobsId', 'desc')
            ->get();

        foreach ($trans_emponjobs2 as $key => $val) {

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

            $sumkm =  $trans_visitlog ? number_format($trans_visitlog, 2) . ' km' : '0 km';
        }



        return view('dsr.listdata', compact('trans_emponjobs', 'trans_clientvisit', 'sumkm', 'mst_dsrClient'));
    }


    public function dsrnewindex()
    {

        $userId = session('userinfo')->userId;
        $sumkm = '0 km';

        $currentDateTime = Carbon::now();
        $startDay = Carbon::today()->startOfDay();
        $endDay = Carbon::today()->endOfDay();

        $mst_dsrClient = mst_dsrClient::where('userId_fk', $userId)
            ->pluck('name')
            ->unique();


        $trans_emponjobs = trans_emponjobs::select('jobExistDate')->where('userId_fk', $userId)
            ->whereBetween('jobStartDate', [strtotime($startDay), strtotime($endDay)])
            ->first();


        $trans_clientvisit = mst_dsrClient::select('checkInDate', 'checkOutDate')->where('userId_fk', $userId)
            ->whereBetween('checkInDate', [strtotime($startDay), strtotime($endDay)])
            ->where('status', 1)
            ->orderBy('dsrClientId', 'desc')
            ->first();

        $trans_emponjobs2 = trans_emponjobs::where('userId_fk', $userId)
            ->where('status', 1)
            ->whereBetween('jobStartDate', [strtotime($startDay), strtotime($endDay)])
            ->orderBy('empIdOnJobsId', 'desc')
            ->get();

        foreach ($trans_emponjobs2 as $key => $val) {

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

            $sumkm =  $trans_visitlog ? number_format($trans_visitlog, 2) . ' km' : '0 km';
        }



        return view('dsr.newlistdata', compact('trans_emponjobs', 'trans_clientvisit', 'sumkm', 'mst_dsrClient'));
    }


    public function attendancereport()
    {

        return view('dsr.attendancereport');
    }

    public function detailreport()
    {

        return view('dsr.detailreport');
    }

    public function checkinsumbit(Request $request)
    {

        // return response()->json(['status' => 301, 'msg' => 'Data Not Insert']);

        $currentDateTime = Carbon::now();
        $today_date = $currentDateTime->format('d-M-Y H:i:s');
        $latitude = trim($request->latitude);
        $longitude = trim($request->longitude);
        $client_type = $request->client_type;

        $visitAuthKey = sha1($latitude . '' . $currentDateTime->toDateTimeString());
        $visitLogAuthKey = sha1('checkin' . '' . $currentDateTime->toDateTimeString());
        $entryAuthKey = sha1('newdistributiorcheckin' . '' . $currentDateTime->toDateTimeString());

        $current_location_image = null;
        $meter_reading_upload = null;
        $visiting_card_image = null;
        $counter_pic = null;

        if ($request->hasFile('current_location_image')) {
            $current_location_image = 'checkin-' . time() . '.' . $request->current_location_image->getClientOriginalExtension();
            $request->current_location_image->move(public_path('document'), $current_location_image);
        }

        if ($request->hasFile('meter_reading_upload')) {
            $meter_reading_upload = 'meter-' . time() . '.' . $request->meter_reading_upload->getClientOriginalExtension();
            $request->meter_reading_upload->move(public_path('document'), $meter_reading_upload);
        }

        if ($request->hasFile('visiting_card_image')) {
            $visiting_card_image = 'visitingcard-' . time() . '.' . $request->visiting_card_image->getClientOriginalExtension();
            $request->visiting_card_image->move(public_path('document'), $visiting_card_image);
        }

        if ($request->hasFile('counter_pic')) {
            $counter_pic = 'counter-' . time() . '.' . $request->counter_pic->getClientOriginalExtension();
            $request->counter_pic->move(public_path('document'), $counter_pic);
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

        if ($client_type == 'Existing') {

            $data = [
                'customerId_fk' => $request->alldistributor,
                'meterReading' => $request->meter_reading,
                'meterReadingImage' => $meter_reading_upload,
                'salesUserId' => $request->assign_user,
                'createById_fk' => session('userinfo')->userId,
                'projectName' => $request->retailer_project_name,
                'checkInLocation' => $locationArea,
                'checkInLatitude' => $latitude,
                'checkInLongitude' => $longitude,
                'checkInDate' => strtotime($today_date),
                'locationImage' => $current_location_image,
                'visitAuthKey' => $visitAuthKey,
                'status' => 1
            ];
            $trans_clientvisit = trans_clientvisit::create($data);

            $lastInsertedId = $trans_clientvisit->clientVisitId;

            $startDay = Carbon::today()->startOfDay();
            $endDay = Carbon::today()->endOfDay();

            $trans_visitlog_data = trans_visitlog::where('userId_fk', session('userinfo')->userId)
                ->select('visitLatitude', 'visitLongitude')
                ->whereBetween('visitDate', [strtotime($startDay), strtotime($endDay)])
                ->orderby('visitId', 'desc')
                ->first();

            $visitlog_latitude  = $trans_visitlog_data->visitLatitude ? $trans_visitlog_data->visitLatitude : 0;

            $visitlog_Longitude =  $trans_visitlog_data->visitLongitude ? $trans_visitlog_data->visitLongitude : 0;

            $km =  calculateDistance($visitlog_latitude, $visitlog_Longitude, $latitude, $longitude);

            $datalog = [
                'userId_fk' => session('userinfo')->userId,
                'clientvisit_id_fk' => $lastInsertedId,
                'checkInType' => 'Check In',
                'visitLocation' => $locationArea,
                'visitLatitude' => $latitude,
                'visitLongitude' => $longitude,
                'km' => $km,
                'meterreading_cal' => $request->meter_reading,
                'visitDate' => strtotime($today_date),
                'distributorcheck' => 'Exist',
                'visitLogAuthKey' => $visitLogAuthKey,
                'status' => 1
            ];

            $trans_visitlog = trans_visitlog::insert($datalog);
        } else {

            $data = [

                'userId_fk' => session('userinfo')->userId,
                'name' => $request->dealer_name,
                'ownerName' => $request->owner_name,
                'phoneNumber' => $request->phone_number,
                'meterReading' => $request->meter_reading,
                'meterReadingImage' => $meter_reading_upload,
                'visitingCard' => $visiting_card_image,
                'counterimage' => $counter_pic,
                'checkInLocation' => $locationArea,
                'checkInLatitude' => $latitude,
                'checkInLongitude' => $longitude,
                'checkInDate' => strtotime($today_date),
                'entryDate' => strtotime($today_date),
                'prospect' => $request->customer_type,
                'entryAuthKey' => $entryAuthKey,
                'status' => 1
            ];

            $trans_clientvisit = mst_dsrClient::create($data);
            $lastInsertedId = $trans_clientvisit->dsrClientId;

            $startDay = Carbon::today()->startOfDay();
            $endDay = Carbon::today()->endOfDay();

            $trans_visitlog_data = trans_visitlog::where('userId_fk', session('userinfo')->userId)
                ->select('visitLatitude', 'visitLongitude')
                ->whereBetween('visitDate', [strtotime($startDay), strtotime($endDay)])
                ->orderby('visitId', 'desc')
                ->first();

            $visitlog_latitude  = $trans_visitlog_data->visitLatitude ? $trans_visitlog_data->visitLatitude : 0;

            $visitlog_Longitude =  $trans_visitlog_data->visitLongitude ? $trans_visitlog_data->visitLongitude : 0;

            $km =  calculateDistance($visitlog_latitude, $visitlog_Longitude, $latitude, $longitude);

            $datalog = [
                'userId_fk' => session('userinfo')->userId,
                'clientvisit_id_fk' => $lastInsertedId,
                'checkInType' => 'Check In',
                'visitLocation' => $locationArea,
                'visitLatitude' => $latitude,
                'visitLongitude' => $longitude,
                'km' => $km,
                'meterreading_cal' => $request->meter_reading,
                'visitDate' => strtotime($today_date),
                'distributorcheck' => 'New',
                'visitLogAuthKey' => $visitLogAuthKey,
                'status' => 1
            ];

            $trans_visitlog = trans_visitlog::insert($datalog);
        }


        if ($trans_clientvisit) {
            return response()->json(['status' => 200, 'msg' => 'Data Insert Successfully']);
        } else {
            return response()->json(['status' => 301, 'msg' => 'Data Not Insert']);
        }
    }

    // public function checkinsumbit(Request $request)
    // {
    //     $currentDateTime = Carbon::now();
    //     $today_date = $currentDateTime->format('d-M-Y H:i:s');
    //     $latitude = trim($request->latitude);
    //     $longitude = trim($request->longitude);
    //     $client_type = $request->client_type;

    //     // Generate unique keys
    //     $visitAuthKey = sha1($latitude . $currentDateTime->toDateTimeString());
    //     $visitLogAuthKey = sha1('checkin' . $currentDateTime->toDateTimeString());
    //     $entryAuthKey = sha1('newdistributiorcheckin' . $currentDateTime->toDateTimeString());

    //     // File upload handling
    //     $files = [
    //         'current_location_image' => null,
    //         'meter_reading_upload' => null,
    //         'visiting_card_image' => null,
    //         'counter_pic' => null,
    //     ];

    //     foreach ($files as $key => $value) {
    //         if ($request->hasFile($key)) {
    //             $files[$key] = $request->file($key)->store('documents', 'public');
    //         }
    //     }

    //     // Prepare location data (can be moved to a queue if using Google API)
    //     $locationArea = ''; // Use Google Maps API or a local mapping library to fetch this data asynchronously.
    //     $locationArea = $this->getLocationAreaFromCoordinates($latitude, $longitude);

    //     // Prepare data for insertion
    //     $data = [
    //         'checkInLatitude' => $latitude,
    //         'checkInLongitude' => $longitude,
    //         'checkInDate' => strtotime($today_date),
    //         'checkInLocation' => $locationArea,
    //         'visitAuthKey' => $visitAuthKey,
    //         'status' => 1,
    //     ];

    //     if ($client_type === 'Existing') {
    //         $data = array_merge($data, [
    //             'customerId_fk' => $request->alldistributor,
    //             'meterReading' => $request->meter_reading,
    //             'meterReadingImage' => $files['meter_reading_upload'],
    //             'salesUserId' => $request->assign_user,
    //             'createById_fk' => session('userinfo')->userId,
    //             'projectName' => $request->retailer_project_name,
    //             'locationImage' => $files['current_location_image'],
    //         ]);

    //         DB::transaction(function () use ($data, $latitude, $longitude, $visitLogAuthKey, $today_date) {
    //             $trans_clientvisit = trans_clientvisit::create($data);

    //             $lastInsertedId = $trans_clientvisit->clientVisitId;

    //             // Fetch previous visit data
    //             $trans_visitlog_data = trans_visitlog::where('userId_fk', session('userinfo')->userId)
    //                 ->select('visitLatitude', 'visitLongitude')
    //                 ->whereBetween('visitDate', [
    //                     strtotime(Carbon::today()->startOfDay()),
    //                     strtotime(Carbon::today()->endOfDay())
    //                 ])
    //                 ->orderby('visitId', 'desc')
    //                 ->first();

    //             $visitlog_latitude = $trans_visitlog_data->visitLatitude ?? 0;
    //             $visitlog_longitude = $trans_visitlog_data->visitLongitude ?? 0;

    //             // Calculate distance (optimize or prefetch if possible)
    //             $km = calculateDistance($visitlog_latitude, $visitlog_longitude, $latitude, $longitude);

    //             $datalog = [
    //                 'userId_fk' => session('userinfo')->userId,
    //                 'clientvisit_id_fk' => $lastInsertedId,
    //                 'checkInType' => 'Check In',
    //                 'visitLocation' => $data['checkInLocation'],
    //                 'visitLatitude' => $latitude,
    //                 'visitLongitude' => $longitude,
    //                 'km' => $km,
    //                 'meterreading_cal' => $data['meterReading'],
    //                 'visitDate' => strtotime($today_date),
    //                 'distributorcheck' => 'Exist',
    //                 'visitLogAuthKey' => $visitLogAuthKey,
    //                 'status' => 1
    //             ];

    //             trans_visitlog::create($datalog);
    //         });
    //     } else {
    //         $data = array_merge($data, [
    //             'userId_fk' => session('userinfo')->userId,
    //             'name' => $request->dealer_name,
    //             'ownerName' => $request->owner_name,
    //             'phoneNumber' => $request->phone_number,
    //             'meterReading' => $request->meter_reading,
    //             'meterReadingImage' => $files['meter_reading_upload'],
    //             'visitingCard' => $files['visiting_card_image'],
    //             'counterimage' => $files['counter_pic'],
    //             'entryAuthKey' => $entryAuthKey,
    //             'entryDate' => strtotime($today_date),
    //             'prospect' => $request->customer_type,
    //         ]);

    //         DB::transaction(function () use ($data, $latitude, $longitude, $visitLogAuthKey, $today_date) {
    //             $trans_clientvisit = mst_dsrClient::create($data);

    //             $lastInsertedId = $trans_clientvisit->dsrClientId;

    //             $trans_visitlog_data = trans_visitlog::where('userId_fk', session('userinfo')->userId)
    //                 ->select('visitLatitude', 'visitLongitude')
    //                 ->whereBetween('visitDate', [
    //                     strtotime(Carbon::today()->startOfDay()),
    //                     strtotime(Carbon::today()->endOfDay())
    //                 ])
    //                 ->orderby('visitId', 'desc')
    //                 ->first();

    //             $visitlog_latitude = $trans_visitlog_data->visitLatitude ?? 0;
    //             $visitlog_longitude = $trans_visitlog_data->visitLongitude ?? 0;

    //             $km = calculateDistance($visitlog_latitude, $visitlog_longitude, $latitude, $longitude);

    //             $datalog = [
    //                 'userId_fk' => session('userinfo')->userId,
    //                 'clientvisit_id_fk' => $lastInsertedId,
    //                 'checkInType' => 'Check In',
    //                 'visitLocation' => $data['checkInLocation'],
    //                 'visitLatitude' => $latitude,
    //                 'visitLongitude' => $longitude,
    //                 'km' => $km,
    //                 'meterreading_cal' => $data['meterReading'],
    //                 'visitDate' => strtotime($today_date),
    //                 'distributorcheck' => 'New',
    //                 'visitLogAuthKey' => $visitLogAuthKey,
    //                 'status' => 1
    //             ];

    //             trans_visitlog::create($datalog);
    //         });
    //     }

    //     return response()->json(['status' => 200, 'msg' => 'Data Insert Successfully']);
    // }


    public function checkoutsumbit(Request $request)
    {

        $currentDateTime = Carbon::now();
        $today_date = $currentDateTime->format('d-M-Y H:i:s');
        $latitude = trim($request->latitude);
        $longitude = trim($request->longitude);
        $order_receive = $request->order_receive;
        $payment_receive = $request->payment_receive;
        $amount_no = $request->amount_no;
        $payment_mode = $request->payment_mode;
        $checkout_meter_reading = $request->checkout_meter_reading;
        $nextmeetingdate = strtotime($request->nextmeetingdate);
        $createById_fk = session('userinfo')->userId;
        $visitLogAuthKey = sha1('checkout' . '' . $currentDateTime->toDateTimeString());

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


        $trans_visitlog =  trans_visitlog::select('distributorcheck')->where('userId_fk', $createById_fk)->orderby('visitId', 'desc')->first();

        // dd($trans_visitlog->distributorcheck);

        if ($trans_visitlog->distributorcheck == 'Exist') {

            $data = [
                'orderReceive' => $order_receive,
                'paymentReceive' => $payment_receive,
                'nextMeetingDate' => $nextmeetingdate,
                'amount' => $amount_no,
                'paymentMode' => $payment_mode,
                'checkOutLocation' => $locationArea,
                'checkOutLatitude' => $latitude,
                'checkOutLongitude' => $longitude,
                'checkoutmeterReading' => $checkout_meter_reading,
                'chekout_meter_reading_upload' => $chekout_meter_reading_upload,
                'checkOutDate' => strtotime($today_date)
            ];

            // Retrieve the latest record for the given createById_fk and update it
            $trans_clientvisit = trans_clientvisit::where('createById_fk', $createById_fk)
                ->orderBy('clientVisitId', 'desc')
                ->first(); // Fetches the latest record

            if ($trans_clientvisit) {
                $trans_clientvisit->update($data);

                $startDay = Carbon::today()->startOfDay();
                $endDay = Carbon::today()->endOfDay();

                $trans_visitlog_data = trans_visitlog::where('userId_fk', session('userinfo')->userId)
                    ->select('visitLatitude', 'visitLongitude')
                    ->whereBetween('visitDate', [strtotime($startDay), strtotime($endDay)])
                    ->orderby('visitId', 'desc')
                    ->first();

                //dd($trans_visitlog_data);

                $km =  calculateDistance($trans_visitlog_data->visitLatitude, $trans_visitlog_data->visitLongitude, $latitude, $longitude);

                $datalog = [
                    'userId_fk' => session('userinfo')->userId,
                    'checkInType' => 'Check Out',
                    'visitLocation' => $locationArea,
                    'visitLatitude' => $latitude,
                    'visitLongitude' => $longitude,
                    'km' => $km,
                    'meterreading_cal' => $checkout_meter_reading,
                    'visitDate' => strtotime($today_date),
                    'distributorcheck' => 'Exist',
                    'visitLogAuthKey' => $visitLogAuthKey,
                    'status' => 1
                ];

                $trans_visitlog = trans_visitlog::insert($datalog);


                return response()->json(['status' => 200, 'msg' => 'Data Insert Successfully']);
            } else {
                return response()->json(['status' => 301, 'msg' => 'Data  Not Insert']);
            }
        } else if ($trans_visitlog->distributorcheck == 'New') {


            $data = [
                'orderReceive' => $order_receive,
                'paymentReceive' => $payment_receive,
                'nextMeetingDate' => $nextmeetingdate,
                'amount' => $amount_no,
                'paymentMode' => $payment_mode,
                'checkOutLocation' => $locationArea,
                'checkOutLatitude' => $latitude,
                'checkOutLongitude' => $longitude,
                'checkoutmeterReading' => $checkout_meter_reading,
                'checkoutmeterReadingImage' => $chekout_meter_reading_upload,
                'checkOutDate' => strtotime($today_date)
            ];

            // dd($data);
            // Retrieve the latest record for the given createById_fk and update it
            $trans_clientvisit = mst_dsrClient::where('userId_fk', $createById_fk)
                ->orderBy('dsrClientId', 'desc')
                ->first(); // Fetches the latest record

            if ($trans_clientvisit) {
                $trans_clientvisit->update($data);

                $startDay = Carbon::today()->startOfDay();
                $endDay = Carbon::today()->endOfDay();

                $trans_visitlog_data = trans_visitlog::where('userId_fk', session('userinfo')->userId)
                    ->select('visitLatitude', 'visitLongitude')
                    ->whereBetween('visitDate', [strtotime($startDay), strtotime($endDay)])
                    ->orderby('visitId', 'desc')
                    ->first();

                //dd($trans_visitlog_data);

                $km =  calculateDistance($trans_visitlog_data->visitLatitude, $trans_visitlog_data->visitLongitude, $latitude, $longitude);

                $datalog = [
                    'userId_fk' => session('userinfo')->userId,
                    'checkInType' => 'Check Out',
                    'visitLocation' => $locationArea,
                    'visitLatitude' => $latitude,
                    'visitLongitude' => $longitude,
                    'km' => $km,
                    'meterreading_cal' => $checkout_meter_reading,
                    'visitDate' => strtotime($today_date),
                    'distributorcheck' => 'New',
                    'visitLogAuthKey' => $visitLogAuthKey,
                    'status' => 1
                ];

                $trans_visitlog = trans_visitlog::insert($datalog);


                return response()->json(['status' => 200, 'msg' => 'Data Insert Successfully']);
            } else {
                return response()->json(['status' => 301, 'msg' => 'Data Not Insert']);
            }
        }
    }

    // public function checkoutsumbit(Request $request)
    // {
    //     $currentDateTime = Carbon::now();
    //     $todayTimestamp = $currentDateTime->timestamp; // UNIX timestamp
    //     $startOfDay = $currentDateTime->copy()->startOfDay()->timestamp;
    //     $endOfDay = $currentDateTime->copy()->endOfDay()->timestamp;

    //     $latitude = trim($request->latitude);
    //     $longitude = trim($request->longitude);
    //     $order_receive = $request->order_receive;
    //     $payment_receive = $request->payment_receive;
    //     $amount_no = $request->amount_no;
    //     $payment_mode = $request->payment_mode;
    //     $checkout_meter_reading = $request->checkout_meter_reading;
    //     $nextMeetingTimestamp = strtotime($request->nextmeetingdate);
    //     $createById_fk = session('userinfo')->userId;
    //     $visitLogAuthKey = sha1('checkout' . $currentDateTime->toDateTimeString());

    //     $chekout_meter_reading_upload = null;

    //     // Optimize file handling
    //     if ($request->hasFile('chekout_meter_reading_upload')) {
    //         $chekout_meter_reading_upload = 'checkout-meter-' . time() . '.' . $request->chekout_meter_reading_upload->getClientOriginalExtension();
    //         $request->chekout_meter_reading_upload->move(public_path('document'), $chekout_meter_reading_upload);
    //     }

    //     // Optimize Google Maps API Call
    //     $locationArea = $this->getLocationAreaFromCoordinates($latitude, $longitude);

    //     // Get the latest distributor status
    //     $trans_visitlog = trans_visitlog::select('distributorcheck')
    //         ->where('userId_fk', $createById_fk)
    //         ->latest('visitId')
    //         ->value('distributorcheck');

    //     if (!$trans_visitlog) {
    //         return response()->json(['status' => 400, 'error' => 'No visit log found']);
    //     }

    //     // Prepare data common for both 'Exist' and 'New' scenarios
    //     $commonData = [
    //         'orderReceive' => $order_receive,
    //         'paymentReceive' => $payment_receive,
    //         'nextMeetingDate' => $nextMeetingTimestamp,
    //         'amount' => $amount_no,
    //         'paymentMode' => $payment_mode,
    //         'checkOutLocation' => $locationArea,
    //         'checkOutLatitude' => $latitude,
    //         'checkOutLongitude' => $longitude,
    //         'checkoutmeterReading' => $checkout_meter_reading,
    //         'chekout_meter_reading_upload' => $chekout_meter_reading_upload,
    //         'checkOutDate' => $todayTimestamp
    //     ];

    //     $latestVisit = trans_visitlog::where('userId_fk', $createById_fk)
    //         ->whereBetween('visitDate', [$startOfDay, $endOfDay])
    //         ->select('visitLatitude', 'visitLongitude')
    //         ->latest('visitId')
    //         ->first();

    //     $km = $latestVisit ? calculateDistance($latestVisit->visitLatitude, $latestVisit->visitLongitude, $latitude, $longitude) : 0;

    //     $datalog = [
    //         'userId_fk' => $createById_fk,
    //         'checkInType' => 'Check Out',
    //         'visitLocation' => $locationArea,
    //         'visitLatitude' => $latitude,
    //         'visitLongitude' => $longitude,
    //         'km' => $km,
    //         'meterreading_cal' => $checkout_meter_reading,
    //         'visitDate' => $todayTimestamp,
    //         'distributorcheck' => $trans_visitlog,
    //         'visitLogAuthKey' => $visitLogAuthKey,
    //         'status' => 1
    //     ];

    //     if ($trans_visitlog === 'Exist') {
    //         $trans_clientvisit = trans_clientvisit::where('createById_fk', $createById_fk)
    //             ->latest('clientVisitId')
    //             ->first();

    //         if ($trans_clientvisit) {
    //             $trans_clientvisit->update($commonData);
    //             trans_visitlog::create($datalog);
    //             return response()->json(['status' => 200, 'msg' => 'Data updated successfully']);
    //         }
    //     } elseif ($trans_visitlog === 'New') {
    //         $trans_clientvisit = mst_dsrClient::where('userId_fk', $createById_fk)
    //             ->latest('dsrClientId')
    //             ->first();

    //         if ($trans_clientvisit) {
    //             $trans_clientvisit->update($commonData);
    //             trans_visitlog::create($datalog);
    //             return response()->json(['status' => 200, 'msg' => 'Data updated successfully']);
    //         }
    //     }

    //     return response()->json(['status' => 301, 'msg' => 'Data not inserted']);
    // }

    /**
     * Helper function to get location area from coordinates using Google Maps API.
     */
    private function getLocationAreaFromCoordinates($latitude, $longitude)
    {
        $googleAPIKey = env('googleAPIKey');
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $latitude . ',' . $longitude . '&key=' . $googleAPIKey;

        $response = Http::retry(3, 100)->get($url); // Retry in case of failure
        if ($response->failed()) {
            return 'Unknown Location';
        }

        $data = $response->json();
        if (!empty($data) && $data['status'] === 'OK') {
            return implode(', ', array_column($data['results'][0]['address_components'], 'long_name'));
        }

        return 'Unknown Location';
    }



    public function listdata(Request $request)
    {


        $rowCount = $request->input('rowCount');
        $page = $request->input('page');

        $userId = session('userinfo')->userId;

        $trans_clientvisit = trans_clientvisit::where('createById_fk', $userId)
            ->where('status', 1)
            ->orderBy('clientVisitId', 'desc')
            ->paginate($rowCount, ['checkInDate', 'checkOutDate', 'customerId_fk', 'projectName', 'checkInLocation', 'checkOutLocation', 'locationImage'], 'page', $page);

        $data = [];

        foreach ($trans_clientvisit as $key => $val) {
            // Parse jobStartDate and jobExistDate using Carbon
            $start = $val->checkInDate ? Carbon::parse($val->checkInDate) : null;
            $end = $val->checkOutDate ? Carbon::parse($val->checkOutDate) : null; // Use current time if jobExistDate is null
            $duration = '';
            // Calculate duration only if start and end are available
            if ($start != ''  && $end != '') {
                $duration = $start && $end ? $end->diff($start) : null;
            }
            $formattedDuration = $duration ? $duration->format('%H:%I:%S') : 'N/A';
            $customername = getcustomerdatabyid($val->customerId_fk);

            $entry = [
                'checkintime' => $val->checkInDate ? date('H:i:s', $val->checkInDate) : '',
                'checkouttime' => $val->checkOutDate ? date('H:i:s', $val->checkOutDate) : '',
                'duration' => $formattedDuration,
                'date' => $val->checkInDate ? date('d-M-Y', $val->checkInDate) : '',
                'checkinaddress' => $val->checkInLocation ?  $val->checkInLocation : '',
                'checkoutaddress' => $val->checkOutLocation ? $val->checkOutLocation : '',
                'distributor' => $customername ? $customername->CustomerName : '',
                'projectname' => $val->projectName ? $val->projectName : '',
                'locationImage' => $val->locationImage ? $val->locationImage : ''
            ];

            $data[] = $entry;
        }

        return response()->json(['data' => $data]);
    }



    public function newlistdata(Request $request)
    {


        $rowCount = $request->input('rowCount');
        $page = $request->input('page');

        $userId = session('userinfo')->userId;

        $trans_clientvisit = mst_dsrClient::where('userId_fk', $userId)
            ->where('status', 1)
            ->orderBy('dsrClientId', 'desc')
            ->paginate($rowCount, ['checkInDate', 'checkOutDate', 'name', 'ownerName', 'phoneNumber', 'prospect', 'checkInLocation', 'checkOutLocation'], 'page', $page);

        $data = [];

        foreach ($trans_clientvisit as $key => $val) {
            // Parse jobStartDate and jobExistDate using Carbon
            $start = $val->checkInDate ? Carbon::parse($val->checkInDate) : null;
            $end = $val->checkOutDate ? Carbon::parse($val->checkOutDate) : null; // Use current time if jobExistDate is null
            $duration = '';
            // Calculate duration only if start and end are available
            if ($start != ''  && $end != '') {
                $duration = $start && $end ? $end->diff($start) : null;
            }
            $formattedDuration = $duration ? $duration->format('%H:%I:%S') : 'N/A';
            $customername = getmastermenudatabyid($val->prospect);

            $entry = [
                'checkintime' => $val->checkInDate ? date('H:i:s', $val->checkInDate) : '',
                'checkouttime' => $val->checkOutDate ? date('H:i:s', $val->checkOutDate) : '',
                'duration' => $formattedDuration,
                'date' => $val->checkInDate ? date('d-M-Y', $val->checkInDate) : '',
                'checkinaddress' => $val->checkInLocation ?  $val->checkInLocation : '',
                'checkoutaddress' => $val->checkOutLocation ? $val->checkOutLocation : '',
                'distributor' => $val->name ?  $val->name : '',
                'ownerName' => $val->ownerName ? $val->ownerName : '',
                'phoneNumber' => $val->phoneNumber ? $val->phoneNumber : '',
                'prospect' =>  $customername ? $customername->name : '',
                'locationImage' => $val->locationImage ? $val->locationImage : ''
            ];

            $data[] = $entry;
        }

        return response()->json(['data' => $data]);
    }



    public function dsrsheetexport($from, $to)
    {

        $sheetname = 'Report-detail-' . $from . '-to-' . $to . '.xlsx';
        $from = strtotime($from);
        $to = strtotime($to);


        return Excel::download(new AttendanceDetailExport($from, $to), $sheetname);
    }


    public function dsrdatasheetexport(Request $request)
    {

        $from = strtotime($request->fromDate);
        $to = strtotime($request->toDate);

        $fromDate = Carbon::parse($from)->addDay();
        $toDate = Carbon::parse($to)->addDay();




        $users = UserList::select('mst_user_list.name', 'mst_user_list.state', 'mst_user_list.city',  'trans_clientvisit.*')
            ->leftJoin('trans_clientvisit', 'trans_clientvisit.createById_fk', '=', 'mst_user_list.userId')
            ->when($fromDate->isSameDay($toDate), function ($query) use ($fromDate) {
                $query->whereBetween('trans_clientvisit.checkInDate', [strtotime($fromDate->startOfDay()), strtotime($fromDate->endOfDay())]);
            }, function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('trans_clientvisit.checkInDate', [strtotime($fromDate->startOfDay()), strtotime($toDate->endOfDay())]);
            })
            ->orderby('mst_user_list.name', 'asc')
            ->get();


        $usersall = UserList::select('mst_user_list.name', 'mst_user_list.state', 'mst_user_list.city', 'mst_dsrClient.checkInDate', 'mst_dsrClient.checkOutDate','mst_dsrClient.name as newname', 'mst_dsrClient.ownerName')
            ->leftJoin('mst_dsrClient', 'mst_dsrClient.userId_fk', '=', 'mst_user_list.userId')
            ->when($fromDate->isSameDay($toDate), function ($query) use ($fromDate) {
                $query->whereBetween('mst_dsrClient.checkInDate', [strtotime($fromDate->startOfDay()), strtotime($fromDate->endOfDay())]);
            }, function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('mst_dsrClient.checkInDate', [strtotime($fromDate->startOfDay()), strtotime($toDate->endOfDay())]);
            })
            ->orderby('mst_user_list.name', 'asc')
            ->get();




        foreach ($users as $key => $user) {

            $state = mstlocation::select('cityName')->where('cityId', $user->state)->first();
            $city = mstlocation::select('cityName')->where('cityId', $user->city)->first();

            $mstcustomerlist =  mstcustomerlist::select('dist_code', 'CustomerName')->where('customerId', $user->customerId_fk)->first();


            $checkIn = Carbon::createFromTimestamp($user->checkInDate);
            if (!empty($user->checkOutDate)) {
                $checkOut = Carbon::createFromTimestamp($user->checkOutDate);
                $timeDifference = $checkIn->diff($checkOut);
                $user['time_spent'] = $timeDifference->h . ':' . $timeDifference->i . ':' . $timeDifference->s;
            } else {
                //$timeDifference = "NA";
                $user['time_spent'] = 'NA';
            }

            $user['Date'] = $user->checkInDate ? date('d-m-Y', $user->checkInDate) : '';
            $user['checkInDate'] = $user->checkInDate ? date('h:i:s A', $user->checkInDate) : '';
            $user['projectname'] = $user->projectName ? $user->projectName : '';
            $user['checkOutDate'] = $user->checkOutDate ? date('h:i:s A', $user->checkOutDate) : '';
            $user['state'] = $state ? $state->cityName : '';
            $user['city'] = $city ? $city->cityName : '';
            $user['dist_code'] = $mstcustomerlist->dist_code ? $mstcustomerlist->dist_code : "";
            $user['CustomerName'] = $mstcustomerlist->CustomerName ? $mstcustomerlist->CustomerName : "";
        }
        foreach ($usersall as $key => $user) {



            $state = mstlocation::select('cityName')->where('cityId', $user->state)->first();
            $city = mstlocation::select('cityName')->where('cityId', $user->city)->first();


            $checkIn = Carbon::createFromTimestamp($user->checkInDate);
            if (!empty($user->checkOutDate)) {
                $checkOut = Carbon::createFromTimestamp($user->checkOutDate);
                $timeDifference = $checkIn->diff($checkOut);
                $user['time_spent'] = $timeDifference->h . ':' . $timeDifference->i . ':' . $timeDifference->s;
            } else {
                //$timeDifference = "NA";
                $user['time_spent'] = 'NA';
            }

            $user['Date'] = $user->checkInDate ? date('d-m-Y', $user->checkInDate) : '';
            $user['checkInDate'] = $user->checkInDate ? date('h:i:s A', $user->checkInDate) : '';
            $user['checkOutDate'] = $user->checkOutDate ? date('h:i:s A', $user->checkOutDate) : '';
            $user['projectname'] = $user->ownerName ? $user->ownerName : '';
            $user['state'] = $state ? $state->cityName : '';
            $user['city'] = $city ? $city->cityName : '';
            $user['dist_code'] =  "";
            $user['CustomerName'] =  $user->newname;
          
        }

        // $mergedUsers = array_merge($users->toArray(), $usersall->toArray());

        // usort($mergedUsers, function ($a, $b) {
        //     return strcmp($a['name'], $b['name']);
        // });

        $mergedUsers = array_merge($users->toArray(), $usersall->toArray());

        // Sort by name first, then by Date
        usort($mergedUsers, function ($a, $b) {
            // Sort by name
            $nameCompare = strcmp($a['name'], $b['name']);
            if ($nameCompare === 0) {
                // If names are the same, sort by date (convert it to timestamp for proper sorting)
                return strtotime($a['Date']) - strtotime($b['Date']);
            }
            return $nameCompare;
        });



        // return response()->json(['users' => $users, 'usersall' => $usersall]);

        return response()->json(['users' => $mergedUsers]);
    }

    // public function dsrdatasheetexportsearch(Request $request){



    //     $date_range = $request->input('date_range');
    //     $employee_name = $request->input('employee_name');
    //     $employee_state = $request->input('employee_state');
    //     $customer_code = $request->input('customer_code');
    //     $schedule_customer_name = $request->input('schedule_customer_name');
    //     $city = $request->input('city');
    //     $schedule_call = $request->input('schedule_call');
    //     $CheckIn = $request->input('CheckIn');
    //     $timespent = $request->input('timespent');
    //     $checkOut = $request->input('checkOut');
    //     $from = strtotime($request->fromDate);
    //     $to = strtotime($request->toDate);


    //     $fromDate = Carbon::parse($from)->addDay();
    //     $toDate = Carbon::parse($to)->addDay();




    //     $users = UserList::select('mst_user_list.name', 'mst_user_list.state', 'mst_user_list.city',  'trans_clientvisit.*')
    //         ->leftJoin('trans_clientvisit', 'trans_clientvisit.createById_fk', '=', 'mst_user_list.userId')
    //         ->when($fromDate->isSameDay($toDate), function ($query) use ($fromDate) {
    //             $query->whereBetween('trans_clientvisit.checkInDate', [strtotime($fromDate->startOfDay()), strtotime($fromDate->endOfDay())]);
    //         }, function ($query) use ($fromDate, $toDate) {
    //             $query->whereBetween('trans_clientvisit.checkInDate', [strtotime($fromDate->startOfDay()), strtotime($toDate->endOfDay())]);
    //         })
    //         ->orderby('mst_user_list.name', 'asc')
    //         ->get();

    //     foreach ($users as $key => $user) {

    //         $state = mstlocation::select('cityName')->where('cityId', $user->state)->first();
    //         $city = mstlocation::select('cityName')->where('cityId', $user->city)->first();

    //         $mstcustomerlist =  mstcustomerlist::select('dist_code', 'CustomerName')->where('customerId', $user->customerId_fk)->first();


    //         $checkIn = Carbon::createFromTimestamp($user->checkInDate);
    //             if (!empty($user->checkOutDate)) {
    //                 $checkOut = Carbon::createFromTimestamp($user->checkOutDate);
    //                 $timeDifference = $checkIn->diff($checkOut);
    //                 $user['time_spent'] = $timeDifference->h . ':' . $timeDifference->i . ':' . $timeDifference->s;
    //             } else {
    //                 //$timeDifference = "NA";
    //                 $user['time_spent'] = 'NA';
    //             }

    //         $user['Date'] = $user->checkInDate ? date('d-m-Y', $user->checkInDate) : '';
    //         $user['checkInDate'] = $user->checkInDate ? date('h:i:s A', $user->checkInDate) : '';
    //         $user['checkOutDate'] = $user->checkOutDate ? date('h:i:s A', $user->checkOutDate) : '';
    //         $user['state'] = $state ? $state->cityName : '';
    //         $user['city'] = $city ? $city->cityName : '';
    //         $user['dist_code'] = $mstcustomerlist->dist_code ? $mstcustomerlist->dist_code : "";
    //         $user['CustomerName'] = $mstcustomerlist->CustomerName ? $mstcustomerlist->CustomerName : "";

    //     }


    //     return response()->json(['users' => $users]);



    // }


    public function dsrdatasheetexportsearch(Request $request)
    {
        $from = strtotime($request->fromDate);
        $to = strtotime($request->toDate);
        $date_range = $request->input('date_range');

        if (!empty($date_range)) {
            $dates = explode(' - ', $date_range);
            $startDate = trim($dates[0]);
            $endDate = trim($dates[1]);

            $fromDate = Carbon::parse($startDate)->startOfDay();
            $toDate = Carbon::parse($endDate)->endOfDay();

            //dd('fromDate =>'.$fromDate .'toDate => '.$toDate);
        } else {
            $fromDate = Carbon::parse($from)->startOfDay();
            $toDate = Carbon::parse($to)->endOfDay();
        }

        $query_state = [];
        $query_city = [];

        if (!empty($request->employee_state)) {
            $query_state = mstlocation::whereNull('parentId')
                ->where('cityName', 'like', '%' . $request->employee_state . '%')
                ->pluck('cityId')
                ->toArray();  // Ensure array format
        }

        if (!empty($request->city)) {
            $query_city = mstlocation::whereNotNull('parentId')
                ->where('cityName', 'like', '%' . $request->city . '%')
                ->pluck('cityId')
                ->toArray();  // Ensure array format
        }

        $users = UserList::select(
            'mst_user_list.userId',
            'mst_user_list.name',
            'mst_user_list.state',
            'mst_user_list.city',
            'trans_clientvisit.*'
        )
            ->leftJoin('trans_clientvisit', 'trans_clientvisit.createById_fk', '=', 'mst_user_list.userId')
            ->leftJoin('mst_customerlist', 'trans_clientvisit.customerId_fk', '=', 'mst_customerlist.customerId')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('trans_clientvisit.checkInDate', [
                    strtotime($fromDate),
                    strtotime($toDate)
                ]);
            })
            ->when($request->filled('employee_name'), function ($query) use ($request) {
                return $query->where('mst_user_list.name', 'LIKE', "%{$request->employee_name}%");
            })
            ->when(!empty($query_state), function ($query) use ($query_state) {
                return $query->whereIn('mst_user_list.state', $query_state);
            })
            ->when($request->filled('customer_code'), function ($query) use ($request) {
                return $query->where('mst_customerlist.dist_code', 'LIKE', "%{$request->customer_code}%");
            })
            ->when($request->filled('schedule_customer_name'), function ($query) use ($request) {
                return $query->where('mst_customerlist.CustomerName', 'LIKE', "%{$request->schedule_customer_name}%");
            })
            ->when(!empty($query_city), function ($query) use ($query_city) {
                return $query->whereIn('mst_user_list.city', $query_city);
            })
            ->when($request->filled('schedule_call'), function ($query) use ($request) {
                return $query->where('trans_clientvisit.schedule_call', $request->schedule_call);
            })
            ->when($request->filled('schedule_call'), function ($query) use ($request) {
                return $query->where('trans_clientvisit.projectName','LIKE', "%{$request->retailor_name}%");
            })
            ->orderBy('mst_user_list.name', 'asc')
            ->get();



        $usersall = UserList::select('mst_user_list.name', 'mst_user_list.state', 'mst_user_list.city', 'mst_dsrClient.checkInDate', 'mst_dsrClient.checkOutDate',  'mst_dsrClient.name as newname', 'mst_dsrClient.ownerName')
            ->leftJoin('mst_dsrClient', 'mst_dsrClient.userId_fk', '=', 'mst_user_list.userId')
            ->when($fromDate->isSameDay($toDate), function ($query) use ($fromDate) {
                $query->whereBetween('mst_dsrClient.checkInDate', [strtotime($fromDate->startOfDay()), strtotime($fromDate->endOfDay())]);
            }, function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('mst_dsrClient.checkInDate', [strtotime($fromDate->startOfDay()), strtotime($toDate->endOfDay())]);
            })->when($request->filled('employee_name'), function ($query) use ($request) {
                return $query->where('mst_user_list.name', 'LIKE', "%{$request->employee_name}%");
            })
            ->when(!empty($query_state), function ($query) use ($query_state) {
                return $query->whereIn('mst_user_list.state', $query_state);
            })
            ->when($request->filled('schedule_customer_name'), function ($query) use ($request) {
                return $query->where('mst_dsrClient.name', 'LIKE', "%{$request->schedule_customer_name}%");
            })
            ->when(!empty($query_city), function ($query) use ($query_city) {
                return $query->whereIn('mst_user_list.city', $query_city);
            })
            ->when($request->filled('retailor_name'), function ($query) use ($request) {
                return $query->where('mst_dsrClient.ownerName','LIKE', "%{$request->retailor_name}%");
            })
            ->orderby('mst_user_list.name', 'asc')
            ->get();



        // Fetch state and city names in bulk for efficiency
        $stateIds = $users->pluck('state')->unique()->filter()->toArray();
        $cityIds = $users->pluck('city')->unique()->filter()->toArray();

        $stateNames = mstlocation::whereIn('cityId', $stateIds)->pluck('cityName', 'cityId')->toArray();
        $cityNames = mstlocation::whereIn('cityId', $cityIds)->pluck('cityName', 'cityId')->toArray();

        foreach ($users as $user) {
            $mstcustomerlist = mstcustomerlist::select('dist_code', 'CustomerName')
                ->where('customerId', $user->customerId_fk)
                ->first();

            $checkIn = Carbon::createFromTimestamp($user->checkInDate);
            if (!empty($user->checkOutDate)) {
                $checkOut = Carbon::createFromTimestamp($user->checkOutDate);
                $timeDifference = $checkIn->diff($checkOut);
                $user['time_spent'] = $timeDifference->h . ':' . $timeDifference->i . ':' . $timeDifference->s;
            } else {
                $user['time_spent'] = 'NA';
            }

            $user['Date'] = $user->checkInDate ? date('d-m-Y', $user->checkInDate) : '';
            $user['projectname'] = $user->projectName ? $user->projectName : '';
            $user['checkInDate'] = $user->checkInDate ? date('h:i:s A', $user->checkInDate) : '';
            $user['checkOutDate'] = $user->checkOutDate ? date('h:i:s A', $user->checkOutDate) : '';
            $user['state'] = $stateNames[$user->state] ?? '';
            $user['city'] = $cityNames[$user->city] ?? '';
            $user['dist_code'] = $mstcustomerlist->dist_code ?? '';
            $user['CustomerName'] = $mstcustomerlist->CustomerName ?? '';
        }

        foreach ($usersall as $user) {
            $mstcustomerlist = mstcustomerlist::select('dist_code', 'CustomerName')
                ->where('customerId', $user->customerId_fk)
                ->first();

            $checkIn = Carbon::createFromTimestamp($user->checkInDate);
            if (!empty($user->checkOutDate)) {
                $checkOut = Carbon::createFromTimestamp($user->checkOutDate);
                $timeDifference = $checkIn->diff($checkOut);
                $user['time_spent'] = $timeDifference->h . ':' . $timeDifference->i . ':' . $timeDifference->s;
            } else {
                $user['time_spent'] = 'NA';
            }

            $user['CustomerName'] = $user->newname;
            $user['projectname'] = $user->ownerName ? $user->ownerName : '';
            $user['Date'] = $user->checkInDate ? date('d-m-Y', $user->checkInDate) : '';
            $user['checkInDate'] = $user->checkInDate ? date('h:i:s A', $user->checkInDate) : '';
            $user['checkOutDate'] = $user->checkOutDate ? date('h:i:s A', $user->checkOutDate) : '';
            $user['state'] = $stateNames[$user->state] ?? '';
            $user['city'] = $cityNames[$user->city] ?? '';
            $user['dist_code'] = $mstcustomerlist->dist_code ?? '';
        }

        $mergedUsers = array_merge($users->toArray(), $usersall->toArray());
        usort($mergedUsers, function ($a, $b) {
            $nameCompare = strcmp($a['name'], $b['name']);
            if ($nameCompare === 0) {
                return strtotime($a['Date']) - strtotime($b['Date']);
            }
            return $nameCompare;
        });
        return response()->json(['users' => $mergedUsers]);

        //return response()->json(['users' => $users, 'usersall' => $usersall]);
    }
}
