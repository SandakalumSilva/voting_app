<?php

namespace App\Console\Commands;

use App\Models\Election;
use Illuminate\Console\Command;


class UpdateVoteStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-vote-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();

        // Update votes whose end time has passed and are not completed
        $votes = Election::where('status', '!=', 'complete')
            ->where('end_time', '<=', $now)
            ->update(['status' => 'completed']);

        $this->info('Vote status updated successfully!');
    }
}
