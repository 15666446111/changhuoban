<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBankinfoToWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withdraws', function (Blueprint $table) {


            $table->string("number")->comment('身份证号')->after('user_id');

            $table->string("bank_name")->comment('银行名称')->after('number');

            $table->string("bank")->comment('银行卡号')->after('bank_name');

            $table->string("open_bank")->comment('开户行')->after('bank'); 


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withdraws', function (Blueprint $table) {
            //
        });
    }
}
