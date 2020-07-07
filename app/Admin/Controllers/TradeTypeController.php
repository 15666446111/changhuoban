<?php

namespace App\Admin\Controllers;

use App\TradeType;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TradeTypeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '结算类型管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TradeType());

        $grid->column('id', __('索引'));

        $grid->column('name', __('类型名称'))->help('结算类型的名称');
        
        $grid->column('trade_type', __('交易标识'))->display(function ($title) {

            $type = [
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
            ];

            $str = "";
            foreach ($title as $key => $value) {
                $str.="<span style='background:#00a65a; padding: 5px 10px; color:white; margin-right:5px; border-radius:5px;'>$type[$value]</span>";
            }
            return $str;
        })->help('交易标识组合');

        $grid->column('card_type', __('交易卡'))->display(function ($title) {
            $str = "";
            foreach ($title as $key => $value) {
                $card = $value == "0" ? '借记卡' : '信用卡';
                $str.="<span style='background:#55acee; padding: 5px 10px; color:white; margin-right:5px; border-radius:5px;'>$card</span>";
            }
            return $str;    
        })->help('交易卡组合');
        $grid->column('trade_code', __('手续费计算类型'))->display(function ($title) {

            $type = [ 
                'Y' => '优惠', 
                'M' => '减免',
                'B' => '标准',
                'YN'=> '云闪付NFC',
                'YM'=> '云闪付双免'
            ];

            $str = "";
            foreach ($title as $key => $value) {
                $str.="<span style='background:#00a65a; padding: 5px 10px; color:white; margin-right:5px; border-radius:5px;'>$type[$value]</span>";
            }
            return $str;
        })->help('手续费计算类型组合');

        $grid->column('is_top', __('是否封顶'))->display(function ($title) {
            $str = "";
            foreach ($title as $key => $value) {
                $card = $value == "0" ? '非封顶' : '封顶';
                $str.="<span style='background:#55acee; padding: 5px 10px; color:white; margin-right:5px; border-radius:5px;'>$card</span>";
            }
            return $str;    
        })->help('是否封顶组合');
        $grid->column('created_at', __('创建时间'))->help('结算类型的创建时间');
        //$grid->column('updated_at', __('Updated at'));

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
        $show = new Show(TradeType::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('trade_type', __('Trade type'));
        $show->field('card_type', __('Card type'));
        $show->field('trade_code', __('Trade code'));
        $show->field('is_top', __('Is top'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new TradeType());

        $form->text('name', __('交易名称'));

        $form->checkbox('trade_type', __('交易标识'))->options([
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
        
        $form->checkbox('card_type', __('交易卡类型'))->options([ 0 => '借记卡', 1 => '信用卡']);

        $form->radio('is_top', __('是否封顶'))->options([ 0 => '非封顶', 1 => '封顶'])->required();

        $form->checkbox('trade_code', __('手续费计算类型'))->options([
            'Y' => '优惠', 
            'M' => '减免',
            'B' => '标准',
            'YN'=> '云闪付NFC',
            'YM'=> '云闪付双免'
        ]);

        return $form;
    }
}
