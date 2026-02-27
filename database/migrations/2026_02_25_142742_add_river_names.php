<?php

use App\Models\River;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $river1 = River::find(1);
        $river1->name = 'prollingbach';
        $river1->save();

        $river2 = River::find(2);
        $river2->name = 'schwarzeois';
        $river2->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
