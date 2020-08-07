<?php

namespace App\Admin\Controllers;

use App\Cash;
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
        $grid = new Grid(new Cash());

        if(Admin::user()->operate != "All"){
            $grid->model()->where('operate', Admin::user()->operate);
        }
        
        $grid->model()->latest();
        //$grid->column('id', __('索引'));
        $grid->column('users.nickname', __('会员昵称'))->help('分润所归属的用户昵称');
        $grid->column('users.account', __('会员账号'))->help('分润所归属的用户账号');
        $grid->column('trades.sn', __('SN号'))->help('分润的终端机具SN');
        $grid->column('trades.merchant_code', __('商户号'))->help('分润的终端机具商户号');
        $grid->column('trades.trade_no', __('交易订单号'))->help('分润的交易订单号');
        $grid->column('trades.amount', __('交易金额'))->display(function ($money) {
            return number_format($money / 100, 2, '.', ',');
        })->label()->help('交易金额');
        $grid->column('cash_money', __('分润金额'))->display(function ($money) {
            return number_format($money / 100, 2, '.', ',');
        })->label()->help('本次分润金额');
        $grid->column('is_run', __('方式'))->using(['1' => '分润', '0' => '返现'])->help('分润类型,分为分润与返现');
        $grid->column('cash_type', __('类型'))->using(['1' => '直营分润', '2' => '团队分润','3'=>'激活返现'
        ,'4'=>'间推激活返现','5'=>'间间推激活返现','6'=>'达标返现','7'=>'二次达标返现','8'=>'三次达标返现','9'=>'财商学院推荐奖励'])->help('分润的详细类型');
        $grid->column('created_at', __('分润时间'))->help('分润下发的时间');

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
                $filter->like('order', '订单')->placeholder('交易的订单编号,模糊匹配');
            });

            $filter->column(1/3, function ($filter) {
                $filter->like('users.account', '账号')->placeholder('分润的代理登陆账号,模糊匹配');
            });

            $filter->column(1/3, function ($filter) {
                $filter->like('trades.merchant_code', '交易商户')->placeholder('交易的商户号编号,模糊匹配');
            });

            // 分润类型
            $filter->column(1/3, function ($filter) {
                $filter->equal('cash_type', '分润类型')->select([
                    '1' => '直营分润', 
                    '2' => '团队分润',
                    '3' => '激活返现',
                    '4' => '交易奖励',
                    '5' => '注册奖励',
                    '6' => '连续达标',
                    '7' => '连续达标(团队)',
                    '8' => '累计达标',
                    '9' => '累计达标(团队)',
                ]);
            });

            // 交易类型
            $filter->column(1/3, function ($filter) {
                $filter->equal('trades.trade_type', '交易类型')->select([
                    '020000' => '消费', 
                    '020002' => '消费撤销', 
                    '020003' => '消费冲正',
                    '020023' => '消费撤销冲正',
                    'U20000' => '电子现金',
                    'T20003' => '日结消费冲正',
                    'T20000' => '日结消费',
                    '024100' => '预授权完成',
                    '024102' => '预授权完成撤销',
                    '024103' => '预授权完成冲正',
                    '024123' => '预授权完成撤销 冲正',
                    '020001' => '退货',
                    '02B100' => '支付宝被扫',
                    '02B200' => '支付宝主扫',
                    '02W100' => '微信被扫',
                    '02W200' => '微信主扫',
                    '02Y100' => '银联被扫',
                    '02Y200' => '银联主扫',
                    '02Y600' => '银联二维码撤销'
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
        $show = new Show(Cash::findOrFail($id));

        if(Admin::user()->operate != "All"){
            $model = CashsLog::where('id', $id)->first();
            if($model->operate != Admin::user()->operate) return abort('403');        
        }

        $show->field('users.nickname', __('会员昵称'));
        $show->field('users.account', __('会员账号'));
        $show->field('trades.sn', __('SN号'));
        $show->field('trades.merchant_code', __('商户号'));
        $show->field('trades.trade_no', __('交易流水号'));
        $show->field('money', __('分润金额'))->as(function ($money) {
            return number_format($money / 100, 2, '.', ',');
        })->label();
        $show->field('is_run', __('方式'))->using(['1' => '分润', '2' => '返现']);
        $show->field('cash_type', __('类型'))->using(['1' => '直营分润', '2' => '团队分润','3'=>'激活返现'
        ,'4'=>'间推激活返现','5'=>'间间推激活返现','6'=>'达标返现','7'=>'二次达标返现','8'=>'三次达标返现','9'=>'财商学院推荐奖励']);
        $show->field('created_at', __('分润时间'));

        $show->trades('交易信息', function ($trades) {

            $trades->setResource('/manage/trades');
            
            $trades->field('trade_no', __('系统流水号'));

            $trades->field('users.nickname', __('所属代理'));

            $trades->field('sn', __('机器序列号'));

            $trades->field('merchant_code',  __('商户号'));

            $trades->field('agt_merchant_id', __('渠道商机构号'));

            $trades->field('amount',         __('交易金额'))->display(function($amount){
                return number_format($amount / 100, 2, '.', ',');
            })->label();

            $trades->field('settle_amount', __('结算金额'))->display(function($amount){
                return number_format($amount / 100, 2, '.', ',');
            })->label();

            $trades->field('trades_deputies.tranTime', __('交易时间'));

            $trades->field('tran_code', __('交易类型'))->using([
                '020000' => '消费', 
                '020002' => '消费撤销', 
                '020003' => '消费冲正',
                '020023' => '消费撤销冲正',
                'U20000' => '电子现金',
                'T20003' => '日结消费冲正',
                'T20000' => '日结消费',
                '024100' => '预授权完成',
                '024102' => '预授权完成撤销',
                '024103' => '预授权完成冲正',
                '024123' => '预授权完成撤销 冲正',
                '020001' => '退货',
                '02B100' => '支付宝被扫',
                '02B200' => '支付宝主扫',
                '02W100' => '微信被扫',
                '02W200' => '微信主扫',
                '02Y100' => '银联被扫',
                '02Y200' => '银联主扫',
                '02Y600' => '银联二维码撤销'
            ]);

            $trades->field('fee_type', __('手续费计算类型'))->using([
                'B' => '标准', 'YN' => '云闪付NFC', 'YM' => '云闪付双免'
            ]);

            $trades->field('card_type', __('交易卡类型'))->using([
                '0' => '借记卡', '1' => '贷记卡'
            ]);

            $trades->field('is_send', __('分润发放'))->using([
                '0' => '未发放', '1' => '已发放'
            ]);

            $trades->field('created_at', __('创建时间'))->date('Y-m-d H:i:s');


            $trades->panel()->tools(function ($tools) {
                $tools->disableEdit();
                $tools->disableList();
                $tools->disableDelete();
            });

            // // 禁用创建按钮
            // $trades->disableCreateButton();
            // // 禁用查询过滤器
            // $trades->disableFilter();
            // // 禁用行选择checkbox
            // $trades->disableRowSelector();
        });

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
