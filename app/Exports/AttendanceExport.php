<?php

namespace App\Exports;

use App\Models\UserList;
use App\Models\mstcustomerlist;
use App\Models\mstlocation;
use DateTime;
use App\Models\trans_visitlog;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class AttendanceExport implements FromView
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

        $users = UserList::select('mst_user_list.*', 'trans_emponjobs.empIdOnJobsId', 'trans_emponjobs.jobStartDate', 'trans_emponjobs.jobExistDate', 'trans_emponjobs.checkInLocationArea', 'trans_emponjobs.checkOutLocationArea')
            ->leftJoin('trans_emponjobs', 'mst_user_list.userId', '=', 'trans_emponjobs.userId_fk')
            // ->whereBetween('trans_emponjobs.jobStartDate', [$this->from, $this->to])
            // ->where('mst_user_list.role_type', 3)
            ->when($fromDate->isSameDay($toDate), function ($query) use ($fromDate) {
                // If 'from' and 'to' dates are the same, filter for that specific day from start to end
                $query->whereBetween('trans_emponjobs.jobStartDate', [strtotime($fromDate->startOfDay()), strtotime($fromDate->endOfDay())]);
            }, function ($query) use ($toDate) {
                // Otherwise, filter between 'from' and 'to' date range
                $query->whereBetween('trans_emponjobs.jobStartDate', [$this->from, strtotime($toDate->endOfDay())]);
            })
            ->where('mst_user_list.staus', 184)
            ->orderby('trans_emponjobs.jobStartDate', 'asc')
            ->get();

           // dd($fromDate->startOfDay());

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


            $user['reporting_manager'] = $reportdata ? $reportdata['name'] : '';
            $user['reporting_manager_code'] = $reportdata ? $reportdata['reporting_manager_code'] : '';
            $user['designation_doer'] = $designation_doer ? $designation_doer['name'] : '';
            $user['state'] = $state ? $state['cityName'] : '';
            $user['distancetravelled'] = $distancetravelled ? number_format($distancetravelled, 2) . ' km' : '0 km';
            $user['first_visit'] = $firstvisit ? date('h:i:s A', $firstvisit->visitDate) : '';
            $user['last_visit'] =  $lastvisit ? date('h:i:s A', $lastvisit->visitDate) : '';
            $user['first_n_last_visit_diff_h'] =  $interval ? $interval->h : '';
            $user['first_n_last_visit_diff_i'] =  $interval ? $interval->i : '';
            $user['totalvisits'] =  $totalvisits ? $totalvisits : '';
            $user['reporting'] =  $Reporting;
            $user['late'] =  $late;
        }

        return view('attendance.export', [
            'users' => $users
        ]);
    }
}
