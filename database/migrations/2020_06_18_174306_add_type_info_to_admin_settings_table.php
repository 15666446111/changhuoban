<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeInfoToAdminSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_settings', function (Blueprint $table) {
            
            $table->tinyInteger('type')->default(1)->comment('模式 1=操盘。2=机构 ')->after('remark');

            $table->text('sons')->nullable()->comment('机构下包含的操盘方编号')->after('type');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_settings', function (Blueprint $table) {
            //
        });
    }
}
