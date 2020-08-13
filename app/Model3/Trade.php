<?php

namespace App\Model3;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $connection = 'mysql_3_1';

    protected $table = 'trade_data_qzah';

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

}
