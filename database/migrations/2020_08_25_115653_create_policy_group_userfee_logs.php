<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePolicyGroupUserfeeLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policy_group_userfee_logs', function (Blueprint $table) {

            $table->bigIncrements('id');
        
            $table->integer('policy_group_id')->default(0)->comment('活动组id');

            $table->integer('trade_type_id')->default(0)->comment('交易类型id');
        
            $table->integer('inc_price')->default(0)->comment('调整额度，自增(借记卡封顶类为百分位，其它交易类型为十万分位)');

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
        Schema::dropIfExists('policy_group_userfee_logs');
    }
}
