<?php

use App\Models\River;
use App\Models\RiverLevel;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home/Home', [
        'rivers' => Inertia::defer(fn () =>
            River::with([
                'levels' => fn ($query) =>
                    $query
                        ->where('timestamp', '>=', Date::now()->subDays(2))
                        ->orderBy('river_id', 'asc')
                        ->orderBy('timestamp', 'asc')
            ])->get()->keyBy('pegel_id')
        ),
    ]);
});

Route::get('/pegel/{river:name}', function (River $river) {
    $river->load([
        'levels' => fn ($query) =>
            $query
                ->where('timestamp', '>=', Date::now()->subDays(8))
                ->orderBy('river_id', 'asc')
                ->orderBy('timestamp', 'asc')
    ]);

    return Inertia::render('River/Show', [
        'river' => $river,
    ]);
});
