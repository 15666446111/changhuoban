<?php

namespace App\Http\Controllers\Migrate;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
	/**
	 * [$merchant 定义操盘方 操盘号]
	 * @var string
	 */
    protected $merchant = "2020081255565510";

    /**
     * [$oldMerchant 旧的操盘方id]
     * @var string
     */
    protected $oldMerchant = "538";


    /**
     * 直推上级
     */
    protected $uid = 24;

    /**
     * [$user 老新用户关系。oldid=》newid ]
     * @var [type]
     */
    protected $user;


    /**
     * [$oldUser  原 3.0平台会员 ]
     * @var [type]
     */
    protected $oldUser;


    /**
     * @Author    Pudding
     * @DateTime  2020-08-12
     * @copyright [copyright]
     * @license   [ 初始化方法 ]
     * @version   [version]
     */
    public function __construct()
    {
    	$this->oldUser = \App\Model3\User::where('txt', 'like', '%,'.$this->oldMerchant.',%')->orWhere('id', $this->oldMerchant)->orderBy('create_time', 'asc')->get();
    
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-08-12
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 开始导入 ]
     * @return    [type]      [description]
     */
	public function start()
	{
		$i = 1;

		foreach ($this->oldUser as $key => $value) {

			if(\App\User::where('account', $value->mobile)->exists()) continue;

			if($value->id == $this->oldMerchant) continue;

			$parent = ($i == 1 or $value->pid == $this->oldMerchant) ? $this->uid : $this->user[$value->pid];

			$newUser = \App\User::create([
				'nickname'	=>	$value->user_nickname,
				'account'	=>  $value->mobile,
				'phone'		=>  $value->mobile,
				'password'	=>  $value->user_pass,
				'user_group'=>	1,
				'parent'	=>	$parent,
				'operate'	=>	$this->merchant,
				'created_at'=>	Carbon::createFromTimeStamp($value->create_time)->toDateTimeString(),
			]);

			$i ++;

			// 追加到数组
			$this->user[$value->id] = $newUser['id'];
		}


		foreach ($this->oldUser as $key => $value) {

			$user = \App\User::where('account', $value->mobile)->first();

			$user->wallets->cash_blance = $value->profitWallet * 100;

			$user->wallets->return_blance = $value->cashWallet * 100;

			$user->wallets->created_at = Carbon::createFromTimeStamp($value->create_time)->toDateTimeString();

			$user->wallets->save();

		}

		$this->sh();
	}


	public function sh()
	{

		foreach ($this->oldUser as $key => $value) {

			foreach ($value->merchants as $k => $v) {

				$user = \App\User::where('account', $value->mobile)->first();

				$merchantNew = \App\Merchant::create([
					'user_id'	=>	$user->id,
					'code'		=>	$v->merchantNo,
					'name'		=>	$v->merchantName,
					'phone'		=>	$v->merchantPhone,
					'created_at'=>  Carbon::createFromTimeStamp($v->addTime)->toDateTimeString(),
					'operate'	=>  $this->merchant,

				]);


				foreach ($v->logs as $a => $b) {
					\App\MerchantsBindLog::create([
						'merchant_code'	=>	$b->merchantCode,
						'sn'			=>	$b->sn,
						'bind_state'	=>	$b->untying == 2 ? 0 : $b->untying,
						'created_at'	=>	Carbon::createFromTimeStamp($b->add_time)->toDateTimeString();
					]);
				}



				foreach ($v->housise as $c => $d) {

					$bind = \App\Model3\HouseBindLog::where('sn', $d->sm)->where('untying', 1)->first();

					$merchantId = empty($bind) ? 0 : \App\Merchant::where('code', $bind->merchantNo)->value('id');


					\App\Machine::create([
						'user_id'		=>	$user->id,
						'sn'			=>  $d->sm,
						'open_state'	=>  $d->open_state == 2 ? 0 : $d->open_state,
						'created_at'	=>  Carbon::createFromTimeStamp($d->add_time)->toDateTimeString(),
						'merchant_id' 	=>  $merchantId,
						'bind_status' 	=>  empty($bind) ? 0 : 1,
						'bind_time'		=>  empty($bind) ? null : Carbon::createFromTimeStamp($d->add_time)->toDateTimeString(),
						'activate_time' =>  empty($bind) ? null : Carbon::createFromTimeStamp($d->activation_time)->toDateTimeString(),
						'activate_state'=>  $bind->activation_state == 4 ? : 0 : $bind->activation_state,
						'standard_status' => 
					]);

					//$user->machines->is_self =  后期更新

					//$user->machines->style_id	= 

					$user->machines->standard_status = 达标状态

					$user->machines->open_time = 开通时间

					$user->machines->overdue_state = 过期状态

					$user->machines->active_end_time = 激活截止时间

					$user->machines->operate = $this->merchant;

					$user->machines->standard_status_lj = 累计达标状态

					$user->machines->policy_id = 政策id;

					$user->machines->sim_frozen_num = 流量卡收取次数

					$user->machines->save();	
				}


				//$user->merchants->activate_sn = $v->merchantPhone;  激活SN 


				//$user->merchants->open_time = Carbon::createFromTimeStamp($v->addTime)->toDateTimeString(); 开通时间
			}
		}
	}







}
