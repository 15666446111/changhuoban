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

            $table->id();

            $table->integer('user_id')->comment('用户ID');

            $table->integer('machine_id')->comment('机器ID');

            $table->integer('trade_id')->default(0)->comment('交易ID');

            $table->integer('money')->default(0)->comment('分润金额，单位：分');

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
