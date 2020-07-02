<?php

namespace App\Admin\Actions;

use Illuminate\Http\Request;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use App\Services\Cj\RepayCjController;

class WithdrawAdopt extends RowAction
{
    public $name = '提现通过';

    public function handle(Model $model, Request $request)
    {
        // 处理错误
        try {

            if(!$request->pass) return $this->response()->error('请填写提现密码')->refresh();

            $application = new RepayCjController($model);

            $result = $application->apply( $request->pass );
                
            if($result['code'] && $result['code'] == 10000 )
                return $this->response()->success($result['message'])->refresh();
            else
                return $this->response()->error($result['message'])->refresh();

        } catch (Exception $e) {

            return $this->response()->error('错误:'.$e->getMessage());

        }
        
    }


    public function form()
    {
     	// 单选框
        $this->password('pass', '审核密码')->required()->help('请输入您在设置中设置的提现审核密码!');
    }

}