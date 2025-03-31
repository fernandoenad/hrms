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
        Schema::create('contribution_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contribution_range_id')->references('id')->on('contribution_ranges')->cascadeOnDelete();

            $table->string('header_name',200)->nullable();
            $table->integer('order')->default(1);
            //employer
            $table->decimal('ee',13,2)->default(0);
            //employee
            $table->decimal('er',13,2)->default(0);

            $table->boolean('is_percent')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contribution_rates');
    }
};
