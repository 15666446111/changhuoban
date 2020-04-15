<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('users', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            $table->bigIncrements('id');

            $table->string('nickname')->nullable()->comment('会员昵称');

            $table->string('account')->comment('会员账号');

            $table->string('avatar')->nullable()->comment('会员头像')->default('images/avatar.png');

            $table->string('password')->comment('会员密码');

            $table->tinyInteger('user_group')->comment('用户组');

            $table->integer('parent')->comment('上级ID')->default(0);

            $table->string('last_ip')->nullable()->comment('最后登录地址');

            $table->timeStamp('last_time')->nullable()->comment('最后登录时间');

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
        Schema::dropIfExists('users');
    }
}
