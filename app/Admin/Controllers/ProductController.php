<?php

namespace App\Admin\Controllers;

use App\Product;
use App\MachinesStyle;
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

        //展示该操盘方下的产品数据
        if(Admin::user()->operate != "All"){
            $grid->model()->where('operate', Admin::user()->operate);
        }

        $grid->model()->latest();

        //$grid->column('id', __('索引'));

        $grid->column('title', __('标题'));

        $grid->column('price', __('价格'))->display(function($money){
            return number_format($money, 2, '.', ',');
        })->label();

        $grid->column('image', __('图片'))->image('', 60);

        $grid->column('active', __('状态'))->switch();
        
        $grid->column('style.style_name', __('型号'));

        $grid->column('state', __('审核'))->using([
            '0' => '待审核', '1' => '正常', '-1' => '拒绝'
        ])->label([
            '0' =>  'warning', '1' => 'success', '-1' => 'default'
        ]);

        $grid->column('created_at', __('创建时间'));

        if(Admin::user()->type == "2" or Admin::user()->operate == "All"){
                
            $grid->disableCreateButton(false);  

            $grid->actions(function (Grid\Displayers\Actions $actions) {

                $actions->disableEdit(false);

                $actions->disableDelete(false);

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
        $show = new Show(Product::findOrFail($id));

        if(Admin::user()->operate != "All"){
            $Plug = Product::where('id', $id)->first();
            if($Plug->operate != Admin::user()->operate) return abort('403');        
        }

        $show->field('title', __('产品标题'));
        $show->field('image', __('缩略图'));
        $show->field('active', __('状态'));
        $show->field('style.style_name', __('型号'));
        $show->field('price', __('价格'));
        $show->field('content', __('内容'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('修改时间'));

        if(Admin::user()->type == "2" or Admin::user()->operate == "All"){

            $show->panel()->tools(function ($tools) {

                $tools->disableDelete(false);
                
            });

        }

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
            $Plug = Product::where('id', request()->route()->parameters()['product'])->first();
            if($Plug->operate != Admin::user()->operate) return abort('403'); 
        }
        
        if($form->isCreating()){

            $form->text('title', __('产品标题'));

            $form->image('image', __('缩略图'));

            $form->switch('active', __('状态'))->default(1);

            $type = \App\MachinesType::where('state',1)->get()->pluck('name', 'id');

            $form->hidden('operate', __('操盘号'))->value(Admin::user()->operate)->readonly();

            $form->select('name','类型')->options($type)->load('factory_name','/api/getAdminFactory');

            $form->select('factory_name','厂商')->load('style_id','/api/getAdminStyle');

            $form->select('style_id','型号')->required();

            $form->ignore(['name','factory_name']);

            $form->currency('price', __('价格'))->symbol('￥');

            $form->ueditor('content', __('内容'));

        }else{

            $form->text('title', __('产品标题'));

            $form->image('image', __('缩略图'));

            $form->switch('active', __('状态'))->default(1);

            $form->hidden('style_id','型号')->required();

            $form->currency('price', __('价格'))->symbol('￥');

            $form->ueditor('content', __('内容'));
            
        }
        

        if(Admin::user()->operate == 'All'){
            $form->select('state', __('审核'))->options([
                0   =>  '待审核',
                1   =>  '正常',
                -1  =>  '拒绝',
            ]);   
        }
        
        return $form;
    }
}
