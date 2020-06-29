<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            
            $table->bigIncrements('id');

            $table->string('title')->comment('品牌名称');

            $table->tinyInteger('active')->default(1)->comment('开启状态');

            $table->string('image')->nullable()->comment('产品缩略图');

            $table->tinyInteger('type')->comment('产品分类');

            $table->integer('price')->comment('产品价格')->default(0);

            $table->longText('content')->nullable()->comment('文章内容');

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
        Schema::dropIfExists('products');
    }
}
