<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRealnamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_realnames', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id')->comment('会员ID');

            $table->tinyInteger('status')->comment('实名状态')->default(0);

            $table->string('name')->nullable()->comment('姓名');

            $table->string('idcard')->nullable()->comment('身份证号');

            $table->string('card_before')->nullable()->comment('身份证正面照片');

            $table->string('card_after')->nullable()->comment('身份证反面照片');

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
        Schema::dropIfExists('user_realnames');
    }
}
