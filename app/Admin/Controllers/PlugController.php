<?php

namespace App\Admin\Controllers;

use App\Plug;
use App\PlugType;
use App\Pluglog;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Auth;

use Encore\Admin\Controllers\AdminController;

class PlugController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '轮播列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Plug());

        if(Admin::user()->operate != "All"){
            $grid->model()->where('operate', Admin::user()->operate);
        } 

        $grid->model()->latest();

        //倒叙
        //$grid->column('id', __('索引'))->sortable();
        if (Admin::user()->operate == "All") {
            $grid->column('admin_users.name', __('操盘方'))->help('轮播图归属操盘方');
        }

        $grid->column('images', __('图片'))->lightbox(['width' => 100, 'height' => 30])->help('轮播图的图片');

        $grid->column('name', __('标题'))->filter()->help('轮播图展示的标题');

        $grid->column('active', __('状态'))->sortable()->switch()->help('轮播图的状态,关闭后app端将不展示');

        $grid->column('plug_types.name', __('类型'))->help('轮播图所在的位置');
        
        $grid->column('sort', __('排序'))->sortable()->label()->help('排序权重的大小,越大越靠前');
        
        $grid->column('href', __('链接'))->link()->help('点击此轮播图跳转的链接');

        $grid->column('verify', __('审核'))
                ->using([ '0' => '待审核', '1' => '正常', '-1' => '拒绝'])
                ->dot([ 0 => 'danger', 1 => 'success' ], 'default')->help('轮播图的审核状态,提交后默认未审核的状态,由总后台审核,审核成功后方可在app展示');
        
        $grid->column('created_at', __('创建时间'))->date('Y-m-d H:i:s')->help('轮播图的添加时间');

        if(Admin::user()->type == "2" or Admin::user()->operate == "All"){
                
            $grid->disableCreateButton(false);

            $grid->actions(function (Grid\Displayers\Actions $actions) {

                $actions->disableEdit(false);

                $actions->disableDelete(true);

            });
        }

        /**
         * @version [<vector>] [< 头部筛选 >]
         */
        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->column(1/4, function ($filter) {
                $filter->like('name', '标题');
            });
           
            $filter->column(1/4, function ($filter) {
                $filter->equal('verify', '审核')->select(['0' => '待审核', '1' => '正常', '2'=> '拒绝']);
            }); 

            $filter->column(1/4, function ($filter) {
                $filter->equal('type_id', '类型')->select(\App\PlugType::get()->pluck('name', 'id'));
            }); 

            if(Admin::user()->operate == "All"){

                $filter->column(1/4, function ($filter) {

                    $filter->equal('operate', '操盘')
                                ->select(\App\AdminUser::where('type', 3)->get()->pluck('name', 'operate'));

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
        $show = new Show(Plug::findOrFail($id));

        /**
         * @version [<vector>] [< 如果当前登录的为操盘方 检查当前轮播图是否属于此操盘方>]
         */
        if(Admin::user()->operate != "All"){
            $Plug = Plug::where('id', $id)->first();
            if($Plug->operate != Admin::user()->operate) return abort('403');        
        }

        $show->field('name', __('标题'));

        $show->field('plug_types', __('所属分类'))->as(function ($content) {
            return $content->name;
        });

        $show->field('active', __('状态'))->using([0 => '关闭', 1 => '开启'])->label('info');

        $show->field('images', __('图片'))->image();

        $show->field('sort', __('排序'))->label();

        $show->field('href', __('链接'))->link();

        $show->field('created_at', __('创建时间'));

        $show->field('updated_at', __('修改时间'));

        if(Admin::user()->type == "2" or Admin::user()->operate == "All"){

            $show->panel()->tools(function ($tools) {

                $tools->disableDelete(false);
                
            });

        }

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {   
        $form = new Form(new Plug());

        /**
         * @version [<vector>] [< 修改Plug时 如果不是超级管理员 其他操盘方禁止修改不属于自己的信息>]
         */
        if(Admin::user()->operate != "All" && request()->route()->parameters()){
            $Plug = Plug::where('id', request()->route()->parameters()['plug'])->first();
            if($Plug->operate != Admin::user()->operate) return abort('403'); 
        }

        $form->text('name', __('标题'));

        $form->image('images', __('图片'))->uniqueName();

        $form->hidden('operate', __('操盘号'))->value(Admin::user()->operate)->readonly();

        if(Admin::user()->operate == 'All'){
            $form->select('verify', __('审核'))->options([
                0   =>  '待审核',
                1   =>  '正常',
                -1  =>  '拒绝',
            ]);   
        }

        $form->switch('active', __('状态'))->default(1);
        
        $form->select('type_id', __('类型'))->options(PlugType::where('active', '1')->get()->pluck('name', 'id'));

        $form->number('sort', __('排序'))->default(0)->help('数值越大越靠前');

        $form->text('href', __('链接'))->default('#');
        
        $form->saving(function (Form $form) {
            
            if($form->isCreating()){
                $form->operate = Admin::user()->operate;
            }
        });

        return $form;
    }
}
