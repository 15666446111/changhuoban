<?php

namespace App\Admin\Controllers;

use App\PolicyGroupRate;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PolicyGroupRateController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'PolicyGroupRate';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PolicyGroupRate());

        $grid->column('id', __('Id'));
        $grid->column('policy_group_id', __('Policy group id'));
        $grid->column('rate_type_id', __('Rate type id'));
        $grid->column('min_rate', __('Min rate'));
        $grid->column('max_rate', __('Max rate'));
        $grid->column('is_abjustable', __('Is abjustable'));
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
        $show = new Show(PolicyGroupRate::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('policy_group_id', __('Policy group id'));
        $show->field('rate_type_id', __('Rate type id'));
        $show->field('min_rate', __('Min rate'));
        $show->field('max_rate', __('Max rate'));
        $show->field('is_abjustable', __('Is abjustable'));
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
        $form = new Form(new PolicyGroupRate());

        $form->number('policy_group_id', __('Policy group id'));
        $form->number('rate_type_id', __('Rate type id'));
        $form->number('min_rate', __('Min rate'));
        $form->number('max_rate', __('Max rate'));
        $form->switch('is_abjustable', __('Is abjustable'))->default(0);

        return $form;
    }
}
