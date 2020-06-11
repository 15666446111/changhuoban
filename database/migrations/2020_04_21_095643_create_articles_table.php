<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('title')->nullable()->comment('文章标题');

            $table->tinyInteger('active')->default(1)->comment('开启状态');

            $table->string('images')->nullable()->comment('缩略图');

            $table->tinyInteger('type_id')->comment('文章类型');

            $table->string('verify')->default(0)->comment('是否审核');

            $table->string('operate')->nullable()->comment('操盤号');

            $table->longText('content')->nullable()->comment('操盤号');

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
        Schema::dropIfExists('articles');
    }
}
