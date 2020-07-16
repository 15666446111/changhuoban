<?php

namespace App\Model1;

use Illuminate\Database\Eloquent\Model;

class UserAgent extends Model
{
    protected $connection = 'mysql_1_1';

    protected $table = 'user_agent';

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
    public function agents()
    {
        return $this->belongsTo('\App\Model1\User', 'agent_id', 'id');
    }

}
