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
        Schema::create('attendance_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('biometric_id')->references('id')->on('biometrics');
            $table->integer('uid');
            $table->string('employee_no');
            $table->foreign('employee_no')->references('empno')->on('employees');

            /*
            1 - Fingerprint
            2 - CARD
            */
            $table->integer('state');

            # 0 - Time-in
            # 1 - Time-out
            # 2 - Break-in
            # 3 - Break-out
            # 4 - Overtime-in
            # 5 - Overtime-out
            $table->integer('type');
            $table->date('date');
            $table->time('time');
            $table->unique(['employee_no','date','time'],'b_d_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_data');
    }
};
