<?php

namespace App\Observers;

use App\PlugType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;



class PlugTypeObserver
{
    /**
     * @param  \App\App\User  $user
     * @return void
     */
    public function created(PlugType $PlugType)
    {
    	\App\AdminLog::create([ 'account' => Admin::user()->id, 'handle'=>'新增轮播图类型', 'after'=> json_encode($PlugType) ]);
    }

    /**
     * @Author    Pudding
     * @DateTime  2020-06-22
     * @copyright [copyright]
     * @license   [license]
     * @version   [version]
     * @param     Company     $company [description]
     * @return    [type]               [description]
     */
    public function updating(PlugType $PlugType)
    {
    	if($PlugType->isDirty()){
	    	\App\AdminLog::create([ 
	    		'account' 	=> Admin::user()->id, 
	    		'handle'	=>'修改轮播图类型',
	    		'before'	=> json_encode($PlugType->getOriginal()),
	    		'after'		=> json_encode($PlugType) 
	    	]);
    	}
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\App\User  $user
     * @return void
     */
    public function updated(PlugType $PlugType)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\App\User  $user
     * @return void
     */
    public function deleted(PlugType $PlugType)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\App\User  $user
     * @return void
     */
    public function restored(PlugType $PlugType)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\App\User  $user
     * @return void
     */
    public function forceDeleted(PlugType $PlugType)
    {
        //
    }
}
