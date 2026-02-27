<?php

namespace App\Jobs;

use App\Models\River;
use App\Models\RiverLevel;
use Carbon\Carbon;
use Illuminate\Contracts\Broadcasting\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImportRiverData implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    /**
     * Create a new job instance.
     *
     * @param string $id River ID
     */
    public function __construct(
        public River $river,
        public ?Carbon $from = null,
        public ?Carbon $to = null,
    )
    {
        //
    }

    public function uniqueId(): string
    {
        return md5(join('|', [
            $this->river->id,
            $this->from?->toDateTimeString(),
            $this->to?->toDateTimeString(),
        ]));
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Updating data for river '.$this->river->name);

        $currentLevel = Http::get('https://pegel.feuerwehr-krems.at/api/getPegel', [
            'pegelid' => $this->river->pegel_id,
        ])->json();

        $this->river->data = $currentLevel;
        $this->river->save();

        $query = [
            'pegelid' => $this->river->pegel_id,
            'za' => 15,
            'd1' => ($this->from ?? Date::now())->subHour()->format('Y-m-d\TH:i:s'),
            'd2' => ($this->to ?? Date::now())->format('Y-m-d\TH:i:s'),
        ];

        $history = Http::get('https://pegel.feuerwehr-krems.at/api/getPegelwerte', $query)->json();

        RiverLevel::upsert(
            collect($history)->map(function ($level) {
                return [
                    'river_id' => $this->river->id,
                    'timestamp' => Date::parse($level['Key'])->toDateTimeString(),
                    'value' => $level['Value'],
                ];
            })->all()
        , uniqueBy: ['river_id', 'timestamp'], update: ['value']);
    }
}
