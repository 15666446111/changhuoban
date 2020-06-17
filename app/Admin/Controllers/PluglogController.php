<?php

namespace App\Admin\Controllers;

use App\Pluglog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PluglogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '操作日志';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Pluglog());

        $grid->column('id', __('索引'));
        $grid->column('username', __('操作用户'));
        $grid->column('plug_id', __('轮播图id'));
        $grid->column('type', __('操作类型'));
        $grid->column('before_back', __('修改前'));
        $grid->column('put', __('操作'));
        $grid->column('created_at', __('操作时间'));
        
        $grid->actions(function ($actions) {

            // 去掉删除
            $actions->disableDelete();
        
            // 去掉编辑
            $actions->disableEdit();
        
        });

        $grid->disableCreateButton();

        $grid->batchActions(function ($batch) {
            $batch->disableDelete();
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
        $show = new Show(Pluglog::findOrFail($id));

        $show->field('id', __('索引'));
        $grid->field('username', __('操作用户'));
        $show->field('plug_id', __('轮播图id'));
        $show->field('type', __('操作类型'));
        $grid->field('before_back', __('修改前'));
        $show->field('put', __('操作'));
        $show->field('created_at', __('操作时间'));

        $show->panel()->tools(function ($tools) {

            $tools->disableDelete();

            $tools->disableEdit();
            
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
        $form = new Form(new Pluglog());

        $form->number('plug_id', __('Plug id'));
        $form->textarea('put', __('Put'));
        $form->text('type', __('Type'));

        return $form;
    }
}
