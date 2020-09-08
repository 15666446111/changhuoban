<?php

namespace App\Admin\Controllers;

use App\Transfer;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;

class TransferController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '调拨日志';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Transfer());

        if(Admin::user()->operate != "All"){
            $grid->model()->where('operate', Admin::user()->operate);   
        }

        $grid->model()->latest();

        //$grid->column('id', __('索引'));
        $grid->column('machine.sn', __('终端号'));
        $grid->column('old_user.nickname', __('划拨前用户'));
        $grid->column('new_user.nickname', __('划拨后用户'));
        $grid->column('state', __('调拨类型'))->using([ '1' => '划拨', '2' => '回拨'])
        ->label('info');
        $grid->column('created_at', __('调拨时间'));
        $grid->column('is_back', __('是否回拨'))->using([ '0' => '否', '1' => '是'])->dot([ 0 => 'danger', 1 => 'success' ], 'default');;

        $grid->disableCreateButton();
        // 全部关闭
        $grid->disableActions();

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            if(Admin::user()->operate == "All"){
                $filter->column(1/3, function ($filter) {
                    $filter->equal('operate', '操盘')->select(\App\AdminSetting::pluck('company as title','operate_number as id')->toArray());
                });
            }
            $userSons = Admin::user()->operate == "All" ? \App\User::pluck('nickname as title', 'id')->toArray() : \App\User::where('operate', Admin::user()->operate)->pluck('nickname as title', 'id')->toArray();
            $filter->column(1/3, function ($filter) use ($userSons){
                $filter->equal('old_user_id', '原代理商')->select($userSons);
            });

            $filter->column(1/3, function ($filter) use ($userSons) {
                $filter->equal('new_user_id', '新代理商')->select($userSons);
            });

            $filter->column(1/3, function ($filter) {  
                $filter->equal('state', '类型')->select([1=> '划拨', 2=>'回拨']);
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
        $show = new Show(Transfer::findOrFail($id));

        if(Admin::user()->operate != "All"){
            $model = Machine::where('id', $id)->first();
            if($model->operate != Admin::user()->operate) return abort('403');        
        }

        $show->field('id', __('Id'));
        $show->field('machine_id', __('Machine id'));
        $show->field('old_user_id', __('Old user id'));
        $show->field('new_user_id', __('New user id'));
        $show->field('state', __('State'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('is_back', __('Is back'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Transfer());

        $form->number('machine_id', __('Machine id'));
        $form->number('old_user_id', __('Old user id'));
        $form->number('new_user_id', __('New user id'));
        $form->switch('state', __('State'));
        $form->number('is_back', __('Is back'));

        return $form;
    }
}
