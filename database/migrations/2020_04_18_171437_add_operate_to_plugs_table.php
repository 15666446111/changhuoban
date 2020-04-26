<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOperateToPlugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plugs', function (Blueprint $table) {
            $table->string('verify')->default(0)->comment('是否审核')->after('href');
            $table->string('operate')->nullable()->comment('操盤号')->after('href');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plugs', function (Blueprint $table) {
            //
        });
    }
}
