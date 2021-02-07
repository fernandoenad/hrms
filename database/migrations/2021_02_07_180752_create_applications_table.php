<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('code');
            $table->unsignedBigInteger('schoolyear');
            $table->string('position');
            $table->string('major');
            $table->string('level');
            $table->string('type');
            $table->unsignedBigInteger('status');
            $table->unsignedBigInteger('station_id');
            $table->timestamps();

            $table->index('person_id');
            $table->index('station_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
