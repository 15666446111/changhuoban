<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policies', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('title')->comment('政策活动');

            $table->tinyInteger('active')->comment('状态')->default(1);

            $table->integer('sett_price')->comment('结算价')->default(0);

            $table->longText('active_return')->comment('激活返现')->nullable();

            $table->longText('standard')->comment('达标奖励')->nullable();

            $table->longText('standard_count')->comment('累计达标返现奖励')->nullable();

            $table->longText('sett_price')->nullable()->change();

            $table->smallInteger('default_push')->default(0)->comment('直接分润比例');

            $table->smallInteger('indirect_push')->default(0)->comment('间接分润比例');

            $table->smallInteger('default_active')->default(0)->comment('直推激活奖励');

            $table->smallInteger('indirect_active')->default(0)->comment('间推激活奖励');

            $table->string('default_active_set')->default(0)->comment('普通用户返现设置');

            $table->string('vip_active_set')->default(0)->comment('代理用户返现设置');

            $table->text('default_standard_set')->nullable()->comment('普通用户达标设置');

            $table->text('vip_standard_set')->nullable()->comment('代理用户达标设置');

            $table->dropColumn([ 'active_return', 'standard', 'standard_count' ]);

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
        Schema::dropIfExists('policies');
    }
}
