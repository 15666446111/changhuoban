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
    	 * @version [<vector>] [< 判断是否是成功交易>]
    	 * $desc == '原交易已冲正'       无效冲正类交易
    	 * 交易冲正时可能会推送多笔交易，已平台收单应答描述前六位为"原交易已冲正"区分是否为无效的冲正类交易,
    	 * 无效的交易信息不进行保存和处理
    	 */
    	if ($this->trade->sys_resp_code != '00' || substr($this->trade->sys_resp_desc, 0, 18) == '原交易已冲正') {
    		$this->trade->remark = '该交易为无效交易';
    		$this->trade->is_invalid = 1;
            $this->trade->save();
            return false;
    	}

    	/**
         * @version [<vector>] [< 检查该机器是否入库>]
         */
        if (empty($this->trade->merchants_sn)) {
            $this->trade->remark = '仓库中无此终端号!';
            $this->trade->save();
            return false;
        }

        /**
         * @version [<vector>] [< 检查该机器是否发货>]
         */
        if (!$this->trade->merchants_sn->user_id || $this->trade->merchants_sn->user_id == "null") {
            $this->trade->remark = '该机器还未发货!';
            $this->trade->save();
            return false;
        }

        /**
         * @version [<vector>] [< 检查该机器所属操盘方和畅捷后台是否一致>]
         */
        $systemCode = \App\AdminSetting::where('operate_number', $this->trade->merchants_sn->operate)->value('system_merchant');
        if ($systemCode != $this->trade->agt_merchant_id) {
            $this->trade->remark = '该机器归属操盘方信息有误';
            $this->trade->save();
            return false;
        }

        /**
         * @version [<vector>] [< 检查是否是重复推送的数据 >]
         * trans_date: 接口推送的交易日期
         * rrn: 参考号
         */
        $sameTrade = \App\Trade::where('trans_date', $this->trade->trans_date)
        						->where('rrn', $this->trade->rrn)
        						->where('id', '<>', $this->trade->id)
                                ->first();
        if (!empty($sameTrade)) {
            $this->trade->remark = '该交易为重复推送数据';
    		$this->trade->is_repeat = 1;
            $this->trade->save();
            return false;
        }

        /**
         * @version [<vector>] [< 更新交易订单的用户id和机具id信息 >]
         */
        $this->trade->user_id = $this->trade->merchants_sn->user_id;
        $this->trade->machine_id = $this->trade->merchants_sn->id;
        $this->trade->operate = $this->trade->merchants_sn->operate;
        $this->trade->save();

        /**
         * @version [<vector>] [< 实行商户绑定>]
         *
         * 1.判断当前商户是否存在
         *      不存在：添加商户信息
         * 		判断机具是否绑定商户
         * 			未绑定：更新绑定商户信息
         * 			已绑定？？
         */
        try {
            $merInfo = \App\Merchant::where('code', $this->trade->merchant_code)->first();

            // 商户不存在时，添加商户信息
            if (!$merInfo || empty($merInfo)) {

                $merInfo = \App\Merchant::create([
                    'user_id'       => $this->trade->merchants_sn->user_id,
                    'code'          => $this->trade->merchant_code,
                    'operate'       => $this->trade->merchants_sn->operate,
                    'name'          => $this->trade->merchant_name,
                    'phone'         => $this->trade->merchant_phone
                ]);

                // 添加绑定记录
                \App\MerchantsBindLog::create([
                    'merchant_code'     => $merInfo->code,
                    'sn'                => $this->trade->sn
                ]);

            } else {

                // 完善商户信息
                if (!empty($merInfo['name']) || !empty($merInfo['phone'])) {

                    \App\Merchant::where('id', $merInfo->id)->update([
                        'name'          => $this->trade->merchant_name,
                        'phone'         => $this->trade->merchant_phone,
                    ]);
                }

            }

            // 机器未绑定商户时，绑定商户
            if ($this->trade->merchants_sn->bind_status == 0 || $this->trade->merchants_sn->merchant_id == 0) {

                \App\Machine::where('sn', $this->trade->sn)->update([
                    'merchant_id'   => $merInfo->id,
                    'bind_status'   => 1,
                    'bind_time'     => date('Y-m-d H:i:s', time())
                ]);

            } else {

                // 已绑定商户，但是绑定商户信息和推送数据中的商户信息不一致时，
                if ($this->trade->merchants_sn->merchant_id != $merInfo->id) {

                    // 更新商户信息
                    \App\Machine::where('sn', $this->trade->sn)->update([
                        'merchant_id'       => $merInfo->id
                    ]);

                    // 更新绑定记录的解绑状态
                    \App\MerchantsBindLog::where('sn', $this->trade->sn)
                                        ->where('bind_state', 1)
                                        ->update(['bind_state' => 0]);
                }

            }
        } catch (\Exception $e) {
            $this->trade->remark = $this->trade->remark."<br/>绑定商户:".json_encode($e->getMessage());
            $this->trade->save();
        }
        

        /**
         * @version [< 给当前交易进行分润发放 >]
         */
        try {
        	$cash = new \App\Http\Controllers\CashController($this->trade);

            $cashResult = $cash->cash();

            $this->trade->remark = $this->trade->remark."<br/>分润:".$cashResult['message'];

            if($cashResult['status'] && $cashResult['status'] !== false){
                $this->trade->is_send = 1;
            }

            $this->trade->save();

        } catch (\Exception $e) {
            $this->trade->remark = $this->trade->remark."<br/>分润:".json_encode($e->getMessage());
            $this->trade->save();
        }
        

        /**
         * @version [< 激活返现处理 >]
         */
        try {
            $cash = new \App\Http\Controllers\ActiveMerchantController($this->trade);

            $returnCash = $cash->active();

            if (!empty($returnCash['message'])) {
                $this->trade->remark = $this->trade->remark."<br/>激活:".$returnCash['message'];
            }

            $this->trade->save();

        } catch (\Exception $e) {
            $this->trade->remark = $this->trade->remark."<br/>激活:".json_encode($e->getMessage());
            $this->trade->save();
        }
    }
}
