<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{

    
    protected $guarded = [];


    /**
     * [machines_styles 关联机具类型表]
     * @author Pudding
     * @DateTime 2020-04-21T15:06:02+0800
     * @return   [type]                   [description]
     */
    public function machines_styles()
    {
    	return $this->belongsTo('App\MachinesStyle', 'style_id', 'id');
    }

    /**
     * [users 机具关联代理]
     * @author Pudding
     * @DateTime 2020-04-22T17:38:41+0800
     * @return   [type]                   [description]
     */
    public function users()
    {
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }

    /**
     * [busers 关联终端品牌模型]
     * @author Pudding
     * @DateTime 2020-04-10T15:35:13+0800
     * @return   [type]                   [description]
     */
    public function brands()
    {
        return $this->belongsTo('\App\Brand', 'brand_id', 'id');
    }
}
