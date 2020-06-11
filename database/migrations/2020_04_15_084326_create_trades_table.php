<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->integer('user_id')->nullable()->comment('用户ID');

            $table->integer('machine_id')->nullable()->comment('机器ID');

            $table->integer('is_send')->default(0)->comment('分润发放状态');

            $table->integer('sn')->nullable()->comment('机器序列号');

            $table->integer('merchant_code')->comment('商户号');

            $table->integer('amount')->default(0)->comment('交易金额，单位：分');

            $table->integer('settle_amount')->default(0)->comment('结算金额，单位：分');

            $table->tinyInteger('cardType')->nullable()->comment('交易卡类型，0贷记卡，1借记卡');

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
        Schema::dropIfExists('trades');
    }
}
