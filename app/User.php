<?php

namespace App;

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
}
