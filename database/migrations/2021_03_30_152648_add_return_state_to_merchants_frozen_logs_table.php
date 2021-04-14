<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReturnStateToMerchantsFrozenLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchants_frozen_logs', function (Blueprint $table) {
            
            $table->integer('return_state')->default(0)->comment('返现状态，0未返现，1已返现')->after('state');

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
