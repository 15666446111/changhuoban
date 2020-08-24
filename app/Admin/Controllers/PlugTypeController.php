<?php

namespace App\Admin\Controllers;

use App\PlugType;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\AdminController;

class PlugTypeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '轮播图类型';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PlugType());

        $grid->model()->latest();
        
        $grid->column('id', __('索引'))->sortable();

        $grid->column('name', __('类型'))->help('轮播图展示的位置,由系统内置');

        $grid->column('active', __('状态'))->sortable()->switch()->help('轮播图位置的状态,关闭后无法在新增轮播图中选择');

        $grid->column('created_at', __('创建时间'))->date('Y-m-d H:i:s')->help('此信息的添加时间');

        $grid->column('updated_at', __('修改时间'))->date('Y-m-d H:i:s')->help('此信息的最后修改时间');

        $grid->disableCreateButton(false);

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->column(1/4, function ($filter) {
                $filter->like('name', '类型');
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
        if(Admin::user()->operate != "All"){
            $model = PlugType::where('id', $id)->first();
            if($model->operate != PlugType::user()->operate) return abort('403');        
        }
        $show = new Show(PlugType::findOrFail($id));

        $show->field('name', __('类型'));

        $show->field('active', __('状态'))->using([0 => '关闭', 1 => '正常']);

        $show->field('created_at', __('创建时间'));

        $show->field('updated_at', __('修改时间'));

        /* 展示该类型的轮播图 */
        $show->plugs('轮播图列表', function ($plugs) {

            $plugs->setResource('/admin/plugs');

            $plugs->model()->latest();

            $plugs->id('索引')->sortable();

            $plugs->name('标题');

            $plugs->active('状态')->bool();

            $plugs->sort('排序')->sortable()->label();

            $plugs->href('链接')->link()->copyable();

            $plugs->operate('所属操盘')->label('info');

            $plugs->created_at('创建时间')->date('Y-m-d H:i:s');
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
        $form = new Form(new PlugType());

        $form->text('name', __('类型'));

        $form->switch('active', __('开启'))->default(1);

        return $form;
    }
}
