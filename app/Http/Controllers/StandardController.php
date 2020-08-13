<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Trade;
use Illuminate\Http\Request;

class StandardController extends Controller
{

	/**
	 * [$trade 该笔交易订单信息]
	 * @var [type]
	 */
	protected $trade;


	/**
	 * [$tradeTime 交易时间]
	 * @var [type]
	 */
	protected $tradeTime;


	/**
	 * [$activeTime 机具激活时间]
	 * @var [type]
	 */
	protected $activeTime;


	/**
	 * [$machine 该交易所属机具]
	 * @var [type]
	 */
	protected $machine;


	/**
	 * [$policy 所属政策]
	 * @var [type]
	 */
	protected $policy;


	/**
	 * [$user 该交易所属的用户]
	 * @var [type]
	 */
	protected $user;
    

    public function __construct(Trade $trade)
    {

    	$this->trade = $trade;

    	$this->machine = $trade->merchants_sn;

    	$this->policy = $trade->merchants_sn->policys;

    	$this->user = $trade->merchants_sn->users;

    }

	/**
	 * [standard 达标方法]
	 * @return [type] [description]
	 */
    public function standard()
    {

    	if (!$this->trade->trade_time) {
    		return array('status' => false, 'message' => '没有交易时间,无法计算达标');
    	}

    	if ($this->machine->activate_state == 0) {
    		return array('status' => false, 'message' => '');
    	}

    	if (!$this->machine->activate_time) {
    		return array('status' => false, 'message' => '找不到机器的激活时间');
    	}

		// sn达标记录
		$snStandardLog = \App\MerchantsStandard::where('sn', $this->trade->sn)->get();
		foreach ($snStandardLog as $key => $val) {
			if ($val->merchant_code != $this->trade->merchant_code) {
				return array('status' => false, 'message' => '机器换绑前已达标,不再进行达标计算');
			}
		}

    	// 该订单的交易时间
    	$this->tradeTime = Carbon::parse($this->trade->trade_time);

    	// 激活时间
    	$this->activeTime = Carbon::parse($this->machine->activate_time);

    	// 如果交易时间小于起始时间，不进行达标计算
		if($this->activeTime->gt($this->tradeTime)){
			return array('status' => false, 'message' => '');
		}

		// 总返现金额
		$money = 0;

		// 计算交易日期距离激活日期的天数
		$diffDay = $this->tradeTime->diffInDays($this->activeTime);

		// 查找出该天数之内的达标的达标设置 包含累积达标和连续达标
		$conStan = [];	// 连续达标
		$cumStan = [];	// 累计达标

		foreach ($this->policy->default_standard_set as $key => $value) {
			if ($diffDay >= $value['standard_start'] && $diffDay <= $value['standard_end'] && $value['standard_end'] > 0) {
				if ($value['standard_type'] == 1) array_push($conStan, $value);
				if ($value['standard_type'] == 2) array_push($cumStan, $value);
			}
		}

		// 累计达标
		if ($this->machine->standard_status_lj != -1) {
			foreach ($cumStan as $key => $val) {

				// 查询机器和商户的当前达标是否已发放
				$machineStanCount = \App\MerchantsStandard::where('sn', $this->trade->sn)->where('index', $val['index'])->count();

				$merchantStanCount = \App\MerchantsStandard::where('merchant_code', $this->trade->merchant_code)->where('index', $val['index'])->count();
				
				if ($machineStanCount == 0 && $merchantStanCount == 0) {
					// 检查是否达到达标标准
					$isStandard = $this->SumTradeIf($val['standard_start'], $val['standard_end'], $val['standard_trade'] * 100);
					if ($isStandard) {
						// 进行发放达标奖励
				    	// 联盟模式
				    	if($this->user->operates->pattern == 1){

				    		// 添加达标记录
				    		$this->addStandardLog($val);
				    		// 添加分润记录并增加用户余额
				    		$this->addUserBalance($this->user->id, $val['standard_price'], 6);

				    		$money = $val['standard_price'];
				    	}

				    	// 工具模式
				    	if($this->user->operates->pattern == 2){
				    		
				    		// 添加分润记录并增加用户余额
				    		$money = $this->toolStandard($val);

				    	}

				    	// 添加达标记录
			    		$this->addStandardLog($val);

					}
				}
			}
		}

		// 连续达标
		if ($this->machine->standard_status != -1) {
			foreach ($conStan as $key => $val) {
				// 查询机器和商户的当前达标是否已发放
				$machineStanCount = \App\MerchantsStandard::where('sn', $this->trade->sn)->where('index', $val['index'])->count();
				$merchantStanCount = \App\MerchantsStandard::where('merchant_code', $this->trade->merchant_code)->where('index', $val['index'])->count();
				
				// 如果没有找到本次的达标奖励发放情况，  连续达标需要检查上次达标情况有没有达标和发放 
				if ($machineStanCount == 0 && $merchantStanCount == 0) {
					// 检查是否达到达标标准
					$isStandard = $this->SumTradeIf($val['standard_start'], $val['standard_end'], $val['standard_trade'] * 100);
					// 如果 当前达标条件已经达到 检查当前是否发放本次达标奖励 上一次达标是否达到
					if ($isStandard) {
						
						$prevStandardArr = array(); 
						foreach ($this->policy->default_standard_set as $k => $v) {
							// 如果符合当前条件
							if($val['standard_start'] > $v['standard_start'] && $val['standard_start'] - 1 == $v['standard_end'] && $v['standard_type'] == '1'){
								$prevStandardArr = $v;
								break;
							}
						}

						if (!empty($prevStandardArr)) {
							
							$trade = $this->SumTradeIf($prevStandardArr['standard_start'], $prevStandardArr['standard_end'], $prevStandardArr['standard_trade'] * 100);

							if(!$trade){
								$this->machine->standard_status = -1;
								$this->machine->save();
								return array('status' => false, 'msg' => '机器上次达标未通过,不发放达标奖励!上次达标条件:机器激活之日起'.$prevStandardArr['standard_start']."-".$prevStandardArr['standard_end']."天内满足".number_format($prevStandardArr['standard_trade'] * 100 , 2, '.', ',')."元交易!");
							}

							// 检查上次达标返现信息
							$haveStandardPrev = \App\MerchantsStandard::where('sn', $this->trade->sn)
												->where('merchant_code', $this->trade->merchant_code)
												->where('index', $prevStandardArr['index'])
												->first();
							if(!$haveStandardPrev or empty($haveStandardPrev)){
								$this->machine->standard_status = -1;
								$this->machine->save();
								return array('status' => false, 'msg' => '机器上次达标发放信息未找到,不发放达标奖励!上次达标条件:机器激活之日起'.$prevStandardArr['standard_start']."-".$prevStandardArr['standard_end']."天内满足".number_format($prevStandardArr['standard_trade'] * 100 , 2, '.', ',')."元交易!");
							}
						}

						// 进行发放达标奖励
				    	// 联盟模式
				    	if($this->user->operates->pattern == 1){

				    		// 添加分润记录并增加用户余额
				    		$this->addUserBalance($this->user->id, $val['standard_price'], 6);

				    		$money = $val['standard_price'];
				    	}

				    	// 工具模式
				    	if($this->user->operates->pattern == 2){
				    		
				    		// 添加分润记录并增加用户余额
				    		$money = $this->toolStandard($val);

				    	}

			    		// 添加达标记录
			    		$this->addStandardLog($val);
					}
				}
			}
		}
		return array('status' => true, 'message' => '达标奖励发放:'.number_format($money, 2, '.', ',')."元");
    }

