<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropRealPayToWithdrawsDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withdraws_datas', function (Blueprint $table) {
            
            $table->dropColumn('repay_wallet');
            
            $table->dropColumn('repay_money');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withdraws_datas', function (Blueprint $table) {
            //
        });
    }
}
