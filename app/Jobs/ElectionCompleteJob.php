<?php

namespace App\Jobs;

use App\Services\ElectionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ElectionCompleteJob implements ShouldQueue
{
    use Queueable;

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
    public function handle(ElectionService $electionService): void
    {
        $electionService->getElection();
    }
}
