<?php

namespace App\Http\Controllers;

use App\Trade;
use Illuminate\Http\Request;

/**
 * 机器激活类
 */
class ActiveMerchantController extends Controller
{

    /**
     * [$trade 该笔交易订单信息]
     * @var [orm trade model]
     */
    protected $trade;

    /**
     * [$policy 该笔交易所属的政策活动]
     * @var [orm model]
     */
    protected $policy;

    /**
     * [$user 该笔交易所属的用户]
     * @var [orm model]
     */
    protected $user;


    public function __construct(Trade $trade)
    {
    	$this->trade 		= $trade;

    	$this->policy 		= $trade->merchants_sn->policys;

      	$this->user   		= $trade->merchants_sn->users;
    }

    /**
     * [active 按交易量激活方法]
     * @return [type] [description]
     */
    public function active()
    {

    	/**
    	 * $this->policy->active_type: 1按冻结金额激活，2按交易金额激活，这里只处理按交易金额激活的机器
    	 */
    	if ($this->policy->active_type != 2) {
    		return array('status' => false, 'message' => '');
    	}


    	/**
    	 * @var [检查机器是已激活]
    	 */
    	if ($this->trade->merchants_sn->activate_state == 1) {
    		return array('status' => false, 'message' => '');
    	}


    	/**
    	 * @var [检查机器和商户是否归属同一用户和商户激活记录]
    	 */
    	$merchantInfo = \App\Merchant::where('code', $this->trade->merchant_code)->first();
    	
    	if ($merchantInfo->user_id != $this->trade->merchants_sn->user_id) {
    		return array('status' => false, 'message' => '该机器和商户所属用户不一致');
    	}

    	// 每个商户只激活返现一次，激活后绑定新机器的商户不处理激活
    	if (!empty($merchantInfo->activate_sn)) {
    		return array('status' => false, 'message' => '该商户已有激活记录,不再发放激活返现');
    	}

    	/**
    	 * 检查机器是否过期
    	 */
    	if (!empty($this->trade->merchants_sn->active_end_time) && 
            strtotime($this->trade->merchants_sn->active_end_time) <= time()) {

			// 更新机器过期状态
    		if ($this->trade->merchants_sn->overdue_state == 0) {
    			$this->trade->merchants_sn->overdue_state = 1;
    			$this->trade->merchants_sn->save();
    		}

    		return array('status' => false, 'message' => '');

    	}

    	## 激活标准大于0时，处理激活
    	if ($this->policy->active_price > 0) {

            // 总返现金额
            $totalMoney = 0;

    		// 查询当前机器的累计交易金额
    		$tradePrice = \App\Trade::where('sn', $this->trade->sn)
    								->where('merchant_code', $this->trade->merchant_code)
									->whereIn('cardType', [1, null])	// 非借记卡
									->where('sysRespCode', '00')			// 交易成功
									->where('is_invalid', 0)				// 非无效交易
									->where('is_repeat', 0)				    // 非重复交易
									->sum('amount');

			// 机器的累计交易金额大于激活标准时，发放激活返现
			if ($tradePrice >= $this->policy->active_price) {

                // 更新机具激活状态
                \App\Machine::where('sn', $this->trade->sn)->update([
                    'activate_state'    => 1,
                    'activate_time'     => date('Y-m-d H:i:s', time()),
                ]);

                // 更新商户激活序列号
                \App\Merchant::where('code', $this->trade->merchant_code)->update([
                    'activate_sn'   => $this->trade->sn
                ]);

                // 添加激活记录
                \App\ActivesLog::create([
                    'merchant_code'     => $this->trade->merchant_code,
                    'sn'                => $this->trade->sn,
                    'user_id'           => $this->user->id,
                    'type'              => 1
                ]);
                
				// 激活返现金额大于0时，增加用户余余额并添加分润记录
				if ($this->policy->default_active > 0) {
                    // 直推激活返现
					$this->addUserBalance($this->user->id, $this->policy->default_active, 3);
				}
				
				if ($this->user->parent > 0) {

                    // 间推激活返现
					if ($this->policy->indirect_active > 0) {
						$this->addUserBalance($this->user->parent, $this->policy->indirect_active, 4);
					}

                    // 间间推激活返现
                    $ppid = \App\User::where('id', $this->user->parent)->value('parent');
                    if ($ppid > 0 && $this->policy->in_indirect_active > 0) {
                        $this->addUserBalance($ppid, $this->policy->in_indirect_active, 5);
                    }

				}

                $totalMoney = ($this->policy->default_active + $this->policy->indirect_active + $this->policy->in_indirect_active);

                return array('status' => true, 'message' => '激活成功，返现' . $totalMoney . '元');
			}
    	}
    }

    /**
     * [addUserBalance 增加用户余额 分润余额 分润记录]
     * @param [type]  $userId [用户id]
     * @param [type]  $money  [分润金额(元)]
     * @param integer $type   [类型，3激活返现(直营)，4激活返现(间推)，5激活返现(间间推)]
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
