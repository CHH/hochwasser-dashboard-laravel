<?php

namespace Database\Seeders;

use App\Models\River;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        River::create([
            'name' => 'prollingbach',
            'pegel_id' => 301,
        ]);
        River::create([
            'name' => 'schwarzeois',
            'pegel_id' => 302,
        ]);
    }
}
