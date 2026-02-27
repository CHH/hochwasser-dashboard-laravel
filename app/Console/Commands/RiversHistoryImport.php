<?php

namespace App\Console\Commands;

use App\Jobs\ImportRiverData;
use App\Models\River;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;

class RiversHistoryImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rivers:history:import';

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
        foreach (River::all() as $river) {
            ImportRiverData::dispatchSync(
                $river,
                from: Date::now()->subDays(8),
                to: Date::now(),
            );
        }
    }
}
