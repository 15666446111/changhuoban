<?php

namespace App\Http\Controllers\V1;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServerController extends Controller
{
	/**
	 * [$dateType 日期类型]
	 * @var [ month or day]
	 */
	protected $dateType;


    /**
     * [$StartTime 开始时间]
     * @var [time]
     */
    protected $StartTime;


    /**
     * [$Users 查询的时间截止]
     * @var [Time String]
     */
    protected  $EndTime;


	/**
	 * [$Type 查询的类型]
	 * @var [本人 或者 团队]
	 */
	protected $Type;


	/**
	 * [$user 当前登陆会员]
	 * @var [type]
	 */
	protected $user;


	/**
	 * [$users 查询的用户]
	 * @var [type]
	 */
	protected $team;


    /**
     * [$date 查询的日期 ]
     * @var 2020-07
     */
    protected $date;


	/**
	 * @Author    Pudding
	 * @DateTime  2020-06-05
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [初始化数据 查询条件]
	 * @param     [type]      $dateType [description]
	 * @param     [type]      $date     [description]
	 * @param     [type]      $current  [description]
	 */
    public function __construct($dateType, $current, $user, $date)
    {

    	$this->dateType = $dateType;

        $this->date     = $date;

        switch ($this->dateType) {
            case 'month':
                $this->StartTime = ($date == 'cur') ? Carbon::now()->startOfMonth()->toDateTimeString() : Carbon::createFromFormat('Y-m', $date)->startOfMonth()->toDateTimeString();
                break;
            case 'day':
                $this->StartTime = Carbon::today()->toDateTimeString();
                break;
            case 'all':
                $this->StartTime = Carbon::createFromFormat('Y-m-d', '1970-01-01')->toDateTimeString();
                break;
            default:
                $this->StartTime = $time;
                break;
        }

        $this->EndTime = ($this->dateType == 'month' && $date != 'cur' ) ? Carbon::createFromFormat('Y-m', $date)->addMonth(1)->startOfMonth()->toDateTimeString() : Carbon::now()->toDateTimeString();

    	$this->Type     = $current;

    	$this->user     = $user;

    	if($this->Type == "current") 
    		$this->team = array($this->user->id);

    	if($this->Type == "team"){
    		$this->team       = $this->getTeam();
            $this->team[]     = $this->user->id;
    	}

    }


    /**
     * @Author    Pudding
     * @DateTime  2020-06-06
     * @copyright [copyright]
     * @license   [license]
     * @version   [获取用户的团队数组]
     * @return    [type]      [description]
     */
    public function getTeam()
    {
        return \App\UserRelation::where('parents', 'like', '%\_'.$this->user->id.'\_%')->pluck('user_id')->toArray();
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-06-05
     * @copyright [copyright]
     * @license   [license]
     * @version   [获取交易详情的所有信息]
     * @return    [type]      [description]
     */
    public function getInfo()
    {
    	$arrs = array();

        $trade = $this->getTrade();

        $merchansAll = $this->merchansAll();
    	// 返回查询的日期
    	$arrs['date']         = $this->getDate();

     	$arrs['trade']	      = number_format( $trade / 100, 2, '.', ',');

     	$arrs['activeCount']  = $this->getActiveCount();

		$arrs['income']		  = number_format($this->getIncome() / 100, 2, '.', ',');
		
		$arrs['friends']      = $this->getFriends();

        $arrs['temails']      = $this->getTemails();

		$arrs['merchants']    = $this->getMerchants();
        
        if ($arrs['merchants'] > 0 )
		    $arrs['Avg']          = number_format(($trade / $merchansAll) / 100, 2, '.', ',');
    	else
            $arrs['Avg']          = 0;
        
        return $arrs;
    }



    /**
     * @Author    Pudding
     * @DateTime  2020-06-05
     * @copyright [copyright]
     * @license   [license]
     * @version   [version]
     * @return    [type]      [description]
     */
    public function getTrade()
    {
    	$select = \App\Trade::whereHasIn('merchants_sn', function($q){
    		$q->whereIn('user_id', $this->team);
    	})->whereBetween('trade_time', [ $this->StartTime,  $this->EndTime])
            ->where('is_repeat', 0)->where('is_invalid', 0)->where('sys_resp_code', '00');
    	return $select->sum('amount');
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-06-05
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 获取激活总数]
     * @return    [type]      [description]
     */
    public function getActiveCount()
    {
    	return \App\Machine::whereIn('user_id', $this->team)->whereBetween('activate_time', [$this->StartTime, $this->EndTime])->count();
	}



    /**
     * @Author    Pudding
     * @DateTime  2020-07-21
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 获取机具总数]
     * @return    [type]      [description]
     */
    public function getTemails()
    {
        return \App\Machine::whereIn('user_id',$this->team)->count();
    }


    /**
     * @version [<vector>] [< 获取已绑定的机具总数 >]
     */
    public function merchansAll()
    {
        return \App\Machine::whereIn('user_id',$this->team)->where('bind_status', 1)->count();
    }


	/**
	 * 获取伙伴总数
	 */
	public function getFriends()
	{
		return \App\UserRelation::where('parents', 'like', '%\_'.$this->user->id.'\_%')->whereBetween('created_at', [ $this->StartTime,  $this->EndTime])->count();
	}


	/**
     * @Author    Pudding
     * @DateTime  2020-07-28
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 获取商户总数 ]
     * @return    [type]      [description]
     */
	public function getMerchants()
	{
		return \App\Merchant::whereIn('user_id',$this->team)->whereBetween('created_at', [ $this->StartTime,  $this->EndTime])->count();
	}



    /**
     * @Author    Pudding
     * @DateTime  2020-06-05
     * @copyright [copyright]
     * @license   [license]
     * @version   [获取收益总额]
     * @return    [type]      [description]
     */
    public function getIncome()
    {
    	return \App\Cash::whereIn('user_id', $this->team)->whereBetween('created_at', [ $this->StartTime,  $this->EndTime])->sum('cash_money');
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-06-05
     * @copyright [copyright]
     * @license   [license]
     * @version   [返回日期]
     * @return    [type]      [description]
     */
    protected function getDate()
    {
        $date = "";

        switch ($this->dateType) {
            case 'month':
                if($this->date == 'cur'){
                    $date = Carbon::now()->year."-".Carbon::now()->month;
                }else{
                    $dateInfo = Carbon::createFromFormat('Y-m', $this->date);
                    $date = $dateInfo->year."-".$dateInfo->month;
                }
                break;
            case 'day':
                $date = Carbon::now()->year."-".Carbon::now()->month.'-'.Carbon::now()->day;
                break;    
            default:
                $date = $this->StartTime;
                break;
        }
        return $date;
    }

}
