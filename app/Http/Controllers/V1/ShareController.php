<?php

namespace App\Http\Controllers\V1;

use File;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ShareController extends Controller
{	
	/**
	 * @version  [<团队扩展二维码海报分享>]
	 * @author   Pudding   
	 * @DateTime 2020-04-08T17:17:40+0800
	 * @param    Request
	 * @return   [type]
	 */
    public function team(Request $request)
    {
        try{
            /** 获取分享类型的素材  */
            // 操盘方分享素材
            $list = \App\Share::where('type_id', 1)->where('operate', $request->user->operate)->ApiGet()->first();

            $adminPoster = \App\Share::where('type_id', 1)->where('operate', 'All')->first();

            $list = empty($list) ? $adminPoster : $list;

            if(!$list or empty($list)) return response()->json(['success'=>['message' => '暂无素材可以分享!', 'data' => array()]]);

            // 生成分享地址
            $Url = "http://".$_SERVER["HTTP_HOST"]."/team/".Hashids::encode($request->user->id);
            
            // 二维码地址
            $CodePath = public_path('/share/'.$request->user->id.'/qrcodes/');
            // 目录不存在则重建
            File::isDirectory($CodePath) or File::makeDirectory($CodePath, 0777, true, true);
            //二维码文件
            $CodeFile = $CodePath."qrcode.png";
            // 生成二维码
            QrCode::format('png')->size($list->code_size)->margin($list->code_margin)->generate($Url, $CodeFile);

            $typeArr=getimagesize(storage_path('app/public/'.$list->getOriginal('images')));

            switch($typeArr['mime'])
            {
                case "image/png":
                    $BackGroud=imagecreatefrompng(storage_path('app/public/'.$list->getOriginal('images')));
                    break;

                case "image/jpg":
                    $BackGroud=imagecreatefromjpeg(storage_path('app/public/'.$list->getOriginal('images')));
                    break;
                case "image/jpeg":
                    $BackGroud=imagecreatefromjpeg(storage_path('app/public/'.$list->getOriginal('images')));
                    break;

                case "image/gif":
                    $BackGroud=imagecreatefromgif(storage_path('app/public/'.$list->getOriginal('images')));
                    break;
            }


            // 合成图片
            //$BackGroud =  imagecreatefromjpeg(storage_path('app/public/'.$list->image));
            $qrcode    =  imagecreatefrompng($CodeFile);

            imagecopyresampled($BackGroud, $qrcode, $list->code_x, $list->code_y, 0, 0, imagesx($qrcode), imagesy($qrcode), imagesx($qrcode), imagesy($qrcode));

            // 海报生成位置
            $PicPath   = public_path('/share/'.$request->user->id.'/team_share/');
            File::isDirectory($PicPath) or File::makeDirectory($PicPath, 0777, true, true);

            $PicFile   = $PicPath.$list->id.".png";

            imagepng($BackGroud, $PicFile);

            $link = "http://".$_SERVER["HTTP_HOST"]."/share/".$request->user->id."/team_share/".$list->id.".png";

            return response()->json(['success'=>['message' => '获取成功!', 'data' => ['link' => $link."?time=".time() ]]]);

        } catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }



    /**
     * @version  [<商户注册二维码海报分享>]
     * @author   Pudding   
     * @DateTime 2020-04-08T17:17:40+0800
     * @param    Request
     * @return   [type]
     */
    public function merchant(Request $request)
    {
        try{
            
            /** 获取分享类型的素材  */
            // 操盘方分享素材
            $list = \App\Share::where('type_id', 2)->where('operate', $request->user->operate)->ApiGet()->first();

            $adminPoster = \App\Share::where('type_id', 2)->where('operate', 'All')->ApiGet()->first();

            $list = empty($list) ? $adminPoster : $list;

            if(!$list or empty($list)) return response()->json(['success'=>['message' => '暂无素材可以分享!', 'data' => array()]]);

            // 分享地址
            $Url = \App\AdminSetting::where('operate_number', $request->user->operate)->value('register_merchant');

            if($Url == null or $Url=="") return response()->json(['error'=>['message' => '无配置商户注册地址!', 'data' => array()]]);
            
            // 二维码地址
            $CodePath = public_path('/share/'.$request->user->id.'/qrcodes/');
            // 目录不存在则重建
            File::isDirectory($CodePath) or File::makeDirectory($CodePath, 0777, true, true);
            //二维码文件
            $CodeFile = $CodePath."qrcode.png";
            // 生成二维码
            QrCode::format('png')->size($list->code_size)->margin($list->code_margin)->generate($Url, $CodeFile);

            $typeArr=getimagesize(storage_path('app/public/'.$list->getOriginal('images')));

            switch($typeArr['mime'])
            {
                case "image/png":
                    $BackGroud=imagecreatefrompng(storage_path('app/public/'.$list->getOriginal('images')));
                    break;

                case "image/jpg":
                    $BackGroud=imagecreatefromjpeg(storage_path('app/public/'.$list->getOriginal('images')));
                    break;
                case "image/jpeg":
                    $BackGroud=imagecreatefromjpeg(storage_path('app/public/'.$list->getOriginal('images')));
                    break;

                case "image/gif":
                    $BackGroud=imagecreatefromgif(storage_path('app/public/'.$list->getOriginal('images')));
                    break;
            }


            // 合成图片
            //$BackGroud =  imagecreatefromjpeg(storage_path('app/public/'.$list->image));
            $qrcode    =  imagecreatefrompng($CodeFile);

            imagecopyresampled($BackGroud, $qrcode, $list->code_x, $list->code_y, 0, 0, imagesx($qrcode), imagesy($qrcode), imagesx($qrcode), imagesy($qrcode));

            // 海报生成位置
            $PicPath   = public_path('/share/'.$request->user->id.'/team_share/');
            File::isDirectory($PicPath) or File::makeDirectory($PicPath, 0777, true, true);

            $PicFile   = $PicPath.$list->id.".png";

            imagepng($BackGroud, $PicFile);

            $link = "http://".$_SERVER["HTTP_HOST"]."/share/".$request->user->id."/team_share/".$list->id.".png";

            return response()->json(['success'=>['message' => '获取成功!', 'data' => ['link' => $link."?time=".time() ]]]);

        } catch (\Exception $e) {
            
            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }
    }
}
