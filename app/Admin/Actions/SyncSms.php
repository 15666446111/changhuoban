<?php

namespace App\Admin\Actions;

use Throwable;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class SyncSms extends Action
{
    protected $selector = '.sync-sms';

    public function handle(Request $request)
    {
        try {
            // 如果当前登陆的是总管理员。不能同步
            if(Admin::user()->operate == 'All' or Admin::user()->type == "1"){
                return $this->response()->swal()->error('请登录操盘方账号进行同步!');
            }
            // 获取操盘方的配置
            $adminSetting = \App\AdminSetting::where('operate_number', Admin::user()->operate)->first();

            if(empty($adminSetting) or !$adminSetting) return $this->response()->swal()->error('未找到配置信息!');

            // 检查畅捷
            if($adminSetting->system_merchant == "") return $this->response()->swal()->error('未找到渠道编号信息!');

            if($adminSetting->system_secret == "") return $this->response()->swal()->error('未找到渠道密钥信息!');

            // 实力化请求累
            $application = new \App\Services\Pmpos\PmposController(false, false, $adminSetting);

            $result = $application->getSmsTemplate();

            if($result->code == "00"){

                foreach ($result->data as $key => $value) {

                    /**
                     * @version [<vector>] [< 获取当前的模版是否存在 >]
                     */
                    $exits = \App\AdminShort::where('operate', Admin::user()->operate)->where('template_id', $value->id)->first();

                    $create = substr($value->createTime, 0, strlen($value->createTime) - 3);

                    $last   = substr($value->lastModTime, 0, strlen($value->createTime) - 3);

                    if(!$exits or empty($exits)){
                        \App\AdminShort::create([
                            'template_id'   =>  $value->id,
                            'agent_id'      =>  $value->agentId,
                            'agent_name'    =>  $value->agentName,
                            'number'        =>  $value->smsCode,
                            'content'       =>  $value->message,
                            'status'        =>  $value->status,
                            'create'        =>  Carbon::createFromTimestamp($create)->toDateTimeString(),
                            'create_user_id'=>  $value->createUserId,
                            'last'          =>  Carbon::createFromTimestamp($last)->toDateTimeString(),
                            'last_user_id'  =>  $value->lastUserId,
                            'operate'       =>  Admin::user()->operate
                        ]);
                    }else{

                        $exits->agent_id    = $value->agentId;
                        $exits->agent_name  = $value->agentName;
                        $exits->number      = $value->smsCode;
                        $exits->content     = $value->message;
                        $exits->status      = $value->status;
                        $exits->create      = Carbon::createFromTimestamp($create)->toDateTimeString();
                        $exits->create_user_id = $value->createUserId;
                        $exits->last        = Carbon::createFromTimestamp($last)->toDateTimeString();
                        $exits->last_user_id= $value->lastUserId;
                        $exits->save();
                    }
                }

            }else{

                return $this->response()->swal()->error('短信模版同步失败!');

            }

        } catch (ValidationException $validationException) {

            return Response::withException($validationException);

        } catch (Throwable $throwable) {

            $this->response()->status = false;

            return $this->response()->swal()->error($throwable->getMessage());
        }

        return $this->response()->success('同步完成!')->refresh();
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
            <a class="btn btn-sm btn-default sync-sms"><i class="fa fa-refresh" style="margin-right: 3px;"></i>同步短信</a>
HTML;
        
    }

    /**
     * [form 点击的按钮 出来的表单]
     * @author Pudding
     * @DateTime 2020-04-21T15:58:56+0800
     * @return   [type]                   [description]
     */
    public function dialog()
    {
        $this->confirm('确定要进行更新同步?');
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
         let html = `<div class='tips' style='color: red;font-size: 18px;'>导入时间取决于数据量，请耐心等待结果不要关闭窗口！<img src="data:image/gif;base64,R0lGODlhEAAQAPQAAP///1VVVfr6+np6eqysrFhYWG5ubuPj48TExGNjY6Ojo5iYmOzs7Lq6utjY2ISEhI6OjgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCgAAACwAAAAAEAAQAAAFUCAgjmRpnqUwFGwhKoRgqq2YFMaRGjWA8AbZiIBbjQQ8AmmFUJEQhQGJhaKOrCksgEla+KIkYvC6SJKQOISoNSYdeIk1ayA8ExTyeR3F749CACH5BAkKAAAALAAAAAAQABAAAAVoICCKR9KMaCoaxeCoqEAkRX3AwMHWxQIIjJSAZWgUEgzBwCBAEQpMwIDwY1FHgwJCtOW2UDWYIDyqNVVkUbYr6CK+o2eUMKgWrqKhj0FrEM8jQQALPFA3MAc8CQSAMA5ZBjgqDQmHIyEAIfkECQoAAAAsAAAAABAAEAAABWAgII4j85Ao2hRIKgrEUBQJLaSHMe8zgQo6Q8sxS7RIhILhBkgumCTZsXkACBC+0cwF2GoLLoFXREDcDlkAojBICRaFLDCOQtQKjmsQSubtDFU/NXcDBHwkaw1cKQ8MiyEAIfkECQoAAAAsAAAAABAAEAAABVIgII5kaZ6AIJQCMRTFQKiDQx4GrBfGa4uCnAEhQuRgPwCBtwK+kCNFgjh6QlFYgGO7baJ2CxIioSDpwqNggWCGDVVGphly3BkOpXDrKfNm/4AhACH5BAkKAAAALAAAAAAQABAAAAVgICCOZGmeqEAMRTEQwskYbV0Yx7kYSIzQhtgoBxCKBDQCIOcoLBimRiFhSABYU5gIgW01pLUBYkRItAYAqrlhYiwKjiWAcDMWY8QjsCf4DewiBzQ2N1AmKlgvgCiMjSQhACH5BAkKAAAALAAAAAAQABAAAAVfICCOZGmeqEgUxUAIpkA0AMKyxkEiSZEIsJqhYAg+boUFSTAkiBiNHks3sg1ILAfBiS10gyqCg0UaFBCkwy3RYKiIYMAC+RAxiQgYsJdAjw5DN2gILzEEZgVcKYuMJiEAOwAAAAAAAAAAAA=="><\/div>`
         $('.modal-header').append(html)
process.then(actionResolverss).catch(actionCatcherss);
SCRIPT;
    }
}