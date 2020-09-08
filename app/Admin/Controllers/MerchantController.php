<?php

namespace App\Admin\Controllers;

use App\Merchant;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\AdminController;

class MerchantController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商户管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Merchant());

        if(Admin::user()->operate != "All"){
            $grid->model()->where('operate', Admin::user()->operate);
        }
        
        // 倒叙
        $grid->model()->latest();

        //$grid->column('id', __('索引'));

        $grid->column('users.nickname', __('代理昵称'))->help('终端机具商户的所属代理昵称');

        $grid->column('users.account', __('代理账号'))->help('终端机具商户的所属代理账号');

        $grid->column('code', __('商户号'))->help('终端机具商户的商户号');

        $grid->column('name', __('商户名称'))->help('终端机具商户的商户名称');

        $grid->column('phone', __('商户电话'))->help('终端机具商户的商户电话');

        $grid->column('trade_amount', __('累计交易金额'))->display(function ($money) {
            return number_format($money / 100, 2, '.', ',');
        })->label('info')->help('终端机具商户的累积交易量');
                
        $grid->column('created_at', __('创建时间'))->help('终端机具商户的开通时间');


        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->column(1/3, function ($filter) {
                $filter->like('code', '商户编号')->placeholder('机具开通的商户编号,模糊匹配');;
            });

            $filter->column(1/3, function ($filter) {
                $filter->like('name', '商户名称')->placeholder('机具开通的商户名称,模糊匹配');;
            });

            $filter->column(1/3, function ($filter) {
                $filter->like('phone', '商户电话')->placeholder('机具开通的商户电话,模糊匹配');;
            });

            $filter->column(1/3, function ($filter) {
                $filter->like('users.account', '持有人')->placeholder('商户归属人的登陆账号,模糊匹配');
            });

            $filter->column(1/3, function ($filter) {
                $filter->like('machines.sn', 'SN')->placeholder('商户所拥有的SN编号,模糊匹配');
            });

            if(Admin::user()->operate == "All"){
                $filter->column(1/3, function ($filter) {
                    $filter->equal('operate', '操盘')->select(\App\AdminSetting::pluck('company as title','operate_number as id')->toArray());
                });
            }

            $filter->column(1/3, function ($filter) {
                $filter->between('created_at', '开通时间')->datetime();
            });
        });

        // 禁用添加按钮
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
        $show = new Show(Merchant::findOrFail($id));

        if(Admin::user()->operate != "All"){
            $model = Merchant::where('id', $id)->first();
            if($model->operate != Admin::user()->operate) return abort('403');        
        }

        $show->field('users.nickname', __('归属代理'));

        $show->field('code', __('商户号'));

        $show->field('name', __('商户名称'));

        $show->field('phone', __('商户电话'));

        $show->field('trade_amount', __('累计交易金额(元)'))->as(function($amount){
            return number_format($amount / 100, 2, '.', ',');
        });

        $show->field('state', __('状态'))->using([0 => '关闭', 1 => '开启', 2 => '注销'])->label('info');

        $show->field('created_at', __('创建时间'));


        /**
         * 显示该商户下的所有终端
         */
        $show->machines('终端管理', function ($machines) {

            $machines->setResource('/admin/machines');

            $machines->model()->latest();

            $machines->column('sn', __('终端SN'));

            $machines->column('users.nickname', __('所属代理'));

            $machines->column('open_state', __('开通状态'))->using([ '0' => '未开通', '1' => '已开通'])
                    ->dot([ 0 => 'danger', 1 => 'success' ], 'default');

            $machines->column('open_time', __('开通时间'));

            $machines->column('activate_state', __('激活状态'))->using([ '0' => '未激活', '1' => '已激活'])
                    ->dot([ 0 => 'default', 1 => 'success' ], 'default');

            $machines->column('activate_time', __('激活时间'));

            $machines->column('bind_status', __('绑定状态'))->using([ '0' => '未绑定', '1' => '已绑定'])
                    ->dot([ 0 => 'default', 1 => 'success' ], 'default');

            $machines->column('bind_time', __('绑定时间'));

            $machines->column('standard_status', __('达标状态'))->using([ '0' => '默认', '1' => '连续达标', '-1' => '达标中断'])
                    ->dot([ 0 => 'default', 1 => 'success', -1 => 'error'], 'default');
            
            // 禁用添加按钮
            $machines->disableCreateButton();
            // 禁用查询过滤器
            $machines->disableFilter();

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
        $form = new Form(new Merchant());

        $form->text('users.account', __('归属代理账号'))->attribute('readonly', 'readonly');

        $form->text('name', __('商户名称'));

        $form->text('phone', __('商户电话'));

        return $form;
    }
}
