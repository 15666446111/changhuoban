<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInfoToMerchantsRateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchants_rate_types', function (Blueprint $table) {
            
            $table->bigInteger('trade_type_id')->nullable()->comment('交易类型id')->after('default_max_rate');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('merchants_rate_types', function (Blueprint $table) {
            //
        });
    }
}
