<?php

namespace App\Admin\Forms;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\AdminController;

class Setting extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '操盘方设置';


    public $description = '操盘方自定义参数设置';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        //dump($request->all());

        admin_success('Processed successfully.');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {

        $this->switch('withdraw_open', '开启提现')->rules('required');

        $this->switch('verify', '是否审核')->rules('required');

        $this->number('rate', '分润提现税点')->rules('required')->help('分润钱包提现时的税点,单位为百分位');

        $this->number('rate_m', '分润提现单笔费用')->rules('required')->help('分润钱包提现时的单笔提现费,单位为百分位');

        $this->number('return_blance', '返现提现税点')->rules('required')->help('返现钱包提现时的税点,单位为百分位');

        $this->number('return_money', '返现提现单笔费用')->rules('required')->help('返现钱包提现时的单笔提现费,单位为百分位');

        $this->number('no_check', '分润免审核额度')->rules('required')->help('分润钱包提现时,低于此额度不用进行审核,单位 分');

        $this->number('no_check_return', '返现免审核额度')->rules('required')->help('返现钱包提现时,低于此额度不用进行审核,单位 分');

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
