<?php

namespace App\Admin\Controllers;

use App\AdminShort;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;

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
        $grid->column('number', __('短信编号'));

        $grid->column('content', __('短信内容'));

        $grid->column('created_at', __('创建时间'));

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
