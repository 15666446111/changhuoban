<?php

namespace App\Admin\Controllers;

use App\Holiday;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Controllers\AdminController;

class HolidayController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '节假日管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Holiday());

        $grid->column('id', __('索引'))->sortable();
        $grid->column('title', __('标题'))->help('节日标题');
        $grid->column('start_time', __('开始时间'))->help('节日开始时间');
        $grid->column('end_time', __('结束时间'))->help('节日结束时间');
        $grid->column('created_at', __('创建时间'))->help('节日信息的创建时间');
        $grid->column('updated_at', __('修改时间'))->help('节日信息的最后修改时间');

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->column(1/4, function ($filter) {
                $filter->like('title', '标题');
            });
        });

        $grid->header(function ($query) {
            return '<code>节假日日期内, 审核提现时 畅捷代付/畅伙伴 代付将不扣除单笔提现手续费!(必须为国家法定节假日日期)</code>';
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
        $show = new Show(Holiday::findOrFail($id));

        $show->field('title', __('节日标题'));
        $show->field('start_time', __('开始时间e'));
        $show->field('end_time', __('结束时间'));
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
        $form = new Form(new Holiday());

        $form->text('title', __('节假日标题'));
        $form->datetime('start_time', __('开始时间'))->default(date('Y-m-d H:i:s'));
        $form->datetime('end_time', __('结束时间'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
