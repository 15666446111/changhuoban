<?php

namespace App\Admin\Controllers;

use App\PolicyGroupSettlement;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PolicyGroupSettlementController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '活动对应用户组结算价';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PolicyGroupSettlement());

        $grid->column('id', __('索引'));
        $grid->column('policy_group_id', __('Policy group id'));
        $grid->column('trade_type_id', __('Trade type id'));
        $grid->column('set_price', __('Set price'));
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
        $show = new Show(PolicyGroupSettlement::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('policy_group_id', __('Policy group id'));
        $show->field('trade_type_id', __('Trade type id'));
        $show->field('set_price', __('Set price'));
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
        $form = new Form(new PolicyGroupSettlement());

        $form->text('policy_group_id', __('Policy group id'));
        $form->text('trade_type_id', __('Trade type id'));
        $form->number('set_price', __('Set price'));

        $form->number('default_price', __('Default price'));
        $form->number('min_price', __('Min price'));

        return $form;
    }
}
