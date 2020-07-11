<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStateToRegisterNoticeContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('register_notice_content', function (Blueprint $table) {
            
            $table->tinyInteger('state')->default(0)->comment('冻结状态，1正常，2异常')->after('remark');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('register_notice_content', function (Blueprint $table) {
            //
        });
    }
}
