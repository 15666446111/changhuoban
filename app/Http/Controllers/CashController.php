<?php

namespace App\Http\Controllers;

use App\Trade;
use Illuminate\Http\Request;

class CashController extends Controller
{

	/**
     * [$trade 该笔交易订单信息]
     * @var [type]
     */
    protected $trade;

    /**
     * [$entryStatus 入账类型，1增加，-1减少]
     * @var [type]
     */
    protected $entryType = 1;

    /**
     * [$feeType 手续费计算类型]
     * @var [type]
     */
    protected $feeType;

    /**
     * [$cardType 交易卡类型，借记卡/贷记卡]
     * @var [type]
     */
    protected $cardType;

    /**
     * [$tranCode 交易码]
     * @var [type]
     */
    protected $tranCode;

    /**
     * [$handFee 当前交易的手续费]
     * @var [type]
     */
    protected $handFee;

    /**
     * [$isTop 是否为封顶类交易，1是，0不是]
     * @var [type]
     */
    protected $isTop = 0;

    public function __construct(Trade $trade)
    {
    	$this->trade = $trade;

    	// 初始化手续费金额
    	$this->handFee = abs($this->trade->amount) - abs($this->trade->settle_amount);
    	// 初始化手续费计算类型
    	$this->feeType = $this->trade->fee_type;
		// 初始化卡类型
		$this->cardType = $this->trade->cardType;
		// 初始化交易码
		$this->tranCode = $this->trade->tranCode;
    }

    /**
     * [cash 交易数据分润类]
     * @return [type] [description]
     */
    public function cash()
    {

    	/**
    	 * @var [处理冲正类交易数据]
    	 * 冲正类交易分润计算使用方法：
    	 * 1.根据当前交易订单的 交易日期、凭证号、商户号、终端号查询原交易
    	 * 2.计算出原交易的应发分润，减少用户余额并记录。查不到原交易时不进行处理
    	 * 020003: 消费冲正
    	 * T20003: 日结消费冲正
    	 */
    	if ($this->trade->tranCode == '020003' || $this->trade->tranCode == 'T20003' || $this->trade->tranCode == '024103') {

            // 对应原交易的交易码 
            // 020000:消费，T20000:日结消费，024100电子现金
            $recTranCode = [
                '020003'    => '020000',
                'T20003'    => 'T20000',
                '024103'    => '024100',
            ];
			// 查询原交易
    		$originalTrade = \App\Trade::where('transDate', $this->trade->transDate)
    									->where('traceNo', $this->trade->traceNo)
    									->where('merchant_code', $this->trade->merchant_code)
    									->where('termId', $this->trade->termId)
    									->where('tranCode', $recTranCode[$this->trade->tranCode])
    									->first();

    		if (!empty($originalTrade)) {

    			// 手续费计算类型
    			$this->feeType = $originalTrade->fee_type;
    			// 卡类型
    			$this->cardType = $originalTrade->cardType;
    			// 交易码
    			$this->tranCode = $originalTrade->tranCode;
    			// 入账类型，1增加，-1减少
    			$this->entryType = -1;

    		} else {

    			return array('status' =>false, 'message' => '无原交易信息');

    		}
    	}

    	/**
    	 * @var [处理撤销类交易数据]
    	 * 撤销类交易分润计算使用方法：
    	 * 1.查询原交易：根据当前交易订单的 原交易日期、原交易订单号查询原交易
    	 * 2.计算出原交易的应发分润，减少用户余额并记录。查不到原交易时不进行处理
    	 */
    	if ($this->trade->tranCode == '020002' ||$this->trade->tranCode == '02Y600' ||$this->trade->tranCode == '024102') {
    		
    		// 查询原交易
			$originalTrade = \App\Trade::where('transDate', $this->trade->originalTranDate)
										->where('rrn', $this->trade->originalRrn)
										->first();

			if (!empty($originalTrade)) {

    			// 手续费计算类型
    			$this->feeType = $originalTrade->fee_type;
    			// 卡类型
    			$this->cardType = $originalTrade->cardType;
    			// 交易码
    			$this->tranCode = $originalTrade->tranCode;
    			// 入账类型，1增加，-1减少
    			$this->entryType = -1;

    		} else {

    			return array('status' =>false, 'message' => '无原交易信息');

    		}
    	}

    	/**
    	 * @var [处理撤销冲正类交易数据]
    	 * 冲正类交易分润计算使用方法：
    	 * 1.查询冲正的原撤销类交易
    	 * 2.根据查询的原撤销类交易查询原交易
    	 * 计算出原交易的应发分润，减少用户余额并记录。查不到原交易时不进行处理
    	 */
    	if ($this->trade->tranCode == '020023' ||$this->trade->tranCode == '024123') {
    		
    		## 1.查询冲正的原撤销类交易
    		$revokeOrTrade = \App\Trade::where('transDate', $this->trade->transDate)
    									->where('traceNo', $this->trade->traceNo)
    									->where('merchant_code', $this->trade->merchant_code)
    									->where('termId', $this->trade->termId)
    									->first();
    		if (empty($revokeOrTrade)) {
    			
    			return array('status' =>false, 'message' => '无原撤销交易信息');

    		} else {

    			## 2.根据查询的原撤销类交易查询原交易
				$originalTrade = \App\Trade::where('transDate', $revokeOrTrade->originalTranDate)
											->where('rrn', $revokeOrTrade->originalRrn)
											->first();

				if (!empty($originalTrade)) {

	    			// 手续费计算类型
	    			$this->feeType = $originalTrade->fee_type;
	    			// 卡类型
	    			$this->cardType = $originalTrade->cardType;
	    			// 交易码
	    			$this->tranCode = $originalTrade->tranCode;
    				// 入账类型，1增加，-1减少
	    			$this->entryType = 1;

				} else {
					
					return array('status' =>false, 'message' => '无原交易信息');

				}

    		}
    	}

    	/**
    	 * @var [借记卡封顶类交易]
    	 * 注：借记卡只有手续费计算类型为标准时存在封顶交易
    	 */
        
    	if ($this->trade->cardType == 0 && $this->trade->fee_type == 'B') {
    		
            // 查询商户当前费率
            $pmposClass = new \App\Services\Pmpos\PmposController($this->trade->merchant_code, $this->trade->sn);
            $merchantRate = $pmposClass->getMerchantFee();

            $merchantRate = json_decode($merchantRate['return_data'], true);

            if ($merchantRate['code'] == '00') {

                // 如果当前交易的手续费等于商户借记卡封顶费率的话，判定为借记卡封顶类交易
                if ($this->handFee / 100 == $merchantRate['data']['dFeeMax']) {
                    $this->isTop = 1;
                }

            } else {

                return array('status' =>false, 'message' => '费率查询' . json_encode($merchantRate));
                
            }
    	}

    	/**
    	 * @var [查询当前交易对应的交易类型id]
    	 */
    	$tradeTypeId = \App\TradeType::where('trade_code', 'like', '%' . $this->feeType . '%')
									->where('card_type', 'like', '%' . $this->cardType . '%')
									->where('trade_type', 'like', '%' . $this->tranCode . '%')
                                    ->where('is_top', $this->isTop)
									->value('id');

    	if (!$tradeTypeId) return array('status' =>false, 'message' => '未配置当前交易类型');

    	// 根据操盘模式，分别处理分润
    	$pattern = \App\AdminSetting::where('operate_number', $this->trade->operate)->value('pattern');

    	if ($pattern == 1) {
    		
    		return $this->vipCash($tradeTypeId);	// 联盟模式

    	} else {

    		// 工具模式
    		
    	}

    }

