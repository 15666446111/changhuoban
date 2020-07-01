<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterNoticeContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_notice_content', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('agentId')->nullable()->comment('商户直属机构号');

            $table->string('merchantId')->nullable()->comment('商户号');

            $table->string('termId')->nullable()->comment('终端号');

            $table->string('termSn')->nullable()->comment('终端SN');

            $table->string('termModel')->nullable()->comment('终端型号');

            $table->string('version')->nullable()->comment('助贷通版本号');

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
        Schema::dropIfExists('register_notice_content');
    }
}
