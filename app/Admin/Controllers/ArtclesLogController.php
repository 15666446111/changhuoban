<?php

namespace App\Admin\Controllers;

use App\Articles_log;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ArtclesLogController extends AdminController
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
        $grid = new Grid(new Articles_log());

        $grid->column('id', __('索引'));
        $grid->column('username', __('操作用户'));
        $grid->column('articles_id', __('文章id'));
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
        $show = new Show(Articles_log::findOrFail($id));

        $show->field('id', __('索引'));
        $show->field('username', __('操作用户'));
        $show->field('articles_id', __('文章id'));
        $show->field('type', __('操作类型'));
        $show->field('before_back', __('修改前'));
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
        $form = new Form(new Articles_log());

        $form->text('username', __('Username'));
        $form->number('articles_id', __('Articles id'));
        $form->text('type', __('Type'));
        $form->text('before_back', __('Before back'));
        $form->textarea('put', __('Put'));

        return $form;
    }
}
