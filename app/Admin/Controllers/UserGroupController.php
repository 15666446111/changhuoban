<?php

namespace App\Admin\Controllers;

use App\UserGroup;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;

class UserGroupController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户组';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UserGroup());

        $grid->model()->latest();
        
        $grid->column('id', __('索引'))->sortable();

        $grid->column('name', __('组名称'))->help('用户组名称');

        $grid->column('level', __('级别'))->label('primary')->help('用户组级别, 由系统内置');

        $grid->disableCreateButton();
        // 全部关闭
        $grid->disableActions();
        
        $grid->disableCreateButton();

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
        if(Admin::user()->operate != "All"){
            $model = UserGroup::where('id', $id)->first();
            if($model->operate != UserGroup::user()->operate) return abort('403');        
        }
        $show = new Show(UserGroup::findOrFail($id));

        $show->field('name', __('组名称'));

        $show->field('level', __('组级别'));

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
        $form = new Form(new UserGroup());

        $form->text('name', __('组名称'));

        $form->number('level', __('级别'))->default(0)->help('越大级别越高,但必须唯一');

        $form->currency('trade_count', '满足交易')->symbol('￥');

        return $form;
    }
}
