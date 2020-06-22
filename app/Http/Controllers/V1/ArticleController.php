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
            // 获取文章类型为公告的数据
            $Article = \App\Article::where('active', '1')->where('verify',1)->where('operate', $request->user->operate)->where('type_id', '1')->orderBy('sort', 'desc')->get();
            
            if(empty($Article) or !$Article) $Article = \App\Article::where('operate','All')->where('active', '1')->where('verify',1)->where('type_id', '1')->orderBy('sort', 'desc')->get();
            
            return response()->json(['success'=>['message' => '获取成功!', 'data' => $Article]]);

    	} catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }

    /**
     * 获取文章详情接口
     */
    public function Article(Request $request)
    {
        try{
            
            $data = \App\Article::where('active', '1')->where('verify',1)->where('id', $request->aid)->first();

            if(!$data or empty($data))
                return response()->json(['success'=>['message' => '暂无数据!', 'data' => []]]);

            return response()->json(['success'=>['message' => '获取成功!', 'data' => $data]]);

        } catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }

    }
}
