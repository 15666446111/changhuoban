<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawsDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraws_datas', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('order_no')->comment('提现订单号');

            $table->integer('phone')->comment('预留手机号');

            $table->string('username')->comment('用户姓名');

            $table->string('idcard')->comment('身份证号');

            $table->string('bank')->comment('银行名称');

            $table->string('bank_open')->nullable()->comment('开户行');

            $table->bigInteger('banklink')->nullable()->comment('联行号');

            $table->integer('repay_money')->nullable()->default(0)->comment('代付系统打款金额');

            $table->integer('repay_wallet')->nullable()->default(0)->comment('代付系统打款金额');

            $table->string('reason')->nullable()->comment('说明');

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
        Schema::dropIfExists('withdraws_datas');
    }
}
