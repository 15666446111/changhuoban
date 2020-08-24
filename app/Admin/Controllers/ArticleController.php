<?php

namespace App\Admin\Controllers;

use App\Article;
use App\ArticleType;
use App\Articles_log;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\AdminController;

class ArticleController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '文章列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article());

        if(Admin::user()->operate != "All"){
            $grid->model()->where('operate', Admin::user()->operate);
        }

        $grid->model()->latest();

        //$grid->column('id', __('Id'));
        
        $grid->column('title', __('标题'))->help('文章的标题');

        $grid->column('active', __('状态'))->switch()->sortable()->help('文章的状态,关闭后 app将不会展示');

        $grid->column('images', __('图片'))->image('', 100, 30)->help('文章的缩略图图片');

        $grid->column('article_types.name', __('文章类型'))->help('文章的展示位置');

        $grid->column('sort', __('排序'))->sortable()->label()->help('文章的排序权重, 值约高越靠前');

        $grid->column('verify', __('审核'))
                ->using([ '0' => '待审核', '1' => '正常', '-1' => '拒绝'])
                ->dot([ 0 => 'danger', 1 => 'success' ], 'default')->help('文章的审核状态,新增文章默认为未审核,由总后台审核后方可展示');

        $grid->column('created_at', __('创建时间'))->date('Y-m-d H:i:s')->help('文章的创建时间');

        //$grid->column('updated_at', __('Updated at'));
        //
        if(Admin::user()->type == "2" or Admin::user()->operate == "All"){
                
            $grid->disableCreateButton(false);

            $grid->actions(function (Grid\Displayers\Actions $actions) {

                $actions->disableEdit(false);

                $actions->disableDelete(false);

            });
            
        }
        
        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->column(1/4, function ($filter) {
                $filter->like('title', '标题');
            });
            // 在这里添加字段过滤器
            $filter->column(1/4, function ($filter) {
                $filter->equal('verify', '审核')->select(['0' => '待审核', '1' => '正常', '2'=> '拒绝']);
            }); 

            $filter->column(1/4, function ($filter) {
                $filter->equal('type_id', '类型')->select(\App\ArticleType::get()->pluck('name', 'id'));
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
        $show = new Show(Article::findOrFail($id));

        /**
         * @version [<vector>] [< 如果当前登录的为操盘方 检查当前分享图是否属于此操盘方>]
         */
        if(Admin::user()->operate != "All"){
            $model = Article::where('id', $id)->first();
            if($model->operate != Admin::user()->operate) return abort('403');        
        }

        $show->field('title', __('标题'));

        $show->field('article_types', __('分类'))->as(function ($content) {
            return $content->name;
        });

        $show->field('active', __('状态'))->using([0 => '关闭', 1 => '开启'])->label('info');

        $show->field('images', __('图片'))->image()->uniqueName();

        $show->field('sort', __('排序'))->label();

        $show->field('created_at', __('创建时间'));

        $show->field('updated_at', __('修改时间'));

        $show->content('文章内容')->unescape()->as(function ($content) {
            return $content;
        });

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
        $form = new Form(new Article());

        /**
         * @version [<vector>] [< 修改Plug时 如果不是超级管理员 其他操盘方禁止修改不属于自己的信息>]
         */
        if(Admin::user()->operate != "All" && request()->route()->parameters()){
            $Plug = Article::where('id', request()->route()->parameters()['article'])->first();
            if($Plug->operate != Admin::user()->operate) return abort('403'); 
        }
        
        $form->hidden('operate', __('操盘号'))->value(Admin::user()->operate)->readonly();

        $form->text('title', __('标题'));

        $form->switch('active', __('状态'))->default(1);

        $form->image('images', __('图片'));

        $form->select('type_id', __('类型'))->options(ArticleType::where('active', '1')->get()->pluck('name', 'id'));

        $form->number('sort', __('排序'))->default(0)->help('数值越大越靠前');

        if(Admin::user()->operate == 'All'){
            $form->select('verify', __('审核'))->options([
                0   =>  '待审核',
                1   =>  '正常',
                -1  =>  '拒绝',
            ]);   
        }
        
        $form->ueditor('content', __('内容'));


        $form->saving(function (Form $form) {
            // dd($form->images);
            if($form->isCreating()){
                $form->operate = Admin::user()->operate;
            }
            
        });

        return $form;
    }

    
}
