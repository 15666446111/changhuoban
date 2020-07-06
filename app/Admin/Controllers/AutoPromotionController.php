<?php

namespace App\Admin\Controllers;

use App\AutoPromotion;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\AdminController;

class AutoPromotionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '自动晋升管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AutoPromotion());

        if(Admin::user()->operate != "All"){
            $grid->model()->where('operate', Admin::user()->operate);
        }

        //$grid->column('id', __('Id'));
        //$grid->column('operate', __('Operate'));
        $grid->column('groups.name', __('用户组'));
        $grid->column('trade_count', __('月交易量'))->editable();
        $grid->column('created_at', __('创建时间'));
        //$grid->column('updated_at', __('Updated at'));

        $grid->disableCreateButton();

        $grid->actions(function (Grid\Displayers\Actions $actions) {

            $actions->disableEdit();

            $actions->disableDelete();

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
        $show = new Show(AutoPromotion::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('operate', __('Operate'));
        $show->field('group_id', __('Group id'));
        $show->field('trade_count', __('Trade count'));
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
        $form = new Form(new AutoPromotion());

        $form->text('operate', __('Operate'));
        $form->number('group_id', __('Group id'));
        $form->number('trade_count', __('Trade count'));

        return $form;
    }
}
