<?php

namespace App\Admin\Actions\Machines;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Unbind extends RowAction
{
    public $name = '解绑';

    public function handle(Model $model)
    {
    	if ($model->bind_status != 1) {
    		return $this->response()->error('数据错误')->refresh();
    	}

    	if (empty($model->merchants)) {
    		return $this->response()->error('商户信息获取失败')->refresh();
    	}

    	// 修改机器表中的绑定信息
    	$model->merchant_id 		= 0;
    	$model->bind_status 		= 0;
    	$model->bind_time 			= null;
    	$model->activate_time 		= null;
    	$model->activate_state 		= 0;
    	$model->standard_status 	= 0;
    	$model->standard_status_lj 	= 0;
    	$model->open_state 			= 0;
    	$model->open_time 			= null;
    	$model->save();

    	// 修改绑定记录中的绑定状态
    	\App\MerchantsBindLog::where('sn', $model->sn)->where('merchant_code', $model->merchants->code)
    							->update(['bind_state' => 0]);

        return $this->response()->success('解绑成功')->refresh();
    }

    public function dialog()
    {
        $this->confirm('确定要解绑当前机器和商户吗？');
    }
}