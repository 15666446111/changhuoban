<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemarkToMerchantsFrozenLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchants_frozen_logs', function (Blueprint $table) {
            
            $table->text('remark')->nullable()->comment('描述')->after('return_data');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('merchants_frozen_logs', function (Blueprint $table) {
            //
        });
    }
}
