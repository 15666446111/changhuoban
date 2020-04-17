<?php

namespace App\Admin\Controllers;

use App\ShareType;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ShareTypeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '分享类型';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ShareType());

        $grid->column('id', __('索引'))->sortable();

        $grid->column('name', __('类型'));

        $grid->column('active', __('状态'))->switch()->sortable();

        $grid->column('created_at', __('创建时间'))->date('Y-m-d H:i:s');

        $grid->column('updated_at', __('删除时间'))->date('Y-m-d H:i:s');

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
        $show = new Show(ShareType::findOrFail($id));

        $show->field('name', __('类型'));

        $show->field('active', __('状态'));

        $show->field('created_at', __('创建时间'));

        $show->field('updated_at', __('修改时间'));

        /* 展示该驾校的订单 */
        $show->shares('订单信息', function ($shares) {

            $shares->model()->latest();

            $shares->id('索引')->sortable();

            $shares->title('标题');

            $shares->active('状态')->switch();

            $shares->sort('排序')->sortable();

            $shares->code_size('二维码大小');

            $shares->code_x('X轴位置');

            $shares->code_y('Y轴位置');

            $shares->disableCreateButton();

            $shares->actions(function ($actions) {
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
        $form = new Form(new ShareType());

        $form->text('name', __('类型'));

        $form->switch('active', __('状态'))->default(1);

        return $form;
    }
}
