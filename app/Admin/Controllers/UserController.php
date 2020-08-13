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

        $form->switch('is_verfity', __('自动晋升'))->default(1);

        $form->text('last_ip', __('最后登录IP'));

        $form->datetime('last_time', __('最后登录时间'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
