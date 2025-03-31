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
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            $table->integer('order')->unique();
            $table->string('contrib_name',150)->unique();
            $table->text('description')->nullable();
            $table->boolean('is_government')->default(1);
            $table->boolean('active')->default(1);
            $table->integer('deduction_type')->default();
            $table->integer('month_deduction')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
