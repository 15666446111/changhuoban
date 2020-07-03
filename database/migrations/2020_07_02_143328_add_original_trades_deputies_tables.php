<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOriginalTradesDeputiesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trades_deputies', function (Blueprint $table) {
            
            $table->string('originalbatchNo')->nullable()->comment('原交易批次号');

            $table->string('originalAuthCode')->nullable()->comment('原交易授权码');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
