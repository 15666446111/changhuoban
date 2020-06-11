<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachinesTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machines_types', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('name')->comment('型号名称');

            $table->tinyInteger('state')->default(1)->comment('开启状态');

            $table->integer('sort')->default(0)->comment('排序权重');

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
        Schema::dropIfExists('machines_types');
    }
}
