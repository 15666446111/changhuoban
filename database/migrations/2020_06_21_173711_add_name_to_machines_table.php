<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameToMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('machines', function (Blueprint $table) {

            $table->string('machine_name')->nullable()->comment("商户名称");

            $table->string("machine_phone")->nullable()->comment("商户电话");

            $table->tinyInteger("bind_status")->default(0)->comment("绑定状态 0未绑定");

            $table->timestamp("bind_time")->nullable()->comment("绑定时间");

            $table->smallInteger("standard_status")->default(0)->comment("达标状态");

            $table->timestamp("open_time")->nullable()->comment("开通时间");

            $table->smallInteger("standard_status_lj")->default(1)->comment("累计达标状态");            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('machines', function (Blueprint $table) {
            //
        });
    }
}