    /**
     * [toolStandard 工具模式达标返现方法]
     * @param  [type] $standard [description]
     * @return [type]           [description]
     */
    public function toolStandard($standard)
    {
    	// 总返现金额
    	$totalMoney = 0;
    	
    	$userId = $this->user->id;

    	$prevReturnMoney = 0;

    	while ($userId > 0) {

    		// 获取设置的用户达标返现金额
    		$stanMoney = $this->getStanMoney($userId, $standard['index'], $standard['standard_price']);
			// 应返现金额
			$money = bcsub($stanMoney, $prevReturnMoney, 2);

			if ($money * 100 > 0) {
				if ($userId == $this->user->id) {
    				// 直推达标返现
	    			$type = $standard['standard_type'] == '1' ? 6 : 8;
	    		} else {
	    			// 间推达标返现
	    			$type = $standard['standard_type'] == '1' ? 7 : 9;
	    		}

				$this->addUserBalance($userId, $money, $type);

                $totalMoney += $money;
                $prevReturnMoney = $stanMoney;
			}

			// 如果用户的达标返现金额等于活动设置的默认返现金额时，不再往下处理
			if ($stanMoney == $standard['standard_price']) {
				return $totalMoney;
			}

			$userId = \App\User::where('id', $userId)->value('parent');

    	}

    	return $totalMoney;
    }

