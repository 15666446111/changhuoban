<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_logs', function (Blueprint $table) {

            $table->bigIncrements('id');
            // 操作账号
            $table->string('account')->nullable();
            // 操作说明
            $table->string('handle')->nullable();
            // 操作前数据
            $table->text('before')->nullable();
            // 操作后数据
            $table->text('after')->nullable();

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
        Schema::dropIfExists('admin_logs');
    }
}
