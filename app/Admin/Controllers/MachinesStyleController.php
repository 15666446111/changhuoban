<?php

namespace App\Admin\Controllers;

use App\MachinesStyle;
use App\MachinesType;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;

class MachinesStyleController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '机具型号';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MachinesStyle());

        $grid->model()->latest();
        
        $grid->column('id', __('索引'))->sortable();

        $grid->column('style_name', __('型号名称'))->help('机具的型号名称');

        $grid->column('machines_fact.factory_name', __('所属厂商'))->help('机具型号所属的厂商');

        // $grid->column('machines_fact.machines_types.name', __('所属类型'))->help('机具型号所属的类型');

        $grid->column('created_at', __('创建时间'))->date('Y-m-d H:i:s')->help('机具型号的创建时间');

        $grid->column('updated_at', __('修改时间'))->date('Y-m-d H:i:s')->help('机具型号的最后修改时间');

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
            $model = MachinesStyle::where('id', $id)->first();
            if($model->operate != MachinesStyle::user()->operate) return abort('403');        
        }
        $show = new Show(MachinesStyle::findOrFail($id));

        $show->field('style_name', __('型号名称'));

        $show->field('created_at', __('创建时间'));

        $show->field('updated_at', __('修改时间'));

        $show->machines_fact('厂商信息', function ($fact) {

            $fact->factory_name('类型名称');

            $fact->panel()->tools(function ($tools) {
                $tools->disableEdit();
                $tools->disableList();
                $tools->disableDelete();
            });
        });

        $show->machines('机具信息', function ($machines) {

            $machines->setResource('/machines');

            $machines->sn('机具终端');

            $machines->user_id('所属代理');

            $machines->open_state('开通状态')->bool();

            $machines->is_self('自备机')->bool();

            $machines->created_at('添加时间')->date('Y-m-d H:i:s');

            $machines->panel()->tools(function ($tools) {
                $tools->disableEdit();
                $tools->disableList();
                $tools->disableDelete();
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
        $form = new Form(new MachinesStyle());

        $form->text('style_name',   __('型号名称'));

        $form->select('aa', __('所属类型'))->options(MachinesType::where('state', '1')->get()->pluck('name', 'id'))->load('factory_id', '/api/getAdminFactory');

        $form->select('factory_id', __('所属厂商'))->required();

        $form->ignore(['aa']);

        return $form;
    }
}
