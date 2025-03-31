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
        Schema::create('contribution_ranges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contribution_id')->references('id')->on('contributions')->cascadeOnDelete();
            $table->decimal('from',13,2)->default(0);
            $table->decimal('to',13,2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contribution_ranges');
    }
};
