<?php

namespace App\Admin\Controllers;

use App\Brand;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BrandController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Brand';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Brand());

        $grid->column('brand_name', __('品牌名称'));

        $grid->column('active', __('状态'))->sortable()->switch();
        
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
        $show = new Show(Brand::findOrFail($id));

        $show->field('brand_name', __('品牌名称'));
        $show->field('active', __('品牌状态'))->using([0 => '关闭', 1 => '开启'])->label('info');
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('修改时间'));


        // $show->merchants('机具列表', function ($merchants) {

        //     $merchants->setResource('/admin/merchants');
            
        //     $merchants->model()->latest();
            
        //     $merchants->id('索引')->sortable();

        //     $merchants->column('busers.nickname', __('归属会员'));

        //     $merchants->column('merchant_terminal', __('终端编号'));

        //     $merchants->column('merchant_sn', __('终端SN'));

        //     $merchants->column('policys.title', __('政策活动'));

        //     $merchants->column('merchant_number', __('商户编号'));

        //     $merchants->column('merchant_name', __('商户名称'));

        //     $merchants->column('user_phone', __('电话号码'));

        //     $merchants->column('bind_status', __('绑定'))->bool();

        //     $merchants->column('bind_time', __('绑定时间'));

        //     $merchants->column('active_status', __('激活'))->bool();

        //     $merchants->column('active_time', __('激活时间'));

        //     $merchants->created_at('创建时间')->date('Y-m-d H:i:s');

        //     $merchants->filter(function ($filter) {
        //         // 去掉默认的id过滤器
        //         $filter->disableIdFilter();

        //         $filter->column(1/3, function ($filter) {
        //             $filter->like('merchant_terminal', '终端编号');
        //         });
        //         $filter->column(1/3, function ($filter) {
        //             $filter->like('merchant_name', '商户名称');
        //         });
        //         $filter->column(1/3, function ($filter) {
        //             $filter->equal('bind_status', '商户名称')->select(['0' => '未绑定', '1' => '已绑定']);
        //         });

        //     });

        //     $merchants->actions(function ($actions) {
        //         // 去掉删除 编辑
        //         $actions->disableDelete();
        //         $actions->disableEdit();
        //     });

        //     $merchants->batchActions(function ($batch) {
        //         $batch->disableDelete();
        //     });

        // });


        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Brand());

        $form->text('brand_name', __('品牌名称'));
        $form->switch('active', __('品牌状态'))->default(1);

        return $form;
    }
}
