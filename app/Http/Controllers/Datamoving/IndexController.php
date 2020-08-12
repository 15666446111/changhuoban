<?php

namespace App\Http\Controllers\Datamoving;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Hash;
use Session;

class IndexController extends Controller
{
	// 操盘方id
	// public $agentIds = [538, 893];
	public $agentIds = [538];

    // 交易记录表名称
	public $tradeTable;

    // 原3.0数据库
    public $databaseOld;

    public $databaseMoving;

	public function __construct()
	{
		$tradeTable = [
			538 => 'trade_data_qzah',
			893	=> 'trade_data_qzhy'
		];

        $databaseOld    = Db::connection('mysql_3');
        $databaseMoving = Db::connection('mysql_moving');
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
    	$agentInfoOld = $databaseOld->table('user')->where('id', $agentId)->first();

    	// 原3.0操盘方设置信息
    	$roleUserInfoOld = $databaseOld->table('role_user')->where('user_id', $agentId)->first();

    	// 原3.0操盘方商户注册链接
    	$merchantRegisterOld = $databaseOld->table('agen_img')->where('agent_id', $agentId)->where('type', 2)->value('url');

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
        $userIdNew = \App\User::insertGetId([
            'nickname'  	=> $agentInfoOld->user_nickname,
            'account'   	=> $agentInfoOld->mobile,
            'phone'     	=> $agentInfoOld->mobile,
            'password'  	=> $agentInfoOld->user_pass,
            'user_group'	=> 1,
            'operate'   	=> $no,
            'created_at'	=> date('Y-m-d H:i:s', $agentInfoOld->create_time),
            'update_at'		=> date('Y-m-d H:i:s', time())
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
        $databaseMoving->table('admin_users')->insert([
            'user_id_old'           => $agentInfoOld->id,
            'admin_user_id_new'     => $adminUser->id,
            'create_at'             => date('Y-m-d H:i:s', time())
        ]);

        $this->moveUserAdd($userIdNew, $agentInfoOld->id);
    }

    /**
     * [users 用户表数据迁移]
     * @param  integer $agentId [description]
     * @return [type]           [description]
     */
    public function users($agentId=0)
    {
    	$userListOld = $databaseOld->table('user')->where('txt', 'like', "%,$agentId,%")->get();

    	foreach ($userListOld as $k => $v) {

            // 查询操盘号
            $adminIdNew = $databaseMoving->table('admin_users')->where('user_id_old', $v->id)->value('admin_user_id_new');
            $operate = \App\adminUser::where('id', $adminIdNew)->value('operate');

            $userIdNew = \App\User::insertGetId([
                'nickname'      => $v->user_nickname,
                'account'       => $v->mobile,
                'phone'         => $v->mobile,
                'password'      => $v->user_pass,
                'user_group'    => 1,
                'operate'       => $operate,
                'create_at'     => date('Y-m-d H:i:s', $v->create_time),
                'update_at'     => date('Y-m-d H:i:s', time())
            ]);

            // 记录新老平台用户关联信息
            $this->moveUserAdd($userIdNew, $v->id);

            // 同步用户钱包数据
            $this->userWalletAdd($userIdNew, $v->profitWallet, $v->cashWallet);

            // 同步添加实名认证表数据
            \App\UserRealname::create(['user_id'   =>  $userIdNew]);

            // 同步添加用户上下级关系表
            

            // 'avatar'     =>              ### 头像暂定为默认
			// 需要先添加再修改的字段
			// 'parent'		=>
    	}
    }




    /**
     * [userWalletAdd 添加用户钱包信息]
     * @param [type] $userId        [新后台用户id]
     * @param [type] $cashBalance   [分润钱包余额]
     * @param [type] $returnBalance [返现钱包余额]
     */
    public function userWalletAdd($userId, $cashBalance, $returnBalance)
    {
        \App\UserWallet::create([
            'user_id'   => $userId,
            'cash_blance'   => $cashBalance,
            'return_blance'   => $returnBalance,
        ]);
    }




    /**
     * [moveUserAdd 新增新后台、老后台用户信息关联信息]
     * @param  [type] $userIdNew [description]
     * @param  [type] $oldUserId [description]
     * @return [type]            [description]
     */
    public function moveUserAdd($userIdNew, $oldUserId)
    {
        $databaseMoving->table('users')->insert([
            'user_id_old'     => $oldUserId,
            'user_id_new'     => $userIdNew,
            'create_at'       => date('Y-m-d H:i:s', time())
        ]);
    }
}
