<?php

namespace App\Admin\Controllers;

use App\Setting;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SettingController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '操盘设置';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Setting());

        $grid->column('operate', __('操盘方'));
        $grid->column('created_at', __('创建时间'));


        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();
        });
        
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
        $show = new Show(Setting::findOrFail($id));

        $show->field('operate', __('操盘方'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('修改时间'));

        $show->panel()->tools(function ($tools) {
            $tools->disableDelete();
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
        $form = new Form(new Setting());

        $form->text('operate', __('操盘方'))->readonly();

        return $form;
    }
}
