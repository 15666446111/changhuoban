<?php

namespace App\Admin\Controllers;

use App\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Widgets\Table;
use Illuminate\Database\Eloquent\Collection;
use Encore\Admin\Controllers\AdminController;

use App\Admin\ShowModel\ShowUserCount;

use Encore\Admin\Layout\Content;

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

        $type = false;

        if(Admin::user()->operate != "All"){

            $grid->model()->where('operate', Admin::user()->operate);

            $type = \App\AdminSetting::where('operate_number', Admin::user()->operate)->value('pattern');
        }

        $grid->model()->latest();


        $grid->column('avatar', __('头像'))->image('', 30, 30)->help('用户的头像');

        $grid->column('nickname', __('昵称'))->copyable()->help('用户的昵称,可在app修改');

        $grid->column('account', __('账号'))->copyable()->help('用户的app登陆账号');

        if( $type != 2 ){

            $grid->column('group.name', __('用户组'))->help('用户所属的用户组,联盟模式独有');

            $grid->column('is_verfity', __('晋升审核'))->bool()->help('每月初的自动晋升,是否审核该用户');

            $grid->column('cur_verfity', __('审核'))->bool()->help('当月是否已经审核');
        }

        $grid->column('parent_user.nickname', __('父级'))->help('用户的直属上级');

        $grid->column('active', __('状态'))->switch()->help('用户的活动状态,关闭后将无法在app登陆');

        $grid->column('draw_state', __('提现状态'))->switch()->help('用户的提现状态,关闭后将无法提现');

        $grid->column('user', '统计')->modal('统计信息', ShowUserCount::class);

        $grid->column('last_ip', __('最后登录地址'))->help('用户最后登陆的IP地址');

        $grid->column('last_time', __('最后登录时间'))->sortable()->help('用户最后登陆的时间');

        $grid->column('created_at', __('创建时间'))->date('Y-m-d H:i:s')->help('用户注册的时间');

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            // 去掉删除  编辑
            $actions->disableDelete();
            $actions->disableEdit(false);
        });

        $grid->batchActions(function ($batch) {
            $batch->disableDelete();
        });

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->column(1/4, function ($filter) {
                $filter->like('nickname', '昵称');
            });
            $filter->column(1/4, function ($filter) {
                $filter->like('account', '账号');
            });   

            //dd(Admin::user()->operate);
            if(Admin::user()->operate == "All"){
                $filter->column(1/4, function ($filter) {
                    $filter->equal('operate', '操盘')->select(\App\AdminSetting::pluck('company as title','operate_number as id')->toArray());
                }); 
                $filter->column(1/4, function ($filter) {
                    $filter->equal('draw_state', '提现')->select([ 0=> '关闭', 1=>'正常']);
                }); 
            }         
        });

        $grid->export(function ($export) {

            // 头像和统计列不需要被导出
            $export->except(['avatar', 'user']);

            $export->originalValue(['nickname', 'account']);

            $export->column('is_verfity', function ($value, $isVerfity) {
                return $isVerfity == 1 ? '已审核' : '未审核';
            });

            $export->column('cur_verfity', function ($value, $curVerfity) {
                return $curVerfity == 1 ? '已审核' : '未审核';
            });

            $export->column('active', function ($value, $originalActive) {
                return $originalActive == 1 ? '正常' : '关闭';
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

        $show = new Show(User::findOrFail($id));

        $type = false;

        /**
         * @version [<vector>] [< 如果当前登录的为操盘方 检查当前分享图是否属于此操盘方>]
         */
        if(Admin::user()->operate != "All"){
            $model = User::where('id', $id)->first();
            if($model->operate != Admin::user()->operate) return abort('403');
            $type = \App\AdminSetting::where('operate_number', Admin::user()->operate)->value('pattern');        
        }


        $show->field('nickname', __('昵称'));

        $show->field('avatar', __('头像'))->image('', 30);


        $show->field('account', __('账号'));

        $show->field('parent_user', __('上级'))->as(function ($content) {
            return $content->nickname;
        });

        $show->field('active', __('状态'))->using([0 => '关闭', 1 => '开启'])->label('info');

        $show->field('draw_state', __('提现状态'))->using([0 => '关闭', 1 => '开启'])->label('info');

        $show->field('group', __('用户组'))->as(function ($content) {
            return $content->name;
        });

        $show->field('group', __('用户组'))->as(function ($content) {
            return $content->name;
        });

        $show->field('last_ip', __('最后登录地址'));

        $show->field('last_time', __('最后登录时间'));

        $show->field('created_at', __('代理注册时间'));

        $show->field('updated_at', __('最后修改时间'));


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
            $realname->created_at('实名认证时间');
            $realname->panel()->tools(function ($tools) {
                $tools->disableEdit();
                $tools->disableList();
                $tools->disableDelete();
            });
        });

        $show->machines('机器列表', function ($machines) {
            //$articles->setResource('/admin/articles');
            $machines->model()->latest();
            $machines->column('sn', __('终端SN'))->help('终端机具背面的SN序列号');
            $machines->column('machines_styles.style_name', __('终端类型'))->help('终端机具的所属类型');
            $machines->column('policys.title', __('所属活动'))->help('终端机具的所属活动');
            $machines->column('open_state', __('开通状态'))->using([ '0' => '未开通', '1' => '已开通'])
                                        ->dot([ 0 => 'danger', 1 => 'success' ], 'default')->help('终端机具的开通状态');
            $machines->column('open_time', __('开通时间'))->help('终端机具的开通时间');

            $machines->column('merchants.name', __('商户名称'))->help('终端机具所归属的商户名称');

            $machines->column('merchants.phone', __('商户电话'))->help('终端机具所归属的商户电话');

            $machines->column('bind_status', __('绑定状态'))->using([ '0' => '未绑定', '1' => '已绑定'])
                                        ->dot([ 0 => 'default', 1 => 'success' ], 'default')->help('终端机具的绑定状态');
            $machines->column('bind_time', __('绑定时间'))->help('终端机具所归属的绑定时间');
            $machines->column('standard_status', __('达标状态'))->using([ '0' => '默认', '1' => '连续达标', '-1' => '达标中断'])
                                        ->dot([ 0 => 'default', 1 => 'success', -1 => 'error'], 'default')->help('终端机具的达标状态');
            $machines->column('overdue_state', __('过期状态'))->using([ '0' => '未过期', '1' => '已过期'])
                                        ->dot([ 0 => 'success', 1 => 'default'], 'default')->help('终端机器的过期状态');
            $machines->column('active_end_time', __('开通截止时间'))->help('终端机具所归属的开通截止时间');

            $machines->filter(function ($filter) {
                $filter->disableIdFilter();
            });

            $machines->disableCreateButton();
            $machines->batchActions(function ($batch) {
                $batch->disableDelete();
            });
            $machines->disableActions();
        });


        $show->cash('分润信息', function ($cash) {
            //$articles->setResource('/admin/articles');
            $cash->model()->latest();
            $cash->column('trades.sn', __('SN号'))->help('分润的终端机具SN');
            $cash->column('trades.merchant_code', __('商户号'))->help('分润的终端机具商户号');
            $cash->column('trades.trade_no', __('交易订单号'))->help('分润的交易订单号');
            $cash->column('trades.amount', __('交易金额'))->display(function ($money) {
                return number_format($money / 100, 2, '.', ',');
            })->label()->help('交易金额');
            $cash->column('cash_money', __('分润金额'))->display(function ($money) {
                return number_format($money / 100, 2, '.', ',');
            })->label()->help('本次分润金额');
            $cash->column('is_run', __('方式'))->using(['1' => '分润', '0' => '返现'])->help('分润类型,分为分润与返现');
            $cash->column('cash_type', __('类型'))->using(['1' => '直营分润', '2' => '团队分润','3'=>'激活返现'
            ,'4'=>'间推激活返现','5'=>'间间推激活返现','6'=>'达标返现','7'=>'二次达标返现','8'=>'三次达标返现','9'=>'财商学院推荐奖励'])->help('分润的详细类型');
            $cash->column('created_at', __('分润时间'))->help('分润下发的时间');
            $cash->filter(function ($filter) {
                $filter->disableIdFilter();
            });

            $cash->disableCreateButton();
            $cash->batchActions(function ($batch) {
                $batch->disableDelete();
            });
            $cash->disableActions();
        });


        // 用户的自动晋升记录
        if( $type != 2 ){
            $show->auto_promotion_logs('晋升历史', function ($logs) {

                //$articles->setResource('/admin/articles');
                
                $logs->model()->latest();
                
                $logs->id('索引')->sortable();

                $logs->status('状态')->bool()->help('本次晋升的考核状态');

                $logs->trade_count('上月交易量')->display(function ($money) {
                    return number_format($money / 100, 2, '.', ',');
                })->label()->help('上月团队总交易量');

                $logs->column('title', '考核标准')->expand(function ($model) {
                    if($model->remark != ""){
                        $data = json_decode($model->remark);
                        $rows = array();
                        foreach ($data as $key => $value) {
                            $rows[] = array( 
                                $value->id,
                                "C".$value->group_id, 
                                number_format($value->trade_count / 100, 2, '.', ','),
                                $value->created_at,
                                $value->updated_at
                            );
                        }
                        return new Table(['索引','用户组', '考核交易量', '创建时间', '修改时间'], $rows);
                    }
                })->help('考核晋升时的操盘方晋升标准');
                //$logs->

                $logs->biz('考核备注')->help('考核时程序执行信息');

                $logs->created_at('考核时间')->help('本次考核时间');

                $logs->filter(function ($filter) {
                    $filter->disableIdFilter();
                    //$filter->like('title');
                });

                $logs->disableCreateButton();
                $logs->batchActions(function ($batch) {
                    $batch->disableDelete();
                });
                $logs->disableActions();
            });
        }


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

        /**
         * @version [<vector>] [< 修改member时 如果不是超级管理员 其他操盘方禁止修改不属于自己的信息>]
         */
        if(Admin::user()->operate != "All" && request()->route()->parameters()){
            $User = \App\User::where('id', request()->route()->parameters()['user'])->first();
            if($User->operate != Admin::user()->operate) return abort('403'); 
        }

        $form->text('nickname', __('昵称'));

        $form->text('account', __('账号'))->readonly();

        $form->image('avatar', __('头像'))->default('images/avatar.png')->uniqueName();

        $form->select('user_group', __('用户组'))->options(\App\UserGroup::get()->pluck('name', 'id'));

        $form->switch('active', __('状态'))->default(1);

        $form->switch('draw_state', __('提现状态'))->default(1);

        $form->switch('is_verfity', __('自动晋升'))->default(1);

        $form->text('last_ip', __('最后登录IP'));

        $form->datetime('last_time', __('最后登录时间'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
