<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachinesFactoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machines_factories', function (Blueprint $table) {
            
            $table->bigIncrements('id');

            $table->string('factory_name')->nullable()->comment('厂商名称');

            $table->tinyInteger('type_id')->comment('所属类型');

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
        Schema::dropIfExists('machines_factories');
    }
}
