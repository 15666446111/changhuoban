<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashs', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->integer('user_id')->default(0)->comment('用户id');

            $table->string('order')->default('')->comment('交易订单号');

            $table->integer('cash_money')->default(0)->comment('分润金额');

            $table->tinyInteger('is_run')->default(0)->comment('是否是分润，1分润，0返现');

            $table->tinyInteger('cash_type')->default(0)->comment('分润类型');

            $table->string('remark')->default('')->comment('分润备注');

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
        Schema::dropIfExists('cashs');
    }
}
