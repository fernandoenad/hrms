<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->string('fiscalcategory');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('services');
            $table->unsignedBigInteger('office_id');
            $table->string('address')->nullable();
            $table->string('category')->nullable();
            $table->unsignedBigInteger('person_id')->nullable();
            $table->timestamps();

            $table->index('office_id');
            $table->index('person_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stations');
    }
}
