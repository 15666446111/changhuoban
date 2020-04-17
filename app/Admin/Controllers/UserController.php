<?php

namespace App\Admin\Controllers;

use App\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '代理用户';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('索引'))->sortable();

        $grid->column('nickname', __('昵称'));

        $grid->column('account', __('账号'));

        $grid->column('avatar', __('头像'));
        
        $grid->column('user_group', __('用户组'));

        $grid->column('parent', __('父级'));

        $grid->column('active', __('状态'));

        $grid->column('last_ip', __('最后登录地址'));

        $grid->column('last_time', __('最后登录时间'));

        $grid->column('created_at', __('创建时间'))->date('Y-m-d H:i:s');
        $grid->column('updated_at', __('修改时间'))->date('Y-m-d H:i:s');

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
        $show = new Show(User::findOrFail($id));

        $show->field('nickname', __('昵称'));
        $show->field('account', __('账号'));
        $show->field('avatar', __('头像'));
        $show->field('user_group', __('用户组'));
        $show->field('parent', __('上级'));
        $show->field('active', __('状态'));
        $show->field('last_ip', __('最后登录地址'));
        $show->field('last_time', __('最后登录时间'));
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
        $form = new Form(new User());

        $form->text('nickname', __('昵称'));

        $form->text('account', __('账号'));

        $form->image('avatar', __('头像'))->default('images/avatar.png');

        $form->password('password', __('密码'));

        $form->number('user_group', __('用户组'))->default(1);

        $form->number('parent', __('上级'))->default(0);

        $form->switch('active', __('状态'))->default(1);

        $form->text('last_ip', __('最后登录IP'));

        $form->datetime('last_time', __('最后登录时间'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
