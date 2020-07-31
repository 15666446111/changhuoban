<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSimToPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('policies', function (Blueprint $table) {
            
            $table->integer('sim_short_id')->default(0)->comment('SIM服务费模板id')->after('short_id');

            $table->integer('sim_charge')->default(0)->comment('SIM服务费金额')->after('short_id');

            $table->integer('sim_cycle')->default(0)->comment('SIM服务费扣除周期（月）')->after('short_id');

            $table->integer('sim_delay')->default(0)->comment('SIM服务费延迟扣除月数，开通当前月数后开始扣除')->after('short_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('policies', function (Blueprint $table) {
            
        });
    }
}
