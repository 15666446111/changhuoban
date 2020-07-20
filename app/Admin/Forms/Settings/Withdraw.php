<?php

namespace App\Admin\Forms\Settings;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\AdminController;

class Withdraw extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '提现设置';


    public $description = '自定义提现配置';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        
        $data = \App\Setting::where('operate', Admin::user()->operate)->first();
        
        $data->withdraw_open = $request->withdraw_open == "on" ? 1 : 0;

        $data->withdraw_pass = $request->withdraw_pass;

        $data->rate = $request->rate;

        $data->rate_m = $request->rate_m * 100;

        $data->return_blance = $request->return_blance;

        $data->return_money = $request->return_money * 100;

        $data->no_check = $request->no_check * 100;

        $data->no_check_return = $request->no_check_return * 100;

        $data->cash_min = $request->cash_min * 100;

        $data->return_min = $request->return_min * 100;

        $data->save();

        admin_success('自定义修改成功!');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {

        $this->switch('withdraw_open', '开启提现')->rules('required');

        $this->password('withdraw_pass', '提现审核密码')->rules('required')->help('审核提现订单时使用');

        $this->number('rate', '分润提现税点')->rules('required')->min(0)->max(20)->help('分润钱包提现时的税点,单位为百分位');

        $this->currency('rate_m', '分润提现单笔费用')->rules('required')->help('分润钱包提现时的单笔提现费,单位为元')->symbol('￥');

        $this->number('return_blance', '返现提现税点')->rules('required')->min(0)->max(20)->help('返现钱包提现时的税点,单位为百分位');

        $this->currency('return_money', '返现提现单笔费用')->rules('required')->help('返现钱包提现时的单笔提现费,单位为元')->symbol('￥');

        $this->currency('no_check', '分润免审核额度')->rules('required')->help('分润钱包提现时,低于此额度不用进行审核,单位为元')->symbol('￥');

        $this->currency('no_check_return', '返现免审核额度')->rules('required')->help('返现钱包提现时,低于此额度不用进行审核,单位为元')->symbol('￥');

        $this->currency('cash_min', '分润最低提现')->rules('required')->help('分润钱包提现时,最少的提现金额')->symbol('￥');

        $this->currency('return_min', '返现最低提现')->rules('required')->help('返现钱包提现时,最少的提现金额')->symbol('￥');

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

        $data->rate_m = $data->rate_m / 100;

        $data->return_money = $data->return_money / 100;

        $data->no_check = $data->no_check / 100;

        $data->no_check_return = $data->no_check_return / 100;

        $data->cash_min = $data->cash_min / 100;

        $data->return_min = $data->return_min / 100;

        return $data->toArray();
    }
}
