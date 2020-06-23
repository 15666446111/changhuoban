<?php

namespace App\Admin\Controllers;

use App\Brand;
use App\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;

class BrandController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '品牌管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Brand());

        $grid->column('brand_name', __('品牌名称'));

        $grid->column('active', __('状态'))->sortable()->switch();
        
        $grid->column('created_at', __('创建时间'));

        if(Admin::user()->type == "2" or Admin::user()->operate == "All"){
                
            $grid->disableCreateButton(false);

            $grid->actions(function (Grid\Displayers\Actions $actions) {

                $actions->disableEdit(false);

                $actions->disableDelete(false);

            });
            
        }

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();


            $filter->column(1/4, function ($filter) {
                
                $filter->like('brand_name', '标题');
                
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
        $show = new Show(Brand::findOrFail($id));

        $show->field('brand_name', __('品牌名称'));
        $show->field('active', __('品牌状态'))->using([0 => '关闭', 1 => '开启'])->label('info');
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('修改时间'));

        if(Admin::user()->type == "2" or Admin::user()->operate == "All"){

            $show->panel()->tools(function ($tools) {

                $tools->disableDelete(false);
                
            });

        }

        $show->products('产品列表', function ($products) {
            
            $products->model()->latest();

            $products->column('id', __('索引'))->sortable();

            $products->column('title', __('标题'));

            $products->column('price', __('价格'))->display(function($money){
                return number_format($money / 100, 2, '.', ',');
            })->label();

            $products->column('image', __('图片'))->image('', 60);

            $products->column('active', __('状态'))->switch();
            
            $products->column('brands.brand_name', __('品牌'));

            $products->column('state', __('审核'))->using([
                '0' => '待审核', '1' => '正常', '-1' => '拒绝'
            ])->label([
                '0' =>  'warning', '1' => 'success', '-1' => 'default'
            ]);

            $products->column('created_at', __('创建时间'));

            $products->filter(function ($filter) {
                // 去掉默认的id过滤器
                $filter->disableIdFilter();

                $filter->column(1/3, function ($filter) {
                    $filter->like('title', '标题');
                });

            });
            if(Admin::user()->type == "2" or Admin::user()->operate == "All"){

                $products->actions(function ($actions) {
                    $actions->disableEdit(false);
                    $actions->disableDelete(false);
                });

                $products->batchActions(function ($batch) {
                    $batch->disableDelete(false);
                });

            }

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
        $form = new Form(new Brand());

        $form->text('brand_name', __('品牌名称'));
        $form->switch('active', __('品牌状态'))->default(1);

        return $form;
    }
}
