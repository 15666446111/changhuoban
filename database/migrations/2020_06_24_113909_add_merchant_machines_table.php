<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMerchantMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('machines', function (Blueprint $table) {

            $table->integer('merchant_id')->default(0)->comment('商户id')->after('style_id');

            $table->tinyInteger('activate_state')->default(0)->comment('激活状态')->after('bind_time');

            $table->timestamp('activate_time')->nullable()->comment('激活时间')->after('bind_time');

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
