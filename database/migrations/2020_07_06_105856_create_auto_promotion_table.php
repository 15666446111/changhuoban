<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoPromotionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_promotion', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string("operate")->comment('操盘号');

            $table->integer("group_id")->comment('用户组');

            $table->bigInteger('trade_count')->default(0)->comment('自动晋升条件');

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
        Schema::dropIfExists('auto_promotion');
    }
}
