<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('action');
            $table->string('remarks');
            $table->unsignedBigInteger('status');
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamps();

            $table->index('person_id');
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
        Schema::dropIfExists('account_requests');
    }
}
