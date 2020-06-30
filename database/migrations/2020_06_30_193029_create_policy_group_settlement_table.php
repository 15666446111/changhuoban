<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePolicyGroupSettlementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policy_group_settlement', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('policy_group_id')->comment('所属活动组');

            $table->string('trade_type_id')->comment('交易类型表');

            $table->integer('set_price')->comment('当前组结算价');

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
        Schema::dropIfExists('policy_group_settlement');
    }
}
