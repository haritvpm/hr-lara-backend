<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        /*
        $schedule->command('app:fetch-attendace-trace-today')
        ->cron('0,6,15 8 * * *'); //for sabha days at different minutes at 8 am
*/
        $schedule->command('app:fetch-attendace-trace-today')
            ->cron('0-59/15 10 * * *'); //every 15 min between 10 to 11

        $schedule->command('app:fetch-attendace-trace-today')
            ->cron('0 11-17 * * *'); //hourly from  11 to 17

        $schedule->command('app:fetch-attendace-trace-yesterday')
            ->cron('0 8,10 * * *') //will the server be up at 8 am?
            ->timezone('Asia/Kolkata')
            ->after(function () {
                // The task has executed...
            });

        $schedule->command('app:fetch-process-all-leaves')
            ->cron('30 13 * * *'); //1.30 pm

        // $schedule->command('fetch:attendanceyesterday')
        //    ->cron('2 8,10 * * *');	//Run the task daily at 8:02 & 10:02
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
