<?php

namespace App\Admin\Controllers;

use App\Withdraw;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Facades\Admin;
use App\Admin\Actions\WithdrawAdopt;
use App\Admin\Actions\WithdrawReject;
use Encore\Admin\Controllers\AdminController;

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

        $grid->column('users.nickname', __('提现用户'))->help('提现人昵称');

        $grid->column('withdrawDatas.bank', '银行信息')->modal('提现卡信息', function ($model) {
            return new Table(['姓名', '身份证号', '银行', '开户行', '联行号', '预留手机'], [ [
                $model->withdrawDatas->username, $model->withdrawDatas->idcard, $model->withdrawDatas->bank, 
                $model->withdrawDatas->bank_open, $model->withdrawDatas->banklink, $model->withdrawDatas->phone
            ] ]);
        });

        $grid->column('money', __('提现金额'))->display(function( $cash){
            return number_format( $cash / 100 , 2, '.', ',');
        })->label()->help('用户申请的提现金额');

        $grid->column('real_money', __('到账金额'))->display(function( $cash){
            return number_format( $cash / 100 , 2, '.', ',');
        })->label('primary')->help('用户实际到账金额');

        $grid->column('rate', __('费率'))->display(function( $fee){
            return number_format( $fee / 100 , 2, '.', ',');
        })->label('info')->help('提现费率/百分位');

        $grid->column('rate_m', __('手续费'))->display(function ($money) {
            return number_format($money/100, 2, '.', ',');
        })->label('info')->help('单笔提现费');

        $grid->column('channle_money', __('实际支出'))->display(function ($money) {
            return number_format( $money/100, 2, '.', ',');
        })->label('danger')->help('代付系统实际支出金额');

        $grid->column('type', __('提现类型'))->using(['1' => '分润提现', '2' => '返现提现'])->dot([ 1 => 'primary', 2 => 'success' ]);

        $grid->column('state', __('提现状态'))->using(['1' => '待审核', '2' => '通过', '3'=>'驳回', '4'=> '交易受理中'])
                                                        ->dot([ 1 => 'default', 2 => 'success', 3 => 'danger', 4 =>'primary' ]);
        $grid->column('make_state', __('打款状态'))->using(['0' => '待处理', '1' => '已打款', '2' => '打款失败'])
                                                        ->dot([ 0 => 'default', 1 => 'success', 2 => 'danger' ]);

        $grid->column('check_at', __('审核时间'))->help('该笔订单处理时间');

        $grid->column('created_at', __('申请时间'))->help('用户申请提现时间');

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

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->column(1/4, function ($filter) {
                $filter->like('order_no', '订单');
            });
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

        $show->field('remark', __('驳回原因'));

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
