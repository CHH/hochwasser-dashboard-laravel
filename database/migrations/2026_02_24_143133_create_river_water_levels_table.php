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
        Schema::create('river_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(River::class);
            $table->dateTime('timestamp');
            $table->decimal('value');

            $table->unique(['river_id', 'timestamp']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('river_levels');
    }
};
