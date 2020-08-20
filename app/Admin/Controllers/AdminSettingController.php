<?php

namespace App\Admin\Controllers;

use Route;
use App\AdminSetting;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\MessageBag;
use Illuminate\Database\Eloquent\Collection;
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

        $grid->model()->collection(function (Collection $collection) {

            // 1. 统计会员信息
            foreach($collection as $item) {
                $item->count_user = number_format($item->users->count())."人";
            }

            // 最后一定要返回集合对象
            return $collection;
        });


        $grid->column('operate_number', __('机构/操盘号'))->help('此列为机构/操盘方的唯一标识,代表此机构或操盘在本系统的标准');

        $grid->column('open', __('状态'))->using([ 0 =>'禁止', 1 =>'正常' ], '未知')->dot([ 0 => 'danger', 1 => 'success' ], 'default')->help('操盘或者机构的状态,若禁止 则此操盘或机构下的所有用户都无法登陆app');

        $grid->column('type', __('类型'))->using([ 1 =>'操盘方', 2 =>'机构方' ])->dot([ 1 => 'primary', 2 => 'success' ])->help('此主体的类型, 操盘或者机构');

        $grid->column('pattern', __('模式'))->using([ 1 =>'联盟模式', 2 =>'工具模式' ])->dot([ 1 => 'primary', 2 => 'success' ])->help('操盘方发展的模式,只有主体为操盘方时有效');

        $grid->column('count_user', __('用户统计'))->label('success')->help('该操盘下发展的用户总计.');

        $grid->column('company', __('公司'))->help('操盘方或者机构方的公司主体');

        $grid->column('phone', __('联系电话'))->help('操盘方或者机构方负责人联系电话');

        $grid->column('email', __('公司邮箱'))->help('操盘方或者机构方联系邮箱,发送统计报表,信息等');

        $grid->column('address', __('公司地址'))->help('操盘方或者机构方公司地址');

        $grid->column('created_at', __('开通时间'))->help('操盘方或者机构方在本平台的入驻时间');

        $grid->disableCreateButton(false);

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->column(1/4, function ($filter) {
                $filter->like('company', '主体');
            });

            $filter->column(1/4, function ($filter) {
                $filter->like('company', '公司');
            });

            $filter->column(1/4, function ($filter) {
                $filter->equal('type', '类型')->select(['1' => '操盘', '2' => '机构']);
            });
            
            $filter->column(1/4, function ($filter) {
                $filter->equal('pattern', '模式')->select(['1' => '联盟模式', '2' => '工具模式']);
            });
                
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
        $show = new Show(AdminSetting::findOrFail($id));

        $show->field('operate_number', __('操盘序号'));

        $show->field('company', __('公司名称'));

        $show->field('phone', __('联系电话'));

        $show->field('email', __('联系邮箱'));

        $show->field('address', __('联系地址'));

        $show->field('created_at', __('入驻时间'));

        $show->divider();
        $show->divider();

        $show->field('open', __('机构状态'));

        /*$show->field('alipay_id',   __('支付宝APP_ID'));
        $show->field('alipay_sec',  __('支付宝密钥'));
        $show->field('alipay_sign', __('支付宝签名'));
        $show->field('alipay_sign', __('支付宝签名'));*/

        $show->divider();
        $show->divider();

        /*$show->field('wx_id', __('Wx id'));
        $show->field('wx_sec', __('Wx sec'));
        $show->field('wx_sign', __('Wx sign'));*/
        

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

        $host = explode('/',Route::getFacadeRoot()->current()->uri);
    
        $no     = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);

        $form->tab('基础信息', function ($form) use ($no, $host) {

            $form->text('operate_number', __('机构/操盘号'))->value($no)->readonly()->help('由系统自动生成,不可更改');

            $form->text('company', __('公司名称'))->required()->help('操盘方/机构方的公司名称, 必填');
            $form->mobile('phone', __('联系电话'));
            $form->email('email', __('公司邮箱'));
            $form->text('address', __('公司地址'));

            if( empty($host[3])){

                $form->text('account', __('登陆账号'))->required()->help('机构使用此账号登陆后台,操盘使用此账号登陆后台与app');
            
                $form->password('password', __('登陆密码'))->required()->help('密码最少6位,数字与字母的组合');

            }

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

                    /**
                     * @version [<vector>] [< 如果是操盘方的联盟模式 创建用户组的晋升标准>]
                     */
                    if($form->pattern == "1"){
                        $group = \App\UserGroup::get();
                        foreach ($group as $key => $value) {
                            \App\AutoPromotion::create([ 'operate'=> $form->operate_number, 'group_id'=> $value->id]);
                        }
                    }
                }

            }
        });

        return $form;
    }
}
