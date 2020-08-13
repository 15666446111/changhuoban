<?php

namespace App\Admin\Controllers;

use App\MachinesType;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;

class MachinesTypeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '机器类型';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MachinesType());

        $grid->model()->latest();
        
        $grid->column('id', __('索引'))->sortable();

        $grid->column('name', __('类型名称'))->help('机器类型的名称');

        $grid->column('state', __('状态'))->sortable()->switch()->help('机器类型的状态,关闭后在新增厂商时无法选择此类型');

        $grid->column('created_at', __('创建时间'))->date('Y-m-d H:i:s')->help('类型的创建的时间');

        $grid->column('updated_at', __('修改时间'))->date('Y-m-d H:i:s')->help('类型的创最后修改时间');

        $grid->actions(function ($actions) {

            // 去掉删除
            $actions->disableDelete();
        
            // 去掉编辑
            // $actions->disableEdit();
        
            // 去掉查看
            // $actions->disableView();
        });

        $grid->disableCreateButton();

        $grid->batchActions(function ($batch) {
            $batch->disableDelete();
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
        if(Admin::user()->operate != "All" && request()->route()->parameters()){
            $MachinesType = MachinesType::where('id', request()->route()->parameters()['machines_types'])->first();
            if($MachinesType->operate != Admin::user()->operate) return abort('403'); 
        }
        $show = new Show(MachinesType::findOrFail($id));

        $show->field('name', __('类型名称'));

        $show->field('state', __('类型状态'))->using([0 => '关闭', 1 => '开启'])->label('info');

        $show->field('created_at', __('创建时间'));

        $show->field('updated_at', __('修改时间'));

        $show->machines_factorys('厂商列表', function ($factorys) {

            $factorys->model()->latest();
            
            $factorys->id('索引')->sortable();

            $factorys->factory_name('厂商');

            $factorys->created_at('创建时间')->date('Y-m-d H:i:s');

            $factorys->filter(function ($filter) {
                $filter->like('factory_name');
            });
        });

        $show->panel()->tools(function ($tools) {

            $tools->disableDelete();

            $tools->disableEdit();
            
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
        $form = new Form(new MachinesType());

        $form->text('name', __('类型名称'));

        $form->switch('state', __('类型状态'))->default(1);

        $form->number('sort', __('类型排序'))->default(1);

        return $form;
    }
}
