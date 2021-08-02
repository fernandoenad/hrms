<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePBBReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_b_b_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('year');
            $table->unsignedBigInteger('station_id');
            $table->unsignedBigInteger('employee_id');
            $table->string('empno');
            $table->unsignedBigInteger('length_of_service');
            $table->unsignedBigInteger('salary_grade');
            $table->unsignedBigInteger('step');
            $table->double('ipcr_score');
            $table->unsignedBigInteger('qualified');
            $table->unsignedBigInteger('status');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->index('station_id');
            $table->index('employee_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p_b_b_reports');
    }
}
