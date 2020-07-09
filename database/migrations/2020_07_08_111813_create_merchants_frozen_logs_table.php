<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsFrozenLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants_frozen_logs', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->bigInteger('merchant_code')->default(0)->comment('商户号');

            $table->string('sn')->default('')->comment('sn');

            $table->tinyInteger('type')->default(0)->comment('类型，1: pos服务费冻结，2: 流量卡费冻结，3:vip会员费冻结');

            $table->integer('frozen_money')->default(0)->comment('冻结金额，单位分');

            $table->tinyInteger('state')->comment('冻结状态');

            $table->text('return_data')->comment('接口返回数据');

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
        Schema::dropIfExists('merchants_frozen_logs');
    }
}
