<?php

namespace App\Console\Commands;

use App\Jobs\ImportRiverData;
use Illuminate\Console\Command;

class RiversImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rivers:import';

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
        foreach (config('pegel.rivers') as $river) {
            ImportRiverData::dispatchSync($river['id']);
        }
    }
}
