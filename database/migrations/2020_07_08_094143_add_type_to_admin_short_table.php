<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToAdminShortTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_short', function (Blueprint $table) {
            
            $table->tinyInteger('type')->default(0)->comment('类型，1: 服务费短信，2: 流量卡费短信，3:vip会员费短信');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_short', function (Blueprint $table) {
            //
        });
    }
}
