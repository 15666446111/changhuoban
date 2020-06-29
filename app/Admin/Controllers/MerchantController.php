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

        // 倒叙
        $grid->model()->latest();

        $grid->column('id', __('索引'));

        $grid->column('users.nickname', __('代理昵称'));

        $grid->column('users.account', __('代理账号'));

        $grid->column('code', __('商户号'));

        $grid->column('name', __('商户名称'));

        $grid->column('phone', __('商户电话'));

        $grid->column('trade_amount', __('累计交易金额'));
                
        $grid->column('created_at', __('创建时间'));

        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->column(1/3, function ($filter) {
                $filter->equal('users.account', '代理账号');
            });

            $filter->column(1/3, function ($filter) {
                $filter->equal('code', '商户号');
            });

            $filter->column(1/3, function ($filter) {
                $filter->equal('machines.sn', 'SN');
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

        if (Admin::user()->operate != 'All') {
            $model = Merchant::where('id', $id)->first();
            if($model->operate != Admin::user()->operate) { return abort(403); }
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
