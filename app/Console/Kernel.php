<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    
    protected $commands = [
        Commands\ChecklistDailyCommmand::class,
    ];


    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('checklist:daily-commmand')->daily();
        $schedule->command('checklist:weekly-commmand')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
