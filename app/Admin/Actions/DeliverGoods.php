<?php

namespace App\Admin\Actions;

use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class DeliverGoods extends RowAction
{
    public $name = '配送发货';

    public function handle(Model $model, Request $request)
    {
        // $request ...
        try { 

            if(!$request->user or !$request->h_policy) return $this->response()->error('参数无效!')->refresh();
        
            $model->user_id = $request->user;

            $model->policy_id = $request->d_policy;

            $model->save();

            /*
            	检查该会员在该政策下是否有结算激活等配置。如果没有 进行默认该政策配置
             */
            /*$userPolicy  = \App\UserPolicy::where('user_id', $request->user)->where('policy_id', $request->policy)->first();

            if(!$userPolicy or empty($userPolicy)){

            	$policy = \App\Policy::where('id', $request->policy)->first();

                $sett_price = $policy['sett_price'];

                foreach ($sett_price as $key => $value) {
                    $sett_price[$key]['setprice'] = $value['defaultPrice'];
                }

                $default_active_set = $policy['default_active_set'];
                $default_active_set['return_money'] = $default_active_set['default_money'];

                $vip_active_set = $policy['vip_active_set'];
                $vip_active_set['return_money'] = $vip_active_set['default_money'];

                // 达标信息
                $standard = $policy->default_standard_set;
                //dd($standard);
            	\App\UserPolicy::create([
            		'user_id'		        =>	$request->user,
            		'policy_id'		        =>	$request->policy,
            		'sett_price'	        =>	$policy->sett_price,
                    'default_active_set'    =>  $default_active_set,
                    'vip_active_set'        =>  $vip_active_set,
                    'standard'              =>  $standard,
            	]);
            }*/

            return $this->response()->success('发货成功')->refresh();

        }catch (Throwable $throwable) {

            $this->response()->status = false;

            return $this->response()->swal()->error($throwable->getMessage());
        }

    }

    /* 发货按钮需要提交资料 */
	public function form()
	{
        $user = \App\User::where('operate', Admin::user()->operate)->pluck('nickname', 'id');
        $this->select('user', '配送会员')->options($user)->rules('required', ['required' => '请选择配送用户']);

        $policyGroups = \App\PolicyGroup::where('operate', Admin::user()->operate)->pluck('title', 'id');
        $this->select('d_title','活动组')->options($policyGroups)->load('d_policy','/api/getAdminUserGroup');
        
        $this->select('d_policy','活动')->required();
	}
}