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
     * [$activeList 活动]
     * @var [type]
     */
    protected $activeList;


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

    	$this->activeList = [
    		276	=> 9,
    		275	=> 10,
    		264	=> 20,
    		256	=> 10,
    		255	=> 11,		// H9-刷5000返99
    		254	=> 12,		// MP70刷100返99
    		245	=> 25,		// MP70-99返99
    		244	=> 24,		// 活动自备机-99返99
    		119	=> 23,		// MP70-99返120
    		117	=> 22,		// H9-298返398 - 3.0
    		116	=> 21,		// MP70-198返298 - 3.0
    		96	=> 20,		// 新活动转自备机
    		95	=> 17,		// H9-298返398
    		94	=> 20,		// 新活动转自备机
    		93	=> 19,		// MP70-198返298
    	];
    
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

			// if(\App\User::where('account', $value->mobile)->exists()) continue;

			// if($value->id == $this->oldMerchant) continue;

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

			dd($newUser);

			$i ++;

			// 追加到数组
			$this->user[$value->id] = $newUser['id'];
		}


		// foreach ($this->oldUser as $key => $value) {

		// 	$user = \App\User::where('account', $value->mobile)->first();

		// 	$user->wallets->cash_blance = $value->profitWallet * 100;

		// 	$user->wallets->return_blance = $value->cashWallet * 100;

		// 	$user->wallets->created_at = Carbon::createFromTimeStamp($value->create_time)->toDateTimeString();

		// 	$user->wallets->save();

		// }

		// $this->sh();
	}


	/**
	 * [sh 商户和机器信息]
	 * @return [type] [description]
	 */
	public function sh()
	{

		foreach ($this->oldUser as $key => $value) {

			foreach ($value->merchants as $k => $v) {

				$user = \App\User::where('account', $value->mobile)->first();

				// 商户信息
				$activateSn = \App\Model3\HouseBindLog::where('merchantCode', $d->merchantNo)->where('activation_state', 1)->value('sn');
				$merchantNew = \App\Merchant::create([
					'user_id'		=>	$user->id,
					'code'			=>	$v->merchantNo,
					'name'			=>	$v->merchantName,
					'phone'			=>	$v->merchantPhone,
					'created_at'	=>  Carbon::createFromTimeStamp($v->addTime)->toDateTimeString(),
					'operate'		=>  $this->merchant,
					'activate_sn'	=>	$activateSn
				]);

				// 商户绑定信息
				foreach ($v->logs as $a => $b) {
					\App\MerchantsBindLog::create([
						'merchant_code'	=>	$b->merchantCode,
						'sn'			=>	$b->sn,
						'bind_state'	=>	$b->untying == 2 ? 0 : $b->untying,
						'created_at'	=>	Carbon::createFromTimeStamp($b->add_time)->toDateTimeString()
					]);
				}


				// 机器信息
				foreach ($v->housise as $c => $d) {

					$bind = \App\Model3\HouseBindLog::where('sn', $d->sm)->where('untying', 1)->first();

					$merchantId = empty($bind) ? 0 : \App\Merchant::where('code', $bind->merchantCode)->value('id');


					\App\Machine::create([
						'user_id'			=>	$user->id,
						'sn'				=>  $d->sm,
						'open_state'		=>  $d->open_state == 2 ? 0 : $d->open_state,
						'created_at'		=>  Carbon::createFromTimeStamp($d->add_time)->toDateTimeString(),
						'merchant_id' 		=>  $merchantId,
						'bind_status' 		=>  empty($bind) ? 0 : 1,
						'bind_time'			=>  empty($bind) ? null : Carbon::createFromTimeStamp($d->add_time)->toDateTimeString(),
						'activate_time' 	=>  empty($bind) ? null : Carbon::createFromTimeStamp($d->activation_time)->toDateTimeString(),
						'activate_state'	=>  $bind->activation_state == 4 ? 0 : $bind->activation_state,
						'standard_status' 	=>	$d->ac_return_state == 2 ? -1 : 0,
						'open_time'			=>	empty($d->opening_time) ? null : Carbon::createFromTimeStamp($d->opening_time)->toDateTimeString(),
						'overdue_state'		=>	$d->overdue_state == 2 ? 1 : 0,
						'active_end_time' 	=>	empty($d->activa_end_time) ? null : Carbon::createFromTimeStamp($d->activa_end_time)->toDateTimeString(),
						'operate'			=>	$this->merchant,
						'standard_status_lj'=>	$d->st_return_state == 2 ? -1 : 0,
						'sim_frozen_num'	=>	$d->sim_fro_state,
						'policy_id'			=>	$this->activeList[$d->activity_id],
					]);

					// $user->machines->policy_id = 政策id;

					//$user->machines->is_self =  后期更新

					//$user->machines->style_id	= 


				}
			}
		}
	}







	// 后期更新
	// $user->machines->style_id 	机器型号
	// $user->merchants->open_time 	商户开通时间

}
