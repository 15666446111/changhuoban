<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MachinesType extends Model
{
    //
    /**
     * [machines_factorys 关联机具厂商]
     * @author Pudding
     * @DateTime 2020-04-21T14:29:53+0800
     * @return   [type]                   [description]
     */
    public function machines_factorys()
    {
    	return $this->hasMany('App\MachinesFactory', 'type_id', "id");
    }

}
