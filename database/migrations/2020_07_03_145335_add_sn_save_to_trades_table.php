<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSnSaveToTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trades', function (Blueprint $table) {

            $table->string('termId')->default('')->change();

            $table->string('sn', 50)->default('')->change();

            $table->string('merchant_code', 50)->default('')->change();

            $table->string('operate')->default('')->change();

            $table->string('tranCode')->default('')->change();

            $table->string('agentId')->default('')->change();

            //$table->string('sysRespDesc')->default('')->change();

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
