<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            
            $table->bigIncrements('id');

            $table->string('operate')->comment('操盘号');

            $table->tinyInteger('withdraw_open')->default(1)->comment('开启提现');

            $table->integer('rate')->default(5)->comment('分润提现税点, 百分位');

            $table->integer('rate_m')->default(300)->comment('分润提现单笔提现费 单位分');

            $table->string('return_blance')->default(5)->comment('返现提现税点 百分位');

            $table->integer('return_money')->default(300)->comment('返现提现单笔提现费 单位分');

            $table->integer('no_check')->comment('分润免审核额度')->default(0);

            $table->integer('no_check_return')->comment('返现免审核额度')->default(0);

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
        Schema::dropIfExists('settings');
    }
}
