<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\XxController;


class HomeController extends Controller
{	
	/**
	 * @version [<vector>] [< 访问项目主目录 处理控制器>]
	 * @author  [Pudding] <[< 755969423@qq.com >]>
	 */
    public function index(Request $request)
    {
        // \App\User::create([
        //     'nickname'      => '测试c1',
        //     'account'       => '15666446115',
        //     'phone'         => '15666446115',
        //     'password'      => "###" . md5(md5('123456' . 'v3ZF87bMUC5MK570QH')),
        //     'user_group'    => 1,
        //     'parent'        => 9,
        //     'operate'       => 'CP1002020041714132163',
        // ]);
    	return view('login');
    }


    /**
     * [home 项目主页面]
     * @author Pudding
     * @DateTime 2020-04-17T14:29:43+0800
     * @param    Request                  $request [description]
     * @return   [type]                            [description]
     */
    public function home(Request $request)
    {
    	return view('home');
    }




    public function exp(Request $request)
    {

        set_time_limit(0);  //设置程序执行时间
        
        ignore_user_abort(true);    //设置断开连接继续执行
        
        header('X-Accel-Buffering: no');    //关闭buffer
        
        header('Content-type: text/html;charset=utf-8');    //设置网页编码
        
        ob_start(); //打开输出缓冲控制
        
        echo str_repeat(' ',1024*4);    //字符填充

        $maxId = 0;

        $speed = 4000;

        $count = \App\Model1\MoneyLog::where('add_time', '>=', strtotime("2020-06-20 00:00:00"))->where('add_time', '<=', strtotime("2020-06-25 00:00:00"))->orderBy('id', 'asc')->count();

        
        $width = 1000;
        
        $arrs = [ 
                '0' => '未定义',
                '1' => '直营分润', 
                '2' => '团队分润',
                '3' => '激活返现',
                '4' => '交易奖励',
                '5' => '注册奖励',
                '6' => '达标返现',
                '7' => '云闪付推荐奖励',
                '8' => '财商学院推荐奖励',
                '9' => 'etc返现奖励',
                '10'=> 'epos直营分润',
                '11'=> 'epos团队分润',
                '12'=> '申卡直推',
                '13'=> '积分直推',
                '14'=> '申卡团队',
                '15'=> '积分团队'
            ];



        $operate = \App\Model1\UserAgent::distinct('agent_id')->pluck('agent_id')->toArray();

        $user    = \App\Model1\User::whereIn('id', $operate)->pluck('user_nickname', 'id')->toArray();

        $user[0] = "平台直属";

        $html = '<div style="margin:100px auto; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: %upx">
        <div style="text-align:center; margin-bottom:10px;">共有'.$count.'条数据需要导出</div><div style="padding: 0; background-color: white; border: 1px solid navy; width: %upx"><div id="progress" style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center; height: 16px"></div></div><div id="msg" style="font-family: Tahoma; font-size: 9pt;">正在导出...</div><div id="percent" style="position: relative; top: -34px; text-align: center; font-weight: bold; font-size: 8pt">0%%</div></div>';
        
        echo sprintf($html, $width+8, $width);
        
        echo ob_get_clean();    //获取当前缓冲区内容并清除当前的输出缓冲
        
        flush();   //刷新缓冲区的内容，输出

        $i = 1;

        $file = storage_path('app/public/分润信息0620_0625.csv'); 

        $fp = fopen($file, 'w');  

        fputcsv($fp,array(
            '编号', 
            '用户账号',
            '代理商', 
            '分润描述',
            '总分润金额',
            '本人分润',
            '团队分润',
            '分润返现',
            '分润时间',
            '分润分类',
            '终端编号',
            '商户编号'
        ));


        while(true){

            $models = \App\Model1\MoneyLog::where('add_time', '>=', strtotime("2020-06-20 00:00:00"))->where('add_time', '<=', strtotime("2020-06-25 00:00:00"))->where('id', '>', $maxId)->limit($speed)->orderBy('id', 'asc')->get();


            if ($models->isEmpty()) {

                return redirect("download_moneylog");

                //return responseStorage::download('public/分润信息.csv');

                break;
            }


            // 组合数据
            $exp_data = array();


            foreach ($models as $key => $value) {

                $proportion = $i / $count;

                $msg = $i == $count ? '导出完成' : '正在导出第' . $i . '条信息';

                $script = '<script>document.getElementById("percent").innerText="%u%%";document.getElementById("progress").style.width="%upx";document.getElementById("msg").innerText="%s";</script>';

                echo sprintf($script, intval($proportion*100), intval( $i / $count * $width), $msg);

                $i++;

                echo ob_get_clean();

                flush();

                fputcsv($fp,array(
                    $value->id, 
                    $value->users->mobile,
                    $user[$value->userAgents->agent_id], 
                    $value->origin,
                    $value->money,
                    $value->self,
                    $value->team,
                    $value->is_run ? '分润' : '返现',
                    date('Y-m-d H:i:s', $value->add_time),
                    $arrs[$value->type],
                    $value->sn,
                    $value->c_code
                ));
            }
            //1590940800。
            $maxId = $models->max(['id']);

        }

    }
}
