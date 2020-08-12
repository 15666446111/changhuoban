<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Jobs\NewSimFrozen;
use App\Http\Controllers\Controller;
use App\Services\Pmpos\PmposController;

/**
 * 
 */
class CrontabController extends Controller
{
	/**
	 * [$tradeOrder 交易记录订单号]
	 * @var [type]
	 */
	protected $tradeOrder;
	
	/**
	 * [froMachineActive 冻结机器激活方法]
	 * @return [type] [description]
	 */
	public function froMachineActive()
	{
		// 查询已开通、未激活、未过期、按冻结状态激活的机器列表
		$machineList = \App\Machine::where('open_state', 1)
									->where('activate_state', 0)
									->where('policy_id', '>', 0)
									->where('merchant_id', '>', 0)
									->where('overdue_state', 0)
									->get();

		foreach ($machineList as $k => $v) {

			// 非冻结的机器，或商户已有激活记录时，不处理激活
			if (!empty($v->merchants->activate_sn) || $v->policys->active_type != 1) {
				continue;
			}
			
			// 查询冻结金额的代理商返还状态
			$pmpos = new PmposController($v->merchants->code, $v->sn);

			$data = json_decode( $pmpos->recordQuery() );

			if ($data->code == '00') {
				
				foreach ($data->data->amtList as $key => $value) {

					// 是冻结POS服务费的活动，并且是已返还代理商的状态时，更新机器的激活返现
					if ($value->posCharge > 0 && $value->agentCollectStatus == 1) {
						
						// dd($value);
						// 更新机器表激活状态和激活时间
						\App\Machine::where('id', $v->id)->update([
							'activate_state'	=> 1,
							'activate_time'		=> Carbon::now()->toDateTimeString(),
						]);

						// 更新商户表激活sn
						\App\Merchant::where('id', $v->merchants->id)->update([
							'activate_sn'	=> $v->sn
						]);

						// 添加激活记录
						\App\ActivesLog::create([
							'merchant_code'		=> $v->merchants->code,
							'sn'				=> $v->sn,
							'user_id'			=> $v->user_id,
							'type'				=> 1
						]);

						// 添加一条虚拟交易订单，只做交易记录的sn和商户号匹配
						$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'H', 'I');

            			$order_no = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));

						$tradeInfo = \App\Trade::create([
							'trade_no'			=> $order_no,
							'user_id'			=> $v->user_id,
							'machine_id'		=> $v->id,
							'is_send'			=> 1,
							'sn'				=> $v->sn,
							'merchant_code'		=> $v->merchants->code,
							'trans_date'		=> date('Ymd'),
							'trade_time'		=> Carbon::now()->toDateTimeString(),
							'remark'			=> '激活数据虚拟记录',
							'operate'			=> $v->operate,
							'sys_resp_code'		=> '',
							'sys_resp_desc'		=> '',
						]);
						$this->tradeOrder = $tradeInfo->trade_no;

						// 操盘模式
	                    $pattern = \App\AdminSetting::where('operate_number', $v->operate)->value('pattern');

						// 添加分润记录、更新代理钱包余额
	                    if ($pattern == 1) {
	                    	// 联盟模式
	                        $this->addUserBalance($v->user_id, $v->policys->default_active, 3, $v->operate);
	                    } else {
	                    	// 工具模式
	                        $this->toolCashBack($v->user_id, $v->policys->id, $v->policys->default_active_set, $v->operate);
	                    }

						$pUserId = \App\User::where('id', $v->user_id)->value('parent');
						
						if ($pUserId > 0) {

							// 间推激活返现
							if ($v->policys->indirect_active > 0) {
								$this->addUserBalance($pUserId, $v->policys->indirect_active, 4, $v->operate);
							}

							// 间间推激活返现
							$ppUserId = \App\User::where('id', $pUserId)->value('parent');
							if ($ppUserId > 0 && $v->policys->in_indirect_active > 0) {
								$this->addUserBalance($ppUserId, $v->policys->in_indirect_active, 5, $v->operate);

							}

						}

					}
				}

			}

		}
	}

    /**
     * [工具模式直推激活返现]
     * @param  [type] $userId           [用户id]
     * @param  [type] $policyId         [活动id]
     * @param  [type] $defaultActiveSet [活动默认返现设置]
     * @param  [type] $operate          [操盘号]
     * @return [type]                   [description]
     */
    public function toolCashBack($userId, $policyId, $defaultActiveSet, $operate)
    {
        $prevReturnMoney = 0;

        $returnUserId = $userId;
        while ($returnUserId > 0) {

            // 用户返现金额
            $returnMoney = \App\UserPolicy::where('user_id', $returnUserId)->where('policy_id', $policyId)->value('default_active_set');

            // 未设置过用户的返现金额时，按默认激活返现金额处理
            if (empty($returnMoney)) {
                $defaultActive = json_decode($defaultActiveSet);
                $returnMoney = $defaultActive->default_money * 100;
            }

            $money = ($returnMoney - $prevReturnMoney) / 100;

            if ($money > 0) {
            	// 类型，3为直营激活返现，11为团队激活返现
            	$type = $returnUserId == $userId ? 3 : 11;
            	// 增加用户余额并添加分润记录
                $this->addUserBalance($returnUserId, $money, $type, $operate);
                $prevReturnMoney = $returnMoney;
            }

            $returnUserId = \App\User::where('id', $returnUserId)->value('parent');
        }
        
    }

	/**
	 * [流量卡费冻结]
	 * @return [type] [description]
	 */
	public function simFrozen()
	{
		## 首次冻结的机具
		// 设置了sim服务费金额的活动id集合
		$activeIds = \App\Policy::where('sim_charge', '>', 0)->pluck('id');

		$machineList = \App\Machine::whereIn('policy_id', $activeIds)
						->where('sim_frozen_num', 0)
						->where('bind_status', 1)
						->where('open_time', '>', 0)
						->get();

		foreach ($machineList as $k => $v) {

			## 检查是否需要发起冻结
			// 机具第一次需要冻结的时间
			$shouldFrozenTime = (new Carbon)->setTimeFromTimeString($v->open_time)->addMonth($v->policys->sim_delay)->toDateTimeString();

			if ($shouldFrozenTime > Carbon::now()->toDateTimeString()) {
				continue ;
			}

			// 添加冻结记录
			$frozenLog = \App\MerchantsFrozenLog::create([
				'merchant_code'		=> $v->merchants->code,
				'sn'				=> $v->sn,
				'type'				=> 2,
				'frozen_money'		=> $v->policys->sim_charge * 100,
                'state'             => 0,
                'send_data'			=> '',
                'return_data'		=> '',
			]);

			$frozenLog->pid = $v->id;

			// 压入队列中，处理剩下的逻辑
			NewSimFrozen::dispatch($frozenLog);

		}

		## 二次和二次以上需要冻结的机具
		$frozenLog = \App\MerchantsFrozenLog::where('type', 2)
					->where('state', 1)
					->where('sim_agent_state', 0)
					->where('sim_agent_time', '<=', Carbon::now()->toDateTimeString())
					->get();

		foreach ($frozenLog as $k => $v) {

			// 检查机器信息是否存在
			if (!$v->machine || empty($v->machine)) {
				$v->remark .= '机具数据异常';
				$v->save();
				continue ;
			}

			// 检查与当前绑定商户是否一致
			if ($v->merchant_code != $v->machine->merchants->code) {
				$v->remark .= '当前机器与商户已解绑';
				$v->save();
				continue ;
			}

			// 检查当前活动是否设置SIM服务费收取金额
			if ($v->policys->sim_charge == 0) {
				$v->remark .= '该机器未设置SIM服务费金额';
				$v->save();
				continue ;
			}

			// 添加冻结记录
			$frozenLog = \App\MerchantsFrozenLog::create([
				'merchant_code'		=> $v->merchant_code,
				'sn'				=> $v->sn,
				'type'				=> 2,
				'frozen_money'		=> $v->machine->policys->sim_charge * 100,
                'state'             => 0,
                'send_data'			=> '',
                'return_data'		=> '',
			]);
			$frozenLog->pid = $v->id;

			// 压入队列中，处理剩下的逻辑
			NewSimFrozen::dispatch($frozenLog);
		}
	}

    /**
     * [addUserBalance 增加用户余额 分润余额 分润记录]
     * @param [type]  $userId [用户id]
     * @param [type]  $money  [分润金额(元)]
     * @param [type]  $type   [类型，3激活返现(直营)，4激活返现(间推)，5激活返现(间间推)]
     * @param [type]  $operate [操盘号]
     */
    public function addUserBalance($userId, $money, $type, $operate)
    {
    	// 添加分润记录
    	\App\Cash::create([
    		'user_id'		=> $userId,
    		'order'			=> '',
    		'cash_money'	=> $money * 100,
    		'is_run'		=> 0,
    		'cash_type'		=> $type,
    		'operate'		=> $operate,
    		'order'			=> $this->tradeOrder
    	]);
    	// 增加用户余额
    	\App\UserWallet::where('user_id', $userId)->increment('return_blance', $money * 100);
    }
}