    /**
     * [vipCash 联盟模式分润计算]
     * @param  [type] $tradeTypeId [description]
     * @return [type]              [description]
     */
    protected function vipCash($tradeTypeId)
    {
    	// 当前交易的总分润金额
    	$rateMoney = 0;

    	## 计算当前交易应发的第一笔分润
        $firstCash = $this->getFirstCash($tradeTypeId, $this->trade->merchants_sn->user_id);

        if (!empty($firstCash['money']) && $firstCash['money'] > 0) {

            // 应发分润金额 = 计算的分润金额 * 入账类型
            $cashMoney = $firstCash['money'] * $this->entryType;
            $rateMoney += $cashMoney;

            // 分润类型，1直营，2团队
            $type = $firstCash['user_id'] == $this->trade->merchants_sn->user_id ? 1 : 2;

            // 增加用户余额并添加分润记录
            $this->addUserBalance($firstCash['user_id'], $cashMoney, $type);


            ## 当前交易应发的第二笔和以后的分润
            $pid = \App\User::where('id', $firstCash['user_id'])->value('parent');

            if ($pid > 0) {

                // 获取上级用户列表和用户之间的结算差价
                $parentUsers = $this->getDifferSettle($pid, $tradeTypeId, $firstCash['settlement']);

                foreach ($parentUsers as $key => $val) {

                    // 如果用户的结算价大于上级结算价的话，给上级发放团队分润
                    if ($val['differSettle'] > 0) {

                        if ($this->isTop == 1) {
                            // 借记卡封顶类交易，团队分润 = 结算价差
                            $teamMoney = $val['differSettle'] / 1000;
                        } else {
                            // 非封顶类交易，团队分润 = 交易金额 * 结算价差
                            $formatSettle = bcdiv($val['differSettle'], 100000, 5);
                            $teamMoney = bcmul(abs($this->trade->amount), $formatSettle);
                        }

                        $teamMoney *= $this->entryType;
                        $rateMoney += $teamMoney;
                        ## 增加用户余额并添加分润记录
                        $this->addUserBalance($val['user_id'], $teamMoney, 2);
                    }
                    
                    ## 检查升级
                    // $this->upgradeGroup($this->trade->merchants_sn->user_id);
                }
            }
            
        }

        return array('status' =>true, 'message' => '订单分润完成,共分润:'.($rateMoney / 100).'元!');
    }

