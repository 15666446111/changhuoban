<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminShortTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_short', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('number')->nullable()->comment('短信编号');

            $table->string('content')->nullable()->comment('短信内容');

            $table->string('operate')->comment('操盘号');

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
        Schema::dropIfExists('admin_short');
    }
}
