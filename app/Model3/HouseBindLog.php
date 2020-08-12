<?php

namespace App\Model3;

use Illuminate\Database\Eloquent\Model;

class HouseBindLog extends Model
{
    protected $connection = 'mysql_3_1';

    protected $table = 'house_bind_log';

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
    public function houses()
    {
    	return $this->hasMany('\App\Model3\House', 'sm', 'sn');
    }
}
