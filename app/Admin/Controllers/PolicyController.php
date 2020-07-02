<?php

namespace App\Admin\Controllers;

use App\Policy;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\MessageBag;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\AdminController;
class PolicyController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '活动管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Policy());

        if(Admin::user()->operate != "All"){
            $grid->model()->where('operate', Admin::user()->operate);
        }

        $grid->model()->latest();

        //$grid->column('id', __('Id'));
        $grid->column('title', __('活动标题'));

        $grid->column('policy_groups.title', __('所属活动组'));

        $grid->column('active', __('状态'))->using([ 0 => '关闭', '1' => '正常'])->dot([ 0 => 'danger', 1 => 'success' ]);

        $grid->column('created_at', __('创建时间'));
        //$grid->column('updated_at', __('Updated at'));
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
        $show = new Show(Policy::findOrFail($id));

        if(Admin::user()->operate != "All"){
            $model = PolicyGroup::where('id', $id)->first();
            if($model->operate != Admin::user()->operate) return abort('403');        
        }

        $show->field('title', __('活动标题'));

        $show->field('policy_group_id', __('Policy group id'));
        $show->field('active', __('Active'));
        $show->field('default_active', __('Default active'));
        $show->field('indirect_active', __('Indirect active'));
        $show->field('default_active_set', __('Default active set'));
        $show->field('vip_active_set', __('Vip active set'));
        $show->field('default_standard_set', __('Default standard set'));
        $show->field('vip_standard_set', __('Vip standard set'));
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
        $form = new Form(new Policy());


        $form->tab('基础信息配置', function ($form) {

            $form->text('title', __('活动标题'));

            $form->switch('active', __('活动状态'))->default(1)->help('关闭活动状态时,配送无法选择此活动,已配送机器分润等不受影响');

            $form->hidden('operate', __('Operate'))->readonly();

            $form->select('policy_group_id', __('所属活动组'))->options(\App\PolicyGroup::where('operate', Admin::user()->operate)->get()->pluck('title', 'id'));
            
        })->tab('激活返现设置', function ($form) {

            $form->number('default_active', __('直推激活'))->default(2)->help('机器激活,上级获得的直推奖励.(单位为分)');
            $form->number('indirect_active', __('间推激活'))->default(1)->help('机器激活,上上级获得的间推奖励.(单位为分)');
            $form->select('active_type', __('激活标准'))->options([1 => '冻结激活', 2 => '交易量激活'])->when(1,function (Form $form) { 
                $form->currency('active_price', __('冻结激活金额'))->symbol('￥')->help('机器激活,上级获得的直推奖励.(单位为分)');
            })->when(2,function (Form $form) { 
                $form->currency('active_price', __('交易量激活金额'))->symbol('￥')->help('机器激活,上级获得的直推奖励.(单位为分)');
            });
            $form->fieldset('用户激活返现', function (Form $form) {
                $form->embeds('default_active_set', '用户激活',function ($form) {
                    $form->number('return_money', '最高返现')->default(0)->rules('required')->help('(单位为分)');
                    $form->number('default_money', '默认返现')->default(0)->rules('required')->help('(单位为分)');
                });
            });

            $form->fieldset('代理激活返现', function (Form $form) {
                $form->embeds('vip_active_set', '代理激活',function ($form) {
                    $form->number('return_money', '最高返现')->default(0)->rules('required')->help('(单位为分)');
                    $form->number('default_money', '默认返现')->default(0)->rules('required')->help('(单位为分)');
                });
            });

        })->tab('达标奖励设置', function ($form) {

            $form->table('default_standard_set', '达标设置',function ($table) {

                $table->hidden('index', '达标标识');

                $table->select('standard_type', '达标类型')->options(['1' => '连续达标', '2' => '累积达标'])->default(1)->required();

                $table->number('standard_start', '日期(起)')->default(0);

                $table->number('standard_end', '日期(止)')->default(0);

                $table->currency('standard_trade', '满足交易')->default(0);

                $table->currency('standard_agent_price', '代理奖励')->default(0);

                $table->currency('standard_price', '本人奖励')->default(0);

                $table->currency('standard_parent_price', '上级奖励')->default(0);

            });

        });
    
        $form->saving(function (Form $form) {
            // dd($form->images);
            if($form->isCreating()){
                $count = Policy::where('operate', Admin::user()->operate)->where('policy_group_id', $form->policy_group_id)->count();
                if($count >= 4 ){
                    $error = new MessageBag([ 'title'   => '创建活动失败', 'message' => '您单个活动组最多创建4个活动']);
                    return back()->with(compact('error'));
                }
                $form->operate = Admin::user()->operate;
                $form->type    = 1;     // 暂时先等于联盟模式
            }
            
        });
        return $form;
    }
}
