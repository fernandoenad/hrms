<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePUserLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_user_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('u_id');
            $table->string('action');
            $table->text('log');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->index('u_id');
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
        Schema::dropIfExists('p_user_logs');
    }
}
