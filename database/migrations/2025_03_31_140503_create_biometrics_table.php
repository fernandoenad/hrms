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
        Schema::create('biometrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->references('id')->on('stations');
            $table->string('ip_address',100);
            $table->string('ip_address_2',100)->nullable();
            $table->string('ip_address_3',100)->nullable();
            $table->string('port', 20)->default(4370);
            $table->unique(['ip_address','port']);
            $table->string('description',300)->nullable();
            $table->unsignedInteger('added_by');
            $table->boolean('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biometrics');
    }
};
