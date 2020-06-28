<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTradeCountToUserGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_groups', function (Blueprint $table) {
            
            $table->bigInteger('trade_count')->default(0)->comment('自动晋升条件')->after('level');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_group', function (Blueprint $table) {
            //
        });
    }
}
