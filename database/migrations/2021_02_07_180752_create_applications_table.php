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
            $table->unsignedBigInteger('vacancy_id');
            $table->unsignedBigInteger('code');
            $table->unsignedBigInteger('schoolyear');
            $table->string('pertdoc_soft')->nullable();
            $table->unsignedBigInteger('pertdoc_hard');
            $table->string('type');
            $table->unsignedBigInteger('status');       
            $table->string('remarks')->nullable();      
            $table->unsignedBigInteger('station_id')->nullable();
            $table->timestamps();

            $table->index('person_id');
            $table->index('vacancy_id');
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
