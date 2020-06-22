<?php

namespace App\Observers;

use App\Share;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;

class ShareObserver
{
    /**
     * Handle the app share "created" event.
     *
     * @param  \App\AppShare  $appShare
     * @return void
     */
    public function created(Share $Share)
    {
        //
        \App\AdminLog::create([ 'account' => Admin::user()->id, 'handle'=>'新增分享素材', 'after'=> json_encode($Share) ]);
    }

    /**
     * Handle the app share "updated" event.
     *
     * @param  \App\AppShare  $appShare
     * @return void
     */
    public function updated(Share $Share)
    {
        if($Share->isDirty()){
            \App\AdminLog::create([ 
                'account'   => Admin::user()->id, 
                'handle'    =>'修改分享素材',
                'before'    => json_encode($Share->getOriginal()),
                'after'     => json_encode($Share) 
            ]);
        }
    }

    /**
     * Handle the app share "deleted" event.
     *
     * @param  \App\AppShare  $appShare
     * @return void
     */
    public function deleted(Share $Share)
    {
        //
    }

    /**
     * Handle the app share "restored" event.
     *
     * @param  \App\AppShare  $appShare
     * @return void
     */
    public function restored(Share $Share)
    {
        //
    }

    /**
     * Handle the app share "force deleted" event.
     *
     * @param  \App\AppShare  $appShare
     * @return void
     */
    public function forceDeleted(Share $Share)
    {
        //
    }
}
