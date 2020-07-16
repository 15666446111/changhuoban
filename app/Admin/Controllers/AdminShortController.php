<?php

namespace App\Admin\Controllers;

use App\AdminShort;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Actions\SyncSms;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\AdminController;

class AdminShortController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '短信管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AdminShort());

        if(Admin::user()->operate != "All"){
            $grid->model()->where('operate', Admin::user()->operate);
        }
        //$grid->column('id', __('索引'));
        //
        $grid->column('operates.company', __('操盘方'))->help('短信所属的操盘方');
        //
        $grid->column('number', __('短信编号'));

        //$grid->column('type', __('短信类型'))->using([ '1' => 'POS服务费', '2' => '通讯（流量卡）费', '3' => 'VIP会员费']);

        $grid->column('content', __('短信内容'));

        $grid->column('status', __('状态'))->using([0 => '关闭', 1=>'可用'])->dot([0=>'danger', 1=>'success']);

        $grid->column('create', __('创建时间'));

        $grid->column('create_user_id', __('创建人'));

        $grid->column('last', __('最后修改时间'));

        $grid->column('last_user_id', __('最后修改人'));

        $grid->tools(function ($tools) {

            $tools->append(new SyncSms());

        });

        $grid->disableCreateButton();
        // 全部关闭
        $grid->disableActions();
        
        $grid->disableCreateButton();

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

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
        $show = new Show(AdminShort::findOrFail($id));

        if(Admin::user()->operate != "All"){
            $model = Article::where('id', $id)->first();
            if($model->operate != Admin::user()->operate) return abort('403');        
        }
        
        $show->field('id', __('索引'));
        $show->field('type', __('短信类型'))->using([1 => 'POS服务费', 2 => '流量卡费', 3 => 'VIP会员费']);
        $show->field('number', __('短信编号'));
        $show->field('content', __('短信内容'));
        $show->field('created_at', __('创建时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new AdminShort());

        $form->select('type', __('短信类型'))->options([1 => 'POS服务费', 2 => '流量卡费', 3 => 'VIP会员费']);
        $form->text('number', __('短信编号'));
        $form->text('content', __('短信内容'));

        $form->saving(function (Form $form) {
            // dd(Admin::user()->operate);
            if($form->isCreating()){
                $form->operate = Admin::user()->operate;
            }
            
        });

        return $form;
    }
}
