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
        $grid->column('operates.company', __('操盘方'))->help('该晋升标准的操盘方');
        //
        $grid->column('groups.name', __('用户组'))->help('要晋升的用户组');

        $grid->column('trade_count', __('月交易量(元)'))->editable()->help('考核的交易量');

        $grid->column('created_at', __('创建时间'))->help('考核标准创建时间');
        //$grid->column('updated_at', __('Updated at'));

        $grid->disableCreateButton();

        $grid->actions(function (Grid\Displayers\Actions $actions) {

            $actions->disableEdit();

            $actions->disableDelete();

        });

        $grid->header(function ($query) {
            return '<code>自动晋升标准说明: 系统会在每月1号进行交易量检测, 交易检测日的上一月月初与月末的交易量满足对应的用户组标准,交易检测月按照对应用户组晋升, 最低为C1</code>';
        });

        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            if(Admin::user()->operate == "All"){
                $filter->column(1/3, function ($filter) {
                    $filter->equal('operate', '操盘方')->select(\App\AdminSetting::where('type', 1)->where('pattern', 1)->pluck('company', 'operate_number as id'));
                });
            }

        });

        $grid->paginate(10);

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
