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
	 * @Author    Pudding
	 * @DateTime  2020-06-05
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [初始化数据 查询条件]
	 * @param     [type]      $dateType [description]
	 * @param     [type]      $date     [description]
	 * @param     [type]      $current  [description]
	 */
    public function __construct($dateType, $current, $user)
    {

    	$this->dateType = $dateType;

        switch ($this->dateType) {
            case 'month':
                $this->StartTime = Carbon::now()->startOfMonth()->toDateTimeString();
                break;
            case 'day':
                $this->StartTime = Carbon::today()->toDateTimeString();
                break;
            case 'all':
                $this->StartTime = Carbon::createFromFormat('Y-m-d H', '1970-01-01 00')->toDateTimeString();
                break;
            default:
                $this->StartTime = $time;
                break;
        }

        $this->EndTime = Carbon::now()->toDateTimeString();

    	$this->Type     = $current;

    	//
    	$this->user     = $user;

    	//dd($this->user);
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

    	// 返回查询的日期
    	$arrs['date']         = $this->getDate();

     	$arrs['trade']	      = number_format( $trade / 100, 2, '.', ',');

     	$arrs['activeCount']  = $this->getActiveCount();

		$arrs['income']		  = number_format($this->getIncome() / 100, 2, '.', ',');
		
		$arrs['friends']      = $this->getFriends();

		$arrs['merchants']    = $this->getMerchants();
        
        if ($arrs['merchants'] > 0 )
		    $arrs['Avg']          = number_format(($trade / $arrs['merchants']) / 100, 2, '.', ',');
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
    	//DB::connection()->enableQueryLog();#开启执行日志

        $team = $this->team;

    	$select = \App\Trade::whereHas('sn', function($q) use ($team){
    		$q->whereIn('user_id', $team);
    	})->whereBetween('created_at', [ $this->StartTime,  $this->EndTime]);

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
    	//DB::connection()->enableQueryLog();#开启执行日志

    	return \App\Machine::whereIn('user_id', $this->team)->whereBetween('activate_time', [ $this->StartTime,  $this->EndTime])->count();
	}


	/**
	 * 获取伙伴总数
	 */
	public function getFriends()
	{
		return \App\UserRelation::where('parents', 'like', '%\_'.$this->user->id.'\_%')->count();
	}


	/**
	 * 获取终端号总数
	 */
	public function getMerchants()
	{
		return \App\Machine::whereIn('user_id',$this->team)->count();
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
    	//DB::connection()->enableQueryLog();#开启执行日志

    	$select = \App\CashsLog::whereIn('user_id', $this->team);

        return $select->whereBetween('created_at', [ $this->StartTime,  $this->EndTime])->sum('money');
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
                $date = Carbon::now()->year."年".Carbon::now()->month."月";
                break;
            case 'day':
                $date = Carbon::now()->year."年".Carbon::now()->month."月".Carbon::now()->day."日";
                break;    
            default:
                $date = $this->StartTime;
                break;
        }
        return $date;
    }

}
