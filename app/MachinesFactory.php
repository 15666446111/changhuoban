<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MachinesFactory extends Model
{
    //
    /**
     * [machines_types 关联类型表]
     * @author Pudding
     * @DateTime 2020-04-21T14:35:12+0800
     * @return   [type]                   [description]
     */
    public function machines_types()
    {
    	return $this->belongsTo('App\MachinesType', 'type_id', 'id');
    }


    /**
     * [machines_styles 关联型号表]
     * @author Pudding
     * @DateTime 2020-04-21T14:38:03+0800
     * @return   [type]                   [description]
     */
    public function machines_styles()
    {
    	return $this->hasMany('App\MachinesStyle', 'factory_id', 'id');
    }
}
