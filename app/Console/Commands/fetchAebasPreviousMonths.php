<?php

namespace App\Console\Commands;

use Carbon\CarbonPeriod;
use Carbon\Carbon;
use App\Jobs\AebasFetchDayJob;
use Illuminate\Console\Command;

class fetchAebasPreviousMonths extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-aebas-previous-months';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches aebas data for this years jan 1 to march 31 description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reportdate = Carbon::today();

        //dont forget to set queue driver in env
        //QUEUE_CONNECTION=database

        //for each day of this year from jan 1 to mar 31
        $start_date =  Carbon::parse('2024-01-01')->startOfDay();
        $end_date = $start_date->clone()->endOfMonth();
        //$end_date = $start_date->clone()->addMonths(2)->endOfMonth();
        $dates = CarbonPeriod::create($start_date, $end_date);
        foreach ($dates as $date) {
            $reportdate = $date->format('Y-m-d');
            \Log::info("fetchin attendance trace for date: " . $reportdate);


            //AebasFetchDayJob::dispatch($reportdate)->delay(now()->addMinutes(3));

        }
    }
}
