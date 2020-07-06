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
        $grid->column('title', __('组名称'));

        $grid->column('operate', __('操盘方'));

        $grid->column('type', __('组类别'))
                ->using([ '1' => '联盟模式', '2' => '工具模式'])
                ->dot([ 1 => 'danger', 2 => 'success' ], 'default');

        $grid->column('created_at', __('创建时间'));

        //$grid->column('updated_at', __('修改时间'));

        // 如果是操盘方的后台 只能存在4个活动组
        if(Admin::user()->operate != "All"){
            $count = PolicyGroup::where('operate', Admin::user()->operate)->count();
            if($count >= 4 ){
                $grid->disableCreateButton();
            }
        }

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
            $settsprice->column('user_groups.name', __('用户组'));
            $settsprice->column('trade_types.name', __('交易类型'));
            $settsprice->column('set_price', __('结算价'))->editable();
            $settsprice->disableCreateButton();
            $settsprice->disableActions();
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
                if($count >= 4 ){
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
