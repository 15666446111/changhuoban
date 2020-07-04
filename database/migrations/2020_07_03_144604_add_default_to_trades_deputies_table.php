<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultToTradesDeputiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trades_deputies', function (Blueprint $table) {
            
            $table->integer('trade_id')->default(0)->change();
            
            $table->string('sendBatchNo')->default('')->change();
            
            $table->string('tranTime', 50)->default(0)->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trades_deputies', function (Blueprint $table) {
            //
        });
    }
}
