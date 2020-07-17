<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function getMessage(Request $request)
    {
        try{
            // 如果不指定type类型 默认获取其他消息
            $request->type  = $request->type ?? 'Other';
            
            $message =  \App\BuserMessage::where('user_id', $request->user->id)
                            ->where('type', $request->type)->orderBy('id', 'desc')->offset(0)->limit(15)->get();
                            
            return response()->json(['success'=>['message' => '获取成功!', 'data' => $message]]);
        } catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);
        }
    }
}
