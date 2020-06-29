<?php

namespace App\Admin\Controllers;

use App\Merchant;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\AdminController;

class MerchantController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商户管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Merchant());

        // 倒叙
        $grid->model()->latest();

        $grid->column('id', __('索引'));

        $grid->column('users.account', __('代理账号'));

        $grid->column('code', __('商户号'));

        $grid->column('name', __('商户名称'));

        $grid->column('phone', __('商户电话'));

        $grid->column('trade_amount', __('累计交易金额'));
                
        $grid->column('created_at', __('创建时间'));

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
        $show = new Show(Merchant::findOrFail($id));

        if (Admin::user()->operate != 'All') {
            $model = Merchant::where('id', $id)->first();
            if($model->operate != Admin::user()->operate) { return abort(403); }
        }

        $show->field('users.user_id', __('归属代理'));

        $show->field('code', __('商户号'));

        $show->field('name', __('商户名称'));

        $show->field('phone', __('商户电话'));

        $show->field('trade_amount', __('累计交易金额(元)'))->as(function($amount){

            return number_format($amount / 100, 2, '.', ',');

        });

        $show->field('state', __('状态'))->as(function($state){

            $arr = [ 0 => '无效', 1 => '有效', 2 => '注销' ];

            return $arr[$state];

        });

        $show->field('created_at', __('创建时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Merchant());

        $form->text('user_id', __('归属代理'));
        $form->text('code', __('商户号'));
        $form->text('name', __('商户名称'));
        $form->mobile('phone', __('商户电话'));
        $form->switch('activate_state', __('激活状态'))->default('0');

        return $form;
    }
}
