<?php

namespace App\Admin\Actions;

use Throwable;
use Illuminate\Http\Request;
use Encore\Admin\Actions\RowAction;
use App\Services\Cj\RepayCjController;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Facades\Admin;
use Maatwebsite\Excel\Validators\ValidationException;

class OrderTracking extends RowAction
{
    public $name = '物流信息';

    public function handle(Model $model, Request $request)
    {
        
        
    }


    public function form(Model $model)
    {
        
        //参数设置
        // $post_data = array();
        // $post_data["customer"] = '公司编号';
        // $key= '*****' ;
        // $post_data["param"] = '{"com":"yuantong","num":"*****"}';

        // $url='http://poll.kuaidi100.com/poll/query.do';
        // $post_data["sign"] = md5($post_data["param"].$key.$post_data["customer"]);
        // $post_data["sign"] = strtoupper($post_data["sign"]);
        // $o="";
        // foreach ($post_data as $k=>$v)
        // {
        //     $o.= "$k=".urlencode($v)."&";		//默认UTF-8编码格式
        // }
        // $post_data=substr($o,0,-1);
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_HEADER, 0);
        // curl_setopt($ch, CURLOPT_URL,$url);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        // $result = curl_exec($ch);
        // $data = str_replace("\"",'"',$result );
        // $data = json_decode($data,true);
        // return $data['data'];

        $data =[["context"=>"上海分拨中心-装件入车扫描",'time'=>'2012-08-28 16:33:19','ftime'=>'2012-08-28 16:33:19'],
        ["context"=>"上海分拨中心-下车扫描",'time'=>'2012-08-27 21:33:19','ftime'=>'2012-08-27 21:33:19']];

        $this->textarea('tracking_num','物流单号')->value(json_encode($data,JSON_UNESCAPED_UNICODE))->readonly();
    }

    

}