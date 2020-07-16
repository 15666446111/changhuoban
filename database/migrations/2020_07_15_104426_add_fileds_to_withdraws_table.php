<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiledsToWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withdraws', function (Blueprint $table) {

            
            $table->smallInteger('pay_system')->default(0)->comment('打款系统 0=未打款 1=畅伙伴 2=畅捷')->after('operate');


            $table->smallInteger('pay_type')->default(1)->comment('打款方式 1=人工审核 2=自动打款(免审)')->after('pay_system');

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
