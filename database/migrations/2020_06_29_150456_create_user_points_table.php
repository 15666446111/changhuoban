<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_points', function (Blueprint $table) {
            
            $table->bigIncrements('id');

            $table->integer('user_id')->comment('用户id');

            $table->string('rate')->comment('分润提现税点');

            $table->integer('rate_m')->comment('分润提现单笔提现费');

            $table->string('return_blance')->comment('返现提现税点');

            $table->integer('return_money')->comment('返现提现单笔提现费');

            $table->integer('no_check')->comment('免审核额度')->default(0);

            $table->string('verify')->default(0)->comment('是否审核');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_points');
    }
}
