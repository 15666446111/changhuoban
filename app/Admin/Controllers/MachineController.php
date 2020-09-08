<?php

namespace App\Admin\Controllers;

use App\Machine;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Facades\Admin;
use App\Admin\Actions\DeliverGoods;
use App\Admin\Actions\ImportMachines;
use App\Admin\Actions\MachineHeadTail;
use App\Admin\Actions\HeadTailDeliverGoods;
use App\Admin\Actions\ImportDeliverGoods;
use Encore\Admin\Controllers\AdminController;
use App\Admin\Actions\Machines\ChangeActivity;
use App\Admin\Actions\Machines\Unbind;

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
            $grid->model()->where('operate', Admin::user()->operate);
        }
        
        // 倒叙
        $grid->model()->latest();

        $grid->column('sn', __('终端SN'))->help('终端机具背面的SN序列号');

        $grid->column('machines_styles.style_name', __('终端类型'))->help('终端机具的所属类型');

        $grid->column('policys.title', __('所属活动'))->help('终端机具的所属活动');

        $grid->column('users.nickname', __('所属代理'))->help('终端机具所属的账号昵称');

        $grid->column('open_state', __('开通状态'))->using([ '0' => '未开通', '1' => '已开通'])->dot([ 0 => 'danger', 1 => 'success' ], 'default')->help('终端机具的开通状态');

        $grid->column('open_time', __('开通时间'))->help('终端机具的开通时间');

        $grid->column('merchants.name', __('商户名称'))->help('终端机具所归属的商户名称');

        $grid->column('merchants.phone', __('商户电话'))->help('终端机具所归属的商户电话');

        $grid->column('bind_status', __('绑定状态'))->using([ '0' => '未绑定', '1' => '已绑定'])->dot([ 0 => 'default', 1 => 'success' ], 'default')->help('终端机具的绑定状态');

        $grid->column('bind_time', __('绑定时间'))->help('终端机具所归属的绑定时间');

        $grid->column('standard_status', __('达标状态'))->using([ '0' => '默认', '1' => '连续达标', '-1' => '达标中断'])
                ->dot([ 0 => 'default', 1 => 'success', -1 => 'error'], 'default')->help('终端机具的达标状态');

        $grid->column('overdue_state', __('过期状态'))->using([ '0' => '未过期', '1' => '已过期'])
                ->dot([ 0 => 'success', 1 => 'default'], 'default')->help('终端机器的过期状态');

        $grid->column('active_end_time', __('开通截止时间'))->help('终端机具所归属的开通截止时间');

        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->column(1/3, function ($filter) {
                $filter->like('sn', '终端SN');
            });

            $filter->column(1/3, function ($filter) {
                $filter->equal('open_state', '是否开通')->select(['0' => '未开通', '1' => '已开通']);
            });

            $filter->column(1/3, function ($filter) {
                $data = Admin::user()->operate == "All" ? array() : array('operate' => Admin::user()->operate);
                $filter->equal('user_id', '代理商')->select(\App\User::where($data)->get()->pluck('nickname', 'id'));
            });

            $filter->column(1/3, function ($filter) {
                $filter->equal('bind_status', '是否绑定')->select(['0' => '未绑定', '1' => '已绑定']);
            });

            $filter->column(1/3, function ($filter) {

                $policyGroupChange = Admin::user()->operate != "All" ? \App\PolicyGroup::where('operate', Admin::user()->operate)->pluck('title', 'id')->toArray() : \App\PolicyGroup::pluck('title', 'id')->toArray();

                $filter->equal('policys.policy_group_id', '所属政策')->select($policyGroupChange)->load('policy_id', '/api/getPolicys');
            });

            $filter->column(1/3, function ($filter) {
                $filter->equal('policy_id', '所属活动')->select();
            });


            if(Admin::user()->operate == "All"){
                $filter->column(1/3, function ($filter) {
                    $filter->equal('operate', '操盘')->select(\App\AdminSetting::pluck('company as title','operate_number as id')->toArray());
                });
            }

            /*$filter->equal('policys.policy_group_id', '所属政策')->select($policyGroupChange)->load('policy_id', '/api/getPolicys');
            $filter->column(1/3, function ($filter) {
                $filter->equal('policy_id', '所属活动')->select();
            });*/


            $filter->column(1/3, function ($filter) {
                $filter->between('open_time', '开通时间')->datetime();
            });

            $filter->column(1/3, function ($filter) {
                $filter->between('open_time', '开通时间')->datetime();
            });


        });


        $grid->actions(function ($actions) {
            // 去掉删除 编辑
            if($actions->row->bind_status){
                $actions->disableDelete();

                $actions->add(new Unbind);
            }

            $actions->disableEdit();
            // 如果机器未发货 显示发货按钮
            if($actions->row['user_id'] == 0 or $actions->row['user_id'] == null) $actions->add(new DeliverGoods);
        });



        $grid->batchActions(function ($batch) {

            $batch->disableDelete(false);

            if(Admin::user()->operate == "All"){
                $batch->add(new ChangeActivity()); // 活动变更
            }
        });


        $grid->export(function ($export) {

            $export->column('open_state', function ($value, $openState) {
                return $openState == 1 ? '已开通' : '未开通';
            });

            $export->column('bind_status', function ($value, $bindStatus) {
                return $bindStatus == 1 ? '已绑定' : '未绑定';
            });

            $export->column('standard_status', function ($value, $originalStandard) {
                $standardStatus = ['0' => '默认', '1' => '连续达标', '-1' => '达标中断'];
                return $standardStatus[$originalStandard];
            });

            $export->column('overdue_state', function ($value, $overdueState) {
                return $overdueState == 1 ? '已过期' : '未过期';
            });

        });


        $grid->tools(function ($tools) {

            //$type = \App\MachinesType::where('state', '1')->get()->pluck('name','id');

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
        
        $show = new Show(Machine::findOrFail($id));

        if(Admin::user()->operate != "All"){
            $model = Machine::where('id', $id)->first();
            if($model->operate != Admin::user()->operate) return abort('403');        
        }

        $show->field('user_id', __('归属人'));
        $show->field('sn', __('机器序列号'));
        $show->field('open_time', __('开通时间'));
        $show->field('open_state', __('开通状态'))->using([ '0' => '未开通', '1' => '已开通']);
        $show->field('is_self', __('是否是自备机'))->using([ '0' => '不是', '1' => '是']);
        $show->field('mercahnts.name', __('商户名称'));
        $show->field('merchants.phone', __('商户电话'));
        // $show->field('created_at', __('Created at'));
        // $show->field('updated_at', __('Updated at'));
        $show->field('machines_styles.style_name', __('所属型号'));
        $show->field('bind_status', __('绑定状态'))->using([ '0' => '未绑定', '1' => '已绑定']);
        $show->field('bind_time', __('绑定时间'));
        $show->field('standard_status', __('达标状态'))->using([ '0' => '默认', '1' => '连续达标', '-1' => '达标中断']);
        $show->field('activate_time', __('激活时间'));
        $show->field('activate_state', __('激活状态'))->using([ '0' => '默认', '1' => '连续达标', '-1' => '达标中断']);
        $show->field('policys.title', __('政策活动'));

        $show->policys('政策信息', function ($policys) {
            $policys->title('政策标题');
            $policys->active('状态')->using(['0'=> '关闭', '1' => '正常']);
            $policys->field('policy_groups.title', __('活动组'));
            $policys->panel()->tools(function ($tools) {
                $tools->disableEdit();
                $tools->disableList();
                $tools->disableDelete();
            });
        });
        

        $show->tradess_sn('交易信息', function ($trade) {

            $trade->setResource('/admin/trades');
            
            $trade->model()->latest();
            
            $trade->id('索引')->sortable();

            $trade->column('trade_no', __('交易流水号'))->copyable();
            $trade->column('merchant_id', __('商户编号'))->copyable();
            $trade->column('merchant_sn', __('SN'))->copyable();

            $trade->column('agt_merchant_id', __('渠道商ID'));
            $trade->column('agt_merchant_name', __('渠道商名称'));
            $trade->column('agt_merchant_level', __('渠道商级别'));

            $trade->column('card_type', __('卡类型'))->using([ '0' => '贷记卡', '1' => '借记卡']);
            $trade->column('trade_type', __('交易类型'));
            $trade->column('trade_time', __('交易时间'));


            $trade->column('amount', __('交易金额'))->display(function ($money) {
                return number_format($money/100, 2, '.', ',');
            })->label('info')->filter('range');

            //$grid->column('rate', __('交易费率'));
            $trade->column('rate_money', __('手续费'))->display(function ($money) {
                return number_format($money/100, 2, '.', ',');
            })->label('warning')->filter('range');

            $trade->column('settle_amount', __('结算金额'))->display(function ($money) {
                return number_format($money/100, 2, '.', ',');
            })->label('success')->filter('range');;

            $trade->column('is_cash', __('分润'))->bool();

            $trade->column('', '其他')->modal('处理结果', function ($model) {
                
                return new Table(['商户编号名称','交易卡号','分润备注'], [[$model->merchant_name,$model->card_number,$model->remark]]);
            
            });

            $trade->column('created_at', __('推送时间'));

            $trade->disableCreateButton();
            $trade->actions(function ($actions) {
                // 去掉删除 编辑
                $actions->disableDelete();
                $actions->disableEdit();
            });
            $trade->batchActions(function ($batch) {
                $batch->disableDelete();
            });

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
        $form = new Form(new Machine());

        if(Admin::user()->operate != "All" && request()->route()->parameters()){
            $data = Machine::where('id', request()->route()->parameters()['machine'])->first();
            if($data->operate != Admin::user()->operate) return abort('403'); 
        }

        $type = \App\MachinesType::where('state',1)->get()->pluck('name', 'id');

        $form->hidden('operate', __('操盘号'))->value($form->operate ?? Admin::user()->operate)->readonly();

        $form->select('name','类型')->options($type)->load('factory_name','/api/getAdminFactory');

        $form->select('factory_name','厂商')->load('style_id','/api/getAdminStyle');

        $form->select('style_id','型号')->required();

        $form->ignore(['name','factory_name']);

        $form->text('sn', __('机具终端'));

        $form->switch('open_state', __('开通状态'));

        $form->switch('is_self', __('是否自备机'));

        return $form;
    }
}