    /**
     * [计算当前交易应发的第一笔分润]
     * @param  [type] $tradeTypeId   [交易类型id]
     * @param  [type] $userId        [用户id]
     * @return [type]                [description]
     */
    public function getFirstCash($tradeTypeId, $userId)
    {
        $cashData = [];

        while ($userId > 0) {
            
            // 用户上级id和所属用户组信息
            $userInfo = \App\User::where('id', $userId)->first(['parent', 'user_group']);

            // 用户结算价
            $settlement = \App\policyGroupSettlement::where('trade_type_id', $tradeTypeId)
                            ->where('user_group_id', $userInfo->user_group)
                            ->where('policy_group_id', $this->trade->merchants_sn->policys->policy_groups->id)
                            ->value('set_price');

            // 计算应发的第一笔分润
            if ($this->isTop == 1) {
                // 借记卡封顶类交易分润，分润金额 = 手续费-结算价
                $cashMoney = $this->handFee - ($settlement / 1000);
            } else {
                // 非封顶类交易分润，分润金额 = 手续费 - 交易金额 * 结算价
                $formatSettle = bcdiv($settlement, 100000, 5);
                $cashMoney = bcsub($this->handFee, bcmul(abs($this->trade->amount), $formatSettle, 3));
            }

            // 分润金额小于0时，判定为当前用户的结算价大于商户费率，不计算当前用户分润
            if ($cashMoney > 0 && $settlement > 0) {
                $cashData = [
                    'user_id'       => $userId,
                    'money'         => $cashMoney,
                    'settlement'    => $settlement
                ];
                break;
            }

            $userId = $userInfo['parent'];
        }

        return $cashData;
    }

    /**
     * 获取上级用户列表和用户之间的结算差价
     * @param  [type] $pid       		[交易直属用户的上级id]
     * @param  [type] $tradeTypeId   	[交易类型id]
     * @param  [type] $settlement 		[交易直属用户的结算价]
     * @return [type]                	[description]
     */
    public function getDifferSettle($pid, $tradeTypeId, $settlement)
    {
    	$parentList = [];

    	while ($pid > 0) {

    		$parentUser = \App\User::where('id', $pid)->first(['parent', 'user_group']);

    		// 用户结算价
    		$pUserSettle = \App\policyGroupSettlement::where('trade_type_id', $tradeTypeId)
							->where('user_group_id', $parentUser->user_group)
							->where('policy_group_id', $this->trade->merchants_sn->policys->policy_groups->id)
							->value('set_price');

            if (!empty($pUserSettle)) {

                // 结算差价
                $differSettle = $settlement - $pUserSettle;

                // 上级结算价大于自己的结算价时，用自己的结算价进行下一步的运算
                $settlement = $differSettle > 0 ? $pUserSettle : $settlement;

                $parentList[] = [
                    'user_id'       => $pid,
                    'differSettle'  => $differSettle
                ];

            }

			$pid = $parentUser->parent;
    	}

    	return $parentList;
    }

    /**
     * [addUserBalance 增加用户余额 分润余额 分润记录]
     * @param [type]  $userId [用户id]
     * @param [type]  $money  [分润金额]
     * @param integer $type   [类型，1直营分润，2团队分润]
     */
    public function addUserBalance($userId, $money, $type = 1)
    {
    	// 添加分润记录
    	\App\Cash::create([
    		'user_id'		=> $userId,
    		'order'			=> $this->trade->trade_no,
    		'cash_money'	=> $money,
    		'is_run'		=> 1,
    		'cash_type'		=> $type,
    		'operate'		=> $this->trade->merchants_sn->operate
    	]);
    	// 增加用户余额
    	\App\UserWallet::where('user_id', $userId)->increment('cash_blance', $money);
    }

    /**
     * [upgradeGroup 用户升级]
     * @param  [type] $userId [description]
     * @return [type]         [description]
     */
  //   public function upgradeGroup($userId)
  //   {
  //   	// 团队用户id
  //   	$teamUserIds = \App\UserRelation::where('parents', 'like', '%\_'.$userId.'\_%')
		// 								->orWhere('user_id', $userId)
		// 								->select('user_id');

		// // 查询本月 交易成功、非借记卡、有效的团队交易
		// $Monthdate = date('Ymd', time());
		// $tradePrice = \App\Trade::where('user_id', 'in', $teamUserIds)
		// 						->where('card_type', 'in', [1, null])	// 非借记卡
		// 						->where('transDate', '>', $Monthdate)	// 本月交易
		// 						->where('sysRespCode', '00'),			// 交易成功
		// 						->where('is_invalid', 0),				// 非无效交易
		// 						->where('is_repeat', 0),				// 非重复交易
		// 						->sum('amount');

  //   }
}
