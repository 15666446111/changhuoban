<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminApiOperationLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_api_operation_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('u_id')->comment('用户id');
            $table->string('path',100)->comment('路由');
            $table->string('method',10)->comment('请求类型');
            $table->string('ip',20)->nullable()->comment('ip');
            $table->text('input')->comment('请求参数');
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
        Schema::dropIfExists('admin_api_operation_log');
    }
}
