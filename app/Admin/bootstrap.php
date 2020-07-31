<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;

// 自定义导航
Admin::navbar(function (\Encore\Admin\Widgets\Navbar $navbar) {
    if(Admin::user() && Admin::user()->type == "3"){
        $navbar->right('<li> <a href="/manage/settings"><i class="fa fa-cog"></i> <span class="label label-success"></span></a></li>');
    }
});

/** Form view init */
Form::init(function (Form $form) {
    $form->disableEditingCheck();
    $form->disableCreatingCheck();
    $form->disableViewCheck();
    $form->tools(function (Form\Tools $tools) {
        $tools->disableDelete();
    });
});

/** Show view init */
Show::init(function (Show $show) {
    $show->panel()->tools(function (Show\Tools $tools) {
        $tools->disableDelete();
        // $tools->disableEdit();
    });
});

/** Grid view init */
Grid::init(function (Grid $grid) {
    // 去掉批量编辑
    $grid->batchActions(function ($batch) {
        $batch->disableDelete();
    });
    
    //$grid->disableCreateButton();
    $grid->actions(function (Grid\Displayers\Actions $actions) {
        //$actions->disableEdit();
        $actions->disableDelete();
    });
});


Admin::css('/css/admin.css?v='.time());
//Encore\Admin\Form::forget(['map', 'editor']);
// 覆盖视图
app('view')->prependNamespace('admin', resource_path('views/admin/views'));
