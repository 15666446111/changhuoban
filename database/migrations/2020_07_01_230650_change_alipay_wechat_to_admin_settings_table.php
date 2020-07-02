<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAlipayWechatToAdminSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_settings', function (Blueprint $table) {
            
            $table->longText('alipay_sec')->nullable()->comment('支付宝支付密钥')->change();

            $table->longText('alipay_sign')->nullable()->comment('支付宝支付加密串')->change();

            $table->longText('wx_sec')->nullable()->comment('微信支付密钥')->change();

            $table->longText('wx_sign')->nullable()->comment('微信支付加密串')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_settings', function (Blueprint $table) {
            //
        });
    }
}
