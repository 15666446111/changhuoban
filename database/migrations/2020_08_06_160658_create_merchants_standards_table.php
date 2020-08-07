<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsStandardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants_standards', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('sn')->default('')->comment('sn');

            $table->bigInteger('merchant_code')->default(0)->comment('商户号');

            $table->integer('policy_id')->default(0)->comment('达标的政策');

            $table->smallInteger('index')->default(0)->comment('达标的索引');

            $table->text('remark')->nullable()->comment('达标的情况');

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
        Schema::dropIfExists('merchants_standards');
    }
}
