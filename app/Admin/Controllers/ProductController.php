<?php

namespace App\Admin\Controllers;

use App\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;

class ProductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product());

        $grid->column('id', __('索引'));

        $grid->column('title', __('标题'));

        $grid->column('price', __('价格'))->display(function($money){
            return number_format($money / 100, 2, '.', ',');
        })->label();

        $grid->column('image', __('图片'))->image('', 60);

        $grid->column('active', __('状态'))->switch();
        
        $grid->column('brands.brand_name', __('品牌'));

        $grid->column('state', __('审核'))->using([
            '0' => '待审核', '1' => '正常', '-1' => '拒绝'
        ])->label([
            '0' =>  'warning', '1' => 'success', '-1' => 'default'
        ]);

        $grid->column('created_at', __('创建时间'));

        $grid->disableCreateButton(false);

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableDelete(false);
        });
    
        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();
        });

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
        $show = new Show(Product::findOrFail($id));

        if(Admin::user()->operate != "All"){
            $Plug = Product::where('id', $id)->first();
            if($Plug->operate != Admin::user()->operate) return abort('403');        
        }

        $show->field('title', __('产品标题'));
        $show->field('image', __('缩略图'));
        $show->field('active', __('状态'));
        $show->field('type', __('品牌'));
        $show->field('price', __('价格'));
        $show->field('content', __('内容'));
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
        $form = new Form(new Product());

        if(Admin::user()->operate != "All" && request()->route()->parameters()){
            $Plug = Plug::where('id', request()->route()->parameters()['plug'])->first();
            if($Plug->operate != Admin::user()->operate) return abort('403'); 
        }

        $form->text('title', __('产品标题'));
        $form->image('image', __('缩略图'));
        $form->switch('active', __('状态'))->default(1);
        $form->select('type', __('品牌'))->options(\App\Brand::where('active', '1')->get()->pluck('brand_name', 'id'));
        $form->number('price', __('价格'));
        $form->ueditor('content', __('内容'));

        if(Admin::user()->operate == 'All'){
            $form->select('verify', __('审核'))->options([
                0   =>  '待审核',
                1   =>  '正常',
                -1  =>  '拒绝',
            ]);   
        }

        return $form;
    }
}
