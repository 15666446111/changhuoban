<?php

namespace App\Http\Controllers\Datamoving;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
	// 操盘方id
	// public $agentIds = [538, 893];
	public $agentIds = [538];

	public $tradeTable;

	public function __construct()
	{
		$tradeTable = [
			538 => 'trade_data_qzah',
			893	=> 'trade_data_qzhy'
		];
	}

    public function index()
    {
    	foreach ($this->agentIds as $k => $v) {
    		$this->adminUsers($v);
    	}
    	
    }

    /**
     * [adminUsers 操盘方账号迁移，添加操盘方后台账号，并同步操盘设置和前台账号信息]
     * @param  integer $agentId [description]
     * @return [type]           [description]
     */
    public function adminUsers($agentId=0)
    {
    	// 原3.0操盘方用户信息
    	$agentInfoOld = Db::connection('mysql_3')->table('user')->where('id', $agentId)->first();

    	// 原3.0操盘方设置信息
    	$roleUserInfoOld = Db::connection('mysql_3')->table('role_user')->where('id', $agentId)->first();

    	// 原3.0操盘方商户注册链接
    	$merchantRegisterOld = Db::connection('mysql_3')->table('agen_img')->where('agent_id', $agentId)->where('type', 2)->value('url');

    	$no = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);

		// 创建后台登陆账号
		$adminUser = \App\AdminUser::create([
			'username'	=> $agentInfoOld->mobile,
			'password'	=> Hash::make('123@chanjet'),
			'name'		=> $agentInfoOld->user_nickname,
			'operate'	=> $no,
			'type'		=> 3,	// 账号类型, 1=平台管理员, 2=机构管理员 , 3=操盘管理员
		]);

		\App\AdminRoleUser::create([
            'role_id'   => 2,
            'user_id'   => $adminUser->id,
        ]);

        // 创建前台登录账号
        \App\User::insert([
            'nickname'  =>  $agentInfoOld->user_nickname,
            'account'   =>  $agentInfoOld->mobile,
            'phone'     =>  $agentInfoOld->mobile,
            'password'  =>  $agentInfoOld->user_pass,
            'user_group'=>  1,
            'operate'   =>  $no,
        ]);

        // 创建操盘方设置信息
        \App\AdminSetting::create([
        	'operate_number'	=> $no,
        	'register_merchant'	=> $merchantRegisterOld,
        	'system_merchant'	=> $roleUserInfoOld->service_id,
        	'system_secret'		=> $roleUserInfoOld->channel_key,
        	'payment_type'		=> $roleUserInfoOld->repay_channel == 1 ? 2 : 1,
        	'payment_merchant'	=> $roleUserInfoOld->pay_merchant_id,
        	'payment_secret'	=> $roleUserInfoOld->pay_key,
        	'pattern'			=> 2,
        	'company'			=> $agentInfoOld->user_nickname
        ]);


        ## 添加迁移后信息和原信息的关联信息
    }

    /**
     * [users 数据迁移]
     * @param  integer $agentId [description]
     * @return [type]           [description]
     */
    public function users($agentId=0)
    {
    	$userListOld = Db::connection('mysql_3')->table('user')->where('txt', 'like', "%,$agentId,%")->get();

    	$userDatas = [];
    	foreach ($userListOld as $k => $v) {
    		$userDatas[] = [
    			'nickname'		=> $v['user_nickname'],
    			'account'		=> $v['mobile'],
    			// 'avatar'		=> 				### 头像暂定为默认
    			'phone'			=> $v['mobile'],
    			'password'		=> $v['user_pass'],
    			'user_group'	=> 1,


    			// 需要先添加再修改的字段
    			// 'parent'		=>
    		];
    	}
    }
}
