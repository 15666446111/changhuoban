<?php

namespace App\Observers;

use App\ShareType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;

class ShareTypeObserver
{
    /**
     * Handle the share type "created" event.
     *
     * @param  \App\App\ShareType  $shareType
     * @return void
     */
    public function created(ShareType $shareType)
    {
        //
        \App\AdminLog::create([ 'account' => Admin::user()->id, 'handle'=>'新增分享类型', 'after'=> json_encode($shareType) ]);
    }

    /**
     * Handle the share type "updated" event.
     *
     * @param  \App\App\ShareType  $shareType
     * @return void
     */
    public function updated(ShareType $shareType)
    {
        if($shareType->isDirty()){
            \App\AdminLog::create([ 
                'account'   => Admin::user()->id, 
                'handle'    =>'修改分享素材',
                'before'    => json_encode($shareType->getOriginal()),
                'after'     => json_encode($shareType) 
            ]);
        }
    }

    /**
     * Handle the share type "deleted" event.
     *
     * @param  \App\App\ShareType  $shareType
     * @return void
     */
    public function deleted(ShareType $shareType)
    {
        //
    }

    /**
     * Handle the share type "restored" event.
     *
     * @param  \App\App\ShareType  $shareType
     * @return void
     */
    public function restored(ShareType $shareType)
    {
        //
    }

    /**
     * Handle the share type "force deleted" event.
     *
     * @param  \App\App\ShareType  $shareType
     * @return void
     */
    public function forceDeleted(ShareType $shareType)
    {
        //
    }
}
