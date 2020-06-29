<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTradesinfoToTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trades', function (Blueprint $table) {
            
            $table->integer('rate')->comment('交易费率')->default(0);

            $table->integer('rate_money')->comment('交易手续费')->default(0);

            $table->string("agt_merchant_id")->nullable()->after('merchant_code')->comment('渠道商户号');

            $table->string("agt_merchant_name")->nullable()->after('agt_merchant_id')->comment('渠道商户名称');

            $table->string("agt_merchant_level")->nullable()->after('agt_merchant_name')->comment('渠道商级别');

            $table->string("merchant_name")->nullable()->after('sn')->comment('商户编号名称');

            $table->string("fee_type")->nullable()->after('rate_money')->comment('手续费类型');

            $table->string("card_number")->nullable()->after('cardType')->comment('交易卡号');

            $table->string("collection_type")->nullable()->after('trade_time')->comment('收款类型');

            $table->string("audit_status")->nullable()->after('collection_type')->comment('清算状态');

            $table->string("is_sim")->nullable()->after('audit_status')->comment('流量卡费');

            $table->string("stl_type")->nullable()->after('is_sim')->comment('结算标示');

            $table->string("scan_flag")->nullable()->after('stl_type')->comment('正反扫标识');

            $table->string("clr_flag")->nullable()->after('scan_flag')->comment('调价');

            $table->string("is_auth_credit_card")->nullable()->after('clr_flag')->comment('是否本人卡');

            $table->timestamp("trade_actime")->nullable()->after('trade_time')->comment('交易接收时间');

            $table->string("remark")->nullable()->after('trade_time')->comment('本条交易备注');

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
