<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->unsignedBigInteger('person_id');
            $table->string('primaryno')->nullable();
            $table->string('secondaryno')->nullable();
            $table->string('emergencyperson')->nullable();
            $table->string('emergencyrelation')->nullable();
            $table->string('emergencyaddress')->nullable();
            $table->string('emergencycontact')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('contacts');
    }
}
