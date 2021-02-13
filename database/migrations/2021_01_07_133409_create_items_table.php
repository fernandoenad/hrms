<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('itemno')->unique();
            $table->string('level');
            $table->date('creationdate');
            $table->string('position');
            $table->string('salarygrade');
            $table->string('employeetype');
            $table->date('appointmentdate')->nullable();
            $table->date('firstdaydate')->nullable();
            $table->date('confirmationdate')->nullable();
            $table->unsignedBigInteger('station_id')->nullable();
            $table->integer('status');
            $table->string('remarks')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('items');
    }
}
