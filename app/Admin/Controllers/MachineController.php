<?php

namespace App\Admin\Controllers;

use App\Machine;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use App\Admin\Actions\ImportMachines;
use App\Admin\Actions\MachineHeadTail;
use App\Admin\Actions\HeadTailDeliverGoods;
use App\Admin\Actions\ImportDeliverGoods;


use Encore\Admin\Controllers\AdminController;

class MachineController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '机具仓库';


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Machine());
        
        if(Admin::user()->operate != "All"){

            $user_id[] = \App\User::where('operate',Admin::user()->operate)->first()->id;

            $id = \App\User::where('operate',Admin::user()->operate)->first()->id;
            $userInfo = \App\UserRelation::where('parents', 'like', "%_".$id."_%")->pluck('user_id')->toArray();

            $user_id = array_merge($user_id,$userInfo);

            $grid->model()->whereIn('user_id',$user_id);
            
        }
        
        // 倒叙
        $grid->model()->latest();

        $grid->column('sn', __('终端SN'));

        $grid->column('machines_styles.style_name', __('终端类型'));

        $grid->column('users.nickname', __('所属代理'));


        $grid->column('open_state', __('开通状态'))->using([ '0' => '未开通', '1' => '已开通'])
                ->dot([ 0 => 'danger', 1 => 'success' ], 'default');

        $grid->column('open_time', __('开通时间'));

        $grid->column('is_self', __('活动自备机'))->using([ '0' => '不是', '1' => '是'])
                ->dot([ 0 => 'success', 1 => 'danger' ], 'default');

        $grid->column('machine_name', __('商户名称'));

        $grid->column('machine_phone', __('商户电话'));

        $grid->column('bind_status', __('绑定状态'))->using([ '0' => '未绑定', '1' => '已绑定'])
                ->dot([ 0 => 'default', 1 => 'success' ], 'default');

        $grid->column('bind_time', __('绑定时间'));

        $grid->column('standard_status', __('达标状态'))->using([ '0' => '默认', '1' => '连续达标', '-1' => '达标中断'])
                ->dot([ 0 => 'default', 1 => 'success', -1 => 'error'], 'default');
        //$grid->column('created_at', __('创建时间'))->date('Y-m-d H:i:s');

        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->column(1/3, function ($filter) {
                $filter->like('sn', '终端编号');
            });

            $filter->column(1/4, function ($filter) {
                $filter->equal('open_state', '状态')->select(['0' => '未开通', '1' => '已开通']);
            });

            $filter->column(1/3, function ($filter) {
                $filter->like('users.nickname', '所属代理');
            });

        });

        $grid->tools(function ($tools) {

            $tools->append(new ImportMachines());

            $tools->append(new MachineHeadTail());

            $tools->append(new HeadTailDeliverGoods());

            $tools->append(new ImportDeliverGoods());

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
        if(Admin::user()->operate != "All"){
            $model = Machine::where('id', $id)->first();
            if($model->operate != Machine::user()->operate) return abort('403');        
        }
        $show = new Show(Machine::findOrFail($id));

        $show->field('user_id', __('归属人'));
        $show->field('sn', __('机器序列号'));
        $show->field('open_state', __('开通状态'));
        $show->field('is_self', __('是否是自备机'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('style_id', __('所属型号'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Machine());

        $form->select('style_id', __('所属型号'))->options([1 => 'a', 2 => 'b']);

        $form->text('sn', __('机具终端'));

        $form->switch('open_state', __('开通状态'));

        $form->switch('is_self', __('是否自备机'));

        return $form;
    }
}
