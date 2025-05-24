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
        Schema::create('dtr_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('generated_by')->references('id')->on('users');
            $table->date('from_date');
            $table->date('to_date');

            $table->datetime('closed_at')->nullable();
            $table->foreignId('closed_by')->references('id')->on('users');
            
            $table->datetime('submitted')->nullable();
            $table->datetime('posted')->nullable();
            $table->integer('status')->default(S_PENDING);
            $table->text('remarks')->nullable();
            $table->text('reject_comments')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dtr_data');
    }
};
