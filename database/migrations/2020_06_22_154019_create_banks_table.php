<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger("user_id")->comment('用户id');

            $table->string("user_name")->nullable()->comment('用户姓名');

            $table->string("bank_name")->nullable()->comment('银行名称');

            $table->string("bank")->nullable()->comment('银行卡号');

            $table->string("number")->nullable()->comment('身份证号');

            $table->string("open_bank")->nullable()->comment('开户行'); 

            $table->bigInteger("is_default")->default(0)->comment('是否设为默认');

            $table->bigInteger("is_del")->default(0)->comment('是否删除');

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
        Schema::dropIfExists('banks');
    }
}
