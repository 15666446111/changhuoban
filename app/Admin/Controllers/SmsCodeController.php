<?php

namespace App\Admin\Controllers;

use App\SmsCode;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SmsCodeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '验证码信息';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SmsCode());

        $grid->column('id', __('索引'));
        $grid->column('phone', __('发送手机'))->help('发送验证码的手机号');
        $grid->column('code', __('验证码'))->help('接收到的验证码');
        $grid->column('is_use', __('是否使用'))->switch()->help('验证码是否使用');
        $grid->column('send_time', __('发送时间'))->help('发送验证码的时间');
        $grid->column('out_time', __('失效时间'))->help('验证码最迟失效时间');
        $grid->column('created_at', __('创建时间'))->help('信息创建时间');
        $grid->column('updated_at', __('使用时间'))->help('验证码使用或失效时间');

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
        $show = new Show(SmsCode::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('phone', __('Phone'));
        $show->field('code', __('Code'));
        $show->field('is_use', __('Is use'));
        $show->field('send_time', __('Send time'));
        $show->field('out_time', __('Out time'));
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
        $form = new Form(new SmsCode());

        $form->mobile('phone', __('Phone'));
        $form->text('code', __('Code'));
        $form->switch('is_use', __('Is use'));
        $form->datetime('send_time', __('Send time'))->default(date('Y-m-d H:i:s'));
        $form->datetime('out_time', __('Out time'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
