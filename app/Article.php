<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    
    protected $table = 'articles';
 

    // 黑名单
    protected $guarded = [];
    /**
     * [article_types 反向关联分类模型]
     * @author Pudding
     * @DateTime 2020-04-21T10:59:11+0800
     * @return   [type]                   [description]
     */
    public function article_types()
    {
    	return $this->belongsTo('App\ArticleType', 'type_id', 'id');
    }

    /**
     * @Author    Pudding
     * @DateTime  2020-06-22
     * @copyright [copyright]
     * @license   [license]
     * @version   [获取文章缩略图图片地址]
     * @param     [type]      $value [description]
     * @return    [type]             [description]
     */
    public function getImagesAttribute($value)
    {
        return "http://".$_SERVER["HTTP_HOST"]."/"."storage/".$value;
    } 
    /**
     * 搜索过滤选项
     */
    public function scopeApiGet($query)
    {
    	return $query->where('active', '1')->where('verify',1)->orderBy('sort', 'desc');
    }

}
