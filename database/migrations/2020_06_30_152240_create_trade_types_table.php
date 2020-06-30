<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradeTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade_types', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('name')->comment('类型');

            $table->string('trade_type')->comment('交易类型');  // card_pay   6

            $table->string('card_type')->comment('卡类型');  // 1 贷记卡。2 借记卡 

            $table->string('trade_code')->comment('交易码'); // 4   1 2 3 4

            $table->string('is_top')->comment('是否封顶');  // 1 2 

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
        Schema::dropIfExists('trade_types');
    }
}
