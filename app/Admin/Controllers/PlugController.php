<?php

namespace App\Admin\Controllers;

use App\Plug;
use \App\PlugType;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

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

        $grid->column('id', __('索引'))->sortable();

        $grid->column('name', __('标题'));

        $grid->column('active', __('状态'))->sortable()->switch();

        $grid->column('plug_types.name', __('类型'));
        
        $grid->column('images', __('图片'));
        
        $grid->column('sort', __('排序'))->sortable();
        
        $grid->column('href', __('链接'))->link();
        
        $grid->column('created_at', __('创建时间'))->date('Y-m-d H:i:s');

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();


            $filter->column(1/4, function ($filter) {
                $filter->like('name', '标题');
                
            });
            // 在这里添加字段过滤器
            
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

        $show->field('name', __('标题'));

        $show->field('active', __('状态'));

        $show->field('type_id', __('类型'));

        $show->field('images', __('图片'));

        $show->field('sort', __('排序'));

        $show->field('href', __('链接'));

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

        $form = new Form(new Plug());

        $form->text('name', __('标题'));

        $form->image('images', __('图片'));

        $form->switch('active', __('状态'))->default(1);
        //'/getPlugType'
        $form->select('type_id', __('类型'))->options(PlugType::where('active', '1')->get()->pluck('name', 'id'));

        $form->number('sort', __('排序'))->default(0)->help('数值越大越靠前');

        $form->text('href', __('链接'))->default('#');

        return $form;
    }
}
