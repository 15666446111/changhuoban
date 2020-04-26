<?php

namespace App\Admin\Controllers;

use App\Machine;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

use App\Admin\Actions\ImportMachines;
use App\Admin\Actions\MachineHeadTail;
use Encore\Admin\Controllers\AdminController;

class MachineController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '机具仓库';


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Machine());

        $grid->column('sn', __('机具终端'));

        $grid->column('machines_styles.style_name', __('机具类型'));

        $grid->column('users.nickname', __('所属代理'));

        $grid->column('open_state', __('开通状态'))->bool();

        $grid->column('is_self', __('活动自备机'))->bool();

        $grid->column('created_at', __('创建时间'))->date('Y-m-d H:i:s');

        $grid->tools(function ($tools) {

            $tools->append(new ImportMachines());

            $tools->append(new MachineHeadTail());
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
        $show = new Show(Machine::findOrFail($id));

        $show->field('user_id', __('User id'));
        $show->field('sn', __('Sn'));
        $show->field('open_state', __('Open state'));
        $show->field('is_self', __('Is self'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('style_id', __('Style id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Machine());

        $form->select('style_id', __('所属型号'))->options(['a' => 1, 'b' => '2']);

        $form->text('sn', __('机具终端'));

        $form->switch('open_state', __('开通状态'));

        $form->switch('is_self', __('是否自备机'));

        return $form;
    }
}
