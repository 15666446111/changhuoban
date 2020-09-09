<?php

namespace App\Admin\Actions\Export;

use Throwable;
use Session;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class ExportMoney extends Action
{
    protected $selector = '.export-moneylog';

    protected $data;

    protected $count = 0;

    protected $cur   = 1;

    public function handle(Request $request)
    {
        try {

            set_time_limit(0);  //设置程序执行时间
            
            ignore_user_abort(true);    //设置断开连接继续执行

            header('X-Accel-Buffering: no');    //关闭buffer
            
            header('Content-type: text/html;charset=utf-8');    //设置网页编码
            
            ob_start(); //打开输出缓冲控制
            
            echo str_repeat(' ',1024*4);    //字符填充

            session()->forget('exp_count');

            session()->forget('exp_message');

            session()->forget('over');

            $list = \App\Model1\MoneyLog::where('id', '>=', '1');

            if($request->start_time)
                $list->where('add_time', '>=', strtotime($request->start_time));

            if($request->end_time)
                $list->where('add_time', '<=', strtotime($request->end_time));


            $count = $list->count();

            $result = $list->get();

            session()->put('exp_count', $count);

            session()->save();

            echo ob_get_clean();    //获取当前缓冲区内容并清除当前的输出缓冲
        
            flush();   //刷新缓冲区的内容，输出
            
            $i = 1;

            foreach ($result as $key => $value) {
                
                $proportion = $i / $count;

                $msg = $i == $count ? '导出完成' : '正在导出第' . $i . '条信息';

                echo $msg."<br/>";

                $i ++;
            }

            session()->put('over', '1');

            session()->save();

        } catch (ValidationException $validationException) {

            return Response::withException($validationException);

        } catch (Throwable $throwable) {

            $this->response()->status = false;
            return $this->response()->swal()->error($throwable->getMessage());
        }

        //return $this->response()->success('导入成功!')->refresh();
    }

    /**
     * [html 展示的HTML]
     * @author Pudding
     * @DateTime 2020-04-21T15:58:43+0800
     * @return   [type]                   [description]
     */
    public function html()
    {
        return <<<HTML
        <a class="btn btn-sm btn-default export-moneylog"><i class="fa fa-upload" style="margin-right: 3px;"></i>大数据导出</a>
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
        $this->text('c_code', '商户编号');

        $this->text('sn', '终端编号');

        $this->datetime('start_time', '开始时间');

        $this->datetime('end_time', '结束时间');
    }


    /**
     * @return string
     * 上传效果
     */
    public function handleActionPromise()
    {
        $resolve = <<<'SCRIPT'

        var actionResolverss = function (data) {
            $('.modal-footer').show()
            $('.tips').remove()
            var response = data[0];
            var target   = data[1];

            if (typeof response !== 'object') {
                return $.admin.swal({type: 'error', title: 'Oops!'});
            }

            var then = function (then) {
                if (then.action == 'refresh') {
                    $.admin.reload();
                }

                if (then.action == 'download') {
                    window.open(then.value, '_blank');
                }

                if (then.action == 'redirect') {
                    $.admin.redirect(then.value);
                }
            };

            if (typeof response.html === 'string') {
                target.html(response.html);
            }

            if (typeof response.swal === 'object') {
                $.admin.swal(response.swal);
            }

            if (typeof response.toastr === 'object') {
                $.admin.toastr[response.toastr.type](response.toastr.content, '', response.toastr.options);
            }

            if (response.then) {
              then(response.then);
            }
        };

        var actionCatcherss = function (request) {
            $('.modal-footer').show()
            $('.tips').remove()

            if (request && typeof request.responseJSON === 'object') {
                $.admin.toastr.error(request.responseJSON.message, '', {positionClass:"toast-bottom-center", timeOut: 10000}).css("width","500px")
            }
        };
SCRIPT;

        Admin::script($resolve);

        return <<<'SCRIPT'

         $('.modal-footer').hide()

         let html = `<div style="margin:30px auto; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: %upx">
        <div style="text-align:center; margin-bottom:10px;" id="touct">正在统计信息</div><div style="padding: 0; background-color: white; border: 1px solid navy; width: %upx"><div id="progress" style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center; height: 16px"></div></div><div id="msg" style="font-family: Tahoma; font-size: 9pt;">正在导出...</div><div id="percent" style="position: relative; top: -34px; text-align: center; font-weight: bold; font-size: 8pt">0%</div></div>`
         $('.modal-header').append(html)


        getInfo();

        function getInfo(){

            var time = setTimeout(getInfo,1000);

            $.ajax({
                url: '/getExp',
                type: 'get',
                dataType: 'json',
                success:function(data){

                    console.log(data)

                    if(data.code == "10000"){

                        document.getElementById("touct").innerText="共有"+ data.data.count + "条信息需要导出";

                        document.getElementById("msg").innerText= data.data.message;

                        if(data.data.over)
                            window.clearTimeout("time");

                    }

                }
            })
        }

process.then(actionResolverss).catch(actionCatcherss);
SCRIPT;
    }
}