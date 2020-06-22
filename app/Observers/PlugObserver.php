<?php

namespace App\Observers;

use App\Plug;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;


class PlugObserver
{
    /**
     * @param  \App\App\User  $user
     * @return void
     */
    public function created(Plug $Plug)
    {
    	\App\AdminLog::create([ 'account' => Admin::user()->id, 'handle'=>'新增轮播图', 'after'=> json_encode($Plug) ]);
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
    public function updating(Plug $Plug)
    {
    	if($Plug->isDirty()){
	    	\App\AdminLog::create([ 
	    		'account' 	=> Admin::user()->id, 
	    		'handle'	=>'修改轮播图',
	    		'before'	=> json_encode($Plug->getOriginal()),
	    		'after'		=> json_encode($Plug) 
	    	]);
    	}
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\App\User  $user
     * @return void
     */
    public function updated(Plug $Plug)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\App\User  $user
     * @return void
     */
    public function deleted(Plug $Plug)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\App\User  $user
     * @return void
     */
    public function restored(Plug $Plug)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\App\User  $user
     * @return void
     */
    public function forceDeleted(Plug $Plug)
    {
        //
    }
}
