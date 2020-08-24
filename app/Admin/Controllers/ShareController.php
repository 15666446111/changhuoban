<?php

namespace App\Admin\Controllers;

use App\Share;
use App\ShareType;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\AdminController;

class ShareController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '分享列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Share());

        if(Admin::user()->operate != "All"){
            $grid->model()->where('operate', Admin::user()->operate);
        }
        
        $grid->model()->latest();
        //$grid->column('id', __('索引'))->sortable();

        $grid->column('images', __('图片'))->image('', 100, 30)->help('分享的素材底图');

        $grid->column('title', __('标题'))->help('分享展示的标题');

        $grid->column('active', __('状态'))->switch()->sortable()->help('分享的状态,关闭后 app将不会展示此条分享');

        $grid->column('share_types.name', __('类型'))->help('此次分享的展示位置');

        $grid->column('sort', __('排序'))->sortable()->editable()->label('default')->help('分享素材的排序权重,值越大 越在前');

        $grid->column('code_size', __('二维码大小'))->editable()->label('default')->help('分享素材所需要的二维码大小');

        $grid->column('code_x', __('X轴位置'))->editable()->label('default')->help('二维码在此素材的X轴位置,单位为像素(px)');

        $grid->column('code_y', __('Y轴位置'))->editable()->label('default')->help('二维码在此素材的Y轴位置,单位为像素(px)');

        $grid->column('verify', __('审核'))->using([ '0' => '待审核', '1' => '正常', '-1' => '拒绝'])
                ->dot([ 0 => 'danger', 1 => 'success' ], 'default')->help('添加素材之后默认为未审核的状态,由总后台审核后方可展示');

        $grid->column('created_at', __('创建时间'))->date('Y-m-d H:i:s')->help('此次分享信息的创建时间');

        //$grid->column('updated_at', __('修改时间'))->date('Y-m-d H:i:s');

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
                $filter->equal('type_id', '类型')->select(\App\ShareType::get()->pluck('name', 'id'));
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
        $show = new Show(Share::findOrFail($id));

        /**
         * @version [<vector>] [< 如果当前登录的为操盘方 检查当前分享图是否属于此操盘方>]
         */
        if(Admin::user()->operate != "All"){
            $model = Share::where('id', $id)->first();
            if($model->operate != Admin::user()->operate) return abort('403');        
        }

        $show->field('title', __('标题'));

        $show->field('share_types', __('所属分类'))->as(function ($content) {
            return $content->name;
        });

        $show->field('active', __('状态'))->using([0 => '关闭', 1 => '开启'])->label('info');

        $show->field('images', __('图片'))->image();

        $show->field('sort', __('排序'))->label();

        $show->field('code_size', __('二维码大小'))->label();

        $show->field('code_x', __('X轴位置'))->label();

        $show->field('code_y', __('Y轴位置'))->label();

        $show->field('created_at', __('创建时间'));

        $show->field('updated_at', __('修改时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Share());

        /**
         * @version [<vector>] [< 修改Plug时 如果不是超级管理员 其他操盘方禁止修改不属于自己的信息>]
         */
        if(Admin::user()->operate != "All" && request()->route()->parameters()){
            $Plug = Share::where('id', request()->route()->parameters()['share'])->first();
            if($Plug->operate != Admin::user()->operate) return abort('403'); 
        }

        $form->hidden('operate', __('操盘号'))->value(Admin::user()->operate)->readonly();

        $form->text('title', __('标题'));

        $form->switch('active', __('状态'))->default(1);

        $form->image('images', __('图片'))->uniqueName();

        $form->select('type_id', __('类型'))->options(ShareType::where('active', '1')->get()->pluck('name', 'id'));

        $form->number('sort', __('排序'))->default(0)->help('数值越大,越靠前');

        $form->number('code_size', __('二维码大小'))->default(100);

        $form->number('code_x', __('X轴位置'))->default(100);

        $form->number('code_y', __('Y轴位置'))->default(100);

        if(Admin::user()->operate == 'All'){
            $form->select('verify', __('审核'))->options([
                0   =>  '待审核',
                1   =>  '正常',
                -1  =>  '拒绝',
            ]);   
        }

        $form->saving(function (Form $form) {
            if($form->isCreating()){
                $form->operate = Admin::user()->operate;
            }
        });
        return $form;
    }
}
