<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachinesStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machines_styles', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('style_name')->nullable()->comment('型号名称');

            $table->tinyInteger('factory_id')->comment('所属厂商');

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
        Schema::dropIfExists('machines_styles');
    }
}
