<?php

namespace App\Admin\Controllers;

use App\Trade;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;

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

        if(Admin::user()->operate != "All"){
            $grid->model()->where('operate', Admin::user()->operate);   
        }

        $grid->model()->latest();
        
        $grid->column('trade_no',__('系统流水号'))->help('交易订单的流水号,畅捷支付的订单号');

        // $grid->column('rrn', __('参考号'))->help('交易订单的参考号,畅捷支付的参考号');

        $grid->column('users.nickname', __('所属代理'))->help('交易订单所归属的代理昵称');

        $grid->column('sn', __('机器序列号'))->help('交易订单所归属的终端机具SN');

        $grid->column('merchant_code',  __('商户号'))->help('交易订单所归属的商户号');

        $grid->column('agt_merchant_id', __('渠道商机构号'))->help('交易订单所归属的渠道商机构号');

        $grid->column('amount',         __('交易金额'))->display(function($amount){
            return number_format($amount / 100, 2, '.', ',');
        })->label()->help('当前交易订单的交易金额');

        // $grid->column('rate_money', __('手续费'))->display(function ($money) {
        //     return number_format($money / 100, 2, '.', ',');
        // })->label('warning')->filter('range')->help('当前交易订单的手续费');

        $grid->column('settle_amount', __('结算金额'))->display(function($amount){
            return number_format($amount / 100, 2, '.', ',');
        })->label('info')->help('当前交易订单的实际结算金额');

        $grid->column('trades_deputies.tranTime', __('交易时间'))->help('当前交易订单的交易时间');

        $grid->column('tran_code', __('交易类型'))->using([
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
        ])->help('当前交易订单的交易类型');

        $grid->column('fee_type', __('手续费计算类型'))->using([
            'B' => '标准', 'YN' => '云闪付NFC', 'YM' => '云闪付双免'
        ])->label([
            'YN' =>  'info', 'YM' => 'warning'
        ])->help('当前交易订单的手续费计算类型');

        $grid->column('card_type', __('交易卡类型'))->using([
            '0' => '借记卡', '1' => '贷记卡'
        ])->label([
            '0' =>  'warning', '1' => 'success'
        ])->help('当前交易订单的交易卡类型');

        $grid->column('is_send', __('分润发放'))->bool()->help('当前交易订单是否发放分润');

        $grid->column('created_at', __('创建时间'))->date('Y-m-d H:i:s')->help('当前交易订单的执行时间');

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

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->column(1/3, function ($filter) {
                $filter->like('trade_no', '订单');
            });
            $filter->column(1/3, function ($filter) {
                $filter->like('sn', 'SN');
            });
            $filter->column(1/3, function ($filter) {
                $filter->like('merchant_code', '商户');
            });
            $filter->column(1/3, function ($filter) {
                $filter->equal('is_send', '状态')->select(['0' => '失败', '1' => '成功']);
            });
            $filter->column(1/3, function ($filter) {
                $filter->equal('is_send', '分润状态')->select(['0' => '未发放', '1' => '已发放']);
            });

            // 交易类型
            $filter->column(1/3, function ($filter) {
                $filter->equal('trade_type', '交易类型')->select([
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
                $filter->between('trade_time', '交易时间')->datetime();
            });
            
            $filter->column(1/3, function ($filter) {

                $arrs = array();
            });
        });


        $grid->export(function ($export) {

            $export->column('amount', function ($value, $amount) {
                return number_format($amount / 100, 2, '.', ',');
            });

            $export->column('settle_amount', function ($value, $settleAmount) {
                return number_format($settleAmount / 100, 2, '.', ',');
            });

            $export->column('fee_type', function ($value, $feeType) {
                $feeTypeRemark = ['B' => '标准', 'YN' => '云闪付NFC', 'YM' => '云闪付双免'];
                return $feeTypeRemark[$feeType];
            });

            $export->column('card_type', function ($value, $originalType) {
                $cardType = ['0' => '借记卡', '1' => '贷记卡'];
                return !empty($cardType[$originalType]) ? $cardType[$originalType] : '';
            });

            $export->column('is_send', function ($value, $isSend) {
                return $isSend == 1 ? '已发放' : '未发放';
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
        
        $show = new Show(Trade::findOrFail($id));

        if(Admin::user()->operate != "All"){
            $model = Trade::where('id', $id)->first();
            if($model->operate != Admin::user()->operate) return abort('403');        
        }

        $show->field('trade_no', __('系统流水号'));
        $show->field('users.nickname', __('代理昵称'));
        $show->field('users.account', __('代理账号'));
        $show->field('sn', __('机器SN'));
        $show->field('merchant_code', __('商户号'));
        $show->field('agt_merchant_id', __('渠道机构号'));

        $show->field('merchant_name', __('商户名称'));

        $show->field('amount', __('交易金额'))->as(function ($money) {
            return number_format($money / 100, 2, '.', ',');
        })->label();

        $show->field('settle_amount', __('结算金额'))->as(function ($money) {
            return number_format($money / 100, 2, '.', ',');
        })->label();

        $show->field('trades_deputies.tranTime', __('交易时间'))->as(function ($tranTime) {
            return date('Y-m-d H:i:s', strtotime($tranTime));
        });

        $show->field('tran_code', __('交易类型'))->using([
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


        $show->field('trades_deputies.fee_type', __('手续费计算类型'))->using([
            'B' => '标准', 'YN' => '云闪付NFC', 'YM' => '云闪付双免'
        ])->label();

        $show->field('card_type', __('交易卡类型'))->using([
            '0' => '借记卡', '1' => '贷记卡'
        ])->label();

        $show->field('trades_deputies.cardNo', __('交易卡号'));
        
        $show->field('is_send', __('是否分润'))->using(['0' => '否', '1' => '是']);

        $show->field('sys_resp_code', __('收单平台应答码'));

        $show->field('sys_resp_desc', __('收单平台应答描述'));

        $show->field('remark', __('本条交易备注'));

        $show->field('created_at', __('推送接收时间'));

        $show->cashs('分润返现', function ($cashs) {

            $cashs->setResource('/manage/cashs');
            
            $cashs->model()->latest();

            $cashs->column('users.nickname', __('会员昵称'))->help('分润所归属的用户昵称');
            $cashs->column('users.account', __('会员账号'))->help('分润所归属的用户账号');
            $cashs->column('trades.sn', __('SN号'))->help('分润的终端机具SN');
            $cashs->column('trades.merchant_code', __('商户号'))->help('分润的终端机具商户号');
            $cashs->column('trades.trade_no', __('交易订单号'))->help('分润的交易订单号');
            $cashs->column('trades.amount', __('交易金额'))->display(function ($money) {
                return number_format($money / 100, 2, '.', ',');
            })->label()->help('交易金额');
            $cashs->column('cash_money', __('分润金额'))->display(function ($money) {
                return number_format($money / 100, 2, '.', ',');
            })->label()->help('本次分润金额');
            $cashs->column('is_run', __('方式'))->using(['1' => '分润', '0' => '返现'])->help('分润类型,分为分润与返现');
            $cashs->column('cash_type', __('类型'))->using(['1' => '直营分润', '2' => '团队分润','3'=>'激活返现'
            ,'4'=>'间推激活返现','5'=>'间间推激活返现','6'=>'达标返现','7'=>'二次达标返现','8'=>'三次达标返现','9'=>'财商学院推荐奖励'])->help('分润的详细类型');
            $cashs->column('created_at', __('分润时间'))->help('分润下发的时间');

            $cashs->actions(function ($actions) {
                // 去掉删除
                $actions->disableDelete();
                // 去掉编辑
                $actions->disableEdit();
            });

            // 禁用创建按钮
            $cashs->disableCreateButton();
            // 禁用查询过滤器
            $cashs->disableFilter();
            // 禁用行选择checkbox
            $cashs->disableRowSelector();
            
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
        $form = new Form(new Trade());

        $form->number('user_id', __('User id'));
        $form->number('machine_id', __('Machine id'));
        $form->number('is_send', __('Is send'));
        $form->number('sn', __('Sn'));
        $form->number('merchant_code', __('Merchant code'));
        $form->number('amount', __('Amount'));
        $form->number('settle_amount', __('Settle amount'));
        $form->switch('card_type', __('card_type'));

        return $form;
    }
}
