<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticController
{	
    /**
     * [$Users 当前登录的用户信息]
     * @var [Collection]
     */
    protected  $Users;

    /**
     * [$Users 保存当前登录用户的所有团队会员ID]
     * @var [Array]
     */
    protected  $Teams;

    /**
     * [$Users 查询的时间截止]
     * @var [Time String]
     */
    protected  $EndTime; 

    /**
     * [$Users 查询的开始时间]
     * @var [Time String]
     */
    protected  $StartTime;


    /**
     * [__construct 初始化  赋值变量]
     * @author Pudding
     * @DateTime 2020-04-10T16:27:28+0800
     * @param    [type]                   $user [description]
     * @param    [type]                   $time [description]
     * @param    string                   $end  [description]
     */
    public function __construct($user, $time, $end = '')
    {
        // 初始化的时候 将当前登录的用户信息给到Users
        $this->Users = $user;

        // 根据time的类型 获得开始时间  可以直接赋值
        switch ($time) {
            case 'month':
                $this->StartTime = carbon::now()->startOfMonth()->toDateTimeString();
                break;
            case 'day':
                $this->StartTime = carbon::today()->toDateTimeString();
                break;
            case 'all':
                $this->StartTime = Carbon::createFromFormat('Y-m-d H', '1970-01-01 00')->toDateTimeString();
                break;
            default:
                $this->StartTime = $time;
                break;
        }

        $this->EndTime = carbon::now()->toDateTimeString();
    }

    public function getStartTime()
    {
        return $this->StartTime;
    }


    /**
     * [getMyTeam 获取我的团队所有会员ID]
     * @author Pudding
     * @DateTime 2020-04-10T16:21:30+0800
     * @return   [type]                   [description]
     */
    public function getMyTeam()
    {
        $user_id[] = \App\User::where('id',$this->Users->id)->first()->id;

        $userInfo = \App\UserRelation::where('parents', 'like', "%_".$this->Users->id."_%")->pluck('user_id')->toArray();

        return array_merge($user_id, $userInfo);
    }


    /**
     * [getTeam 获取新增的商户数量]
     * @author Pudding
     * @DateTime 2020-04-10T16:05:18+0800
     * @return   [type]                   [description]
     */
    public function getNewAddMerchant()
    {
        
        $Arr =  $this->getMyTeam();
        
        return \App\Merchant::whereBetween('created_at', [ $this->StartTime,  $this->EndTime])->whereIn('user_id', $Arr)->count();     
    }


    /**
     * [getTradeSum 获取新的交易金额]
     * @author Pudding
     * @DateTime 2020-04-10T16:31:07+0800
     * @param    [type]                   $rule [查询自己的还是团队的]
     * @return   [type]                         [description]
     */
    public function getTradeSum($rule = 'team')
    {
        $Arr = $rule == 'team' ? $this->getMyTeam() :  array($this->Users->id);

        return \App\Trade::whereBetween('created_at', [ 
                    $this->StartTime,  $this->EndTime])->whereHas('users', function($q) use ($Arr){
                        $q->whereIn('id', $Arr);
                    })->sum('amount');
    }



    /**
     * [getTeam 获取新增的伙伴数量]
     * @author Pudding
     * @DateTime 2020-04-10T16:05:18+0800
     * @return   [type]                   [description]
     */
    public function getNewAddTeamCount()
    {
        $Start = $this->StartTime;

        $End   = $this->EndTime;

        return \App\UserRelation::where('parents', 'like', '%_'.$this->Users->id.'_%')->whereHas('users', function($q) use ($Start, $End){
                $q->whereBetween('created_at', [ $Start, $End]);
        })->count();
    }


    /**
     * 获取新的收益金额
     */
    public function getCashSum($rule = 'team')
    {
        $Arr = $rule == 'team' ? $this->getMyTeam() :  array($this->Users->id);

        return \App\Cash::whereBetween('created_at', [$this->StartTime, $this->EndTime])->whereIn('user_id',$Arr)->sum('cash_money');

    }


    /**
     * 获取新的激活台数
     */
    public function getMachineCount()
    {

        $Arr =  $this->getMyTeam();
        
        return \App\Machine::where('activate_state', '1')->whereBetween('created_at', [ 
                    $this->StartTime,  $this->EndTime])->whereHas('users', function($q) use ($Arr){
                        $q->whereIn('id', $Arr);
                    })->count();   

    }


}
