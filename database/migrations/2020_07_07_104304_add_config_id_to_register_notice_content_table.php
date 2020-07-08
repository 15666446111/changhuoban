<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConfigIdToRegisterNoticeContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('register_notice_content', function (Blueprint $table) {
            
            $table->integer('config_agent_id')->default()->comment('商户通知配置机构号')->after('id');
            
            $table->text('remark')->comment('本条通知备注')->after('version');

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
