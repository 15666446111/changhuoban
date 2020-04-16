<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants_table', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            $table->bigIncrements('id');

            $table->integer('user_id')->comment('用户ID');

            $table->bigInteger('code')->comment('商户号');

            $table->string('name')->nullable()->comment('商户名称');

            $table->string('phone')->nullable()->comment('商户电话');

            $table->integer('trade_amount')->default(0)->comment('商户累计交易金额，单位：分');

            $table->string('state')->default(1)->comment('商户状态 0:无效, 1:有效, X：注销');

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
        Schema::dropIfExists('merchants_table');
    }
}
