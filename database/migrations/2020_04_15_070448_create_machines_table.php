<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machines', function (Blueprint $table) {
            
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');

            $table->integer('user_id')->nullable()->comment('归属人');

            $table->string('sn')->comment('机器序列号');

            $table->integer('agent_id')->nullable()->comment('代理商');

            $table->tinyInteger('open_state')->default(0)->comment('开通状态');

            $table->tinyInteger('is_self')->default(0)->comment('是否是自备机');

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
        Schema::dropIfExists('machines');
    }
}
