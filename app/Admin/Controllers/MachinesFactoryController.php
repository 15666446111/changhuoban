<?php

namespace App\Admin\Controllers;

use App\MachinesType;
use App\MachinesFactory;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;

use Encore\Admin\Controllers\AdminController;

class MachinesFactoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '机具厂商';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MachinesFactory());

        $grid->model()->latest();
        
        $grid->column('id', __('索引'))->sortable();

        $grid->column('factory_name', __('厂商名称'))->help('机具厂商的名称');

        $grid->column('machines_types.name', __('所属类型'))->help('机具厂商所属的类型');

        $grid->column('created_at', __('创建时间'))->date('Y-m-d H:i:s')->help('机具厂商的创建时间');

        $grid->column('updated_at', __('修改时间'))->date('Y-m-d H:i:s')->help('机具厂商的最后修改时间');

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
            $model = MachinesFactory::where('id', $id)->first();
            if($model->operate != MachinesFactory::user()->operate) return abort('403');        
        }
        $show = new Show(MachinesFactory::findOrFail($id));

        $show->field('factory_name', __('厂商名称'));

        $show->field('created_at', __('创建时间'));

        $show->field('updated_at', __('修改时间'));

        $show->machines_types('类型信息', function ($type) {

            $type->name('类型名称');

            $type->panel()->tools(function ($tools) {
                $tools->disableEdit();
                $tools->disableList();
                $tools->disableDelete();
            });
        });

        $show->machines_styles('型号列表', function ($styles) {

            $styles->model()->latest();
            
            $styles->id('索引')->sortable();

            $styles->style_name('型号');

            $styles->created_at('创建时间')->date('Y-m-d H:i:s');

            $styles->filter(function ($filter) {
                $filter->like('factory_name');
            });
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
        $form = new Form(new MachinesFactory());

        $form->text('factory_name', __('厂商名称'));

        $form->select('type_id', __('所属类型'))->options(MachinesType::where('state', '1')->get()->pluck('name', 'id'))->rules('required');

        return $form;
    }
}
