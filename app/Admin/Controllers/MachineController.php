<?php

namespace App\Admin\Controllers;

use App\Machine;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
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

        if(Admin::user()->operate != "All"){

            $grid->filter(function ($filter) {
                // 去掉默认的id过滤器
                $filter->disableIdFilter();
    
                $filter->column(1/3, function ($filter) {
                    $filter->like('sn', '终端编号');
                });
    
                $filter->column(1/4, function ($filter) {
                    $filter->equal('open_state', '状态')->select(['0' => '未开通', '1' => '已开通']);
                });
    
                $filter->column(1/3, function ($filter) {
                    $filter->like('users.nickname', '所属代理');
                });
    
            });
    
            $grid->tools(function ($tools) {
    
                $tools->append(new ImportMachines());
    
                $tools->append(new MachineHeadTail());
            });

        }

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
            $model = Machine::where('id', $id)->first();
            if($model->operate != Machine::user()->operate) return abort('403');        
        }
        $show = new Show(Machine::findOrFail($id));

        $show->field('user_id', __('归属人'));
        $show->field('sn', __('机器序列号'));
        $show->field('open_state', __('开通状态'));
        $show->field('is_self', __('是否是自备机'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('style_id', __('所属型号'));

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
