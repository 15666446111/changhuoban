<?php

namespace App\Admin\Controllers;

use App\PolicyGroup;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\MessageBag;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\AdminController;
class PolicyGroupController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '活动组管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PolicyGroup());

        if(Admin::user()->operate != "All"){
            $grid->model()->where('operate', Admin::user()->operate);
        }

        $grid->model()->latest();
        
        //$grid->column('id', __('Id'));
        //
        $grid->column('title', __('组名称'))->help('活动组的名称');

        $grid->column('operates.company', __('操盘方'))->help('活动组所属的操盘方标识');

        $grid->column('type', __('组类别'))
                ->using([ '1' => '联盟模式', '2' => '工具模式'])
                ->dot([ 1 => 'danger', 2 => 'success' ], 'default')->help('活动组所属的操盘方发展模式');

        $grid->column('created_at', __('创建时间'))->help('活动组的创建时间');

        //$grid->column('updated_at', __('修改时间'));

        // 如果是操盘方的后台 只能存在4个活动组
        if(Admin::user()->operate != "All"){
            $count = PolicyGroup::where('operate', Admin::user()->operate)->count();
            if($count >= 4 ){
                $grid->disableCreateButton();
            }
        }

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->column(1/4, function ($filter) {
                $filter->like('title', '组名');
            });
            
            if(Admin::user()->operate == "All"){
                $filter->column(1/3, function ($filter) {
                    $filter->equal('operate', '操盘方')->select(\App\AdminSetting::where('type', 1)->pluck('company', 'operate_number as id'));
                });
            }

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
        $show = new Show(PolicyGroup::findOrFail($id));

        if(Admin::user()->operate != "All"){
            $model = PolicyGroup::where('id', $id)->first();
            if($model->operate != Admin::user()->operate) return abort('403');        
        }

        $show->field('title', __('活动组标题'));
        $show->field('created_at', __('创建时间'));
        //$show->field('updated_at', __('Updated at'));

        $show->settsprice('结算价设置', function ($settsprice) {
            $settsprice->resource('/manage/policy-group-settlements');
            $settsprice->column('user_groups.name', __('用户组'))->help('当前活动组下的当前用户组');
            $settsprice->column('trade_types.name', __('交易类型'))->help('当前活动组下的当前用户组的结算类型');
            $settsprice->column('set_price', __('结算价'))->editable()->help('当前活动组下的当前用户组的结算类型的结算底价,单位为十万分位, 例如:万525,填写525');
            $settsprice->disableCreateButton();
            $settsprice->disableActions();

            $settsprice->filter(function($filter){
                // 去掉默认的id过滤器
                $filter->disableIdFilter();

                $filter->column(1/4, function ($filter) {
                    $filter->equal('user_group_id', '用户组')->select(\App\UserGroup::get()->pluck('name', 'id'));
                });

                $filter->column(1/4, function ($filter) {
                    $filter->equal('trade_type_id', '结算类型')->select(\App\TradeType::get()->pluck('name', 'id'));
                });
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
        $form = new Form(new PolicyGroup());

        $form->text('title', __('活动组标题'));
        $form->hidden('operate', __('Operate'))->readonly();
        $form->hidden('type', __('Type'))->readonly();

        $form->saving(function (Form $form) {
            // dd($form->images);
            if($form->isCreating()){
                $count = PolicyGroup::where('operate', Admin::user()->operate)->count();
                if($count >= 2 ){
                    $error = new MessageBag([ 'title'   => '创建活动组失败', 'message' => '您只能创建最多4个活动组']);
                    return back()->with(compact('error'));
                }
                $form->operate = Admin::user()->operate;
                $form->type    = 1;     // 暂时先等于联盟模式
            }
            
        });

        $form->saved(function (Form $form) {
            // 跳转页面
            return redirect('/manage/policy-groups/'. $form->model()->id);
        });

        return $form;
    }
}
