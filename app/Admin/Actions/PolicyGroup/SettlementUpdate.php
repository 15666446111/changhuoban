<?php

namespace App\Admin\Actions\PolicyGroup;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class SettlementUpdate extends RowAction
{
    public $name = '批量调整';

    public function handle(Model $model, Request $request)
    {
    	try {

            // 查询用户结算价设置记录
            $userFeeList = \App\UserFee::where('policy_group_id', $model->policy_group_id)->get();

            // 修改用户已设置结算价
            foreach ($userFeeList as $key => $value) {

                // 修改记录
                $userFeeLogs = [];

                $priceArr = json_decode($value->price, true);
                foreach ($priceArr as $k => $v) {
                    if ($v['index'] == $model->trade_type_id) {
                        $priceArr[$k]['price'] += $request->settlement;
                        $userFeeLogs[] = [
                            'user_id'           => $value->user_id,
                            'policy_group_id'   => $model->policy_group_id,
                            'trade_type_id'     => $model->trade_type_id,
                            'old_settlement'    => $v['price'],
                            'new_settlement'    => $priceArr[$k]['price'],
                            'created_at'        => Carbon::now()->toDateTimeString()
                        ];
                    }
                }

                \App\UserFee::where('id', $value->id)->update([
                    'price' => json_encode($priceArr)
                ]);

                // 添加用户结算价修改记录
                \App\UserFeeLog::insert($userFeeLogs);
            }

            // 添加活动组结算价批量上调记录
            \App\PolicyGroupUserfeeLog::create([
                'policy_group_id'   => $model->policy_group_id,
                'trade_type_id'     => $model->trade_type_id,
                'inc_price'         => $request->settlement
            ]);

			return $this->response()->success('调整成功')->refresh();

    	} catch (Exception $e) {

            return $this->response()->error('错误:'.$e->getMessage());

        }
    }


    public function form()
    {

        $this->text('settlement', '同步调整额度')->required()->help();
    }
}