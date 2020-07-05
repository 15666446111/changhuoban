<?php

namespace App\Admin\Controllers;

use App\Order;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use App\Admin\Actions\OrderRegis;
use App\Admin\Actions\OrderTracking;

class OrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '订单管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order());

        if(Admin::user()->operate != "All"){

            $grid->model()->where('operate', Admin::user()->operate);
            
        }

        $grid->model()->latest();

        //$grid->column('id', __('索引'));
        $grid->column('order_no', __('订单编号'));
        $grid->column('users.nickname', __('下单会员'));
        $grid->column('products.title', __('订单产品'));
        $grid->column('product_price', __('产品单价'))->display(function($amount){
            return number_format($amount / 100, 2, '.', ',');
        })->label();
        $grid->column('numbers', __('订单数量'));
        $grid->column('price', __('订单价格'))->display(function($amount){
            return number_format($amount / 100, 2, '.', ',');
        })->label("info");
        $grid->column('address', __('配送地址'));
        $grid->column('status', __('订单状态'))->using(['0' => '未支付', '1' => '已支付']);
        $grid->column('remark', __('订单备注'));
        $grid->column('tracking_status', __('物流状态'))->using(['0' => '未发货', '1' => '已发货']);
        $grid->column('tracking_num', __('物流单号'));
        $grid->column('created_at', __('创建时间'));
        
        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
 
            //关闭行操作 删除 
            $actions->disableDelete();
            

            if($actions->row['tracking_status'] == '1'){

                $actions->add(new OrderTracking());

            }else{
                
                $actions->add(new OrderRegis());

            }

           
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
        $show = new Show(Order::findOrFail($id));

        if(Admin::user()->operate != "All"){
            $model = Order::where('id', $id)->first();
            if($model->operate != Admin::user()->operate) return abort('403');        
        }

        $show->field('order_no', __('订单编号'));
        $show->field('user_id', __('下单会员'));
        $show->field('product_id', __('订单产品'));
        $show->field('product_price', __('产品单价'));
        $show->field('numbers', __('订单数量'));
        $show->field('price', __('订单价格'));
        $show->field('address', __('配送地址'));
        $show->field('status', __('订单状态'));
        $show->field('remark', __('订单备注'));
        $show->field('created_at', __('创建时间'));
        $show->field('tracking_num', __('物流单号'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Order());

        $form->text('order_no', __('订单编号'));
        $form->text('user_id', __('下单会员'));
        $form->text('product_id', __('订单产品'));
        $form->text('product_price', __('产品单价'));
        $form->text('numbers', __('订单数量'));
        $form->text('price', __('订单价格'));
        $form->text('address', __('配送地址'));
        $form->text('status', __('订单状态'));
        $form->text('remark', __('订单备注'));

        return $form;
    }

}
