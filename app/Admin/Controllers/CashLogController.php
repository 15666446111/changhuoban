<?php

namespace App\Admin\Controllers;

use App\CashsLog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CashLogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\CashsLog';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CashsLog());

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('User id'));
        $grid->column('machine_id', __('Machine id'));
        $grid->column('trade_id', __('Trade id'));
        $grid->column('money', __('Money'));
        $grid->column('is_run', __('Is run'));
        $grid->column('type', __('Type'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(CashsLog::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('machine_id', __('Machine id'));
        $show->field('trade_id', __('Trade id'));
        $show->field('money', __('Money'));
        $show->field('is_run', __('Is run'));
        $show->field('type', __('Type'));
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
        $form = new Form(new CashsLog());

        $form->number('user_id', __('User id'));
        $form->number('machine_id', __('Machine id'));
        $form->number('trade_id', __('Trade id'));
        $form->number('money', __('Money'));
        $form->switch('is_run', __('Is run'));
        $form->switch('type', __('Type'));

        return $form;
    }
}
