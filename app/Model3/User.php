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
}
