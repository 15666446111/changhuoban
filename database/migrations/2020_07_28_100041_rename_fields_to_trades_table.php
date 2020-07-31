<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameFieldsToTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trades', function (Blueprint $table) {
            
            $table->renameColumn('termId', 'term_id');
            
            $table->renameColumn('sysTraceNo', 'sys_trace_no');
            
            $table->renameColumn('cardType', 'card_type');
            
            $table->renameColumn('transDate', 'trans_date');

            $table->renameColumn('traceNo', 'trace_no');

            $table->renameColumn('tranCode', 'tran_code');
            
            $table->renameColumn('agentId', 'agent_id');
            
            $table->renameColumn('inputMode', 'input_mode');
            
            $table->renameColumn('originalTranDate', 'original_tran_date');
            
            $table->renameColumn('originalRrn', 'original_rrn');
            
            $table->renameColumn('originaltraceNo', 'original_trace_no');
            
            $table->renameColumn('sysRespCode', 'sys_resp_code');
            
            $table->renameColumn('sysRespDesc', 'sys_resp_desc');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trades', function (Blueprint $table) {
            //
        });
    }
}
