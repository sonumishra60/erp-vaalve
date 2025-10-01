<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\CheckList;
use Illuminate\Support\Facades\Log;

class CheckWeeklyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checklist:weekly-commmand';
   
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'cron job this is Weekly task update script';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $frequency_masterdata = getfrequencymasterid();
        
            if (!$frequency_masterdata) {
                throw new Exception('Frequency master data not found.');
            }
        
            $status = 0;
            $weekly_task_id = getmasterdatawithids($frequency_masterdata->masterDataId, 2);
        
            if (!$weekly_task_id) {
                throw new Exception('Weekly task ID not found.');
            }
        
            $updateCount = CheckList::where('frequencyType', $weekly_task_id->masterMenuId)
                                    ->where('status', 4)
                                    ->get();
        
            if ($updateCount->isEmpty()) {
                Log::info("No records found to update.");
            }
        
            foreach ($updateCount as $val) {
                $currentDateTime = Carbon::now();
                $dateAfter7Days = $currentDateTime->copy()->addDays(7);
                $finalDate = $dateAfter7Days->toDateTimeString();
        
                if ($val->nextPlanDate != null) {
                    $anotherDate = Carbon::createFromTimestamp($val->nextPlanDate);
        
                    if ($currentDateTime->isSameDay($anotherDate)) {
                        $status = 1;
                    }
                } else {
                    $anotherDate = Carbon::createFromTimestamp($val->checkListDate);
                }
        
                if ($dateAfter7Days->isSameDay($anotherDate)) {
                    $update = CheckList::where('frequencyType', $weekly_task_id->masterMenuId)
                                       ->where('status', 4)
                                       ->update([
                                           'status' => $status,
                                           'nextPlanDate' => strtotime($finalDate)
                                       ]);
        
                    if ($update) {
                        Log::info("Updated record ID {$val->id}.");
                    } else {
                        Log::info("No update performed for record ID {$val->id}.");
                    }
                }
            }
        } catch (Exception $e) {
            Log::error("Error in handle method: " . $e->getMessage());
        }
        
    }
}