<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePolicyGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policy_groups', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('title')->nullable()->comment('活动组名称');

            $table->string('operate')->comment('所属操盘方');

            $table->string('type')->comment('联盟方式还是工具方式');

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
        Schema::dropIfExists('policy_groups');
    }
}
