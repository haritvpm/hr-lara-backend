<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Services\LeaveFetchService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessLeavesJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //artisan queue:work --tries=1 --timeout=0
        $leaveService = new LeaveFetchService();
        $leaveService->fetchLeave();
        $leaveService->processLeaves();

    }
}
