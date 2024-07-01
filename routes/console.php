<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\ProcessLeavesJob;


/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

/*
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
*/

//* * * * * cd /home/kla/hrApp/hrmsapp-lara && php artisan schedule:run >> /dev/null 2>&1

Schedule::command('app:fetch-attendace-trace-today')
->cron('15,45 8-9 * * *'); //half hourly from  8 to 9

Schedule::command('app:fetch-attendace-trace-today')
->cron('0-59/15 10-12 * * *'); //every 15 min between 10 to 12

Schedule::command('app:fetch-attendace-trace-today')
->cron('15,45 12-17 * * *'); //half hourly from  12 to 17

Schedule::command('app:fetch-attendace-trace-yesterday')
->cron('0,57 8,10,11 * * *') //will the server be up at 8 am?
->timezone('Asia/Kolkata')
->after(function () {
    // The task has executed...
});

Schedule::job(new ProcessLeavesJob)
->cron('30 13 * * *'); //1.30 pm

