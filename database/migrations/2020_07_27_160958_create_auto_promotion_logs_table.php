<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoPromotionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_promotion_logs', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->bigInteger('user_id')->comment('审核的用户');

            $table->string('operate')->nullable()->comment('所属操盘');

            $table->tinyInteger('status')->default(1)->comment('审核状态');

            $table->bigInteger('trade_count')->default(0)->comment('上月交易量');

            $table->text('remark')->nullable()->comment('当月的晋升审核标准');

            $table->string('biz')->nullable()->comment('晋升备注');

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
        Schema::dropIfExists('auto_promotion_logs');
    }
}
