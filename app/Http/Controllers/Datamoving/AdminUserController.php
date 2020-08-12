<?php

namespace App\Http\Controllers\Datamoving;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Hash;

class AdminUserController extends Controller
{

	
	/**
	 * [$agentIds 操盘方id]
	 * @var array
	 */
	protected $agentIds = [538, 893];

	/**
	 * [$agentInfoOld 原3.0操盘方用户信息]
	 * @var [type]
	 */
	protected $agentInfoOld;
	protected $roleUserInfoOld;		// 原3.0操盘方设置信息
	protected $merchantRegisterOld;	// 原3.0操盘方商户注册链接

    /**
     * [$databaseOld 原3.0数据库]
     * @var [type]
     */
    protected $databaseOld;

    /**
     * [$databaseMoving 原数据和新数据关联关系数据库]
     * @var [type]
     */
    protected $databaseMoving;

	public function __construct()
	{
		$this->databaseOld    = Db::connection('mysql_3');
        $this->databaseMoving = Db::connection('mysql_moving');
	}


	public function index()
	{
		foreach ($this->agentIds as $k => $v) {
			// 原3.0操盘方用户信息
	    	$this->agentInfoOld = $this->databaseOld->table('user')->where('id', $agentId)->first();

	    	// 原3.0操盘方设置信息
	    	$this->roleUserInfoOld = $this->databaseOld->table('role_user')->where('user_id', $agentId)->first();

	    	// 原3.0操盘方商户注册链接
	    	$this->merchantRegisterOld = $this->databaseOld->table('agen_img')->where('agent_id', $agentId)->where('type', 2)->value('url');

    		$this->adminUsers($v);
    	}
	}

    /**
     * [adminUsers description]
     * @param  integer $agentId [description]
     * @return [type]           [description]
     */
    public function adminUsers($agentId=0)
    {
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
}
