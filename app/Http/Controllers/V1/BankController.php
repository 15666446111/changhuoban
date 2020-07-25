<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankController extends Controller
{
    /**
     * @Author    Pudding
     * @DateTime  2020-07-18
     * @copyright [copyright]
     * @license   [license]
     * @version   [version]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function insertBank(Request $request)
    {
        try{ 
            
            if(!$request->name){
                return response()->json(['error'=>['message' => '请填写您的姓名']]);
            }

            if(!$request->bank){
                return response()->json(['error'=>['message' => '请填写银行卡号']]);
            }

            if(!$request->bank_name){
                return response()->json(['error'=>['message' => '请填写银行名称']]);
            }

            if(!$request->number){
                return response()->json(['error'=>['message' => '请填写身份证号']]);  
            }

            if(!$request->open_bank){
                return response()->json(['error'=>['message' => '请填写开户行信息']]);
            } 

            if(!$request->city or !$request->province){
                return response()->json(['error'=>['message' => '请填写省市信息']]);
            } 
            
            $banklink = $this->openBank($request->bank_name, $request->bank, $request->province, $request->city,);

            if(!$banklink){
                 return response()->json(['error'=>['message' => '获取联行号失败!']]);
            }

            if($request->is_default && $request->is_default == 1){
                \App\Bank::where('user_id',$request->user->id)->update(['is_default'=>0]);
            }
            
            $card = \App\Bank::create([
                'user_id'   => $request->user->id,
                'user_name' => $request->name,
                'bank_name' => $request->bank_name,
                'bank'      => $request->bank,
                'number'    => $request->number,
                'open_bank' => $request->open_bank,
                'is_default'=> $request->is_default ?? 0,
                'bank_open' => $banklink,
                'city'      => $request->city,
                'province'  => $request->province
            ]);

            return response()->json(['success'=>['message' => '添加成功!', 'data' => $card ]]); 

        } catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '银行卡信息不正确']]);

        }
    }



    /**
     * @Author    Pudding
     * @DateTime  2020-07-18
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 查询结算卡信息]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function selectBank(Request $request)
    {
        try{ 
            
            $data=\App\Bank::where('user_id',$request->user->id)->where('is_del', 0)->orderBy('is_default','desc')->get();

            return response()->json(['success'=>['message' => '获取成功!', 'data'=>$data]]); 

        } catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-18
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 查询默认结算卡 ]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function bankDefault(Request $request)
    {
        try{ 
            
            $data=\App\Bank::where('user_id', $request->user->id)->where('is_default','1')->where('is_del',0)->first();

            return response()->json(['success'=>['message' => '获取成功!', 'data'=>$data]]); 

        } catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-18
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 查询单个银行卡信息接口 ]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function bankFirst(Request $request)
    {
        try{ 

            if(!$request->id) return response()->json(['error'=>['message' => '缺少必要参数:请选择银行卡']]);
            
            $data=\App\Bank::where('user_id',$request->user->id)->where('id',$request->id)->first();

            return response()->json(['success'=>['message' => '获取成功!', 'data'=>$data]]); 

        } catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-18
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 删除银行卡结算信息接口 ]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function unsetBank(Request $request)
    {
        try{ 

            if(!$request->id) return response()->json(['error'=>['message' => '缺少必要参数:请选择银行卡']]);
            
            \App\Bank::where('user_id',$request->user->id)->where('id',$request->id)->update(['is_del'=>1]);

            return response()->json(['success'=>['message' => '删除成功!', []]]); 

        } catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }



    /**
     * @Author    Pudding
     * @DateTime  2020-07-18
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 修改结算卡信息 ]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function updateBank(Request $request)
    {
        try{ 
            
            if(!$request->id) return response()->json(['error'=>['message' => '缺少必要参数:请选择银行卡']]);

            if(!$request->name) return response()->json(['error'=>['message' => '缺少必要参数:姓名']]);

            if(!$request->bank) return response()->json(['error'=>['message' => '缺少必要参数:银行卡号']]);

            if(!$request->bank_name) return response()->json(['error'=>['message' => '缺少必要参数:银行名称']]);

            if(!$request->number) return response()->json(['error'=>['message' => '缺少必要参数:身份证号']]);

            if(!$request->open_bank) return response()->json(['error'=>['message' => '缺少必要参数:开户行']]);

            if(!$request->city) return response()->json(['error'=>['message' => '缺少必要参数:市']]);

            if(!$request->province) return response()->json(['error'=>['message' => '缺少必要参数:省']]);

            $query = \App\Bank::where('user_id',$request->user->id)->where('id',$request->id)->first();

            if(empty($query)){
                return response()->json(['error'=>['message' => '结算卡信息获取失败']]);
            }

            $banklink = $this->openBank($request->bank_name, $request->bank, $request->province, $request->city,);

            if(!$banklink){
                 return response()->json(['error'=>['message' => '获取联行号失败!']]);
            }

            if($request->is_default == 1){
                \App\Bank::where('user_id',$request->user->id)->update([ 'is_default' =>0 ]);
            }

            $bank = \App\Bank::where('user_id',$request->user->id)->where('id',$request->id)->update([
                    'user_name' =>  $request->name,
                    'bank_name' =>  $request->bank_name,
                    'bank'      =>  $request->bank,
                    'number'    =>  $request->number,
                    'open_bank' =>  $request->open_bank,
                    'is_default'=>  $request->is_default ?? 0,
                    'bank_open' =>  $banklink,
                    'city'      =>$request->city,
                    'province'  =>$request->province
                ]);

            return response()->json(['success'=>['message' => '修改成功!', 'data' => $bank ]]); 


        } catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '银行卡信息不正确']]);

        }
    }



    /**
     * 查询联行号接口
     */
    public function openBank($bank_name, $card, $province, $city)
    {
        $host = "https://cnaps.market.alicloudapi.com";
        $path = "/lianzhuo/querybankaps";
        $method = "GET";
        $appcode = "2b98c225a8d24644959f3c7bcec08e23";//AppCode
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);

        $data = [
            'bank'      => $bank_name,
            'card'      => $card,
            'city'      => $city,
            'province'  => $province,
        ];
        $querys = http_build_query($data , '' , '&');

        $bodys = "";

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

        if(!$bankLink) return false;

        if(!$bankLink['data']) return false;

        if(empty($bankLink['data']['record'])) return false;

        return $bankLink['data']['record'][0]['bankCode'];
    }


}
