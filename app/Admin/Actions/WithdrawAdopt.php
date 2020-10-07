<?php

namespace App\Admin\Actions;

use Illuminate\Http\Request;
use Encore\Admin\Actions\RowAction;
use App\Services\Cj\RepayCjController;
use Illuminate\Database\Eloquent\Model;

class WithdrawAdopt extends RowAction
{
    public $name = '提现通过';

    public function handle(Model $model, Request $request)
    {
        // 处理错误
        try {
            if(!$request->pass) return $this->response()->error('请填写提现密码')->refresh();

            // 添加一条虚拟交易订单，只做交易记录的sn和商户号匹配
            $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'H', 'I', 'J', 'K');

            $order_no = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));

            $model->order_no = $order_no;
            $model->save();
            // 获取当前登陆的操盘方配置
            $application = new RepayCjController($model);
            $result = $application->apply( $request->pass );
                
            if($result['code'] && $result['code'] == 10000 ) 
                return $this->response()->success($result['message'])->refresh();
            else 
                return $this->response()->error($result['message'])->refresh();
        } catch (Exception $e) {
            return $this->response()->error('错误:'.$e->getMessage());
        }
        
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-08-22
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 提现审核密码 必填项 ]
     * @return    [type]      [description]
     */
    public function form()
    {
     	// 单选框
        $this->password('pass', '审核密码')->required()->help('请输入您在设置中设置的提现审核密码!');
    }

}