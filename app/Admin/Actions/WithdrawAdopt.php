<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\RepayCjController;

class WithdrawAdopt extends RowAction
{
    public $name = '通过';

    public function handle(Model $model)
    {
        
        $repay = new RepayCjController();
        $repay->authQuery();

        return $this->response()->success('ss')->refresh();
    }

    // public function form()
    // {
    // 	// 单选框
    //     $this->password('pass', '审核密码');
    // }

}