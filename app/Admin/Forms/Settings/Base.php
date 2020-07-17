<?php

namespace App\Admin\Forms\Settings;

use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Widgets\Form;
use Encore\Admin\Controllers\AdminController;

class Base extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '基础配置';


    public $description = '自定义基础配置';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        
        admin_success('自定义修改成功!');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {


    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {   
        if(Admin::user()->type != 3){
            admin_error('抱歉, 您无权操作.'); 
            return response()->back();
        } 
        
        $data = \App\Setting::where('operate', Admin::user()->operate)->first();

        if(!$data or empty( $data ))

        $data = \App\Setting::create(['operate' => Admin::user()->operate]);

        $data = \App\Setting::where('operate', Admin::user()->operate)->first();

        return $data->toArray();
    }
}
