<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuserMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buser_messages', function (Blueprint $table) {

            $table->bigIncrements('id');
            
            $table->integer('user_id')->comment('会员ID');

            $table->string('type')->default('other')->comment('消息类型');

            $table->tinyInteger('is_read')->default(0)->comment('是否已读');

            $table->string('title')->comment('消息标题');

            $table->longText('message_text')->comment('消息内容');

            $table->string('send_plat')->comment('发送方')->default('系统发送');

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
        Schema::dropIfExists('buser_messages');
    }
}
