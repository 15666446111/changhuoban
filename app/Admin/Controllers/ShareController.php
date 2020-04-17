<?php

namespace App\Admin\Controllers;

use App\Share;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ShareController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '分享列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Share());

        $grid->column('id', __('索引'))->sortable();

        $grid->column('title', __('标题'));

        $grid->column('active', __('状态'))->switch()->sortable();

        $grid->column('images', __('图片'));

        $grid->column('share_types.name', __('类型'));

        $grid->column('sort', __('排序'))->sortable();

        $grid->column('code_size', __('二维码大小'));

        $grid->column('code_x', __('X轴位置'));

        $grid->column('code_y', __('Y轴位置'));

        $grid->column('created_at', __('创建时间'))->date('Y-m-d H:i:s');

        $grid->column('updated_at', __('修改时间'))->date('Y-m-d H:i:s');

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->column(1/4, function ($filter) {
                $filter->like('name', '标题');
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
        $show = new Show(Share::findOrFail($id));

        $show->field('title', __('标题'));

        $show->field('active', __('状态'));

        $show->field('images', __('图片'));

        $show->field('type_id', __('类型'));

        $show->field('sort', __('排序'));

        $show->field('code_size', __('二维码大小'));

        $show->field('code_x', __('X轴位置'));

        $show->field('code_y', __('Y轴位置'));

        $show->field('created_at', __('创建时间'));

        $show->field('updated_at', __('修改时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Share());

        $form->text('title', __('标题'));

        $form->switch('active', __('状态'))->default(1);

        $form->image('images', __('图片'));

        $form->select('type_id', __('类型'))->options('/getShareType');

        $form->number('sort', __('排序'))->default(0)->help('数值越大,越靠前');

        $form->number('code_size', __('二维码大小'))->default(100);

        $form->number('code_x', __('X轴位置'))->default(100);

        $form->number('code_y', __('Y轴位置'))->default(100);

        return $form;
    }
}
