<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class WithdrawReject extends RowAction
{
    public $name = '驳回';

    public function handle(Model $model)
    {

        return $this->response()->success('Success message.')->refresh();
    }

}