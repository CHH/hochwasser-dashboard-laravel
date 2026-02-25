<?php

namespace Tests\Feature;

use App\Models\River;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class RiverTest extends TestCase
{
    use RefreshDatabase;

    public function test_river_show_page_returns_successful_response(): void
    {
        $river = River::create([
            'pegel_id' => '301',
            'data' => ['Key' => ['cPegel' => 'Test River', 'cLinie1' => 100, 'cLinie2' => 150, 'cLinie3' => 200, 'cKurzeinheit' => 'cm'], 'Value' => ['Value' => 50, 'Key' => now()->toIso8601String()]],
        ]);

        $response = $this->withoutVite()->get("/rivers/{$river->pegel_id}");

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) =>
            $page->component('River/Show')
        );
    }

    public function test_river_show_page_returns_404_for_unknown_river(): void
    {
        $response = $this->withoutVite()->get('/rivers/nonexistent');

        $response->assertStatus(404);
    }
}
