<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MachinesStyle extends Model
{
    //
    /**
     * [machines_fact 关联厂商表]
     * @author Pudding
     * @DateTime 2020-04-21T14:35:12+0800
     * @return   [type]                   [description]
     */
    public function machines_fact()
    {
    	return $this->belongsTo('App\MachinesFactory', 'factory_id', 'id');
    }

    /**
     * [machines 关联机具表]
     * @author Pudding
     * @DateTime 2020-04-21T15:04:42+0800
     * @return   [type]                   [description]
     */
    public function machines()
    {
        return $this->hasMany('App\Machine', 'style_id', 'id');
    }

}
