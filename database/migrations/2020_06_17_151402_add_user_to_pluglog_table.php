<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserToPluglogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pluglog', function (Blueprint $table) {
            
            $table->string('username')->comment('操作用户');

            $table->string('before_back')->comment('修改前');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pluglog', function (Blueprint $table) {
            //
        });
    }
}
