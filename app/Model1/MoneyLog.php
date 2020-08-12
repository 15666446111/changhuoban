<?php

namespace App\Model1;

use Illuminate\Database\Eloquent\Model;

class MoneyLog extends Model
{
    protected $connection = 'mysql_1_1';

    protected $table = 'money_log';

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
    public function users()
    {
        return $this->belongsTo('App\Model1\UserInfo', 'user_id', 'id');
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-15
     * @copyright [copyright]
     * @license   [license]
     * @version   [version]
     * @return    [type]      [description]
     */
    public function brands()
    {
        return $this->belongsTo('App\Model1\Brand', 'brand_id', 'id');
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-15
     * @copyright [copyright]
     * @license   [license]
     * @version   [version]
     * @return    [type]      [description]
     */
    public function activitys()
    {
        return $this->belongsTo('App\Model1\Activity', 'activity_id', 'id');
    }


    public function userAgents()
    {
        return $this->belongsTo('App\Model1\UserAgent', 'user_id', 'user_id')->withDefault(['agent_id' => 0]);
    }


    /*public function trades()
    {
        return $this->belongsTo('App\Model1\Activity', 'activity_id', 'id');
    }*/

}
