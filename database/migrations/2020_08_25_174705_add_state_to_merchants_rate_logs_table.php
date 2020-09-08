<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStateToMerchantsRateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchants_rate_logs', function (Blueprint $table) {
            
            $table->tinyInteger('state')->default(1)->comment('状态，1成功 0失败')->after('adjust_user_id');

            $table->text('remark')->nullable()->comment('描述')->after('adjust_user_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('merchants_rate_logs', function (Blueprint $table) {
            //
        });
    }
}
