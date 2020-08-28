<?php

namespace App\Model3;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $connection = 'mysql_3_1';

    // protected $table = 'trade_data_qzah';
    protected $table = 'trade_data_qzhy';
    // protected $table = 'trade_data_wfab';

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
     * @version   [ 分润表 ]
     * @return    [type]      [description]
     */
    public function cashs()
    {
        return $this->hasMany('\App\Model3\Cash', 't_id', 'id');
    }
}
