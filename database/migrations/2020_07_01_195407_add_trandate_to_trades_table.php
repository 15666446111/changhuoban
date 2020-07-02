<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrandateToTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trades', function (Blueprint $table) {
            
            $table->integer('transDate')->comment('交易日期 (收单系统，交易发生的日期)')->after('card_number');

            $table->string('tranCode')->comment('交易码');

            $table->string('agentId')->comment('商户直属机构号');

            $table->integer('traceNo')->comment('凭证号')->after('trade_time');

            $table->integer('sysTraceNo')->comment('系统流水号')->after('agt_merchant_level');

            $table->integer('inputMode')->nullable()->comment('输入方式');

            $table->string('termId')->comment('终端号')->after('is_send');

            $table->string('originalTranDate')->nullable()->comment('原交易日期');

            $table->string('originalRrn')->nullable()->comment('原交易参考号');

            $table->string('originaltraceNo')->nullable()->comment('原交易凭证号');

            $table->string('originalbatchNo')->nullable()->comment('原交易批次号');

            $table->string('originalAuthCode')->nullable()->comment('原交易授权码');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trades', function (Blueprint $table) {
            //
        });
    }
}
