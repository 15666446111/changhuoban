<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInfoToAdminShortsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_short', function (Blueprint $table) {
            
            $table->string('template_id')->after('id')->comment('模版标识');

            $table->string('agent_id')->after('template_id')->comment('模版所属渠道商户');

            $table->string('agent_name')->nullable()->after('agent_id')->comment('模版所属渠道商户名称');

            $table->string('status')->default(1)->after('content')->comment('模版状态');

            $table->string('create')->nullable()->after('status')->comment('创建时间');

            $table->string('create_user_id')->nullable()->after('create')->comment('创建用户id');

            $table->string('last')->nullable()->after('create_user_id')->comment('最后修改时间');

            $table->string('last_user_id')->nullable()->after('last')->comment('最后修改用户');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_shorts', function (Blueprint $table) {
            //
        });
    }
}
