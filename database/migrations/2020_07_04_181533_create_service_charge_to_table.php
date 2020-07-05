<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceChargeToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_charge', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('agentId')->nullable()->comment('渠道编号');

            $table->string('token')->nullable()->comment('令牌');

            $table->string('traceNo')->nullable()->comment('请求流水号');

            $table->string('merchId')->nullable()->comment('商户号');

            $table->string('directAgentId')->nullable()->comment('商户直属代理商编号');

            $table->string('sn')->nullable()->comment('终端SN序列号');

            $table->string('posCharge')->nullable()->comment('POS服务费金额(元)');

            $table->string('vipCharge')->nullable()->comment('VIP会员服务费金额(元)');

            $table->string('simCharge')->nullable()->comment('SIM服务费金额(元)');

            $table->string('smsSend')->nullable()->comment('是否发送短信');

            $table->string('smsCode')->nullable()->comment('短信模板编号');

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
        Schema::dropIfExists('service_charge_to');
    }
}
