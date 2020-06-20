<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_settings', function (Blueprint $table) {
            
            $table->bigIncrements('id');

            $table->string('operate_number')->comment('所属操盘或者机构号');

            $table->string('company')->nullable()->comment('公司名称');

            $table->string('phone')->nullable()->comment('联系电话');

            $table->string('email')->nullable()->comment('公司邮箱');

            $table->string('address')->nullable()->comment('公司地址');



            $table->string('alipay_id')->nullable()->comment('支付宝支付应用ID');

            $table->string('alipay_sec')->nullable()->comment('支付宝支付密钥');

            $table->string('alipay_sign')->nullable()->comment('支付宝支付加密串');




            $table->string('wx_id')->nullable()->comment('微信支付应用ID');

            $table->string('wx_sec')->nullable()->comment('微信支付密钥');

            $table->string('wx_sign')->nullable()->comment('微信支付加密串');


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
        Schema::dropIfExists('admin_settings');
    }
}
