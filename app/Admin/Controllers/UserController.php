<?php

namespace App\Admin\Controllers;

use App\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\AdminController;

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

        //$grid->column('id', __('索引'))->sortable();

        if(Admin::user()->operate != "All"){
            $grid->model()->where('operate', Admin::user()->operate);
        }

        $grid->model()->latest();

        $grid->column('avatar', __('头像'))->image('', 30, 30);

        $grid->column('nickname', __('昵称'))->copyable();

        $grid->column('account', __('账号'))->copyable();

        $grid->column('group.name', __('用户组'));

        $grid->column('parent', __('父级'));

        $grid->column('active', __('状态'))->switch();

        $grid->column('wallets.cash_blance', __('分润余额'))->display(function( $cash){
            return number_format( $cash , 2, '.', ',');
        })->label();

        $grid->column('wallets.return_blance', __('返现余额'))->display(function($cash){
            return number_format($cash , 2, '.', ',');
        })->label('info');

        $grid->column('last_ip', __('最后登录地址'));

        $grid->column('last_time', __('最后登录时间'))->sortable();

        $grid->column('created_at', __('创建时间'))->date('Y-m-d H:i:s');

        //$grid->column('updated_at', __('修改时间'))->date('Y-m-d H:i:s');
        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            // 去掉删除  编辑
            $actions->disableDelete();
            $actions->disableEdit();
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

        $show = new Show(User::findOrFail($id));

        /**
         * @version [<vector>] [< 如果当前登录的为操盘方 检查当前分享图是否属于此操盘方>]
         */
        if(Admin::user()->operate != "All"){
            $model = User::where('id', $id)->first();
            if($model->operate != Admin::user()->operate) return abort('403');        
        }

        $show->field('nickname', __('昵称'));

        $show->field('account', __('账号'));

        $show->field('avatar', __('头像'))->image();

        $show->field('parent', __('上级'));

        $show->field('active', __('状态'))->using([0 => '关闭', 1 => '开启'])->label('info');

        $show->field('last_ip', __('最后登录地址'));

        $show->field('last_time', __('最后登录时间'));

        $show->field('created_at', __('创建时间'));

        //$show->field('updated_at', __('修改时间'));
        //
        $show->group('用户组信息', function ($group) {

            $group->name('用户组');

            $group->panel()->tools(function ($tools) {
                $tools->disableEdit();
                $tools->disableList();
                $tools->disableDelete();
            });
        });


        $show->wallets('用户钱包信息', function ($wallet) {

            $wallet->cash_blance('分润余额')->as(function ($blance) {
                return number_format($blance / 100, 2);
            })->label('success');

            $wallet->return_blance('返现余额')->as(function ($total_fee) {
                return number_format($total_fee / 100, 2);
            })->label('info');

            $wallet->panel()->tools(function ($tools) {
                $tools->disableEdit();
                $tools->disableList();
                $tools->disableDelete();
            });
        });

        $show->realname('实名信息', function ($realname) {

            $realname->status('实名状态')->label('success');

            $realname->name('姓名');

            $realname->idcard('身份证号');

            $realname->card_before('身份证正面')->image();

            $realname->card_after('身份证反面')->image();

            $realname->panel()->tools(function ($tools) {
                $tools->disableEdit();
                $tools->disableList();
                $tools->disableDelete();
            });

        });

        $show->panel()->tools(function ($tools) {
            $tools->disableEdit();
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
        $form = new Form(new User());

        $form->text('nickname', __('昵称'));

        $form->text('account', __('账号'));

        $form->image('avatar', __('头像'))->default('images/avatar.png')->uniqueName();

        $form->password('password', __('密码'));

        $form->number('user_group', __('用户组'))->default(1);

        $form->number('parent', __('上级'))->default(0);

        $form->switch('active', __('状态'))->default(1);

        $form->text('last_ip', __('最后登录IP'));

        $form->datetime('last_time', __('最后登录时间'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
