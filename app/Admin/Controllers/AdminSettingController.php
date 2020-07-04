<?php

namespace App\Admin\Controllers;

use App\AdminSetting;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\MessageBag;
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

        $grid->model()->latest();

        $grid->column('operate_number', __('机构/操盘号'));

        $grid->column('open', __('状态'))->using([ 0 =>'禁止', 1 =>'正常' ], '未知')->dot([ 0 => 'danger', 1 => 'success' ], 'default');

        $grid->column('type', __('模式'))->using([ 1 =>'联盟模式', 2 =>'操盘模式' ])->dot([ 1 => 'primary', 2 => 'success' ]);

        $grid->column('company', __('公司'));

        $grid->column('phone', __('联系电话'));

        $grid->column('email', __('公司邮箱'));

        $grid->column('address', __('公司地址'));

        $grid->column('created_at', __('开通时间'));

        $grid->disableCreateButton(false);

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

            $form->text('operate_number', __('机构/操盘号'))->value($no)->readonly()->help('由系统自动生成,不可更改');

            $form->text('company', __('公司名称'))->required()->help('操盘方/机构方的公司名称, 必填');
            $form->mobile('phone', __('联系电话'));
            $form->email('email', __('公司邮箱'));
            $form->text('address', __('公司地址'));

            $form->mobile('account', __('登陆账号'))->required()->help('机构使用此账号登陆后台,操盘使用此账号登陆后台与app');
            
            $form->password('password', __('登陆密码'))->required()->help('密码最少6位,数字与字母的组合');

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

        $form->ignore(['account', 'password']);
        

        //保存前回调
        $form->saving(function (Form $form) {
            /** @version  如果是新增的信息， 需要根据类型的不同， 创建不同的账号 */
            if($form->isCreating()){

                $account = \request('account');

                $password= \request('password');
                
                /**
                   @version 查询账户是否存在或使用
                 */
                $adminUser = \App\AdminUser::where('username', $account)->get();

                if(!$adminUser->isEmpty()){
                    $error = new MessageBag([ 'title'   => '新开机构/操盘失败', 'message' => '该账号已经存在' ]);
                    return back()->with(compact('error'));
                }

                // 根据选择的开户类型创建后台登陆账号 并且给与相应的权限
                $adminUser = \App\AdminUser::create([
                    'username'  =>  $account,
                    'password'  =>  bcrypt($password),
                    'name'      =>  $form->company,
                    'operate'   =>  $form->operate_number,
                    'type'      =>  $form->type == '1' ? 3 : 2,
                ]); 

                \App\AdminRoleUser::create([
                    'role_id'   =>$form->type == '1' ? 2 : 3,
                    'user_id'   =>$adminUser->id,
                ]);

                // 根据选择的类型 创建对应的前台账号。如果创建的是操盘方， 创建前台账号 并且 如果是联盟模式 , 该账号为最高级别用户组
                if($form->type == '1'){
                    \App\User::create([
                        'nickname'  =>  $account,
                        'account'   =>  $account,
                        'phone'     =>  $form->phone,
                        'password'  =>  "###" . md5(md5($password . 'v3ZF87bMUC5MK570QH')),
                        'user_group'=>  $form->pattern == "1" ? 10 : 1,
                        'operate'   =>  $form->operate_number,
                    ]);
                }

            }
        });

        return $form;
    }
}
