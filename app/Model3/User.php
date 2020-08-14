<?php

namespace App\Model3;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $connection = 'mysql_3_1';

    protected $table = 'user';

    // 黑名单
    protected $guarded = [];


    /**
     * @Author    Pudding
     * @DateTime  2020-08-12
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 机器表 ]
     * @return    [type]      [description]
     */
    public function housise()
    {
    	return $this->hasMany('\App\Model3\House', 'partner_id', 'id');
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-08-12
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 商户表 ]
     * @return    [type]      [description]
     */
    public function merchants()
    {
    	return $this->hasMany('\App\Model3\Merchant', 'user_id', 'id');
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-08-12
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 用户结算价表 ]
     * @return    [type]      [description]
     */
    public function settlements()
    {
        return $this->hasMany('\App\Model3\Settlement', 'user_id', 'id')->orderBy('seId', 'asc');
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-08-12
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 用户提现记录表 ]
     * @return    [type]      [description]
     */
    public function withdraws()
    {
        return $this->hasMany('\App\Model3\Withdraw', 'user_id', 'id');
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-08-12
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 用户提现银行卡表 ]
     * @return    [type]      [description]
     */
    public function banks()
    {
        return $this->hasOne('\App\Model3\Bank', 'user_id', 'id');
    }
}
