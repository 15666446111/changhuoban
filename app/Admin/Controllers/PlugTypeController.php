<?php

namespace App\Admin\Controllers;

use App\PlugType;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PlugTypeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '轮播图类型';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PlugType());

        $grid->column('id', __('索引'))->sortable();
        $grid->column('name', __('类型'));
        $grid->column('active', __('状态'))->sortable()->switch();
        $grid->column('created_at', __('创建时间'))->date('Y-m-d H:i:s');
        $grid->column('updated_at', __('修改时间'))->date('Y-m-d H:i:s');

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();


            $filter->column(1/4, function ($filter) {
                $filter->like('name', '类型');
                
            });
            // 在这里添加字段过滤器
            

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
        $show = new Show(PlugType::findOrFail($id));

        $show->field('name', __('类型'));

        $show->field('active', __('状态'));

        $show->field('created_at', __('创建时间'));

        $show->field('updated_at', __('修改时间'));

        /* 展示该驾校的订单 */
        $show->plugs('订单信息', function ($plugs) {

            $plugs->model()->latest();

            $plugs->id('索引')->sortable();

            $plugs->name('标题');

            $plugs->active('状态')->switch();

            $plugs->sort('排序')->sortable();

            $plugs->href('链接')->link()->copyable();

            $plugs->disableCreateButton();

            $plugs->actions(function ($actions) {
                // 去掉删除
                $actions->disableDelete();
                // 去掉编辑
                $actions->disableEdit();
            });
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
        $form = new Form(new PlugType());

        $form->text('name', __('类型'));

        $form->switch('active', __('开启'))->default(1);

        return $form;
    }
}
