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


    protected $trade;

    /**
     * [$activeList 原活动id对应新活动id ]
     * @var [type]
     */
	protected $activeList = [
	      276 => 9,
	      275 => 10,
	      264 => 20,
	      256 => 10,
	      255 => 11,  // H9-刷5000返99
	      254 => 12,  // MP70刷100返99
	      245 => 25,  // MP70-99返99
	      244 => 24,  // 活动自备机-99返99
	      119 => 23,  // MP70-99返120
	      117 => 22,  // H9-298返398 - 3.0
	      116 => 21,  // MP70-198返298 - 3.0
	      96 => 20,  // 新活动转自备机
	      95 => 17,  // H9-298返398
	      94 => 20,  // 新活动转自备机
	      93 => 19,  // MP70-198返298
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

    	$this->trade   = \App\Model3\Trade::orderBy('j_pytime', 'asc')->get();
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
				'operate'	=>	$this->merchant,
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
	public function syncTrade()
	{

        set_time_limit(0);  								//设置程序执行时间
        
        ignore_user_abort(true);    						//设置断开连接继续执行
        
        ob_start(); 										//打开输出缓冲控制
        
        echo str_repeat(' ',1024*4);    					//字符填充

        $width3 = 1000;

        $html3 = '<div style="margin:100px auto; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: %upx">
        <div style="text-align:center; margin-bottom:10px;">共有'.count($this->trade).'条交易数据需要同步</div><div style="padding: 0; background-color: white; border: 1px solid navy; width: %upx"><div id="progress4" style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center; height: 16px"></div></div><div id="msg4" style="font-family: Tahoma; font-size: 9pt;">正在处理...</div><div id="percent4" style="position: relative; top: -34px; text-align: center; font-weight: bold; font-size: 8pt">0%%</div></div>';

        echo sprintf($html3, $width3+8, $width3);
        
        echo ob_get_clean();    							//获取当前缓冲区内容并清除当前的输出缓冲

        flush();   											//刷新缓冲区的内容，输出

        $i = 1;

        $error = array();

        foreach ($this->trade as $key => $value) 
        {

            $proportion = $i / count($this->trade);

            $msg4 = $i == count($this->trade) ? '交易数据同步完成' : '正在同步第' . $i . '条交易数据信息';
            
            $script4 = '<script>document.getElementById("percent4").innerText="%u%%";document.getElementById("progress4").style.width="%upx";document.getElementById("msg4").innerText="%s";</script>';
            

            // 创建订单
            $order = \App\Trade::create([
            	'trade_no'	=>	$value->j_pydate.$value->rrn,
            	'user_id'	=>	$this->user[$value->user_id],
            	'machine_id'=> 	-1,
            	'is_send'	=>  $value->is_send,	// 分润发放状态
            	'term_id'	=> 	$value->termId, 	// 终端好
            	'sn'		=>  $value->sm,
            	'merchant_name'	=>	$value->,// 商户名
            	'merchant_phone'=> 	$value->,//
            	'merchant_code'	=>	$value->j_code,//
            	'agt_merchant_id'	=> 	,//
            	'agt_merchant_name'	=>	,//
            	'agt_merchant_level'=>	,//
            	'sysTraceNo'		=>	,//
            	'rrn'				=>	,//
            	'trade_type'		=>	,//
            	'amount'			=>	,//
            	'settle_amount'		=>	,//
            	'cardType'			=>	,//
            	'card_number'		=>	,//
            	'transDate'			=>	,//
            	'trade_time'		=>	,//
            	'traceNo'			=>	,//
            	'remark'			=>	,//
            	'trade_actime'		=>	,//
            	'collection_type'	=>	,//
            	'audit_status'		=>	,//
            	'is_sim'			=>	,//
            	'stl_type'			=>	,//
            	'scan_flag'			=>	,//
            	'clr_flag'			=>	,//
            	'is_auth_credit_card'	=>	,//
            	'trade_post'		=>	,//
            	'created_at'		=>	,//
            	'rate'				=>	,//
            	'rate_money'		=>	,//
            	'fee_type'			=>	,//
            	'operate'			=>	,//
            	'tranCode'			=>	,//
            	'agentId'			=>	,//
            	'inputMode'			=>	,//
            	'originalTranDate'	=>	,//
            	'originalRrn'		=>	,//
            	'originaltraceNo'	=>	,//
            	'is_repeat'			=>	,//
            	'is_invalid'		=>	,//
            ]);	


            $orderInfo = \App\TradesDeputy::create([
            	'trade_id'		=>	$order->id,
            	'sendBatchNo'	=>	,
            	'tranTime'		=>	,
            	'cardNo'		=>	,
            	'authCode'		=>	,
            	'batchNo'		=>	,
            	'orderId'		=>	,
            	'bankName'		=>	,
            	'version'		=>	,
            	'activeStat'	=>	,
            	'termBindDate'	=>	,
            	'merchLevel'	=>	,
            	'termModel'		=>	,
            	'settleDate'	=>	,
            	'created_at'	=>	,
            	'originalbatchNo'	=>	,
            	'originalAuthCode'	=>	,
            ]);


            echo sprintf($script4, intval($proportion *100 ), intval( $i/count($this->trade)*$width3), $msg4);

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

        set_time_limit(0);  								//设置程序执行时间
        
        ignore_user_abort(true);    						//设置断开连接继续执行
        
        ob_start(); 										//打开输出缓冲控制
        
        echo str_repeat(' ',1024*4);    					//字符填充

        $width2 = 1000;

        $html2 = '<div style="margin:100px auto; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: %upx">
        <div style="text-align:center; margin-bottom:10px;">共有'.count($this->oldUser).'条会员商户机具需要迁移</div><div style="padding: 0; background-color: white; border: 1px solid navy; width: %upx"><div id="progress2" style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center; height: 16px"></div></div><div id="msg2" style="font-family: Tahoma; font-size: 9pt;">正在处理...</div><div id="percent2" style="position: relative; top: -34px; text-align: center; font-weight: bold; font-size: 8pt">0%%</div></div>';

        echo sprintf($html2, $width2+8, $width2);
        
        echo ob_get_clean();    							//获取当前缓冲区内容并清除当前的输出缓冲

        flush();   											//刷新缓冲区的内容，输出

        $i = 1;

        $error = array();

        foreach ($this->oldUser as $key => $value) 
        {

            $proportion = $i / count($this->oldUser);

            $msg2 = $i == count($this->oldUser) ? '商户机具数据同步完成' : '正在同步第' . $i . '条会员商户机具信息';
            
            $script2 = '<script>document.getElementById("percent2").innerText="%u%%";document.getElementById("progress2").style.width="%upx";document.getElementById("msg2").innerText="%s";</script>';
            

            foreach ($value->merchants as $k => $v) {
            	$user 		= \App\User::where('account', $value->mobile)->first();
            	$active  	= "";

            	foreach ($v->logs as $a => $b) {
					if($b->activation_state == "1") $active = $b->sn;
					\App\MerchantsBindLog::create([
						'merchant_code'	=>	$b->merchantCode,
						'sn'			=>	$b->sn,
						'bind_state'	=>	$b->untying == 2 ? 0 : $b->untying,
						'created_at'	=>	Carbon::createFromTimeStamp($b->add_time)->toDateTimeString(),
					]);
				}

				if($v->merchantNo){
					$merchantNew = \App\Merchant::create([
						'user_id'	=>	$user->id,
						'code'		=>	$v->merchantNo,
						'name'		=>	$v->merchantName,
						'phone'		=>	$v->merchantPhone,
						'activate_sn'=> $active,
						'open_time' =>  $v->addTime ? Carbon::createFromTimeStamp($v->addTime)->toDateTimeString() : null ,
						'created_at'=>  $v->addTime ? Carbon::createFromTimeStamp($v->addTime)->toDateTimeString() : null ,
						'operate'	=>  $this->merchant,
					]);
				}
            }



			foreach ($value->housise as $c => $d) {

				$bind = \App\Model3\HouseBindLog::where('sn', $d->sm)->where('untying', 1)->first();

				$merchantId = empty($bind) ? 0 : \App\Merchant::where('code', $bind->merchantCode)->value('id');


				\App\Machine::create([
					'user_id'		=>	$user->id,
					'sn'			=>  $d->sm,
					'open_state'	=>  $d->open_state == 2 ? 0 : $d->open_state,
					'created_at'	=>  Carbon::createFromTimeStamp($d->add_time)->toDateTimeString(),
					'merchant_id' 	=>  $merchantId,
					'bind_status' 	=>  empty($bind) ? 0 : 1,
					'bind_time'		=>  empty($bind) ? null : Carbon::createFromTimeStamp($bind->add_time)->toDateTimeString(),
					'activate_time' =>  (empty($bind) || $bind->activation_time == "0" || !$bind->activation_time) ? null : Carbon::createFromTimeStamp($bind->activation_time)->toDateTimeString(),
					'activate_state'=>  (empty($bind) || $bind->activation_state == 4) ? 0 : $bind->activation_state,
					'standard_status' => $d->ac_return_state == 2 ? -1 : 0,
					'open_time'		=>	empty($d->opening_time) ? null : Carbon::createFromTimeStamp($d->opening_time)->toDateTimeString(),
					'overdue_state'	=> $d->overdue_state == 2 ? 1 : 0,
					'active_end_time' =>  empty($d->activa_end_time) ? null : Carbon::createFromTimeStamp($d->activa_end_time)->toDateTimeString(),
					'operate'   => $this->merchant,
					'standard_status_lj'=> $d->st_return_state == 2 ? -1 : 0,
					'sim_frozen_num' => $d->sim_fro_state,
					'policy_id'   	 => $this->activeList[$d->activity_id],
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
	 * @version   [ 同步交易数据 分润数据表 ]
	 * @return    [type]      [description]
	 */
	public function syncWallet()
	{

        set_time_limit(0);  								//设置程序执行时间
        
        ignore_user_abort(true);    						//设置断开连接继续执行
        
        ob_start(); 										//打开输出缓冲控制
        
        echo str_repeat(' ',1024*4);    					//字符填充

        $width1 = 1000;

        $html1 = '<div style="margin:100px auto; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: %upx">
        <div style="text-align:center; margin-bottom:10px;">共有'.count($this->oldUser).'条会员交易数据需要同步</div><div style="padding: 0; background-color: white; border: 1px solid navy; width: %upx"><div id="progress1" style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center; height: 16px"></div></div><div id="msg1" style="font-family: Tahoma; font-size: 9pt;">正在处理...</div><div id="percent1" style="position: relative; top: -34px; text-align: center; font-weight: bold; font-size: 8pt">0%%</div></div>';

        echo sprintf($html1, $width1+8, $width1);
        
        echo ob_get_clean();    							//获取当前缓冲区内容并清除当前的输出缓冲

        flush();   											//刷新缓冲区的内容，输出

        $i = 1;

        $error = array();

        foreach ($this->oldUser as $key => $value) 
        {

            $proportion = $i / count($this->oldUser);

            $msg1 = $i == count($this->oldUser) ? '钱包数据同步完成' : '正在同步第' . $i . '条会员钱包信息';
            
            $script1 = '<script>document.getElementById("percent1").innerText="%u%%";document.getElementById("progress1").style.width="%upx";document.getElementById("msg1").innerText="%s";</script>';
            

			$user = \App\User::where('account', $value->mobile)->first();

			$user->wallets->cash_blance = $value->profitWallet * 100;

			$user->wallets->return_blance = $value->cashWallet * 100;

			$user->wallets->created_at = Carbon::createFromTimeStamp($value->create_time)->toDateTimeString();

			$user->wallets->save();

            echo sprintf($script1, intval($proportion *100 ), intval( $i/count($this->oldUser)*$width1), $msg1);

            $i++;

            echo ob_get_clean();    //获取当前缓冲区内容并清除当前的输出缓冲

            flush();   //刷新缓冲区的内容，输出
        }

        $this->syncMerchantsBindLog();
	}







}
