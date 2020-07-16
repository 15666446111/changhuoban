<?php

namespace App\Model1;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $connection = 'mysql_1_1';

    protected $table = 'brand';

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
    	return $this->hasMany('\App\Model1\MoneyLog', 'brand_id', 'id');
    }
}
