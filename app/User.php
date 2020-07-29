<?php

namespace App;

use URL;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
/*    protected $fillable = [
        'name', 'email', 'password',
    ];*/

    /**
     * [$guarded 黑名单设置]
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Relation To UserGroup
     *
     * @var array
     */
    public function group()
    {
        return $this->belongsTo('\App\UserGroup', 'user_group', 'id');
    }


    /**
     * Relation To UserGroup
     *
     * @var array
     */
    public function wallets()
    {
        return $this->hasOne('\App\UserWallet', 'user_id', 'id');
    }


    /**
     * Relation To UserRealname
     *
     * @var array
     */
    public function realname()
    {
        return $this->hasOne('\App\UserRealname', 'user_id', 'id');
    }


    /**
     * [machines 用户关联机具列表]
     * @author Pudding
     * @DateTime 2020-04-22T17:38:09+0800
     * @return   [type]                   [description]
     */
    public function machines()
    {
        return $this->hasMany('\App\Machine', 'user_id', 'id');
    }


    /**
     * 用户关联分润返现受益表
     */
    public function cash()
    {
        return $this->hasMany('\App\Cash', 'user_id', 'id');
    }

    /**
     * [merchants 用户关联商户列表]
     * @author Pudding
     * @return   [type]                   [description]
     */
    public function merchants()
    {
        return $this->hasMany('\App\Merchant', 'user_id', 'id');
    }

    /**
     * [admin_user 反向关联后台用户表]
     * @return [type] [description]
     */
    public function admin_user()
    {
        return $this->belongsTo('\App\AdminUser', 'operate', 'operate');
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-18
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 关联操盘方 ]
     * @return    [type]      [description]
     */
    public function operates()
    {
        return $this->belongsTo('\App\AdminSetting', 'operate', 'operate_number');
    }



    /**
     * @Author    Pudding
     * @DateTime  2020-06-22
     * @copyright [copyright]
     * @license   [license]
     * @version   [获取头像图片地址]
     * @param     [type]      $value [description]
     * @return    [type]             [description]
     */
    public function getAvatarAttribute($value)
    {
        return "http://".$_SERVER["HTTP_HOST"]."/storage/".$value;
    }


    /**
     * [getParentStr 获取会员的所有上级]
     * @author Pudding
     * @DateTime 2020-04-13T16:47:17+0800
     * @param    [type]                     $id [会员唯一标识]
     * @return   [string]                       [返回字符串类型]
     */
    public static function getParentStr($id, $parents = "")
    {
        $User = \App\User::where('id', $id)->first();

        if(!$User or empty($User)) return $parents;

        $parents .= "_".$User->id."_,";

        return $User->parent > 0 ? self::getParentStr($User->parent, $parents) : $parents;
    }

    /**
     * 关联划拨表
     */
    public function old_user_id()
    {
        return $this->belongsTo('App\Transfer','id','old_user_id');
    }

    /**
     * 关联划拨表
     */
    public function new_user_id()
    {
        return $this->belongsTo('App\Transfer','id','new_user_id');
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-13
     * @copyright [copyright]
     * @license   [license]
     * @version   [父级信息]
     * @return    [type]      [description]
     */
    public function parent_user()
    {
        return $this->hasOne('App\User', 'id', 'parent')->withDefault(['nickname' => '平台直属下级']);
    }


     /**
     * 关联税点表
     */
    public function settings()
    {
        return $this->hasOne('App\Setting', 'operate','operate');
    }


    public function auto_promotion_logs()
    {
        return $this->hasMany('\App\AutoPromotionLog', 'user_id', 'id');
    }
}
