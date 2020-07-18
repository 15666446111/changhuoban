<?php

namespace App\Admin\Actions;

use Illuminate\Http\Request;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class WithdrawReject extends RowAction
{
    public $name = '驳回申请';

    public function handle(Model $model, Request $request)
    {
    	try {
    		if ($model->state != 1) return $this->response()->error('当前提现订单不支持驳回')->refresh();

    		if (!$request->remark) return $this->response()->error('请填写驳回原因')->refresh();

    		$model->state = 3;

    		$model->remark = $request->remark;
    		
    		$model->save();

    		// 增加用户钱包余额
    		if ($model->type == 1) {
    			\App\UserWallet::where('user_id', $model->user_id)->increment('cash_blance', $model->money);
    		}
    		if ($model->type == 2) {
    			\App\UserWallet::where('user_id', $model->user_id)->increment('return_blance', $model->money);
    		}

			return $this->response()->success('驳回成功')->refresh();

    	} catch (Exception $e) {

            return $this->response()->error('错误:'.$e->getMessage());

        }
    }


    public function form()
    {
     	// 单选框
        $this->text('remark', '驳回原因')->required()->help('请输入驳回原因!');
    }
}