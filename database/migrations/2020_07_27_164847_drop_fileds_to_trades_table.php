<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropFiledsToTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trades', function (Blueprint $table) {
            $table->dropColumn([
                'agt_merchant_name',
                'agt_merchant_level',
                'trade_type',
                'card_number',
                'trade_actime',
                'collection_type',
                'audit_status',
                'is_sim',
                'stl_type',
                'scan_flag',
                'clr_flag',
                'is_auth_credit_card',
                'trade_post',
                'rate',
                'rate_money'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trades', function (Blueprint $table) {
            //
        });
    }
}
