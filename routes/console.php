<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


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

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command('app:fetch-attendace-trace-today')
->cron('0-59/15 10 * * *'); //every 15 min between 10 to 11

Schedule::command('app:fetch-attendace-trace-today')
->cron('12,15,45 11-17 * * *'); //hourly from  11 to 17

Schedule::command('app:fetch-attendace-trace-yesterday')
->cron('0 8,10 * * *') //will the server be up at 8 am?
->timezone('Asia/Kolkata')
->after(function () {
    // The task has executed...
});

Schedule::command('app:fetch-process-all-leaves')
->cron('30 13 * * *'); //1.30 pm

