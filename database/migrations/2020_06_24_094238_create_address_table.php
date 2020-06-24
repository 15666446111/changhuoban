<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger("user_id")->comment('用户id');

            $table->string("name")->nullable()->comment('收货人');

            $table->string("tel")->nullable()->comment('电话');

            $table->string("province")->nullable()->comment('省');

            $table->string("city")->nullable()->comment('市'); 

            $table->string("area")->nullable()->comment('区'); 

            $table->text("detail")->nullable()->comment('详细地址'); 

            $table->string("is_default")->nullable()->comment('是否为默认地址'); 

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
        Schema::dropIfExists('address');
    }
}
