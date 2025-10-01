<?php

namespace App\Exports;

use App\Models\UserList;
use App\Models\mstcustomerlist;
use App\Models\mstlocation;
use DateTime;
use App\Models\trans_clientvisit;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class AttendanceDetailExport implements FromView
{
    protected $from, $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function view(): View
    {

        $fromDate = Carbon::parse($this->from)->addDay();
        $toDate = Carbon::parse($this->to)->addDay();

        $users = UserList::select('mst_user_list.name', 'mst_user_list.state', 'mst_user_list.city',  'trans_clientvisit.*')
            ->leftJoin('trans_clientvisit', 'trans_clientvisit.createById_fk', '=', 'mst_user_list.userId')
            ->when($fromDate->isSameDay($toDate), function ($query) use ($fromDate) {
                $query->whereBetween('trans_clientvisit.checkInDate', [strtotime($fromDate->startOfDay()), strtotime($fromDate->endOfDay())]);
            }, function ($query) use ($toDate) {
                $query->whereBetween('trans_clientvisit.checkInDate', [$this->from, strtotime($toDate->endOfDay())]);
            })
            ->orderby('mst_user_list.name', 'asc')
            ->get();


        $usersall = UserList::select('mst_user_list.name', 'mst_user_list.state', 'mst_user_list.city', 'mst_dsrClient.checkInDate', 'mst_dsrClient.checkOutDate', 'mst_dsrClient.name as newname', 'mst_dsrClient.ownerName')
            ->leftJoin('mst_dsrClient', 'mst_dsrClient.userId_fk', '=', 'mst_user_list.userId')
            ->when($fromDate->isSameDay($toDate), function ($query) use ($fromDate) {
                $query->whereBetween('mst_dsrClient.checkInDate', [strtotime($fromDate->startOfDay()), strtotime($fromDate->endOfDay())]);
            }, function ($query) use ($toDate) {
                $query->whereBetween('mst_dsrClient.checkInDate', [$this->from, strtotime($toDate->endOfDay())]);
            })
            ->orderby('mst_user_list.name', 'asc')
            ->get();

        //dd(strtotime($fromDate->startOfDay()).'-'.strtotime($fromDate->endOfDay()).'-'.$this->from.'-'.strtotime($toDate->endOfDay()).'-'.$usersall);

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
                $user['time_spent'] = 'NA';
            }



            $user['Date'] = $user->checkInDate ? date('d-m-Y', $user->checkInDate) : '';
            $user['projectname'] = $user->projectName ? $user->projectName : '';
            $user['checkInDate'] = $user->checkInDate ? date('h:i:s A', $user->checkInDate) : '';
            $user['checkOutDate'] = $user->checkOutDate ? date('h:i:s A', $user->checkOutDate) : '';
            $user['state'] = $state ? $state->cityName : '';
            $user['city'] = $city ? $city->cityName : '';
            $user['dist_code'] = $mstcustomerlist ? $mstcustomerlist->dist_code : "";
            $user['CustomerName'] = $mstcustomerlist ? $mstcustomerlist->CustomerName : "";
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

            $user['CustomerName'] = $user->newname;
            $user['Date'] = $user->checkInDate ? date('d-m-Y', $user->checkInDate) : '';
            $user['checkInDate'] = $user->checkInDate ? date('h:i:s A', $user->checkInDate) : '';
            $user['checkOutDate'] = $user->checkOutDate ? date('h:i:s A', $user->checkOutDate) : '';
            $user['projectname'] = $user->ownerName ? $user->ownerName : '';
            $user['state'] = $state ? $state->cityName : '';
            $user['city'] = $city ? $city->cityName : '';
            $user['dist_code'] =  "";
          
        }

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

        return view('attendance.daydetailexport', [
            'users' => collect($mergedUsers) // Convert array back to a Laravel collection
        ]);
    }
}
