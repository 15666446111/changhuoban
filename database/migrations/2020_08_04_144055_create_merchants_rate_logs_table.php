<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsRateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants_rate_logs', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->bigInteger('merchant_code')->default(0)->comment('商户号');

            $table->bigInteger('policy_group_id')->default(0)->comment('活动组id');

            $table->text('original_rate')->nullable()->comment('调整前费率');

            $table->text('adjust_rate')->nullable()->comment('调整后费率');

            $table->integer('adjust_user_id')->default(0)->comment('调整用户id');

            $table->string('operate')->default('')->comment('操盘号');

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
        Schema::dropIfExists('merchants_rate_logs');
    }
}
