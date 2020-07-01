<?php

namespace App\Admin\Controllers;

use App\Withdraw;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use App\Admin\Actions\WithdrawAdopt;
use App\Admin\Actions\WithdrawReject;

class WithdrawController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '提现列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Withdraw());

        if(Admin::user()->operate != "All"){

            $user_id[] = \App\User::where('operate',Admin::user()->operate)->first()->id;

            $id = \App\User::where('operate',Admin::user()->operate)->first()->id;
            $userInfo = \App\UserRelation::where('parents', 'like', "%_".$id."_%")->pluck('user_id')->toArray();

            $user_id = array_merge($user_id,$userInfo);

            $grid->model()->whereIn('user_id',$user_id);
            
        }
        
        $grid->model()->latest();
        
        $grid->column('order_no', __('提现订单'));

        $grid->column('users.nickname', __('提现代理'));
        
        $grid->column('money', __('提现金额'))->label();

        $grid->column('real_money', __('到账金额'))->label('info');

        $grid->column('type', __('提现类型'))
                ->using(['1' => '分润提现', '2' => '返现提现']);

        $grid->column('state', __('提现状态'))
                ->using(['1' => '待审核', '2' => '通过', '3'=>'驳回'])
                ->dot([ 0 => 'success', 1 => 'danger' ], 'default');

        $grid->column('make_state', __('打款状态'))
                ->using(['0' => '未打款', '1' => '已打款'])
                ->dot([ 0 => 'danger', 1 => 'success' ], 'default');

        $grid->column('check_at', __('审核时间'));

        $grid->column('created_at', __('申请时间'));

        //
        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();
            // 去掉编辑
            $actions->disableEdit();
            // 添加通过按钮
            $actions->add(new WithdrawAdopt());
            // 添加驳回按钮
            $actions->add(new WithdrawReject());
        });

        $grid->batchActions(function ($batch) {
            $batch->disableDelete();
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        if(Admin::user()->operate != "All"){
            $model = Withdraw::where('id', $id)->first();
            if($model->operate != Withdraw::user()->operate) return abort('403');        
        }
        $show = new Show(Withdraw::findOrFail($id));

        $show->field('order_no', __('提现订单号'));

        $show->field('money', __('提现金额'));

        $show->field('real_money', __('到账金额'));

        $show->field('user_id', __('User id'));
        
        $show->field('type', __('提现方式'));

        $show->field('state', __('提现状态'));

        $show->field('make_state', __('打款状态'));

        $show->field('check_at', __('审核时间'));

        $show->field('created_at', __('申请时间'));

        //$show->field('updated_at', __('Updated at'));
        $show->panel()->tools(function ($tools) {
            $tools->disableEdit();
            $tools->disableDelete();
        });
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Withdraw());

        $form->number('user_id', __('User id'));
        $form->text('order_no', __('Order no'));
        $form->number('money', __('Money'));
        $form->number('real_money', __('Real money'));
        $form->switch('type', __('Type'));
        $form->switch('state', __('State'))->default(1);
        $form->switch('make_state', __('Make state'));
        $form->datetime('check_at', __('Check at'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
