<?php

use App\Console\Commands\OrphanTranslations;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

//Schedule::command(OrphanTranslations::class)->everyFiveMinutes();
Schedule::command(OrphanTranslations::class)->dailyAt('20:00');
