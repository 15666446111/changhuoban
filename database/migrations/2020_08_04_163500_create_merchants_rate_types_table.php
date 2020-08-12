<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsRateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants_rate_types', function (Blueprint $table) {
            
            $table->bigIncrements('id');

            $table->string('type', 50)->default('')->comment('费率类型');

            $table->string('type_name')->default('')->comment('费率类型描述');

            $table->string('is_top')->default(0)->comment('是否是借记卡封顶类费率');

            $table->integer('default_min_rate')->default(0)->comment('可调整最小费率默认值，十万分位');

            $table->integer('default_max_rate')->default(0)->comment('可调整最大费率默认值，十万分位');

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
        Schema::dropIfExists('merchants_rate_types');
    }
}
