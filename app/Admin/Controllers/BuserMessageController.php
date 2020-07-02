<?php

namespace App\Admin\Controllers;

use App\BuserMessage;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BuserMessageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '消息通知';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new BuserMessage());

        $grid->column('id', __('索引'));
        $grid->column('user_id', __('会员'));
        $grid->column('type', __('类型'));
        $grid->column('is_read', __('已读'))->using([ '0' => '未读', '1' => '已读'])
            ->dot([ 0 => 'danger', 1 => 'success' ], 'default');
        $grid->column('title', __('标题'));
        $grid->column('message_text', __('内容'));
        $grid->column('send_plat', __('发送方'));
        $grid->column('created_at', __('创建时间'));

        $grid->disableCreateButton();
        
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
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
        $show = new Show(BuserMessage::findOrFail($id));

        $show->field('id', __('索引'));
        $show->field('user_id', __('会员'));
        $show->field('type', __('类型'));
        $show->field('is_read', __('已读'))->using([0 => '未读', 1 => '已读']);
        $show->field('title', __('标题'));
        $show->field('message_text', __('内容'));
        $show->field('send_plat', __('发送方'));
        $show->field('created_at', __('创建时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new BuserMessage());

        $form->number('user_id', __('User id'));
        $form->text('type', __('Type'))->default('other');
        $form->switch('is_read', __('Is read'));
        $form->text('title', __('Title'));
        $form->textarea('message_text', __('Message text'));
        $form->text('send_plat', __('Send plat'))->default('系统发送');

        return $form;
    }
}
