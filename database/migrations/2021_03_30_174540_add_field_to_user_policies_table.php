<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToUserPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_policies', function (Blueprint $table) {
            
            $table->integer('service_fee')->default(0)->comment('流量卡返现金额')->after('vip_active_set');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_policies', function (Blueprint $table) {
            //
        });
    }
}
