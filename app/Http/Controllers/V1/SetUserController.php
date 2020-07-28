<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\V1\BankController;

class SetUserController extends Controller
{
    /**
     * @Author    Pudding
     * @DateTime  2020-07-28
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 我的 - 个人信息 ]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function getUserInfo(Request $request)
    {
        try{
            
            $data = [];
            //用户id
            $data['id'] = $request->user->id;
            //用户昵称
            $data['nickname'] = $request->user->nickname;
            //用户账号
            $data['account'] = $request->user->account;
            //用户状态
            $data['active'] = $request->user->active;
            //用户头像
            $data['heading'] = $request->user->avatar;
            //用户手机号
            $data['phone'] = $request->user->phone;
            //用户组id
            $data['user_group'] = $request->user->user_group;
            //用户级别
            $data['group'] = $request->user->group->name;
            //钱包总余额
            $data['blance'] = number_format($request->user->wallets->cash_blance + $request->user->wallets->return_blance, 2, '.', ',');
            //分润余额
            $data['cash_blance'] = number_format($request->user->wallets->cash_blance, 2, '.', ',');
            //返现余额
            $data['return_blance'] = number_format($request->user->wallets->return_blance, 2, '.', ',');
            //注册时间
            $data['created_at'] = $request->user->created_at;
            return response()->json(['success'=>['message' => '获取成功!', 'data' => $data]]);
        } catch (\Exception $e) {
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);
        }
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-28
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 我的 - 用户头像修改 ]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function editUserInfo(Request $request){

        try{
            $tmp = $request->file('file');
            //判断文件上传是否有效
            if($tmp->isValid()) {
                //获取文件后缀
                $FileType = $tmp->getClientOriginalExtension(); 
                //获取文件临时存放位置
                $FilePath = $tmp->getRealPath(); 
                //定义文件名
                $FileName = date('Ymd') . uniqid() . '.' . $FileType; 
                //存储文件
                Storage::disk('avatar')->put($FileName, file_get_contents($FilePath));
                $request->user->avatar = "avatar/".$FileName;
                $request->user->save();
                return response()->json(['success'=>['message' => '修改成功!', 'link' => "http://".$_SERVER["HTTP_HOST"]."/storage/avatar/" . $FileName ]]);
            }
            return response()->json(['error'=>['message' => '头像上传失败!']]);
        } catch (\Exception $e) {
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);
        }
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-28
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 我的 - 修改信息 ]
     * @param     Request     $request [description]
     */
    public function setUserInfos(Request $request)
    {
        try{ 
            if(!$request->nickname) return response()->json(['error'=>['message' => '缺少必要参数:名称']]);
            $userInfo = \App\User::where('id',$request->user->id)->first();
            $userInfo->nickname = $request->nickname;
            $userInfo->save();
            return response()->json(['success'=>['message' => '修改成功!', []]]); 
    	} catch (\Exception $e) {
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);
        }
    }

}
