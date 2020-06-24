<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServersController
{
    //

    /**
     *  查询类型 用户或者伙伴或者总数
     */
    protected $Type;

    /**
     * 当前登录会员
     */
    protected $user;


    /**
     * 查询的用户
     */
    protected $team;


    /**
     * 初始化数据  查询条件
     */
    public function __construct($Type, $user)
    {
        $this->Type = $Type;

        $this->user = $user;

        // dd($this->Users->id);
        if($this->Type == "user"){

            $this->team = array($this->user->id);

        }else if($this->Type == "friend"){
    
            $this->team   = \App\UserRelation::where('parents', 'like', "%\_".$this->user->id."\_%")->pluck('user_id')->toArray();
            
        }else{

            $this->team   = \App\UserRelation::where('parents', 'like', '%\_'.$this->user->id.'\_%')->pluck('user_id')->toArray();
            $this->team[] = $this->user->id;

        }
        
    }


    /**
     * 获取终端机器管理所有信息
     */
    public function getInfo()
    {
        $arrs = [];

        $arrs['AllMerchants'] = $this->getAllMerchants();

        $arrs['Bound']        = $this->getBound();

        $arrs['UnBound']      = $this->getUnBound();

        $arrs['Bind']         = $this->getBind();

        return $arrs;
    }

    /**
     * 查询全部机器详情信息
     */
    public function getAllMerchants()
    {

        $select = \App\Machine::select('sn as merchant_sn','bind_status','open_state as active_status','open_time as active_time','bind_time','policy_id')
        ->whereIn('user_id', $this->team)
        ->get();
        $arr = [];

        foreach($select as $k=>$v){
            if(!$v->policys){
                $arr[] = [
                    'merchant_sn'   =>  $v->merchant_sn,
                    'bind_status'   =>  $v->bind_status,
                    'active_status' =>  $v->active_status,
                    'active_time'   =>  $v->active_time,
                    'bind_time'     =>  $v->bind_time,
                    'policy_id'     =>  $v->policy_id,
                    'title'         =>  '无活动',
                ];
            }else{
                $arr[] = [
                    'merchant_sn'   =>  $v->merchant_sn,
                    'bind_status'   =>  $v->bind_status,
                    'active_status' =>  $v->active_status,
                    'active_time'   =>  $v->active_time,
                    'bind_time'     =>  $v->bind_time,
                    'policy_id'     =>  $v->policy_id,
                    'title' => $v->policys->title
                ];
            }
            
        }

        return $arr;
    }

    /**
     * 查询已绑定机器详情信息
     */
    public function getBound()
    {
        $select = \App\Machine::select('sn as merchant_sn','bind_status','open_state as active_status','open_time as active_time','bind_time','policy_id')
        ->whereIn('user_id', $this->team)
        ->where('bind_status',1)
        ->get();
        $arr = [];

        foreach($select as $k=>$v){
            if(!$v->policys){
                $arr[] = [
                    'merchant_sn'   =>  $v->merchant_sn,
                    'bind_status'   =>  $v->bind_status,
                    'active_status' =>  $v->active_status,
                    'active_time'   =>  $v->active_time,
                    'bind_time'     =>  $v->bind_time,
                    'policy_id'     =>  $v->policy_id,
                    'title'         =>  '无活动',
                ];
            }else{
                $arr[] = [
                    'merchant_sn'   =>  $v->merchant_sn,
                    'bind_status'   =>  $v->bind_status,
                    'active_status' =>  $v->active_status,
                    'active_time'   =>  $v->active_time,
                    'bind_time'     =>  $v->bind_time,
                    'policy_id'     =>  $v->policy_id,
                    'title' => $v->policys->title
                ];
            }
            
        }
        
        return $arr;
    }

    /**
     * 查询未绑定机器详情
     */
    public function getUnBound()
    {
        $select = \App\Machine::select('sn as merchant_sn','bind_status','open_state as active_status','policy_id')
        ->whereIn('user_id',  $this->team)
        ->where('bind_status',0)
        ->get();
        $arr = [];

        foreach($select as $k=>$v){
            if(!$v->policy_id or $v->policy_id == 0){
                $arr[] = [
                    'merchant_sn'   =>  $v->merchant_sn,
                    'bind_status'   =>  $v->bind_status,
                    'active_status' =>  $v->active_status,
                    'policy_id'     =>  $v->policy_id,
                    'title'         =>  '无活动',
                ];
            }else{
                $arr[] = [
                    'merchant_sn'   =>  $v->merchant_sn,
                    'bind_status'   =>  $v->bind_status,
                    'active_status' =>  $v->active_status,
                    'policy_id'     =>  $v->policy_id,
                    'title' => $v->policys->title
                ];
            }
            
        }
        
        return $arr;
    }

    /**
     * 查询已激活机器详情
     */
    public function getBind()
    {

        $select = \App\Machine::select('sn as merchant_sn','open_state as active_status','policy_id')
        ->whereIn('user_id',  $this->team)
        ->where('open_state',1)
        ->get();

        $arr = [];

        foreach($select as $k=>$v){
            if(!$v->policys){
                $arr[] = [
                    'merchant_sn'   =>  $v->merchant_sn,
                    'active_status' =>  $v->active_status,
                    'policy_id'     =>  $v->policy_id,
                    'title'         =>  '无活动',
                ];
            }else{
                $arr[] = [
                    'merchant_sn'   =>  $v->merchant_sn,
                    'active_status' =>  $v->active_status,
                    'policy_id'     =>  $v->policy_id,
                    'title' => $v->policys->title
                ];
            }
            
        }
        
        return $arr;
    }
}
