<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIntoToPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('policies', function (Blueprint $table) {
            
            $table->integer('policy_group_id')->comment('所属活动组')->after('title');

            $table->string('operate')->comment('所属操盘')->after('vip_standard_set');
            
            if (Schema::hasColumn('policies', 'sett_price')) {
                $table->dropColumn('sett_price');
            }

            if (Schema::hasColumn('policies', 'default_push')) {
                $table->dropColumn('default_push');
            }

            if (Schema::hasColumn('policies', 'indirect_push')) {
                $table->dropColumn('indirect_push');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('policies', function (Blueprint $table) {
            //
        });
    }
}
