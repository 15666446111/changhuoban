<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsBindLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants_bind_logs', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->bigInteger('merchant_code')->default(0)->comment('商户号');

            $table->string('sn')->default('')->comment('sn');

            $table->tinyInteger('bind_state')->default('1')->comment('绑定状态，1正常，0已解绑');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchants_bind_logs');
    }
}
