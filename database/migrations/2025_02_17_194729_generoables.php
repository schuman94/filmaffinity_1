<?php

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
        Schema::create('generoables', function (Blueprint $table) {
            $table->foreignId('genero_id')->constrained();
            $table->morphs('generoable');
            $table->primary(['genero_id', 'generoable_type', 'generoable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generoables');
    }
};
