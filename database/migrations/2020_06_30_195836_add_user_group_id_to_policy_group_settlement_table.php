<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserGroupIdToPolicyGroupSettlementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('policy_group_settlement', function (Blueprint $table) {
            
            $table->string('user_group_id')->after('trade_type_id')->comment('用户组');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('policy_group_settlement', function (Blueprint $table) {
            //
        });
    }
}
