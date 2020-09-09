<?php

namespace App\Admin\Controllers;

use App\Model1\MoneyLog;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Filters\TimestampBetween;
use Encore\Admin\Controllers\AdminController;

use App\Admin\Actions\Export\Export1MoneyLog;

class MoneyLogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '分润管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MoneyLog());

        $grid->model()->orderBy('add_time', 'desc');

        $grid->column('id', __('索引'));

        $grid->column('users.user_nickname', __('用户昵称'));

        $grid->column('users.mobile', __('用户账号'));

        $grid->column('userAgents.agent_id', __('操盘方'))->display(function($agent){

            return $agent == "8089" ? '平台直属' : \App\Model1\UserInfo::where('id', $agent)->value('user_nickname');
        
        });

        //$grid->column('userAgent.agent_id', __('操盘方'));

        $grid->column('sn', __('机器SN'));

        $grid->column('c_code', __('商户编号'));

        //$grid->column('t_id', __('交易ID'));

        $grid->column('money', __('分润金额'));

        $grid->column('self', __('本人'));

        $grid->column('team', __('团队'));

        $grid->column('is_run', __('描述'))->using(['0' => '返现', '1' => '分润']);

        $grid->column('brands.name', __('品牌'));

        $grid->column('activitys.name', __('活动'));

        $grid->column('type', __('分润类型'))->using([
                '1' => '直营分润', 
                '2' => '团队分润',
                '3' => '激活返现',
                '4' => '交易奖励',
                '5' => '注册奖励',
                '6' => '达标返现',
                '7' => '云闪付推荐奖励',
                '8' => '财商学院推荐奖励',
                '9' => 'etc返现奖励',
                '10'=> 'epos直营分润',
                '11'=> 'epos团队分润',
                '12'=> '申卡直推',
                '13'=> '积分直推',
                '14'=> '申卡团队',
                '15'=> '积分团队'
            ]);

        $grid->column('add_time', __('分润时间'))->display(function($time){
            return date('Y-m-d H:i:s', $time);
        });

        $grid->batchActions(function ($batch) {
            $batch->disableDelete();
        });

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();
            // 去掉编辑
            $actions->disableEdit();

        });

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->column(1/3, function ($filter) {
                $filter->like('c_code', '商户编号')->placeholder('分润的商户编号');
            });

            $filter->column(1/3, function ($filter) {
                $filter->like('sn', '终端SN')->placeholder('终端机具的编号');
            });

            // 在这里添加字段过滤器
            $filter->column(1/3, function ($filter) {
                $filter->use(new TimestampBetween('add_time', '分润时间'))->datetime();
            });


            $filter->column(1/3, function ($filter) {
                $filter->equal('brand_id', '机器品牌')->select(\App\Model1\Brand::get()->pluck('name', 'id'));
            });


            $filter->column(1/3, function ($filter) {
                $filter->like('users.mobile', '代理账号')->placeholder('请输入代理的账号,模糊匹配');
            });

            $filter->column(1/3, function ($filter) {
                $filter->equal('is_run', '描述')->select([
                    '0' => '返现', 
                    '1' => '分润',
                ]);
            });

            $filter->column(1/3, function ($filter) {
                $filter->equal('type', '分润类型')->select([
                    '1' => '直营分润', 
                    '2' => '团队分润',
                    '3' => '激活返现',
                    '4' => '交易奖励',
                    '5' => '注册奖励',
                    '6' => '达标返现',
                    '7' => '云闪付推荐奖励',
                    '8' => '财商学院推荐奖励',
                    '9' => 'etc返现奖励',
                    '10'=> 'epos直营分润',
                    '11'=> 'epos团队分润',
                    '12'=> '申卡直推',
                    '13'=> '积分直推',
                    '14'=> '申卡团队',
                    '15'=> '积分团队'
                ]);
            });

            $filter->column(1/3, function ($filter) {
                $filter->equal('activity_id', '参与活动')->select(\App\Model1\Activity::get()->pluck('name', 'id'));
            });

            $filter->column(1/3, function ($filter) {

                $user = \App\Model1\UserAgent::distinct('agent_id')->pluck('agent_id')->toArray();

                $data = \App\Model1\UserInfo::whereIn('id', $user)->pluck('user_nickname', 'id')->toArray();

                $filter->where(function ($query) {
                    switch ($this->input) {
                        case '8089':
                            $uid = \App\Model1\UserAgent::distinct('user_id')->pluck('user_id')->toArray();
                            $query->whereNotIn('user_id', $uid);
                            break;
                        default:
                            $uid = \App\Model1\UserAgent::where('agent_id', $this->input)->distinct('user_id')->pluck('user_id')->toArray();

                            $query->whereIn('user_id', $uid);
                            break;
                    }
                }, '操盘方')->select($data);

                
                //dd($data);
                //$filter->equal('userAgents.agent_id', '操盘方')->select($data);

            });
        });

        $excel = new Export1MoneyLog();

        $excel->setAttr(['id', 'sn'], ['id', 'sn']);

        $grid->exporter($excel);

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
        $show = new Show(MoneyLog::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('origin', __('Origin'));
        $show->field('money', __('Money'));
        $show->field('self', __('Self'));
        $show->field('team', __('Team'));
        $show->field('is_run', __('Is run'));
        $show->field('add_time', __('Add time'));
        $show->field('highest_id', __('Highest id'));
        $show->field('brand_id', __('Brand id'));
        $show->field('activity_id', __('Activity id'));
        $show->field('type', __('Type'));
        $show->field('sn', __('Sn'));
        $show->field('c_code', __('C code'));
        $show->field('t_id', __('T id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new MoneyLog());

        $form->number('user_id', __('User id'));
        $form->text('origin', __('Origin'));
        $form->decimal('money', __('Money'))->default(0.00);
        $form->decimal('self', __('Self'))->default(0.00);
        $form->decimal('team', __('Team'))->default(0.00);
        $form->switch('is_run', __('Is run'));
        $form->text('add_time', __('Add time'));
        $form->number('highest_id', __('Highest id'));
        $form->number('brand_id', __('Brand id'));
        $form->number('activity_id', __('Activity id'));
        $form->switch('type', __('Type'));
        $form->text('sn', __('Sn'));
        $form->text('c_code', __('C code'));
        $form->number('t_id', __('T id'));

        return $form;
    }
}
