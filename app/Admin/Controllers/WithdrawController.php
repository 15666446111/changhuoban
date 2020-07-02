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
            $grid->model()->where('operate', Admin::user()->operate);   
        }
        
        $grid->model()->latest();
        
        $grid->column('order_no', __('提现订单'));

        $grid->column('users.nickname', __('提现用户'));
        
        $grid->column('money', __('提现金额'))->display(function( $cash){
            return number_format( $cash / 100 , 2, '.', ',');
        })->label();

        $grid->column('real_money', __('到账金额'))->display(function( $cash){
            return number_format( $cash / 100 , 2, '.', ',');
        })->label('info');

        $grid->column('type', __('提现类型'))->using(['1' => '分润提现', '2' => '返现提现'])->dot([ 1 => 'primary', 2 => 'success' ]);

        $grid->column('rate', __('提现费率'))->display(function( $fee){
            return number_format( $fee / 100 , 2, '.', ',');
        })->label('info');

        $grid->column('rate_m', __('手续费'))->display(function ($money) {
            return number_format($money/100, 2, '.', ',');
        })->label('info')->filter('range');

        $grid->column('state', __('提现状态'))
                ->using(['1' => '待审核', '2' => '通过', '3'=>'驳回'])->dot([ 1 => 'default', 2 => 'success', 3=> 'error' ]);

        $grid->column('make_state', __('打款状态'))->using(['0' => '未打款', '1' => '已打款'])->dot([ 0 => 'default', 1 => 'success' ]);

        $grid->column('check_at', __('审核时间'));

        $grid->column('created_at', __('申请时间'));

        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();
            // 去掉编辑
            $actions->disableEdit();

            if($actions->row['state'] == "1"){
                // 添加通过按钮
                $actions->add(new WithdrawAdopt());
                // 添加驳回按钮
                $actions->add(new WithdrawReject());
            }

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

        if(Admin::user()->operate != "All"){
            $model = Withdraw::where('id', $id)->first();
            if($model->operate != Admin::user()->operate) return abort('403');        
        }

        $show->field('order_no', __('提现订单号'));

        $show->field('money', __('提现金额'));

        $show->field('rate', __('提现费率'));

        $show->field('rate_m', __('手续费'))->display(function ($money) {
            return number_format($money/100, 2, '.', ',');
        })->label('info')->filter('range');

        $show->field('real_money', __('到账金额'));

        $show->field('users.nickname', __('用户'));
        
        $show->field('type', __('提现方式'))->using(['1' => '分润钱包提现', '2' => '返现钱包提现']);

        $show->field('state', __('提现状态'))->using(['1' => '待审核', '2' => '通过', '3'=>'驳回']);

        $show->field('make_state', __('打款状态'))->using(['0' => '未打款', '1' => '已打款']);

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
