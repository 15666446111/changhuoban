<?php

namespace App\Admin\Controllers;

use App\Withdraw;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

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

        $grid->column('order_no', __('提现订单'));

        $grid->column('user_id', __('提现代理'));
        
        $grid->column('money', __('提现金额'));

        $grid->column('real_money', __('到账金额'));

        $grid->column('type', __('提现类型'));

        $grid->column('state', __('提现状态'));

        $grid->column('make_state', __('打款状态'));

        $grid->column('check_at', __('审核时间'));

        $grid->column('created_at', __('申请时间'));

        //$grid->column('updated_at', __('Updated at'));
        //
        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();
            // 去掉编辑
            $actions->disableEdit();
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
