<?php

use App\Jobs\ElectionCompleteJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::job(ElectionCompleteJob::class)->everyMinute();
