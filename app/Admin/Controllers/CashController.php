<?php

namespace App\Admin\Controllers;

use App\CashsLog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;

class CashController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '分润列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CashsLog());

        if(Admin::user()->operate != "All"){

            $user_id[] = \App\User::where('operate',Admin::user()->operate)->first()->id;

            $id = \App\User::where('operate',Admin::user()->operate)->first()->id;
            $userInfo = \App\UserRelation::where('parents', 'like', "%_".$id."_%")->pluck('user_id')->toArray();

            $user_id = array_merge($user_id,$userInfo);

            $grid->model()->whereIn('user_id',$user_id);
            
        }

        $grid->column('id', __('索引'));
        $grid->column('users.nickname', __('会员昵称'));
        $grid->column('machines.sn', __('终端号'));
        $grid->column('trades.order_no', __('交易流水号'));
        $grid->column('money', __('分润金额'))->display(function ($money) {
            return number_format($money / 100, 2, '.', ',');
        })->label();
        $grid->column('is_run', __('方式'))->using(['1' => '分润', '2' => '返现']);
        $grid->column('type', __('类型'))->using(['1' => '直营分润', '2' => '团队分润','3'=>'激活返现'
        ,'4'=>'间推激活返现','5'=>'间间推激活返现','6'=>'达标返现','7'=>'二次达标返现','8'=>'三次达标返现','9'=>'财商学院推荐奖励']);
        $grid->column('created_at', __('分润时间'));

        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            // 去掉删除 编辑
            $actions->disableDelete();
            $actions->disableEdit();
        });
        $grid->batchActions(function ($batch) {
            $batch->disableDelete();
        });

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->column(1/3, function ($filter) {
                $filter->like('order_no', '订单');
            });

            // 交易类型
            $filter->column(1/3, function ($filter) {
                $filter->equal('type', '分润类型')->select([
                    '1'      => '直营分润', 
                    '2'      => '团队分润',
                    '3'      => '激活返现',
                    '4'      => '间推激活返现',
                    '5'      => '间间推激活返现',
                    '6'      => '达标返现',
                    '7'      => '二次达标返现',
                    '8'      => '三次达标返现',
                    '9'      => '财商学院推荐奖励'
                ]);
            });
            // 在这里添加字段过滤器
            $filter->column(1/3, function ($filter) {
                $filter->between('created_at', '分润时间')->datetime();
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
        $show = new Show(CashsLog::findOrFail($id));

        $show->field('id', __('索引'));
        $show->field('users.nickname', __('会员昵称'));
        $show->field('machines.sn', __('终端号'));
        $show->field('trades.order_no', __('交易流水号'));
        $show->field('money', __('分润金额'))->as(function ($money) {
            return number_format($money / 100, 2, '.', ',');
        })->label();
        $show->field('is_run', __('方式'))->using(['1' => '分润', '2' => '返现']);
        $show->field('type', __('类型'))->using(['1' => '直营分润', '2' => '团队分润','3'=>'激活返现'
        ,'4'=>'间推激活返现','5'=>'间间推激活返现','6'=>'达标返现','7'=>'二次达标返现','8'=>'三次达标返现','9'=>'财商学院推荐奖励']);
        $show->field('created_at', __('分润时间'));

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
        $form = new Form(new CashsLog());

        $form->number('user_id', __('User id'));
        $form->number('machine_id', __('Machine id'));
        $form->number('trade_id', __('Trade id'));
        $form->number('money', __('Money'));
        $form->switch('is_run', __('Is run'));
        $form->switch('type', __('Type'));

        return $form;
    }
}
