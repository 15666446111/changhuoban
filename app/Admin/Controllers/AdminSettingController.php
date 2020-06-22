<?php

namespace App\Admin\Controllers;

use App\AdminSetting;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Controllers\AdminController;

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

        $grid->column('open', __('状态'))->using([ 0 => '禁止', 1 => '正常' ], '未知')->dot([ 0 => 'danger', 1 => 'success' ], 'default');

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
        $form   = new Form(new AdminSetting());

        $no     = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);

        $form->tab('基础信息', function ($form) use ($no) {

            $form->text('operate_number', __('机构/操盘号'))->value($no)->readonly();
            $form->text('company', __('公司名称'))->required();
            $form->mobile('phone', __('联系电话'));
            $form->email('email', __('公司邮箱'));
            $form->text('address', __('公司地址'));

            $form->radioButton('type', '操盘/机构')->options([ 1 => '操盘方', 2 => '机构方' ])->when(2,function (Form $form) { 

                $form->listbox('sons', __('包含操盘'))->options([1 => 'foo', 2 => 'bar', 'val' => 'Option name']);

            })->default(1);

        })->tab('扩展设置', function ($form) {

            $form->radioButton('open', __('活动状态'))->options([ 1 => '正常',2 => '禁止' ])->default(1)->help('禁止后,此机构和操盘下所有账户均不可登陆');

            $form->text('remark', __('禁止说明'))->help('禁止后,所有账户登陆提示此信息');

            $form->radioButton('pattern', __('发展模式'))->options([ 1 => '联盟模式', 2 => '工具模式' ])->default(1)->help('选择后,此项不可再变更');

            $form->url('register_merchant', __('商户注册'))->help('商户注册的外部链接');

            $form->text('system_merchant', __('机构编号'))->help('3.0系统的机构编号');

            $form->text('system_secret', __('渠道密钥'))->help('3.0系统的渠道密钥');


        })->tab('支付设置', function ($form) {

            $form->text('alipay_id', __('支付宝应用ID'));
            $form->text('alipay_sec', __('支付宝密钥'));
            $form->text('alipay_sign', __('支付宝签名串'));

            $form->text('wx_id', __('微信应用ID'));
            $form->text('wx_sec', __('微信密钥'));
            $form->text('wx_sign', __('微信签名串'));

        })->tab('短信设置', function ($form) {


        })->tab('代付设置', function ($form) {

            $form->radioButton('payment_type', __('代付模式'))->options([ 1 => '畅伙伴', 2 => '畅捷支付' ])->default(1);

            $form->text('payment_merchant', __('代付商户'));

            $form->text('payment_secret', __('代付密钥'));

        });




        return $form;
    }
}
