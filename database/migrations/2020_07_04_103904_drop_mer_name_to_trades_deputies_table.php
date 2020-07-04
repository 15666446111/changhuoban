<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropMerNameToTradesDeputiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trades_deputies', function (Blueprint $table) {

            $table->dropColumn('mobileNo');
            
            $table->dropColumn('merchantName');
            
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
