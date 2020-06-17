<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articles_log extends Model
{
    
    protected $table = 'articles_log';
 

    // 黑名单
    protected $guarded = [];

}
