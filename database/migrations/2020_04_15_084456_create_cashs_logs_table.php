<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashs_logs', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->integer('user_id')->comment('用户ID');

            $table->integer('machine_id')->comment('机器ID');

            $table->integer('trade_id')->default(0)->comment('交易ID');

            $table->integer('money')->default(0)->comment('分润金额，单位：分');

            $table->tinyInteger('is_run')->comment('1分润，2返现');

            $table->tinyInteger('type')->comment('类型，1直营分润，2团队分润，3激活返现，4间推激活返现，5间间推激活返现，6达标返现，7二次达标返现，8三次达标返现，9财商学院推荐奖励');

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
        Schema::dropIfExists('cashs_logs');
    }
}
