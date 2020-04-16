<?php

namespace App\Admin\Controllers;

use App\Plug;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PlugController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '轮播列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Plug());

        $grid->column('id', __('索引'))->sortable();

        $grid->column('name', __('标题'));

        $grid->column('active', __('状态'))->sortable()->switch();

        $grid->column('plug_types.name', __('类型'));
        
        $grid->column('images', __('图片'));
        
        $grid->column('sort', __('排序'))->sortable();
        
        $grid->column('href', __('链接'))->link();
        
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
        $show = new Show(Plug::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('active', __('Active'));
        $show->field('type_id', __('Type id'));
        $show->field('images', __('Images'));
        $show->field('sort', __('Sort'));
        $show->field('href', __('Href'));
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
        $form = new Form(new Plug());

        $form->text('name', __('Name'));
        $form->switch('active', __('Active'))->default(1);
        $form->number('type_id', __('Type id'));
        $form->text('images', __('Images'));
        $form->number('sort', __('Sort'))->default(0);
        $form->text('href', __('Href'))->default('#');

        return $form;
    }
}
