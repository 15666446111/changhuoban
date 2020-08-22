<?php

namespace App\Admin\Controllers;

use App\ShareType;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;

class ShareTypeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '分享类型';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ShareType());

        $grid->model()->latest();
        
        $grid->column('id', __('索引'))->sortable();

        $grid->column('name', __('类型'))->help('分享展示的位置,由系统内置');

        $grid->column('active', __('状态'))->switch()->sortable()->help('分享位置的状态,关闭后 新增分享将无法选择此位置');

        $grid->column('created_at', __('创建时间'))->date('Y-m-d H:i:s')->help('此信息的创建时间');

        $grid->column('updated_at', __('删除时间'))->date('Y-m-d H:i:s')->help('此信息的最后修改时间');

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->column(1/4, function ($filter) {
                $filter->like('name', '类型');
                
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
        if(Admin::user()->operate != "All"){
            $model = ShareType::where('id', $id)->first();
            if($model->operate != ShareType::user()->operate) return abort('403');        
        }
        $show = new Show(ShareType::findOrFail($id));

        $show->field('name', __('类型'));

        $show->field('active', __('状态'))->using([0 => '关闭', 1 => '正常']);

        $show->field('created_at', __('创建时间'));

        $show->field('updated_at', __('修改时间'));

        /* 展示该分享类型的素材 */
        $show->shares('分享素材', function ($shares) {

            $shares->setResource('/admin/shares');

            $shares->model()->latest();

            $shares->id('索引')->sortable();

            $shares->title('标题');

            $shares->active('状态')->bool();

            $shares->sort('排序')->sortable()->label();

            $shares->code_size('二维码大小')->label();

            $shares->code_x('X轴位置')->label();

            $shares->code_y('Y轴位置')->label();

            $shares->operate('所属操盘')->label('info');

            $shares->created_at('创建时间')->date('Y-m-d H:i:s');
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
        $form = new Form(new ShareType());

        $form->text('name', __('类型'));

        $form->switch('active', __('状态'))->default(1);

        return $form;
    }
}
