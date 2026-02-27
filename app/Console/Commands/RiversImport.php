<?php

namespace App\Console\Commands;

use App\Jobs\ImportRiverData;
use App\Models\River;
use Illuminate\Console\Command;

class RiversImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rivers:import {--delay=}';

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
        if ($this->option('delay')) {
            sleep((int) $this->option('delay'));
        }

        foreach (River::all() as $river) {
            ImportRiverData::dispatchSync($river);
        }
    }
}
