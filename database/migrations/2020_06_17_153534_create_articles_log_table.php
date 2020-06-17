<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles_log', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('username')->comment('操作用户');

            $table->integer('articles_id')->comment('文章id');

            $table->string('type')->comment('操作类型');

            $table->string('before_back')->nullable()->comment('修改前');

            $table->text('put')->comment('操作');

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
        Schema::dropIfExists('articles_log');
    }
}
