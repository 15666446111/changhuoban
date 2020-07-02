<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradesDeputiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trades_deputies', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('sendBatchNo')->comment('交易通知推送批次号');

            $table->bigInteger('tranTime')->comment('交易时间（接口推送）');

            $table->string('cardNo')->nullable()->comment('卡号(带*)');

            $table->string('authCode')->nullable()->comment('授权码');

            $table->integer('batchNo')->nullable()->comment('终端批次号');

            $table->string('orderId')->nullable()->comment('订单号');

            $table->string('bankName')->nullable()->comment('发卡行');

            $table->string('version')->nullable()->comment('助贷通版本号');

            $table->string('activeStat')->nullable()->comment('商户终端激活状态，0-未激活 1-已激活 2-已处理');

            $table->string('termBindDate')->nullable()->comment('助贷通活动终端绑定日期');

            $table->string('merchLevel')->nullable()->comment('商户类别 1-A类商户； 2-B类商户；3-C类商户；4-Z类商户');

            $table->string('termModel')->nullable()->comment('终端型号');

            $table->string('mobileNo')->nullable()->comment('商户手机号');

            $table->string('merchantName')->nullable()->comment('商户名称');

            $table->string('settleDate')->nullable()->comment('清算日期');

            $table->string('sysRespCode')->comment('收单平台应答码');

            $table->string('sysRespDesc')->comment('收单平台应答描述');

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
        Schema::dropIfExists('trades_deputies');
    }
}
