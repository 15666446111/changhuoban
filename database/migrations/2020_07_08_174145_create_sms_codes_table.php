<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_codes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('phone')->comment('手机号');

            $table->string('code')->comment('验证码');

            $table->tinyInteger('is_use')->default(0)->comment('是否使用');

            $table->timestamp('send_time')->nullable()->comment('发送时间');

            $table->timestamp('out_time')->nullable()->comment('失效时间');

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
        Schema::dropIfExists('sms_codes');
    }
}
