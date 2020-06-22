<?php

namespace App\Observers;

use App\ArticleType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;

class ArticleTypeObserver
{
    /**
     * Handle the article type "created" event.
     *
     * @param  \App\ArticleType  $articleType
     * @return void
     */
    public function created(ArticleType $articleType)
    {
        //
        \App\AdminLog::create([ 'account' => Admin::user()->id, 'handle'=>'新增文章类型', 'after'=> json_encode($articleType) ]);
    }

    /**
     * Handle the article type "updated" event.
     *
     * @param  \App\ArticleType  $articleType
     * @return void
     */
    public function updated(ArticleType $articleType)
    {
        //
        if($articleType->isDirty()){
            \App\AdminLog::create([ 
                'account'   => Admin::user()->id, 
                'handle'    =>'修改文章类型',
                'before'    => json_encode($articleType->getOriginal()),
                'after'     => json_encode($articleType) 
            ]);
        }
    }

    /**
     * Handle the article type "deleted" event.
     *
     * @param  \App\ArticleType  $articleType
     * @return void
     */
    public function deleted(ArticleType $articleType)
    {
        //
    }

    /**
     * Handle the article type "restored" event.
     *
     * @param  \App\ArticleType  $articleType
     * @return void
     */
    public function restored(ArticleType $articleType)
    {
        //
    }

    /**
     * Handle the article type "force deleted" event.
     *
     * @param  \App\ArticleType  $articleType
     * @return void
     */
    public function forceDeleted(ArticleType $articleType)
    {
        //
    }
}
