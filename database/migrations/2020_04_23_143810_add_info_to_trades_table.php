<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoToTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trades', function (Blueprint $table) {

            $table->string('trade_no')->nullable()->comment('交易流水号')->first();

            $table->string('rrn')->nullable()->comment('参考号')->after('merchant_code');
            //
            $table->timestamp('trade_time')->nullable()->comment('交易时间')->after('cardType');
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
