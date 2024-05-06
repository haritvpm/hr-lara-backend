<?php

namespace App\Console\Commands;

use Carbon\CarbonPeriod;
use Carbon\Carbon;
use App\Jobs\AebasFetchDayJob;
use Illuminate\Console\Command;

class fetchAebasPreviousMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-month {month}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches aebas data for current year\'s month=jan/feb/... ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reportdate = Carbon::today();

        //dont forget to set queue driver in env
        //QUEUE_CONNECTION=database

        //for each day of this year from jan 1 to mar 31
        //first day of jan
        $start_date =  Carbon::parse($this->argument('month'))->startOfMonth();
       // $start_date =  Carbon::parse(  )->startOfDay();
        $end_date = $start_date->clone()->endOfMonth();
        if($end_date->greaterThan(Carbon::yesterday())) $end_date = Carbon::yesterday();
        //$end_date = $start_date->clone()->addMonths(2)->endOfMonth();
        $dates = CarbonPeriod::create($start_date, $end_date);
        foreach ($dates as $date) {
            $reportdate = $date->format('Y-m-d');
            \Log::info("fetchin attendance trace for date: " . $reportdate);

            AebasFetchDayJob::dispatch($reportdate)->delay(now()->addMinutes(3));

        }
    }
}
