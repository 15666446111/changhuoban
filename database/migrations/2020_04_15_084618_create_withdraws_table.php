<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraws', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->integer('user_id')->comment('用户ID');

            $table->string('order_no')->comment('订单号');

            $table->integer('money')->default(0)->comment('提现金额');

            $table->integer('real_money')->default(0)->comment('实际打款金额');

            $table->tinyInteger('type')->comment('类型，1分润提现，2返现提现');

            $table->tinyInteger('state')->default(1)->comment('状态，1待审核，2通过，3驳回');

            $table->tinyInteger('make_state')->comment('打款状态：1成功，2失败');

            $table->timestamp('check_at')->nullable()->comment('审核时间');

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
        Schema::dropIfExists('withdraws');
    }
}
