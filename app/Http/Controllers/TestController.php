<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * [$podcast 用来接收参数的变量]
     * @var [type]
     */
    protected $trade;

    public function __construct($params)
    {
        $this->trade = $params;
    }

    /**
     * [index 测试方法]
     * @return [type] [description]
     */
    public function index()
    {

    	/**
         * @version [<vector>] [< 检查该机器是否入库>]
         */
        if (empty($this->trade->merchants_sn)) {
            $this->trade->remark = '仓库中无此终端号!';
            $this->trade->save();
            return false;
        }

        // /**
        //  * @version [<vector>] [< 检查该机器是否发货>]
        //  */
        if (!$this->trade->merchants_sn->user_id || $this->trade->merchants_sn->user_id == "null") {
            $this->trade->remark = '该机器还未发货!';
            $this->trade->save();
            return false;
        }

        // /**
        //  * @version [<vector>] [< 检查该机器所属操盘方和畅捷后台是否一致>]
        //  */
        if ($this->trade->merchants_sn->operate != $this->trade->agt_merchant_id) {
            $this->trade->remark = '该机器归属操盘方信息有误';
            $this->trade->save();
            return false;
        }

        // /**
        //  * @version [<vector>] [< 检查是否是重复推送的数据 >]
        //  * transDate: 接口推送的交易日期
        //  * rrn: 参考号
        //  */
        $sameTrade = \App\Trade::where('transDate', $this->trade->transDate)->where('rrn', $this->trade->rrn)
                                ->first();
        if (empty($sameTrade)) {
            $this->trade->remark = '该交易为重复推送数据';
            $this->trade->save();
            return false;
        }


        /**
         * @version [<vector>] [< 实行商户绑定>]
         */
        if ($this->trade->merchants_sn->bind_status == "0" || $this->trade->merchants_sn->merchant_id == null) {
            
        }


        /**
         * 更新交易订单的用户id等信息
         */
        

        /**
         * @version [< 给当前交易进行分润发放 >]
         */
        try {
        	$cash = new \App\Http\Controllers\CashController($this->trade);

            $cashResult = $cash->cash();

        } catch (\Exception $e) {
            // $this->trade->remark = $this->trade->remark."<br/>分润:".json_encode($e->getMessage());
            // $this->trade->save();
        }
    }
}
