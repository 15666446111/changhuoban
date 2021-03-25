<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldsToMerchantsFrozenLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchants_frozen_logs', function (Blueprint $table) {
            
            $table->dropColumn('sim_agent_state');

        });

        DB::statement("ALTER TABLE `merchants_frozen_logs` CHANGE `state` `state` TINYINT DEFAULT 0 NOT NULL COMMENT '状态，0未冻结、1已发起、2发起失败、3冻结成功、-1订单取消'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('merchants_frozen_logs', function (Blueprint $table) {
            //
        });
    }
}
