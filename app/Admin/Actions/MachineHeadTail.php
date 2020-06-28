<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\Action;
use Illuminate\Http\Request;

class MachineHeadTail extends Action
{
    protected $selector = '.machine-head-tail';

    public function handle(Request $request)
    {
        // $request ...
        try { 
            if(!$request->head or !$request->tail){
                return $this->response()->error('参数无效!')->refresh();
            }

            if($request->tail < $request->head){
                return $this->response()->error('终端尾行不能低于首行')->refresh();
            }

            $data = [];

            if(strlen($request->head) != strlen($request->tail)){
                return $this->response()->error('终端首尾长度不一样')->refresh();
            }

            //
            $lenth = strlen($request->head);


            for($i = $request->head; $i<= $request->tail; $i++){

                $i =sprintf("%0".$lenth."d", $i);

                $data[] = $i;

            }
            
            $eplice = \App\Machine::whereIn('sn', $data)->pluck('sn')->toArray();
            // 交集
            $epliceRows = array_intersect($data, $eplice);
            // 差集
            $InsertData = array_diff($data, $eplice);

            foreach ($InsertData as $key => $value) {
                \App\Machine::create([
                    'sn'       =>  $value,
                    'style_id'          =>  $request->style_id,
                ]);
            }

        }catch (Throwable $throwable) {

            $this->response()->status = false;

            return $this->response()->swal()->error($throwable->getMessage());
        }

        return $this->response()->success('补全成功!')->refresh();
    }

    public function html()
    {
        return <<<HTML
        <a class="btn btn-sm btn-default machine-head-tail"><i class="fa fa-balance-scale" style="margin-right: 3px;"></i>首尾补全</a>
HTML;
    }


    /**
     * [form 点击的按钮 出来的表单]
     * @author Pudding
     * @DateTime 2020-04-21T15:58:56+0800
     * @return   [type]                   [description]
     */
    public function form()
    {
        $Type = \App\MachinesType::where('state', '1')->get()->pluck('name','id');

        $this->select('type', '机具类型')->options($Type)->load('factory', '/api/getAdminFactory');

        $this->select('factory', '机具厂商');

        $this->text('head', '机具首行终端号')->rules('required', ['required' => '首行不能为空']);

        $this->text('tail', '机具尾行终端号')->rules('required', ['required' => '尾行不能为空']);
    }
}