    /**
     * [getStanMoney 获取用户达标返现金额]
     * @param  [type] $userId       [用户id]
     * @param  [type] $index        [达标设置索引]
     * @param  [type] $defaultMoney [默认达标返现金额]
     * @return [type]               [description]
     */
    public function getStanMoney($userId, $index, $defaultMoney)
    {
    	$stanReturnMoney = $defaultMoney;
    	// 查询当前用户的达标返现数据
    	$userPolicy = \App\UserPolicy::where('user_id', $userId)->where('policy_id', $this->policy->id)->first();

    	if (!empty($userPolicy->standard)) {
    		foreach ($userPolicy->standard as $key => $val) {
    			if ($val['index'] == $index) {
    				$stanReturnMoney = $val['standard_price'];
    			}
    		}
    	}

    	return $stanReturnMoney;
    }

    /**
     * @Author    Pudding
     * @DateTime  2020-08-07
     * @copyright [copyright]
     * @license   [license]
     * @version   [查询时间段内的交易是否满足达标要求]
     * @param     [type]      $start [开始天数]
     * @param     [type]      $end   [结束天数]
     * @param     [type]      $count [达标标准]
     */
    public function SumTradeIf($start=0, $end=0, $count=0)
    {
    	$this->startTime = Carbon::parse($this->machine->activate_time);

    	$startTime = $this->startTime->addDays($start)->toDateTimeString();
    	
    	$endTime   = $this->startTime->addDays($end)->toDateTimeString();
    	
    	// 查询出这时间段内的sn、商户号的成功的信用卡交易
    	$trade = \App\Trade::where('sn', $this->trade->sn)
    					->where('merchant_code', $this->trade->merchant_code)
    					->where('card_type', 1)
    					->where('is_repeat', 0)
    					->where('is_invalid', 0)
    					->where('sys_resp_code', '00')
    					->whereBetween('trade_time', [$startTime, $endTime])
    					->sum('amount');

    	return $trade >=  $count ? true : false;
    }


    /**
     * [addStandardLog 添加达标记录]
     * @param [type] $standard [description]
     */
    public function addStandardLog($standard)
    {	
    	$standard['standard_trade'] = $standard['standard_trade'] * 100;

    	$standard['standard_price'] = $standard['standard_price'] * 100;

    	\App\MerchantsStandard::create([
    		'sn'			=> $this->trade->sn,
    		'merchant_code'	=> $this->trade->merchant_code,
    		'policy_id'		=> $this->policy->id,
    		'index'			=> $standard['index'],
    		'remark'		=> json_encode($standard)
    	]);
    }

    /**
     * [addUserBalance 增加用户余额 分润余额 分润记录]
     * @param [type]  $userId [用户id]
     * @param [type]  $money  [分润金额(元)]
     * @param integer $type   [类型，6连续达标，7连续达标（团队），8累计达标（直营），9累计达标（团队）]
     */
    public function addUserBalance($userId, $money, $type)
    {
    	// 添加分润记录
    	\App\Cash::create([
    		'user_id'		=> $userId,
    		'order'			=> $this->trade->trade_no,
    		'cash_money'	=> $money * 100,
    		'is_run'		=> 0,
    		'cash_type'		=> $type,
    		'operate'		=> $this->trade->merchants_sn->operate
    	]);
    	// 增加用户余额
    	\App\UserWallet::where('user_id', $userId)->increment('return_blance', $money * 100);
    }

}
