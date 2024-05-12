<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\PunchingTraceFetchService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AebasFetchDayJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 3600;

    /**
     * Execute the job.
     */
    /*

    needs to tables generated and migrated
php artisan queue:table
php artisan queue:failed-table

    To process the queue in Laravel, you need to start the queue worker using the php artisan queue:work command. This command starts a long-running PHP process that continuously polls the queue for new jobs to process.



    artisan queue:work --tries=1 --timeout=0

    The queue worker executes each job by calling its handle method, and then marks the job as completed. If an error occurs while processing a job, the worker will retry the job a certain number of times before moving it to the failed job queue.
    */
    public function handle(): void
    {
        (new PunchingTraceFetchService())->fetchTrace( $this->date);

        \Log::info ('processing AebasFetch' . $this->date);
    }
}
