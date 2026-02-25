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

Route::get('/rivers/{pegelId}', function (string $pegelId) {
    $river = River::where('pegel_id', $pegelId)->firstOrFail();

    return Inertia::render('River/Show', [
        'river' => Inertia::defer(fn () =>
            $river->load([
                'levels' => fn ($query) =>
                    $query
                        ->where('timestamp', '>=', Date::now()->subDays(30))
                        ->orderBy('timestamp', 'asc')
            ])
        ),
    ]);
})->name('rivers.show');
