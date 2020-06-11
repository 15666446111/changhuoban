<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugs', function (Blueprint $table) {

            $table->bigIncrements('id');
            
            $table->string('name')->nullable()->comment('轮播标题');

            $table->tinyInteger('active')->default(1)->comment('开启状态');

            $table->tinyInteger('type_id')->comment('所属类型');

            $table->string('images')->nullable()->comment('图片地址');

            $table->tinyInteger('sort')->default(0)->comment('排序权重');

            $table->string('href')->nullable()->default("#")->comment('链接地址');

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
        Schema::dropIfExists('plugs');
    }
}
