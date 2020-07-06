<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivesLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actives_logs', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->bigInteger('merchant_code')->default(0)->comment('商户号');

            $table->string('sn')->default('')->comment('SN码');

            $table->integer('user_id')->default(0)->comment('返现用户id');

            $table->tinyInteger('type')->default(0)->comment('类型，1激活，2达标');

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
        Schema::dropIfExists('actives_logs');
    }
}
