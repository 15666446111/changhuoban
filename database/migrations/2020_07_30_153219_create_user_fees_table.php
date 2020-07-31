<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_fees', function (Blueprint $table) {
            
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->comment('用户');

            $table->integer('policy_group_id')->comment('活动组');

            $table->text('price')->nullable()->comment('结算价');

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
        Schema::dropIfExists('user_fees');
    }
}
