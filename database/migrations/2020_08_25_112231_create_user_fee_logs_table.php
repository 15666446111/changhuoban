<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFeeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_fee_logs', function (Blueprint $table) {

            $table->bigIncrements('id');
            
            $table->bigInteger('user_id')->default(0)->comment('用户id');

            $table->integer('policy_group_id')->default(0)->comment('活动组id');

            $table->integer('trade_type_id')->default(0)->comment('交易类型id');

            $table->integer('old_settlement')->default(0)->comment('调整前结算价');

            $table->integer('new_settlement')->default(0)->comment('调整后结算价');

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
        Schema::dropIfExists('user_fee_logs');
    }
}
