<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PolicyController extends Controller
{
    /**
     * @Author    Pudding
     * @DateTime  2020-06-02
     * @copyright [copyright]
     * @license   [license]
     * @version   [获取政策活动列表]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function getPolicy(Request $request)
    {
    	try{
            
            $policy = \App\Policy::where('operate', $request->user->operate)->select(['id', 'title'])->get();

            return response()->json(['success'=>['message' => '获取成功!', 'data' => $policy]]);

    	} catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }

    /**
     * @Author    Pudding
     * @DateTime  2020-07-31
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 首页 - 伙伴管理 - 获取活动组列表 ]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function getPolicyGroup(Request $request)
    {
        try{

            if(!$request->uid) return response()->json(['error'=>['message' => '缺少伙伴信息!']]);

            $user = \App\User::where('id', $request->uid)->first();

            if(!$user or empty($user)) return response()->json(['error'=>['message' => '找不到伙伴信息!']]);

            if($user->operate != $request->user->operate)  return response()->json(['error'=>['message' => '无权限!']]);

            if($user->parent != $request->user->id ) return response()->json(['error'=>['message' => '只能查询直接下级的信息!']]);

            $list = \App\PolicyGroup::where('operate', $request->user->operate)->get();

            return response()->json(['success'=>['message' => '获取成功!', 'data' => $list->toArray()]]);

        } catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-31
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 首页 - 伙伴管理 - 活动列表 ]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function getPolicyList(Request $request)
    {
        try{

            if(!$request->uid) return response()->json(['error'=>['message' => '缺少伙伴信息!']]);

            if(!$request->gid) return response()->json(['error'=>['message' => '请选择活动组!']]);

            $user = \App\User::where('id', $request->uid)->first();

            if(!$user or empty($user)) return response()->json(['error'=>['message' => '找不到伙伴信息!']]);

            if($user->operate != $request->user->operate)  return response()->json(['error'=>['message' => '无权限!']]);

            if($user->parent != $request->user->id ) return response()->json(['error'=>['message' => '只能查询直接下级的信息!']]);

            $list = \App\Policy::where('operate', $request->user->operate)->where('policy_group_id', $request->gid)->select('id', 'title')->get();

            return response()->json(['success'=>['message' => '获取成功!', 'data' => $list->toArray()]]);

        } catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-31
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 首页 - 伙伴管理 - 获取活动组结算价 ]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function getPrice(Request $request)
    {
        try{

            if(!$request->uid) return response()->json(['error'=>['message' => '缺少伙伴信息!']]);

            if(!$request->gid) return response()->json(['error'=>['message' => '请选择活动组!']]);

            $user = \App\User::where('id', $request->uid)->first();

            if(!$user or empty($user)) return response()->json(['error'=>['message' => '找不到伙伴信息!']]);

            if($user->operate != $request->user->operate)  return response()->json(['error'=>['message' => '无权限!']]);

            if($user->parent != $request->user->id ) return response()->json(['error'=>['message' => '只能查询直接下级的信息!']]);


            $policyGroup = \App\PolicyGroup::where('id', $request->gid)->first();
            if(!$policyGroup or empty($policyGroup)) return response()->json(['error'=>['message' => '活动组不存在!']]);

            // 只有工具版本才可以获取结算价 设置结算价
            $setting = \App\AdminSetting::where('operate_number', $request->user->operate)->first();
            if(!$setting or empty($setting)) return response()->json(['error'=>['message' => '未找到操盘方信息']]); 

            if($setting->pattern != '2') return response()->json(['error'=>['message' => '非工具版本不能设置']]); 

            // 是工具版， 获取活动组的结算价以及可设置的区间
            $price = array();
            #1. 首先获取当前会员在这活动组的结算价
            $userPrice = \App\UserFee::where('user_id', $request->uid)->where('policy_group_id', $request->gid)->first();
            #2. 获取本人的该活动组的配置信息
            $currPrice = \App\UserFee::where('user_id', $request->user->id)->where('policy_group_id', $request->gid)->first();
            #3. 获取活动组的结算价默认配置 
            $defaultPrice = \App\PolicyGroupSettlement::where('policy_group_id', $request->gid)->get();
            foreach ($defaultPrice as $key => $value) {
                $price['list'][$key] = array(
                    'index' =>  $value->trade_type_id,
                    'title' =>  $value->trade_types->name,
                    'price' =>  empty($userPrice) ? $value->default_price : $this->getUserPrice(json_decode($userPrice->price, true), $value),
                    'min'   =>  $value->min_price,
                    'max'   =>  empty($currPrice) ? $value->default_price : $this->getUserPrice(json_decode($currPrice->price, true), $value),
                );
            }

            $price['PolicyGroup'] = $policyGroup->title;

            return response()->json(['success'=>['message' => '获取成功!', 'data' => $price]]);

        } catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }



    /**
     * @Author    Pudding
     * @DateTime  2020-07-31
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 获取交易类型的 该用户的结算费率 ]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function getUserPrice($price, $value)
    {   
        $fee = 0;
        foreach ($price as $key => $v) {
            if($value->trade_type_id == $v['index']){
                $fee = $v['price'];
                break;
            }
        }
        return $fee;
    }
}
