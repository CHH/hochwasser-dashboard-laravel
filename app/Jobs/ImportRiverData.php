<?php

namespace App\Jobs;

use App\Models\River;
use App\Models\RiverLevel;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImportRiverData implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     *
     * @param string $id River ID
     */
    public function __construct(
        public string $id,
        public ?Carbon $from = null,
        public ?Carbon $to = null,
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Updating data for river '.$this->id);

        $currentLevel = Http::get('https://pegel.feuerwehr-krems.at/api/getPegel', [
            'pegelid' => $this->id,
        ])->json();

        River::updateOrCreate([
            'pegel_id' => $this->id,
        ], [
            'data' => $currentLevel
        ]);

        $river = River::where('pegel_id', $this->id)->first();

        $query = [
            'pegelid' => $this->id,
            'za' => 15,
            'd1' => ($this->from ?? Date::now())->subHour()->format('Y-m-d\TH:i:s'),
            'd2' => ($this->to ?? Date::now())->format('Y-m-d\TH:i:s'),
        ];

        $history = Http::get('https://pegel.feuerwehr-krems.at/api/getPegelwerte', $query)->json();

        RiverLevel::upsert(
            collect($history)->map(function ($level) use ($river) {
                return [
                    'river_id' => $river->id,
                    'timestamp' => Date::parse($level['Key'])->toDateTimeString(),
                    'value' => $level['Value'],
                ];
            })->all()
        , uniqueBy: ['river_id', 'timestamp'], update: ['value']);
    }
}
