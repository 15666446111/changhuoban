<?php

namespace App\Admin\Controllers;

use App\AdminSetting;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AdminSettingController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '机构与操盘';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AdminSetting());

        $grid->column('operate_number', __('机构/操盘号'));

        $grid->column('company', __('公司'));

        $grid->column('phone', __('联系电话'));

        $grid->column('email', __('公司邮箱'));

        $grid->column('address', __('公司地址'));

        $grid->column('created_at', __('开通时间'));

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
        $show = new Show(AdminSetting::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('operate_number', __('Operate number'));
        $show->field('company', __('Company'));
        $show->field('phone', __('Phone'));
        $show->field('email', __('Email'));
        $show->field('address', __('Address'));
        $show->field('alipay_id', __('Alipay id'));
        $show->field('alipay_sec', __('Alipay sec'));
        $show->field('alipay_sign', __('Alipay sign'));
        $show->field('wx_id', __('Wx id'));
        $show->field('wx_sec', __('Wx sec'));
        $show->field('wx_sign', __('Wx sign'));
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
        $form = new Form(new AdminSetting());

        $form->tab('基础信息', function ($form) {

            $form->text('operate_number', __('机构/操盘号'))->value('111')->readonly();
            $form->text('company', __('公司名称'));
            $form->mobile('phone', __('联系电话'));
            $form->email('email', __('公司邮箱'));
            $form->text('address', __('公司地址'));

            $form->radioButton('type', '操盘/机构')->options([ 1 => '操盘方', 2 => '机构方' ])->when(2,function (Form $form) { 

                $form->listbox('sons', __('包含操盘'))->options([1 => 'foo', 2 => 'bar', 'val' => 'Option name']);

            })->default(1);

        })->tab('支付设置', function ($form) {

            $form->text('alipay_id', __('支付宝应用ID'));
            $form->text('alipay_sec', __('支付宝密钥'));
            $form->text('alipay_sign', __('支付宝签名串'));

            $form->text('wx_id', __('微信应用ID'));
            $form->text('wx_sec', __('微信密钥'));
            $form->text('wx_sign', __('微信签名串'));

        })->tab('短信设置', function ($form) {

            $form->text('alipay_id', __('支付宝应用ID'));
            $form->text('alipay_sec', __('支付宝密钥'));
            $form->text('alipay_sign', __('支付宝签名串'));

        });




        return $form;
    }
}
