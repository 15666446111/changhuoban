<?php

namespace App\Http\Controllers;

use App\Trade;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SimCashbackController extends Controller
{
	/**
	 * [$trade 流量卡冻结记录]
	 * @var [type]
	 */
	protected $frozenLog;


    /**
     * [$policy 该笔交易对应的活动信息]
     * @var [type]
     */
    protected $policy;


	/**
	 * [$user 当前交易所属的用户]
	 * @var [type]
	 */
	protected $user;
    

    public function __construct(Trade $trade)
    {
    	$this->frozenLog = \App\MerchantsFrozenLog::whereType(2)->whereMerchantCode($trade->merchant_code)->whereSn($trade->sn)->first();

    	$this->policy  	 = $trade->merchants_sn->policys;

    	$this->user 	 = $trade->merchants_sn->users;
    }

    public function cashBack()
    {
    	if (empty($this->frozenLog)) {
    		return array('status' => false, 'message' => 'no orders');
    	}

    	/**
    	 * 检查订单是否返现
    	 */
    	if ($this->frozenLog->return_state !== 0) {
    		return array('status' => false, 'message' => '4001');
    	}

    	/**
    	 * 检查是否是已发起订单
    	 */
    	if ($this->frozenLog->state != 1) {
    		return array('status' => false, 'message' => '4002');
    	}

    	/**
    	 * 检查是否记录冻结接口返回的操作序列号
    	 */
    	$returnData = json_decode($this->frozenLog->return_data);
    	if (empty($returnData) || empty($returnData->data->optNo)) {
    		return array('status' => false, 'message' => '未找到操作序列号');
    	}

    	// 查询订单冻结状态
    	$pmposServer = new \App\Services\Pmpos\PmposController($this->frozenLog->merchant_code, $this->frozenLog->sn);

    	$result = json_decode( $pmposServer->amtQuery($returnData->data->optNo) );
    	if (empty($result)) {
    		return array('status' => false, 'message' => '服务费代收查询失败');
    	}

    	if ($result->code != "00") {
    		return array('status' => false, 'message' => $result->message);
    	}

    	## 代理商已入账时，处理流量卡返现
    	if ($result->data->agentCollectStatus == '1') {
    		
    		// 更新订单为状态
    		$this->frozenLog->state 		= 3;
    		$this->frozenLog->return_state 	= 1;
    		$this->frozenLog->save();

    		// 总返现金额
            $totalMoney = 0;

    		// 操盘模式
            $pattern = \App\AdminSetting::where('operate_number', $this->user->operate)->value('pattern');

            // 联盟模式
            if ($pattern == 1) {
                $this->addUserBalance($this->user->id, $this->policy->service_fee, 3);
                $totalMoney += $this->policy->service_fee;
            } else {
                // 工具模式
                $reMoney = $this->handle($this->user->id);
                $totalMoney += $reMoney;
            }

            return array('status' => true, 'message' => '返现' . $totalMoney . '元');
    	}
    }

    /**
     * [handle 工具模式流量卡费返现]
     * @param  [type] $userId [description]
     * @return [type]         [description]
     */
    public function handle($userId)
    {
        // 总发放金额
        $totalMoney = 0;

        $prevReturnMoney = 0;

        while ($userId > 0) {

            // 查询所有上级用户(包含自己)
            $userIdArr = \App\User::getParentArr($userId);

            // 查询所有上级(包含自己)中已设置的最低返现金额
            $userPolicys = \App\UserPolicy::whereIn('user_id', $userIdArr)
                                        ->where('policy_id', $this->policy->id)
                                        ->orderBy('service_fee', 'asc')
                                        ->select('service_fee', 'user_id')
                                        ->first();

            if (!empty($userPolicys)) {
                $returnMoney = $userPolicys->service_fee;
            } else {
                // 未查询到已设置的返现信息时，按活动默认激活返现金额处理
                $returnMoney = $this->policy->sim_cashback * 100;
            }

            $money = ($returnMoney - $prevReturnMoney) / 100;

            if ($money > 0) {
                $type = $userId == $this->user->id ? 12 : 13;
                $this->addUserBalance($userId, $money, $type);

                $totalMoney += $money;
                $prevReturnMoney = $returnMoney;
            }

            // 用户的返现金额登录等于活动设置的返现金额时，结束循环
            if ($returnMoney == $this->policy->sim_cashback * 100) {
                break;
            }

            $userId = \App\User::where('id', $userId)->value('parent');
        }
        
        return $totalMoney;
    }

    /**
     * [addUserBalance 增加用户余额 分润余额 分润记录]
     * @param [type]  $userId [用户id]
     * @param [type]  $money  [分润金额(元)]
     * @param integer $type   [类型，12流量卡费返现(直营)，13流量卡费返现(团队)]
     */
    public function addUserBalance($userId, $money, $type)
    {
        // 添加分润记录
        \App\Cash::create([
            'user_id'       => $userId,
            'order'         => $this->trade->trade_no,
            'cash_money'    => $money * 100,
            'is_run'        => 0,
            'cash_type'     => $type,
            'operate'       => $this->trade->merchants_sn->operate
        ]);
        // 增加用户余额
        \App\UserWallet::where('user_id', $userId)->increment('return_blance', $money * 100);
    }
}
