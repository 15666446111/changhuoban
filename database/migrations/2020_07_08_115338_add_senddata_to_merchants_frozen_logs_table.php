<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSenddataToMerchantsFrozenLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchants_frozen_logs', function (Blueprint $table) {
            
            $table->text('send_data')->comment('接口请求数据')->after('state');

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
