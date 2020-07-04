<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSaveIstopToTradeTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trade_types', function (Blueprint $table) {
            
            $table->string('is_top')->default(0)->change();

            $table->string('card_type')->nullable()->comment('卡类型0:借记卡，1:信用卡')->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trade_types', function (Blueprint $table) {
            //
        });
    }
}
