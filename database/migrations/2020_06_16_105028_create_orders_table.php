<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('order_no')->comment('订单编号');

            $table->string('user_id')->comment('用户id');

            $table->string('product_id')->comment('产品id');

            $table->string('product_price')->comment('产品单价');

            $table->string('numbers')->comment('购买数量');

            $table->string('price')->comment('订单总价');

            $table->string('address')->comment('配送地址');

            $table->string('status')->default(0)->comment('订单状态');

            $table->string('remark')->nullable()->comment('订单备注');

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
        Schema::dropIfExists('orders');
    }
}
