<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePolicyGroupRateLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policy_group_rate_logs', function (Blueprint $table) {
            
            $table->bigIncrements('id');
        
            $table->integer('policy_group_id')->default(0)->comment('活动组id');

            $table->integer('rate_type_id')->default(0)->comment('费率类型id');
        
            $table->integer('price')->default(0)->comment('调整额度(十万分位)');

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
        Schema::dropIfExists('policy_group_rate_logs');
    }
}
