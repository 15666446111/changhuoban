<?php

namespace App\Model1;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $connection = 'mysql_1_1';

    protected $table = 'user';

    // 黑名单
    protected $guarded = [];

    /**
     * @Author    Pudding
     * @DateTime  2020-07-15
     * @copyright [copyright]
     * @license   [license]
     * @version   [version]
     * @return    [type]      [description]
     */
    public function moneys()
    {
    	return $this->hasMany('\App\Model1\MoneyLog', 'user_id', 'id');
    }




    // 操盘方
    public function operate()
    {
    	return $this->hasMany('\App\Model1\UserAgent', 'agent_id', 'id');
    }
}
