<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class WithdrawReject extends RowAction
{
    public $name = '驳回申请';

    public function handle(Model $model)
    {

        return $this->response()->success('Success message.')->refresh();
    }


    public function form()
    {
     	// 单选框
        $this->password('bak', '驳回原因')->required()->help('请输入此次驳回的原因,供用户查询详情!');
    }

}