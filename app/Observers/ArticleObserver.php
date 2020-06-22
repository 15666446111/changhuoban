<?php

namespace App\Observers;

use App\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;

class ArticleObserver
{
    /**
     * Handle the article "created" event.
     *
     * @param  \App\Article  $article
     * @return void
     */
    public function created(Article $article)
    {
        //
        \App\AdminLog::create([ 'account' => Admin::user()->id, 'handle'=>'新增文章', 'after'=> json_encode($article) ]);
    }

    /**
     * Handle the article "updated" event.
     *
     * @param  \App\Article  $article
     * @return void
     */
    public function updated(Article $article)
    {
        //
        if($article->isDirty()){
            \App\AdminLog::create([ 
                'account'   => Admin::user()->id, 
                'handle'    =>'修改文章内容',
                'before'    => json_encode($article->getOriginal()),
                'after'     => json_encode($article) 
            ]);
        }
    }

    /**
     * Handle the article "deleted" event.
     *
     * @param  \App\Article  $article
     * @return void
     */
    public function deleted(Article $article)
    {
        //
    }

    /**
     * Handle the article "restored" event.
     *
     * @param  \App\Article  $article
     * @return void
     */
    public function restored(Article $article)
    {
        //
    }

    /**
     * Handle the article "force deleted" event.
     *
     * @param  \App\Article  $article
     * @return void
     */
    public function forceDeleted(Article $article)
    {
        //
    }
}
