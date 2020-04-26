<?php

namespace App\Admin\Controllers;

use App\Trade;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TradeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '交易列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Trade());

        $grid->column('trade_no',        __('系统流水号'));

        $grid->column('rrn',            __('参考号'));

        $grid->column('user_id',        __('所属代理'));

        $grid->column('sn',             __('机器序列号'));

        $grid->column('merchant_code',  __('商户号'));

        $grid->column('amount',         __('交易金额'))->display(function($amount){
            return number_format($amount / 100, 2, '.', ',');
        })->label();

        $grid->column('settle_amount', __('结算金额'))->display(function($amount){
            return number_format($amount / 100, 2, '.', ',');
        })->label('info');

        $grid->column('trade_time',        __('交易时间'));

        $grid->column('cardType', __('交易卡类型'))->using([
            '0' => '贷记卡', '1' => '借记卡'
        ])->label([
            '0' =>  'warning', '1' => 'success'
        ]);

        $grid->column('is_send', __('分润发放'))->bool();

        $grid->column('created_at', __('创建时间'))->date('Y-m-d H:i:s');
        //$grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Trade::findOrFail($id));

        $show->field('trade_no', __('系统流水号'));

        $show->field('rrn', __('参考号'));

        $show->field('sn', __('机器序列号'));

        $show->field('merchant_code', __('机器商户号'));

        $show->field('amount', __('交易金额'));

        $show->field('settle_amount', __('结算金额'));

        $show->field('trade_time',        __('交易时间'));

        $show->field('user_id', __('所属代理'));

        $show->field('machine_id', __('商户ID'));
        
        $show->field('cardType', __('交易卡类型'));

        $show->field('created_at', __('创建时间'));
        //$show->field('updated_at', __('Updated at'));

        $show->field('is_send', __('分润发放'));


        $show->field('trade_post', __('推送报文'))->json();

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
        $form = new Form(new Trade());

        $form->number('user_id', __('User id'));
        $form->number('machine_id', __('Machine id'));
        $form->number('is_send', __('Is send'));
        $form->number('sn', __('Sn'));
        $form->number('merchant_code', __('Merchant code'));
        $form->number('amount', __('Amount'));
        $form->number('settle_amount', __('Settle amount'));
        $form->switch('cardType', __('CardType'));

        return $form;
    }
}
