<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holidays', function (Blueprint $table) {

            $table->bigIncrements('id');
            
            $table->string('title')->comment('节假日标题');

            $table->timestamp('start_time')->nullable()->comment('开始时间');

            $table->timestamp('end_time')->nullable()->comment('结束时间');

            $table->timestamps();
        
        });
    }

    /**
     * 
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holidays');
    }
}
