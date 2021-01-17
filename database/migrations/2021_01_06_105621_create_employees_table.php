<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('person_id');
            $table->string('empno')->unique();
            $table->date('hiredate');
            $table->integer('step');
            $table->date('lastapptdate');
            $table->date('lastnosidate')->nullable();
            $table->date('retirementdate')->nullable();
            $table->string('employmentstatus');
            $table->string('tinno')->nullable();
            $table->string('gsisbpno')->nullable();
            $table->string('philhealthno')->nullable();
            $table->string('pagibigid')->nullable();
            $table->string('dbpaccountno')->nullable();
            $table->unsignedBigInteger('item_id')->unique();
            $table->timestamps();

            $table->index('person_id');
            $table->index('item_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
