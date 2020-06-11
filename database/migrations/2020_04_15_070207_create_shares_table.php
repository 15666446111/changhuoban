<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shares', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('title')->nullable()->comment('分享标题');

            $table->tinyInteger('active')->default(1)->comment('开启状态');

            $table->string('images')->nullable()->comment('素材地址');

            $table->tinyInteger('type_id')->comment('类型ID');

            $table->integer('sort')->default(0)->comment('排序权重');

            $table->integer('code_size')->default(100)->comment('二维码大小');

            $table->integer('code_x')->default(100)->comment('二维码X轴位置');

            $table->integer('code_y')->default(100)->comment('二维码Y轴位置');

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
        Schema::dropIfExists('shares');
    }
}
