<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FetchProcessAllLeaves extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-process-all-leaves';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch all leaves and process them';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ProcessLeavesJob::dispatch();
    }
}
