<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePolicyGroupRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policy_group_rates', function (Blueprint $table) {
            
            $table->bigIncrements('id');

            $table->bigInteger('policy_group_id')->default(0)->comment('活动组id');

            $table->bigInteger('rate_type_id')->default(0)->comment('费率类型id');

            $table->integer('min_rate')->default(0)->comment('可调整费率最小值，十万分位');

            $table->integer('max_rate')->default(0)->comment('可调整费率最大值，十万分位');

            $table->tinyInteger('is_abjustable')->default(0)->comment('是否可调整');

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
        Schema::dropIfExists('policy_group_rates');
    }
}
