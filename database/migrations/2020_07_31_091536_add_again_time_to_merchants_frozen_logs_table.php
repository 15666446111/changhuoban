<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAgainTimeToMerchantsFrozenLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchants_frozen_logs', function (Blueprint $table) {
            
            $table->timestamp('sim_agent_time')->nullable()->comment('SIM流量费下次应收取时间')->after('state');
            
            $table->tinyInteger('sim_agent_state')->default(0)->comment('SIM流量费下次冻结状态')->after('state');

        });

        Schema::table('machines', function (Blueprint $table) {
            
            $table->smallInteger('sim_frozen_num')->default(0)->comment('SIM服务费已收取次数');

        });
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
