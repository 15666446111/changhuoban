<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleType extends Model
{
    //
    /**
     * [articles 关联文章模型]
     * @author Pudding
     * @DateTime 2020-04-21T10:58:24+0800
     * @return   [type]                   [description]
     */
    public function articles()
    {
    	return $this->hasMany('App\Article', 'type_id', 'id');
    }
}
