<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminApiUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_api_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',20)->unique('username')->comment('账号');
            $table->string('password')->comment('密码');
            $table->string('name')->comment('用户名');
            $table->string('avatar')->comment('头像');
            $table->string('remember_token')->nullable();
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
        Schema::dropIfExists('admin_api_users');
    }
}
