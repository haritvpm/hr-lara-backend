<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use App\Services\PunchingCalcService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CalcMonthJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $date_str;
    /**
     * Create a new job instance.
     */
    public function __construct($date_str)
    {
        $this->date_str = $date_str;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //artisan queue:work --tries=1 --timeout=0

        $c_today = Carbon::today();

        $date =  Carbon::parse($this->date_str);

        if ($date->lessThan($c_today)) {
         (new PunchingCalcService())->calculate($this->date_str);
        }

    }
}
