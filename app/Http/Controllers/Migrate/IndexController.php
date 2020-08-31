<?php

namespace App\Http\Controllers\Migrate;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
	/**
	 * [$operate 定义操盘方 操盘号]
	 * @var string
	 */
    protected $operate = "2020082153100102";

    /**
     * [$oldMerchant 旧的操盘方id]
     * @var string
     */
    protected $oldMerchant = "639";


    /**
     * [$oldServiceId 操盘方机构号]
     * @var string
     */
    protected $oldServiceId = "49058393";


    /**
     * 直推上级
     */
    protected $uid = 193;


    /**
     * [$policyGruopId 活动组id，每个操盘方取固定值]
     * @var integer
     */
    protected $policyGruopId = 15;


    /**
     * [$user 老新用户关系。oldid=》newid ]
     * @var [type]
     */
    protected $user;


    /**
     * [$merchant 老新商户关系。oldid=》newid ]
     * @var [type]
     */
    protected $merchant;


    /**
     * [$oldUser  原 3.0平台会员 ]
     * @var [type]
     */
    protected $oldUser;


    /**
     * [$trade 原3.0平台交易数据]
     * @var [type]
     */
    protected $trade;


    /**
     * [$brandList 原机具型号id对应新机具型号id ]
     * @var [type]
     */
    protected $brandList = [
        57  => 7,       // 助代通3.0 MF69S
        58  => 9,       // 助代通3.0 MF919-智能
        59  => 3,       // 助代通3.0 MP70
        60  => 4,       // 助代通3.0 H9
        61  => 2,       // 助代通3.0 MP70-扫码
        62  => 1,       // 助代通3.0 H9-扫码

        154 => 13,      // 助代通3.0 H9
        155 => 12,      // 助代通3.0 MP70
        160 => 14,      // 助代通3.0 MP70 - 扫码
        161 => 15,      // 助代通3.0 H9-扫码

        66  => 6,      // 活动自备机(全)
        145 => 6,      // 活动自备机(全)
        146 => 6,      // 活动自备机(全)
        147 => 6,      // 活动自备机(全)
        148 => 6,      // 活动自备机(全)
        169 => 6,      // 活动自备机(全)

        109 => 5,      // 自备机(全)
        114 => 5,      // 自备机(全)
        115 => 5,      // 自备机(全)
        116 => 5,      // 自备机(全)
        118 => 5,      // 自备机(全)
        131 => 5,      // 自备机(全)
        138 => 5,      // 自备机(全)
        141 => 5,      // 自备机(全)
        142 => 5,      // 自备机(全)
        144 => 5,      // 自备机(全)
        152 => 5,      // 自备机(全)
        165 => 5,      // 自备机(全)
        166 => 5,      // 自备机(全)
        168 => 5,      // 自备机(全)
    ];


    /**
     * [$activeList 原活动id对应新活动id ]
     * @var [type]
     */
    // 青州安恒
	// protected $activeList = [276 => 9, 275 => 10, 264 => 20, 256 => 10, 255 => 11, 254 => 12, 245 => 25, 244 => 24, 119 => 23, 117 => 22, 116 => 21, 96 => 20, 95 => 17, 94 => 20, 93 => 19, 
 //    ];
    // 青州恒远
    protected $activeList = [
        145 => 39,  // 自备机
        144 => 40,  // 298返120活动
        143 => 37,  // MP70-0返0
        120 => 36,  // 新活动转自备机

        101 => 38,  // 活动押金机转自备机
        100 => 42,  // 3元冻结无返现
        99 => 43,   // 300返120
        98 => 41,   // 49返49，刷5000激活，第二月刷5000返20，第三月刷5000返30.
        97 => 44,   // 198反298
    ];


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

        $tradeField = ['tranCode', 'user_id', 'j_pydate', 'rrn', 'is_send', 'termId', 'sm', 'j_code', 'j_num', 'j_money', 'settleAmount', 'cardType', 'j_pydate', 'j_pytime', 'traceNo', 'add_time', 'feeType', 'platCode', 'inputMode', 'originalTranDate', 'originalRrn', 'sysRespCode', 'sysRespDesc', 'version', 'activeStat', 'merchLevel' ];
    	$this->trade   = \App\Model3\Trade::orderBy('j_pytime', 'asc')->get($tradeField);

        $this->syncTrade();die;
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

        set_time_limit(0);  								//设置程序执行时间
        
        ignore_user_abort(true);    						//设置断开连接继续执行
        
        header('X-Accel-Buffering: no');    				//关闭buffer
        
        header('Content-type: text/html;charset=utf-8');    //设置网页编码
        
        ob_start(); 										//打开输出缓冲控制
        
        echo str_repeat(' ',1024*4);    					//字符填充

        $width = 1000;

        $html = '<div style="margin:100px auto; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: %upx">
        <div style="text-align:center; margin-bottom:10px;">共有'.count($this->oldUser).'名会员需要迁移</div><div style="padding: 0; background-color: white; border: 1px solid navy; width: %upx"><div id="progress" style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center; height: 16px"></div></div><div id="msg" style="font-family: Tahoma; font-size: 9pt;">正在处理...</div><div id="percent" style="position: relative; top: -34px; text-align: center; font-weight: bold; font-size: 8pt">0%%</div></div>';

        echo sprintf($html, $width+8, $width);
        
        echo ob_get_clean();    							//获取当前缓冲区内容并清除当前的输出缓冲

        flush();   											//刷新缓冲区的内容，输出

        $i = 1;

        $error = array();

        foreach ($this->oldUser as $key => $value) 
        {

            $proportion = $i / count($this->oldUser);

            $msg = $i == count($this->oldUser) ? '迁移完成' : '正在迁移第' . $i . '条会员信息';
            
            $script = '<script>document.getElementById("percent").innerText="%u%%";document.getElementById("progress").style.width="%upx";document.getElementById("msg").innerText="%s";</script>';
            

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
				'operate'	=>	$this->operate,
				'created_at'=>	Carbon::createFromTimeStamp($value->create_time)->toDateTimeString(),
			]);

			$this->user[$value->id] = $newUser['id'];

			//print_r($this->user);

            echo sprintf($script, intval($proportion*100), intval( $i/count($this->oldUser)*$width), $msg);

            $i++;

            echo ob_get_clean();    //获取当前缓冲区内容并清除当前的输出缓冲

            flush();   //刷新缓冲区的内容，输出
        }

        $this->syncWallet();
	}



    /**
     * @Author    Pudding
     * @DateTime  2020-08-13
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 同步钱包信息 ]
     * @return    [type]      [description]
     */
    public function syncWallet()
    {

        set_time_limit(0);                                  //设置程序执行时间
        
        ignore_user_abort(true);                            //设置断开连接继续执行
        
        ob_start();                                         //打开输出缓冲控制
        
        echo str_repeat(' ',1024*4);                        //字符填充

        $width1 = 1000;

        $html1 = '<div style="margin:100px auto; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: %upx">
        <div style="text-align:center; margin-bottom:10px;">共有'.count($this->oldUser).'条会员钱包信息需要同步</div><div style="padding: 0; background-color: white; border: 1px solid navy; width: %upx"><div id="progress1" style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center; height: 16px"></div></div><div id="msg1" style="font-family: Tahoma; font-size: 9pt;">正在处理...</div><div id="percent1" style="position: relative; top: -34px; text-align: center; font-weight: bold; font-size: 8pt">0%%</div></div>';

        echo sprintf($html1, $width1+8, $width1);
        
        echo ob_get_clean();                                //获取当前缓冲区内容并清除当前的输出缓冲

        flush();                                            //刷新缓冲区的内容，输出

        $i = 1;

        $error = array();

        foreach ($this->oldUser as $key => $value) 
        {

            $proportion = $i / count($this->oldUser);

            $msg1 = $i == count($this->oldUser) ? '钱包数据同步完成' : '正在同步第' . $i . '条会员钱包信息';
            
            $script1 = '<script>document.getElementById("percent1").innerText="%u%%";document.getElementById("progress1").style.width="%upx";document.getElementById("msg1").innerText="%s";</script>';
            
            // 用户钱包信息
            $user = \App\User::where('account', $value->mobile)->first();

            $user->wallets->cash_blance = $value->profitWallet * 100;

            $user->wallets->return_blance = $value->cashWallet * 100;

            $user->wallets->created_at = Carbon::createFromTimeStamp($value->create_time)->toDateTimeString();

            $user->wallets->save();

            // 提现银行卡信息
            $userId = $value->id == $this->oldMerchant ? $this->uid : $this->user[$value->id];

            if (!empty($value->banks)) {
                \App\Bank::create([
                    'user_id'   => $userId,
                    'user_name' => $value->banks->name,
                    'bank_name' => $value->banks->bank,
                    'bank'      => $value->banks->bank_number,
                    'number'    => $value->banks->number,
                    'open_bank' => $value->banks->kaihuhang,
                    'bank_open' => $value->banks->banklink,
                    'is_default'=> 1
                ]);
            }
            

            echo sprintf($script1, intval($proportion *100 ), intval( $i/count($this->oldUser)*$width1), $msg1);

            $i++;

            echo ob_get_clean();    //获取当前缓冲区内容并清除当前的输出缓冲

            flush();   //刷新缓冲区的内容，输出
        }

        sleep(1);

        $this->syncSettlement();
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-08-13
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 用户结算价、用户激活返现信息 ]
     * @return    [type]      [description]
     */
    public function syncSettlement()
    {

        set_time_limit(0);                                  //设置程序执行时间
        
        ignore_user_abort(true);                            //设置断开连接继续执行
        
        ob_start();                                         //打开输出缓冲控制
        
        echo str_repeat(' ',1024*4);                        //字符填充

        $width4 = 1000;

        $html4 = '<div style="margin:100px auto; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: %upx">
        <div style="text-align:center; margin-bottom:10px;">共有'.count($this->oldUser).'条会员结算信息需要同步</div><div style="padding: 0; background-color: white; border: 1px solid navy; width: %upx"><div id="progress4" style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center; height: 16px"></div></div><div id="msg4" style="font-family: Tahoma; font-size: 9pt;">正在处理...</div><div id="percent4" style="position: relative; top: -34px; text-align: center; font-weight: bold; font-size: 8pt">0%%</div></div>';

        echo sprintf($html4, $width4+8, $width4);
        
        echo ob_get_clean();                                //获取当前缓冲区内容并清除当前的输出缓冲

        flush();                                            //刷新缓冲区的内容，输出

        $i = 1;

        $error = array();

        // 原结算价分类信息
        $oldSettlementType = \App\Model3\SettlementType::get();

        foreach ($this->oldUser as $key => $value) 
        {

            $proportion = $i / count($this->oldUser);

            $msg4 = $i == count($this->oldUser) ? '会员结算信息同步完成' : '正在同步第' . $i . '条会员结算信息';
            
            $script1 = '<script>document.getElementById("percent4").innerText="%u%%";document.getElementById("progress4").style.width="%upx";document.getElementById("msg4").innerText="%s";</script>';
            
            // 用户结算价信息
            $priceArr = [];
            // 用户激活返现信息
            $activeArr = [];

            $userId = $value->id == $this->oldMerchant ? $this->uid : $this->user[$value->id];

            foreach ($value->settlements as $k => $v) {
                // 结算价信息
                if ($v->seId > 0) {
                    $priceArr[] = [
                        'index'     => $v->seId + 1,
                        // $v->seId == 3 为借记卡封顶类型
                        'price'     => $v->seId == 3 ? bcmul($v->settlement, 100) : bcmul($v->settlement, 100000)
                    ];
                } else {
                    // 活动激活返现信息
                    \App\UserPolicy::create([
                        'default_active_set'    => $v->settlement * 100,
                        'user_id'               => $userId,
                        'policy_id'             => $this->activeList[$v->activityId]
                    ]);
                }
            }

            // 用户未设置结算价时，获取默认结算价信息
            if (empty($priceArr)) {
                foreach ($oldSettlementType as $k => $v) {
                    $priceArr[] = [
                        'index'     => $v->id + 1,
                        // $v->id == 3 为借记卡封顶类型
                        'price'     => $v->id == 3 ? bcmul($v->defaultSettle, 100) : bcmul($v->defaultSettle, 100000)
                    ];
                }
            }

            if (!empty($priceArr)) {
                \App\UserFee::create([
                    'user_id'           => $userId,
                    'policy_group_id'   => $this->policyGruopId,
                    'price'             => json_encode($priceArr)
                ]);
            }
            
            echo sprintf($script1, intval($proportion *100 ), intval( $i/count($this->oldUser)*$width4), $msg4);

            $i++;

            echo ob_get_clean();    //获取当前缓冲区内容并清除当前的输出缓冲

            flush();   //刷新缓冲区的内容，输出
        }

        $this->syncMerchantsBindLog();
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-08-13
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 同步绑定记录表 ]
     * @return    [type]      [description]
     */
    public function syncMerchantsBindLog()
    {

        set_time_limit(0);                                  //设置程序执行时间
        
        ignore_user_abort(true);                            //设置断开连接继续执行
        
        ob_start();                                         //打开输出缓冲控制
        
        echo str_repeat(' ',1024*4);                        //字符填充

        $width2 = 1000;

        $html2 = '<div style="margin:100px auto; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: %upx">
        <div style="text-align:center; margin-bottom:10px;">共有'.count($this->oldUser).'条会员商户机具需要迁移</div><div style="padding: 0; background-color: white; border: 1px solid navy; width: %upx"><div id="progress2" style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center; height: 16px"></div></div><div id="msg2" style="font-family: Tahoma; font-size: 9pt;">正在处理...</div><div id="percent2" style="position: relative; top: -34px; text-align: center; font-weight: bold; font-size: 8pt">0%%</div></div>';

        echo sprintf($html2, $width2+8, $width2);
        
        echo ob_get_clean();                                //获取当前缓冲区内容并清除当前的输出缓冲

        flush();                                            //刷新缓冲区的内容，输出

        $i = 1;

        $error = array();

        foreach ($this->oldUser as $key => $value) 
        {

            $proportion = $i / count($this->oldUser);

            $msg2 = $i == count($this->oldUser) ? '商户机具数据同步完成' : '正在同步第' . $i . '条会员商户机具信息';
            
            $script2 = '<script>document.getElementById("percent2").innerText="%u%%";document.getElementById("progress2").style.width="%upx";document.getElementById("msg2").innerText="%s";</script>';
            

            $user       = \App\User::where('account', $value->mobile)->first();
            foreach ($value->merchants as $k => $v) {
                $active     = "";

                foreach ($v->logs as $a => $b) {
                    if($b->activation_state == "1") $active = $b->sn;
                    \App\MerchantsBindLog::create([
                        'merchant_code' =>  $b->merchantCode,
                        'sn'            =>  $b->sn,
                        'bind_state'    =>  $b->untying == 2 ? 0 : $b->untying,
                        'created_at'    =>  Carbon::createFromTimeStamp($b->add_time)->toDateTimeString()
                    ]);
                }

                if($v->merchantNo){
                    $merchantNew = \App\Merchant::create([
                        'user_id'   =>  $user->id,
                        'code'      =>  $v->merchantNo,
                        'name'      =>  $v->merchantName,
                        'phone'     =>  $v->merchantPhone,
                        'activate_sn'=> $active,
                        'open_time' =>  $v->addTime ? Carbon::createFromTimeStamp($v->addTime)->toDateTimeString() : null ,
                        'created_at'=>  $v->addTime ? Carbon::createFromTimeStamp($v->addTime)->toDateTimeString() : null ,
                        'operate'   =>  $this->operate,
                    ]);

                    $this->merchant[$v->id] = $merchantNew->id;
                }
            }

            foreach ($value->housise as $c => $d) {

                $bind = \App\Model3\HouseBindLog::where('sn', $d->sm)->where('untying', 1)->first();

                $merchantId = empty($bind) ? 0 : \App\Merchant::where('code', $bind->merchantCode)->value('id');


                \App\Machine::create([
                    'user_id'       =>  $user->id,
                    'sn'            =>  $d->sm,
                    'open_state'    =>  $d->open_state == 2 ? 0 : $d->open_state,
                    'created_at'    =>  Carbon::createFromTimeStamp($d->add_time)->toDateTimeString(),
                    'merchant_id'   =>  $merchantId,
                    'bind_status'   =>  empty($bind) ? 0 : 1,
                    'bind_time'     =>  empty($bind) ? null : Carbon::createFromTimeStamp($bind->add_time)->toDateTimeString(),
                    'activate_time' =>  (empty($bind) || $bind->activation_time == "0" || !$bind->activation_time) ? null : Carbon::createFromTimeStamp($bind->activation_time)->toDateTimeString(),
                    'activate_state'=>  (empty($bind) || $bind->activation_state == 4) ? 0 : $bind->activation_state,
                    'standard_status' => $d->ac_return_state == 2 ? -1 : 0,
                    'open_time'     =>  empty($d->opening_time) ? null : Carbon::createFromTimeStamp($d->opening_time)->toDateTimeString(),
                    'overdue_state' => $d->overdue_state == 2 ? 1 : 0,
                    'active_end_time' =>  empty($d->activa_end_time) ? null : Carbon::createFromTimeStamp($d->activa_end_time)->toDateTimeString(),
                    'operate'   => $this->operate,
                    'standard_status_lj'=> $d->st_return_state == 2 ? -1 : 0,
                    'sim_frozen_num' => $d->sim_fro_state,
                    'policy_id'      => $this->activeList[$d->activity_id],
                    'style_id'       => $this->brandList[$d->brand_id]
                ]);
            }

            echo sprintf($script2, intval($proportion *100 ), intval( $i/count($this->oldUser)*$width2), $msg2);

            $i++;

            echo ob_get_clean();    //获取当前缓冲区内容并清除当前的输出缓冲

            flush();   //刷新缓冲区的内容，输出
        }

        $this->syncTrade();
    }



	/**
	 * @Author    Pudding
	 * @DateTime  2020-08-13
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [ 同步交易数据 分润数据（直营分润、团队分润） ]
	 * @return    [type]      [description]
	 */
	public function syncTrade()
	{

        set_time_limit(0);  								//设置程序执行时间
        
        ignore_user_abort(true);    						//设置断开连接继续执行
        
        ob_start(); 										//打开输出缓冲控制
        
        echo str_repeat(' ',1024*4);    					//字符填充

        $width3 = 1000;

        $html3 = '<div style="margin:100px auto; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: %upx">
        <div style="text-align:center; margin-bottom:10px;">共有'.count($this->trade).'条交易数据需要同步</div><div style="padding: 0; background-color: white; border: 1px solid navy; width: %upx"><div id="progress3" style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center; height: 16px"></div></div><div id="msg3" style="font-family: Tahoma; font-size: 9pt;">正在处理...</div><div id="percent3" style="position: relative; top: -34px; text-align: center; font-weight: bold; font-size: 8pt">0%%</div></div>';

        echo sprintf($html3, $width3+8, $width3);
        
        echo ob_get_clean();    							//获取当前缓冲区内容并清除当前的输出缓冲

        flush();   											//刷新缓冲区的内容，输出

        $i = 1;

        $error = array();

        foreach ($this->trade as $key => $value) 
        {

            $proportion = $i / count($this->trade);

            $msg3 = $i == count($this->trade) ? '交易数据同步完成' : '正在同步第' . $i . '条交易数据信息';
            
            $script4 = '<script>document.getElementById("percent3").innerText="%u%%";document.getElementById("progress3").style.width="%upx";document.getElementById("msg3").innerText="%s";</script>';
            
            $deductionTranCode = [
                '020002'    => '020002',
                '020003'    => '020003',
                'T20003'    => 'T20003',
                '024102'    => '024102',
                '024103'    => '024103',
                '020001'    => '020001',
                '02Y600'    => '02Y600'
            ];

            $addSub = !empty($deductionTranCode[$value->tranCode]) ? -1 : 1;
            // 归属用戶id
            $userId = $value->user_id;
            if ($value->user_id > 0) {
                $userId = $value->user_id == $this->oldMerchant ? $this->uid : $this->user[$value->user_id];
            }

            // 创建订单
            $order = \App\Trade::create([
                'trade_no'          => $value->j_pydate . $value->rrn,
                'user_id'           => $userId,
                'machine_id'        => -1,
                'is_send'           => $value->is_send,
                'term_id'           => !empty($value->termId) ? $value->termId : '',
                'sn'                => $value->sm,
                'merchant_name'     => null,
                'merchant_phone'    => '',
                'merchant_code'     => $value->j_code,
                'agt_merchant_id'   => $this->oldServiceId,
                'sys_trace_no'      => !empty($value->j_num) ? $value->j_num : '',
                'rrn'               => $value->rrn,
                'amount'            => $value->j_money * 100 * $addSub,
                'settle_amount'     => $value->settleAmount * 100 * $addSub,
                'card_type'         => $value->cardType,
                'trans_date'        => $value->j_pydate,
                'trade_time'        => Carbon::createFromFormat('YmdHis', $value->j_pytime)->toDateTimeString(),
                'trace_no'          => !empty($value->traceNo) ? $value->traceNo : '',
                'remark'            => '',
                'created_at'        => Carbon::createFromTimeStamp($value->add_time)->toDateTimeString(),
                'fee_type'          => $value->feeType,
                'operate'           => $this->operate,
                'tran_code'         => $value->tranCode,
                'agent_id'          => !empty($value->platCode) ? $value->platCode : '',
                'input_mode'        => $value->inputMode,
                'original_tran_date'=> $value->originalTranDate,
                'original_rrn'      => $value->originalRrn,
                'original_trace_no' => null,
                'sys_resp_code'     => $value->sysRespCode,
                'sys_resp_desc'     => !empty($value->sysRespDesc) ? $value->sysRespDesc : '',
                'is_repeat'         => 0,
                'is_invalid'        => 0,
            ]);


            $orderInfo = \App\TradesDeputy::create([
            	'trade_id'		=> $order->id,
            	'version'		=> $value->version,
            	'activeStat'	=> $value->activeStat,
            	'merchLevel'	=> $value->merchLevel,
            	'termModel'		=> $value->termModel,
            	'created_at'	=> Carbon::createFromTimeStamp($value->add_time)->toDateTimeString(),
            ]);

            ## 同步交易数据对应的分润信息
            $cashArr = [];

            $cashTypeArr = [
                1   => 1,   // 直营分润
                2   => 2,   // 团队分润
                3   => 3,   // 激活返现(直营)
                16  => 4,   // 激活间推奖励
                17  => 5,   // 激活间间推奖励
                7   => 6,   // 连续达标返现(直营)
                6   => 8,   // 累计达标返现(直营)
                4   => 11,  // 激活返现(团队)
                5   => 12,  // 注册奖励
                8   => 13,  // 财商学院推荐奖励
                10  => 14,  // EPOS直营分润
                11  => 15,  // EPOS团队分润
                12  => 16,  // 推荐办卡
                13  => 17,  // 积分兑换
                14  => 18,  // 推荐办卡(团队)
                15  => 19,  // 积分兑换(团队)
            ];

            // foreach ($value->cashs as $k => $v) {
            //     if ($v->c_code == $value->j_code) {
            //         $cashArr[] = [
            //             'user_id'   => $v->user_id == $this->oldMerchant ? $this->uid : $this->user[$v->user_id],
            //             'order'     => $value->j_pydate . $value->rrn,
            //             'cash_money'=> $v->money * 100,
            //             'is_run'    => $v->is_run,
            //             'cash_type' => $cashTypeArr[$v->type],
            //             'operate'   => $this->operate,
            //             'created_at'=> Carbon::createFromTimeStamp($v->add_time)->toDateTimeString(),
            //         ];
            //     }
            // }

            // \App\Cash::insert($cashArr);


            echo sprintf($script4, intval($proportion *100 ), intval( $i/count($this->trade)*$width3), $msg3);

            $i++;

            echo ob_get_clean();    //获取当前缓冲区内容并清除当前的输出缓冲

            flush();   //刷新缓冲区的内容，输出
        }

        // $this->syncCashs();
	}

    /**
     * @Author    Pudding
     * @DateTime  2020-08-24
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 同步分润数据（返现、其它） ]
     * @return    [type]      [description]
     */
    // public function syncCashs()
    // {
        
    //     set_time_limit(0);                                  //设置程序执行时间
        
    //     ignore_user_abort(true);                            //设置断开连接继续执行
        
    //     ob_start();                                         //打开输出缓冲控制
        
    //     echo str_repeat(' ',1024*4);                        //字符填充

    //     $width5 = 1000;

    //     // 返现记录
    //     $cashList = \App\Model3\Cash::where('type', '>', 2)->where('agent_id', $this->oldMerchant)->get();

    //     $html5 = '<div style="margin:100px auto; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: %upx">
    //     <div style="text-align:center; margin-bottom:10px;">共有'.count($this->cashList).'条返现记录数据需要同步</div><div style="padding: 0; background-color: white; border: 1px solid navy; width: %upx"><div id="progress3" style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center; height: 16px"></div></div><div id="msg5" style="font-family: Tahoma; font-size: 9pt;">正在处理...</div><div id="percent3" style="position: relative; top: -34px; text-align: center; font-weight: bold; font-size: 8pt">0%%</div></div>';

    //     echo sprintf($html5, $width5+8, $width5);
        
    //     echo ob_get_clean();                                //获取当前缓冲区内容并清除当前的输出缓冲

    //     flush();                                            //刷新缓冲区的内容，输出

    //     $i = 1;

    //     $error = array();

    //     $data = [];
    //     foreach ($cashList as $key => $value) {

    //         $proportion = $i / count($cashList);

    //         $msg5 = $i == count($cashList) ? '返现记录数据同步完成' : '正在同步第' . $i . '条返现记录数据信息';
            
    //         $script5 = '<script>document.getElementById("percent5").innerText="%u%%";document.getElementById("progress5").style.width="%upx";document.getElementById("msg5").innerText="%s";</script>';

    //         // 添加一条虚拟交易订单，只做分润记录的sn和商户号匹配
    //         $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'H', 'I', 'J', 'K');

    //         $orderNo = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));

    //         $tradeInfo = \App\Trade::create([
    //             'trade_no'          => $orderNo,
    //             'user_id'           => $value->user_id,
    //             'machine_id'        => $this->merchant[$value->id],
    //             'is_send'           => 1,
    //             'sn'                => $value->sn,
    //             'merchant_code'     => $value->c_code,
    //             'trans_date'        => date('Ymd'),
    //             'trade_time'        => Carbon::now()->toDateTimeString(),
    //             'remark'            => '激活数据虚拟记录',
    //             'operate'           => $this->operate
    //             'sys_resp_code'     => '',
    //             'sys_resp_desc'     => '',
    //         ]);

    //         // 原分润记录的分润类型对应新分润记录表的分润类型，oldCashType => newCashType
    //         $cashTypeArr = [
    //             1   => 1,   // 直营分润
    //             2   => 2,   // 团队分润
    //             3   => 3,   // 激活返现(直营)
    //             16  => 4,   // 激活间推奖励
    //             17  => 5,   // 激活间间推奖励
    //             7   => 6,   // 连续达标返现(直营)
    //             6   => 8,   // 累计达标返现(直营)
    //             4   => 11,  // 激活返现(团队)
    //             5   => 12,  // 注册奖励
    //             8   => 13,  // 财商学院推荐奖励
    //             10  => 14,  // EPOS直营分润
    //             11  => 15,  // EPOS团队分润
    //             12  => 16,  // 推荐办卡
    //             13  => 17,  // 积分兑换
    //             14  => 18,  // 推荐办卡(团队)
    //             15  => 19,  // 积分兑换(团队)
    //         ];

    //         \App\Cash::create([
    //             'user_id'   => $value->user_id,
    //             'order'     => $orderNo,
    //             'cash_money'=> bcmul($value->money, 100),
    //             'is_run'    => $value->is_run,
    //             'cash_type' => $cashTypeArr[$value->type],
    //             'operate'   => $this->operate,
    //             'created_at'=> Carbon::createFromTimeStamp($v->add_time)->toDateTimeString()
    //         ]);

    //         echo sprintf($script5, intval($proportion *100 ), intval( $i/count($this->trade)*$width5), $msg5);

    //         $i++;

    //         echo ob_get_clean();    //获取当前缓冲区内容并清除当前的输出缓冲

    //         flush();   //刷新缓冲区的内容，输出
    //     }

    //     echo '迁移完成';die;
    // }


    // public function syncWithdraw()
    // {
        
    //     set_time_limit(0);                                  //设置程序执行时间
        
    //     ignore_user_abort(true);                            //设置断开连接继续执行
        
    //     ob_start();                                         //打开输出缓冲控制
        
    //     echo str_repeat(' ',1024*4);                        //字符填充

    //     $width5 = 1000;

    //     $html5 = '<div style="margin:100px auto; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: %upx">
    //     <div style="text-align:center; margin-bottom:10px;">共有'.count($this->oldUser).'个会员提现数据需要同步</div><div style="padding: 0; background-color: white; border: 1px solid navy; width: %upx"><div id="progress5" style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center; height: 16px"></div></div><div id="msg5" style="font-family: Tahoma; font-size: 9pt;">正在处理...</div><div id="percent5" style="position: relative; top: -34px; text-align: center; font-weight: bold; font-size: 8pt">0%%</div></div>';

    //     echo sprintf($html5, $width5+8, $width5);
        
    //     echo ob_get_clean();                                //获取当前缓冲区内容并清除当前的输出缓冲

    //     flush();                                            //刷新缓冲区的内容，输出

    //     $i = 1;

    //     $error = array();

    //     foreach ($this->oldUser as $key => $value) 
    //     {

    //         $proportion = $i / count($this->oldUser);

    //         $msg5 = $i == count($this->oldUser) ? '会员提现数据同步完成' : '正在同步第' . $i . '个会员提现数据';
            
    //         $script1 = '<script>document.getElementById("percent5").innerText="%u%%";document.getElementById("progress5").style.width="%upx";document.getElementById("msg5").innerText="%s";</script>';
            
    //         foreach ($value->wallets as $k => $v) {

    //             // 原后台与新后台打款状态关系，oldId => newId
    //             $stateArr = [
    //                 1 => 2,
    //                 2 => 1,
    //                 3 => 3
    //             ];
    //             // 审核时间
    //             $checkAt = !empty($v->check_time) ? Carbon::createFromTimeStamp($v->check_time)->toDateTimeString() : null;
    //             // 打款系统
    //             $paySystem = 0;
    //             if ($v->money_state == 1) {
    //                 $paySystem = $v->platform == 2 ? 2 : 1;
    //             }
                
    //             \App\UserWallet::create([
    //                 'user_id'       => $this->user[$v->user_id],
    //                 'order_no'      => $v->numbers,
    //                 'money'         => $v->money * 100,
    //                 'real_money'    => $v->numbers * 100,
    //                 'type'          => $v->walletType,
    //                 'state'         => $stateArr[$v->state],
    //                 'make_state'    => $v->money_state == 1 ? $v->money_state : 2,
    //                 'check_at'      => $checkAt,
    //                 'created_at'    => Carbon::createFromTimeStamp($v->time)->toDateTimeString(),
    //                 'operate'       => $this->merchant,
    //                 'pay_system'    => $paySystem,
    //                 'pay_type'      => $v->automatic == 1 ? 2 : 1,
    //                 // 'rate'          => $v->numbers,
    //                 // 'rate_m'        => $v->numbers,
    //                 'remark'        => !empty($v->reason) ? $v->reason : '',
    //                 'channle_money' => $v->numbers,
    //             ]);

    //         }

    //         echo sprintf($script1, intval($proportion *100 ), intval( $i/count($this->oldUser)*$width5), $msg5);

    //         $i++;

    //         echo ob_get_clean();    //获取当前缓冲区内容并清除当前的输出缓冲

    //         flush();   //刷新缓冲区的内容，输出
    //     }

    //     $this->syncSettlement();
    // }
}
