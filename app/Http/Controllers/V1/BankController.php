<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankController extends Controller
{
    
    /**
     * 查询联行号接口
     */
    public function openBank($bank)
    {
        $host = "https://cnaps.market.alicloudapi.com";
        $path = "/lundroid/queryunionbankno";
        $method = "GET";
        $appcode = "2b98c225a8d24644959f3c7bcec08e23";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = 'bank='.$bank['bank_name'].'&city='.$bank['city'].'&province='.$bank['province'];
        $bodys = "";
        // $querys = "bank=中国民生银行&city=济南市&province=山东";
        $url = $host . $path . "?" . $querys;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }

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


        file_put_contents("./a.txt", json_encode($bankLink));


        if(!$bankLink) return false;

        if(empty($bankLink['data']['record'])) return false;

        return $bankLink['data']['record'][0]['bankCode'];
    }


}
