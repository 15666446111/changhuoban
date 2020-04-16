<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            $table->bigIncrements('id');

            $table->unsignedBigInteger('machine_id')->comment('机器ID');

            $table->foreign('machine_id')->references('id')->on('machines')->onDelete('cascade');

            $table->integer('old_user_id')->comment('划拨前用户');

            $table->integer('new_user_id')->comment('划拨后用户');

            $table->tinyInteger('state')->comment('类型 1划拨，2回拨');

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
        Schema::dropIfExists('transfers');
    }
}
