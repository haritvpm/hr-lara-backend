<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PunchingTraceFetchService;

class fetchAttendaceTraceToday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-attendace-trace-today';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch today attendance trace using api4';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \Log::info("fetch attendance trace today execution!");
        (new PunchingTraceFetchService())->fetchTrace();
        return Command::SUCCESS;
    }
}
