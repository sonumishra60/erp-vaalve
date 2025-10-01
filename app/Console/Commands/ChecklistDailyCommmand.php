<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use App\Models\CheckList;

class ChecklistDailyCommmand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checklist:daily-commmand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'cron job this is daily task update script';

    public function handle()
    {
        try {
           
            $frequency_masterdata = getfrequencymasterid();

            if (!$frequency_masterdata) {
                throw new Exception('Frequency master data not found.');
            }

           
            $daily_task_id = getmasterdatawithids($frequency_masterdata->masterDataId, 1);

            if (!$daily_task_id) {
                throw new Exception('Daily task ID not found.');
            }

            $updateCount = CheckList::where('frequencyType', $daily_task_id->masterMenuId)
                                    ->where('status', 4)
                                    ->update(['status' => 0]);

            if ($updateCount) {
                Log::info("Updated $updateCount records in MasterMenu.");
            } else {
                Log::info("No records were updated in MasterMenu.");
            }

        } catch (Exception $e) {
            Log::error("Error in handle method: " . $e->getMessage());
        }
    }
}