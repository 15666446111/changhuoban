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
                    'min'   =>  empty($currPrice) ? $value->default_price : $this->getUserPrice(json_decode($currPrice->price, true), $value),
                    'max'   =>  $value->default_price,
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
     * @version   [ 首页 - 伙伴管理 - 设置活动组结算价 ]
     * @param     Request     $request [description]
     */
    public function setPrice(Request $request)
    {
        try{
            //return response()->json(['error'=>['message' => '缺少伙伴信息!', 'data' => json_encode($request->all())]]);

            if(!$request->uid) return response()->json(['error'=>['message' => '缺少伙伴信息!']]);
            if(!$request->gid) return response()->json(['error'=>['message' => '请选择活动组!']]);
            if(!$request->set_price) return response()->json(['error'=>['message' => '请设置结算价参数!']]);

            $user = \App\User::where('id', $request->uid)->first();
            if(!$user or empty($user)) return response()->json(['error'=>['message' => '找不到伙伴信息!']]);

            if($user->operate != $request->user->operate)  return response()->json(['error'=>['message' => '无权限!']]);
            if($user->parent != $request->user->id ) return response()->json(['error'=>['message' => '只能设置直接下级的信息!']]);


            $policyGroup = \App\PolicyGroup::where('id', $request->gid)->first();
            if(!$policyGroup or empty($policyGroup)) return response()->json(['error'=>['message' => '活动组不存在!']]);

            // 只有工具版本才可以获取结算价 设置结算价
            $setting = \App\AdminSetting::where('operate_number', $request->user->operate)->first();
            if(!$setting or empty($setting)) return response()->json(['error'=>['message' => '未找到操盘方信息']]); 

            if($setting->pattern != '2') return response()->json(['error'=>['message' => '非工具版本不能设置']]); 

            #1. 首先获取当前会员在这活动组的结算价
            $userPrice = \App\UserFee::where('user_id', $request->uid)->where('policy_group_id', $request->gid)->first();
            #2. 获取活动组的结算价默认配置 
            $defaultPrice = \App\PolicyGroupSettlement::where('policy_group_id', $request->gid)->get();
            #3. 获取本人的该活动组的配置信息
            $currPrice = \App\UserFee::where('user_id', $request->user->id)->where('policy_group_id', $request->gid)->first();
            #3. 如果该会员在活动组不存在结算价， 先添加一条默认的
            if(!$userPrice or empty($userPrice)){
                $args = array();
                foreach ($defaultPrice as $key => $value) {
                    $args[] = array('index' => $value->trade_type_id, 'price' => $value->default_price);
                }

                $userPrice = \App\UserFee::create([
                    'user_id'           =>  $request->uid,
                    'policy_group_id'   =>  $request->gid,
                    'price'             =>  json_encode($args),
                ]);
            }


            $param = json_decode($userPrice->price, true);
            foreach ($param as $key => $value) {

                $min = $this->getMinPrice($currPrice, $defaultPrice, $value);

                $max = $this->getMaxPrice($currPrice, $defaultPrice, $value );

                if($min == 0 or $max == 0){
                    return response()->json(['error'=>['message' => '操盘方暂无设置结算价!']]);
                }

                $price = $this->getSetPrice($request->set_price, $value);

                if($price != 0 && $price != $value['price']){
                    if($price >= $min && $price <= $max ){
                        $param[$key]['price'] = $price;
                    }else return response()->json(['error'=>['message' =>'参数不再合理区间内!']]);
                }
            }

            $userPrice->price = json_encode($param);
            $userPrice->save();

            return response()->json(['success'=>['message' => '设置成功!']]);

        } catch (\Exception $e) {
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);
        }
    }



    /**
     * @Author    Pudding
     * @DateTime  2020-08-01
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 首页 - 伙伴管理 - 获取激活返现 ]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function getActive(Request $request)
    {
        try{
            if(!$request->uid) return response()->json(['error'=>['message' => '缺少伙伴信息!']]);
            if(!$request->pid) return response()->json(['error'=>['message' => '请选择活动政策信息!']]);

            $user = \App\User::where('id', $request->uid)->first();
            if(!$user or empty($user)) return response()->json(['error'=>['message' => '找不到伙伴信息!']]);

            if($user->operate != $request->user->operate)  return response()->json(['error'=>['message' => '无权限!']]);
            if($user->parent != $request->user->id ) return response()->json(['error'=>['message' => '只能查询直接下级的信息!']]);

            $policy = \App\Policy::where('id', $request->pid)->first();
            if(!$policy or empty($policy)) return response()->json(['error'=>['message' => '活动政策不存在!']]);
            $defaultSet = json_decode($policy->default_active_set, true);
            
            // 只有工具版本才可以获取激活返现
            $setting = \App\AdminSetting::where('operate_number', $request->user->operate)->first();
            if(!$setting or empty($setting)) return response()->json(['error'=>['message' => '未找到操盘方信息']]); 
            if($setting->pattern != '2') return response()->json(['error'=>['message' => '非工具版本不能设置']]); 

            // 是工具版， 获取当前会员在当前活动的激活返现
            $price = array();
            #1. 首先获取当前会员在这活动组的结算价
            $userActive = \App\UserPolicy::where('user_id', $request->uid)->where('policy_id', $request->pid)->first();
            #2. 获取本人的该活动组的配置信息
            $currActive = \App\UserPolicy::where('user_id', $request->user->id)->where('policy_id', $request->pid)->first();

            $price['active']['active_money']      = empty($userActive) ? $defaultSet['default_money'] * 100 : $userActive->default_active_set;
            $price['active']['active_money_min']  = 0;
            $price['active']['active_money_max']  = empty($currActive) ? $defaultSet['default_money'] * 100 : $currActive->default_active_set;

            $price['policy'] = $policy->title;

            return response()->json(['success'=>['message' => '获取成功!', 'data' => $price]]);

        } catch (\Exception $e) {
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);
        }
    }



    /**
     * @Author    Pudding
     * @DateTime  2020-08-01
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 首页 - 伙伴管理 - 设置激活返现 ]
     * @param     Request     $request [description]
     */
    public function setActive(Request $request)
    {
        try{
            if(!$request->uid) return response()->json(['error'=>['message' => '缺少伙伴信息!']]);
            if(!$request->pid) return response()->json(['error'=>['message' => '请选择活动政策信息!']]);
            if(!$request->return_money) return response()->json(['error'=>['message' => '请输入设置的金额!']]);
            if(!is_numeric($request->return_money)) return response()->json(['error'=>['message' => '激活返现必须为有效金额!']]);

            $user = \App\User::where('id', $request->uid)->first();
            if(!$user or empty($user)) return response()->json(['error'=>['message' => '找不到伙伴信息!']]);

            if($user->operate != $request->user->operate)  return response()->json(['error'=>['message' => '无权限!']]);
            if($user->parent != $request->user->id ) return response()->json(['error'=>['message' => '只能查询直接下级的信息!']]);

            $policy = \App\Policy::where('id', $request->pid)->first();
            if(!$policy or empty($policy)) return response()->json(['error'=>['message' => '活动政策不存在!']]);
            $defaultSet = json_decode($policy->default_active_set, true);
            $defaultStd = $policy->default_standard_set;

            // 只有工具版本才可以获取激活返现
            $setting = \App\AdminSetting::where('operate_number', $request->user->operate)->first();
            if(!$setting or empty($setting)) return response()->json(['error'=>['message' => '未找到操盘方信息']]); 
            if($setting->pattern != '2') return response()->json(['error'=>['message' => '非工具版本不能设置']]); 

            // 是工具版， 获取当前会员在当前活动的激活返现
            $price = array();
            #1. 首先获取当前会员在这活动组的结算价
            $userActive = \App\UserPolicy::where('user_id', $request->uid)->where('policy_id', $request->pid)->first();
            #1.1 如果没有用户的活动信息 ， 需要新增一条
            if(!$userActive or empty($userActive)){
                $userActive = \App\UserPolicy::create([
                    'user_id'   =>  $request->uid,
                    'policy_id' =>  $request->pid,
                    'default_active_set'    =>  $defaultSet['default_money'] * 100,
                    'standard'  =>  $defaultStd,
                ]);
            }

            #2. 获取本人的该活动组的配置信息
            $currActive = \App\UserPolicy::where('user_id', $request->user->id)->where('policy_id', $request->pid)->first();

            $max = empty($currActive) ? $defaultSet['default_money'] * 100 : $currActive->default_active_set;

            if($request->return_money >= 0 && $request->return_money <= $max){
                $userActive->default_active_set = $request->return_money;
            }else{
                return response()->json(['error'=>['message' => '激活返现设置不合法']]); 
            }

            $userActive->save();

            return response()->json(['success'=>['message' => '设置成功!']]);

        } catch (\Exception $e) {
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);
        }
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-08-05
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 首页 - 伙伴管理 - 获取激活返现 ]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function getStandard(Request $request)
    {
        //try{
            if(!$request->uid) return response()->json(['error'=>['message' => '缺少伙伴信息!']]);
            if(!$request->pid) return response()->json(['error'=>['message' => '请选择活动政策信息!']]);

            $user = \App\User::where('id', $request->uid)->first();
            if(!$user or empty($user)) return response()->json(['error'=>['message' => '找不到伙伴信息!']]);

            if($user->operate != $request->user->operate)  return response()->json(['error'=>['message' => '无权限!']]);
            if($user->parent != $request->user->id ) return response()->json(['error'=>['message' => '只能查询直接下级的信息!']]);

            $policy = \App\Policy::where('id', $request->pid)->first();
            if(!$policy or empty($policy)) return response()->json(['error'=>['message' => '活动政策不存在!']]);
            $defaultSet = json_decode($policy->default_active_set, true);
            
            // 只有工具版本才可以获取激活返现
            $setting = \App\AdminSetting::where('operate_number', $request->user->operate)->first();
            if(!$setting or empty($setting)) return response()->json(['error'=>['message' => '未找到操盘方信息']]); 
            if($setting->pattern != '2') return response()->json(['error'=>['message' => '非工具版本不能设置']]); 

            // 是工具版， 获取当前会员在当前活动的激活返现
            $price = array();
            #1. 首先获取当前会员在这活动组的达标奖励
            $userStandard = \App\UserPolicy::where('user_id', $request->uid)->where('policy_id', $request->pid)->first();
            #2. 获取本人的该活动组的配置信息
            $currStandard = \App\UserPolicy::where('user_id', $request->user->id)->where('policy_id', $request->pid)->first();

            $standard = $policy->default_standard_set;
            
            foreach ($standard as $key => $value) {
                $price[] = array(
                    'index' =>  $value['index'],
                    'standard_type' => $value['standard_type'] == 1 ? '连续达标' : '累积达标',
                    'standard_start'=> $value['standard_start'],
                    'standard_end'  => $value['standard_end'],
                    'standard_trade'=> $value['standard_trade'] * 100,
                    'standard_price'=> empty($userStandard) ? $value['standard_price'] * 100 : $this->getUserStandardPrice($value['index'], $userStandard, $value),
                    'min'           => 0,
                    'max'           => empty($currStandard) ? $value['standard_price'] * 100 : $this->getUserStandardPrice($value['index'], $currStandard, $value),
                );
                # code...
            }
            return response()->json(['success'=>['message' => '获取成功!', 'data' => $price]]);
        /*} catch (\Exception $e) {
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);
        }*/
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-08-05
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 首页 - 伙伴管理 - 设置达标返现 ]
     * @param     Request     $request [description]
     */
    public function setStandard(Request $request)
    {
        try{
            if(!$request->uid) return response()->json(['error'=>['message' => '缺少伙伴信息!']]);
            if(!$request->pid) return response()->json(['error'=>['message' => '请选择活动政策信息!']]);
            if(!$request->standard) return response()->json(['error'=>['message' => '请输入设置的参数!']]);

            if(!is_array($request->standard)) return response()->json(['error'=>['message' => '参数需为数组格式!']]);

            $user = \App\User::where('id', $request->uid)->first();
            if(!$user or empty($user)) return response()->json(['error'=>['message' => '找不到伙伴信息!']]);

            if($user->operate != $request->user->operate)  return response()->json(['error'=>['message' => '无权限!']]);
            if($user->parent != $request->user->id ) return response()->json(['error'=>['message' => '只能查询直接下级的信息!']]);

            $policy = \App\Policy::where('id', $request->pid)->first();
            if(!$policy or empty($policy)) return response()->json(['error'=>['message' => '活动政策不存在!']]);
            $defaultSet = json_decode($policy->default_active_set, true);
            $defaultStd = $policy->default_standard_set;

            // 只有工具版本才可以获取激活返现
            $setting = \App\AdminSetting::where('operate_number', $request->user->operate)->first();
            if(!$setting or empty($setting)) return response()->json(['error'=>['message' => '未找到操盘方信息']]); 
            if($setting->pattern != '2') return response()->json(['error'=>['message' => '非工具版本不能设置']]); 

            // 是工具版， 获取当前会员在当前活动的激活返现
            $price = array();
            #1. 首先获取当前会员在这活动组的结算价
            $userStandard = \App\UserPolicy::where('user_id', $request->uid)->where('policy_id', $request->pid)->first();
            #1.1 如果没有用户的活动信息 ， 需要新增一条
            if(!$userStandard or empty($userStandard)){
                $userStandard = \App\UserPolicy::create([
                    'user_id'   =>  $request->uid,
                    'policy_id' =>  $request->pid,
                    'default_active_set'    =>  $defaultSet['default_money'] * 100,
                    'standard'  =>  $defaultStd,
                ]);
            }

            #2. 获取本人的该活动组的配置信息
            $currStandard = \App\UserPolicy::where('user_id', $request->user->id)->where('policy_id', $request->pid)->first();

            $arrs = array();
            $standard = $policy->default_standard_set;
            foreach ($standard as $key => $value) {
                $max = empty($currStandard) ? $value['standard_price'] * 100 : $this->getUserStandardPrice($value['index'], $currStandard, $value);

                $min = 0;
                $price = $this->getStandardPrice($value['index'], $request->standard);
                if($price < $min or $price > $max){
                    return response()->json(['error'=>['message' => '达标返现设置不合法']]);
                }
                $arrs[] = array(
                    'index'             => $value['index'],
                    'standard_type'     => $value['standard_type'],
                    'standard_start'    => $value['standard_start'],
                    'standard_end'      => $value['standard_end'],
                    'standard_trade'    => $value['standard_trade'] / 100,
                    'standard_price'    => $price / 100,
                );
            }

            $userStandard->standard = $arrs;

            $userStandard->save();

            return response()->json(['success'=>['message' => '设置成功!']]);

        } catch (\Exception $e) {
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);
        }
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-08-05
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 获取设置的达标返现 ]
     * @param     [type]      $index [description]
     * @param     [type]      $param [description]
     * @return    [type]             [description]
     */
    public function getStandardPrice($index, $param)
    {
        $price = 0;

        foreach ($param as $key => $value) {
            if($value['index'] == $index){
                $price = $value['standard_price'];
                break;
            }
        }
        return $price;
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-08-05
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 获取用户的某项达标返现金额 ]
     * @param     [type]      $index      [description]
     * @param     [type]      $userPolicy [description]
     * @return    [type]                  [description]
     */
    public function getUserStandardPrice($index, $userPolicy, $value)
    {
        $price = 0;

        $standard = $userPolicy->standard;

        foreach ($standard as $key => $v) {
            if($v['index'] == $index){
                $price = $v['standard_price'] * 100;
                break;
            }
        }

        return $price == 0 ? $value['standard_price'] * 100 : $price;
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


    /**
     * @Author    Pudding
     * @DateTime  2020-07-31
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 获取最低结算价 当前活动的当前交易方式 ]
     * @param     [type]      $price [description]
     * @param     [type]      $value [description]
     * @return    [type]             [description]
     */
    public function getMinPrice($price, $default, $value)
    {   
        $min = 0;
        if(empty($price)){
            foreach ($default as $k => $v) {
                if($v->trade_type_id == $value['index']){
                    $min = $v->default_price;
                    break;
                }
            }
        }else{
            foreach (json_decode($price->price) as $key => $v) {
                if($v->index == $value['index']){
                    $min = $v->price;
                    break;
                }
            }
        }

        return $min;
    }

    /**
     * @Author    Pudding
     * @DateTime  2020-07-31
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 获取 交易类型 活动组的 最高结算价 ]
     * @param     [type]      $curr    [description]
     * @param     [type]      $default [description]
     * @param     [type]      $value   [description]
     * @return    [type]               [description]
     */
    public function getMaxPrice($curr, $default, $value)
    {
        $max = 0;
        //if(empty($curr)){

            foreach ($default as $key => $v) {
                if($v->trade_type_id == $value['index']){
                    $max = $v->default_price;
                    break;
                }
            }

/*        }else{

            $ag = json_decode($curr->price, true);
            foreach ($ag as $key => $v) {
                if($v['index'] == $value['index']){
                    $max = $v->price;
                    break;
                }
            }
        }*/
        return $max;
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-31
     * @copyright [copyright]
     * @license   [license]
     * @version   [获取设置的结算价]
     * @param     [type]      $set_price [description]
     * @param     [type]      $value     [description]
     * @return    [type]                 [description]
     */
    public function getSetPrice($set_price, $value)
    {
        $rate = 0;  
        foreach ($set_price as $key => $v) {
            if($v['index'] == $value['index']) {
                $rate = $v['price'];
                break;
            }
        }
        return $rate;
    }
}
