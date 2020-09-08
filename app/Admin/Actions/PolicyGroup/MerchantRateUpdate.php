<?php

namespace App\Admin\Actions\PolicyGroup;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

use App\Jobs\MerchantsRateUpdate;

class MerchantRateUpdate extends RowAction
{
    public $name = '费率批量调整';

    public function handle(Model $model, Request $request)
    {
    	try {

            ## 选择的费率类型
            $rateType = $model->rate_types->type;

            ## 1、查询当前活动组下的所有商户
            $policyList = \App\Policy::where('policy_group_id', $model->policy_group_id)->get();

            foreach ($policyList as $key => $value) {

                if ($value->machines->count() == 0) {
                    continue ;
                }

                // 活动下的商户信息
                foreach ($value->machines as $k => $v) {

                    if ($v->merchant_id > 0 && !empty($v->merchants)) {

                        // 压入队列中，处理剩下的逻辑
                        MerchantsRateUpdate::dispatch($v, $rateType, $request->rate);
                    }
                }

            }
            
            \App\PolicyGroupRateLog::create([
                'policy_group_id'   => $model->policy_group_id,
                'rate_type_id'      => $model->rate_type_id,
                'price'             => $request->rate,
            ]);

			return $this->response()->success('请求已压入队列处理')->refresh();

    	} catch (Exception $e) {

            return $this->response()->error('错误:'.$e->getMessage());

        }
    }


    public function form()
    {
        $this->text('rate', '同步调整额度')->required()->help('单位和列表中的单位相同');
    }
}