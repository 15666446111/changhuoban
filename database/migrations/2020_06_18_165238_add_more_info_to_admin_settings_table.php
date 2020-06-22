<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreInfoToAdminSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_settings', function (Blueprint $table) {

            $table->tinyInteger('open')->default(1)->comment('机构/操盘状态')->after('operate_number');

            $table->string('remark')->nullable()->comment('关闭原因')->after('open');

            $table->tinyInteger('pattern')->default(1)->comment('模式 1=联盟模式。2=工具模式 ')->after('remark');

            $table->string('register_merchant')->nullable()->comment('商户注册链接')->after('remark');

            


            $table->string('system_merchant')->nullable()->comment('3.0机构编号')->after('register_merchant');

            $table->string('system_secret')->nullable()->comment('3.0渠道密钥')->after('system_merchant');


            // 代付资料 
            $table->tinyInteger('payment_type')->default(1)->comment('代付方式 1=畅伙伴。2=畅捷 ')->after('system_secret');

            $table->string('payment_merchant')->nullable()->comment('代付商户号')->after('payment_type');

            $table->string('payment_secret')->nullable()->comment('代付密钥')->after('payment_merchant');
            // 
            // 
            //
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


        });
    }
}
