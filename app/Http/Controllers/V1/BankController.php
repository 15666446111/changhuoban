<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankController extends Controller
{
    
    /**
     * 查询联行号接口
     */
    public function openBank()
    {
        $host = "http://cnaps.market.alicloudapi.com";
        $path = "/lianzhuo/querybankaps";
        $method = "GET";
        $appcode = "2b98c225a8d24644959f3c7bcec08e23";//AppCode
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "bank=%E5%B7%A5%E5%95%86%E9%93%B6%E8%A1%8C&card=6226286336722163&city=%E6%B5%8E%E5%8D%97%E5%B8%82&key=%E6%A7%90%E8%8D%AB&page=1&province=%E5%B1%B1%E4%B8%9C%E7%9C%81";
        $bodys = "";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        $data = curl_exec($curl);
        $bankLink = json_decode($data,true);
        return $bankLink['data']['record'][0]['bankCode'];
    }


}
