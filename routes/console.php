<?php

use App\Jobs\ImportRiverData;
use App\Models\River;
use App\Models\RiverLevel;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('app:rivers:import --delay=60')
    ->everyFiveMinutes()
    ->runInBackground();

Schedule::call(function () {
    RiverLevel::where('timestamp', '<', Date::today()->subDays(8))->delete();
})->daily();
