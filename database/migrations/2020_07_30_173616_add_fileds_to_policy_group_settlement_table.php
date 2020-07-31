<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiledsToPolicyGroupSettlementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('policy_group_settlement', function (Blueprint $table) {
            
            $table->integer('default_price')->default(0)->comment('默认结算价')->after('set_price');

            $table->integer('min_price')->default(0)->comment('最低结算价')->after('default_price');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('policy_group_settlement', function (Blueprint $table) {
            //
        });
    }
}
