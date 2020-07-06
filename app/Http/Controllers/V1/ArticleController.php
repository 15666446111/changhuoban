<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
	 * @version  [<获取系统公告列表>]
	 * @author   Pudding   
	 * @param    Request
	 * @return   [type]
	 */
    public function Notice(Request $request)
    {
    	try{
            $type_id = $request->type_id;

            if(!$type_id) return response()->json(['error'=>['message' => '缺少必要参数:公告类型']]);

            if($type_id == 1){
                // 获取文章类型为公告的数据
                $Article = \App\Article::where('operate', $request->user->operate)->where('type_id', $type_id)->ApiGet()->first(['id','title','images','created_at','updated_at']);
                
                if(empty($Article) or !$Article) $Article = \App\Article::where('operate','All')->where('type_id', $type_id)->ApiGet()->first(['id','title','images','created_at','updated_at']);
            }else{
                $Article = \App\Article::where('operate', $request->user->operate)->where('type_id', $type_id)->ApiGet()->get(['id','title','images','created_at','updated_at']);
                
                if($Article->isEmpty()) $Article = \App\Article::where('operate','All')->where('type_id', $type_id)->ApiGet()->get(['id','title','images','created_at','updated_at']);
            }

            return response()->json(['success'=>['message' => '获取成功!', 'data' => $Article]]);

    	} catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }

    /**
    * @version  [<获取常见问题列表>]
    * @author   Pudding   
    * @DateTime 2020-04-08T17:17:40+0800
    * @param    Request
    * @return   [type]
    */
    public function problem(Request $request)
    {
        try{
            // 获取展示的轮播图
            $Article = \App\Article::where('operate', $request->user->operate)->where('active', '1')->where('verify',1)->where('type_id', '2')->orderBy('sort', 'desc')->offset(0)->limit(5)->get();
            
            if($Article->isEmpty()) $Article = \App\Article::where('operate','All')->where('active', '1')->where('verify',1)->where('type_id', '2')->orderBy('sort', 'desc')->offset(0)->limit(5)->get();
            
            return response()->json(['success'=>['message' => '获取成功!', 'data' => $Article]]);  

        } catch (\Exception $e) {
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);
        }
    }


    /**
     * 获取文章详情接口
     */
    public function Article_detail(Request $request)
    {
        try{

            if(!$request->aid) return response()->json(['error'=>['message' => '缺少必要参数:请选择文章']]);
            
            $data = \App\Article::where('active', '1')->where('verify',1)->where('id', $request->aid)->first();

            if(!$data or empty($data))
                return response()->json(['success'=>['message' => '暂无数据!', 'data' => []]]);

            return response()->json(['success'=>['message' => '获取成功!', 'data' => $data]]);

        } catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }

    }


    /**
     * @version  [<获取微信分享文案列表>]
     * @author   Pudding   
     * @DateTime 2020-04-08T17:17:40+0800
     * @param    Request
     * @return   [type]
     */
    public function wxShare(Request $request)
    {
        try{
            // 获取展示的文案
            $Article = \App\Article::where('active', '1')->where('type_id', '3')->orderBy('id', 'desc')->offset(0)->limit(5)->get();

            return response()->json(['success'=>['message' => '获取成功!', 'data' => $Article]]);

        } catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }
}
