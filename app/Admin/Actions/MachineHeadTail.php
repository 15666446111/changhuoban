<?php

namespace App\Admin\Actions;

use Throwable;
use Encore\Admin\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Encore\Admin\Actions\Action;
use Maatwebsite\Excel\Validators\ValidationException;

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

        $this->select('h_name','类型')->options($Type)->load('factory_name','/api/getAdminFactory');

        $this->select('h_factory_name','厂商');

        $this->select('h_style_id','型号')->required();

        $this->text('head', '机具首行终端号')->rules('required', ['required' => '首行不能为空']);

        $this->text('tail', '机具尾行终端号')->rules('required', ['required' => '尾行不能为空']);
    }

    /**
     * @return string
     * 上传效果
     */
    public function handleActionPromise()
    {
        $resolve = <<<'SCRIPT'

        $(".h_name").on('change',function(){
            var h_name = $(".h_name option:selected").val();
            if(h_name == ""){ 
                $(".h_factory_name").find("option").remove();
                $(".h_style_id").find("option").remove();
            }else{
                $.ajax({
                    url: '/api/getAdminFactory',
                    data:{q: h_name},
                    success:function(data){
                        var options = '';
                        $.each(data, function(i, val) {  
                            options += "<option value='"+val['id']+"'>"+val['text']+"</option>";
                        });
                        $(".h_factory_name").html(options);
                        $(".h_factory_name").change();
                    }
                });
            }
        })

        $(".h_factory_name").on('change',function(){
            var h_factory_name = $(".h_factory_name option:selected").val();
            if(h_factory_name == ""){ $(".h_style_id").find("option").remove();
            }else{
                $.ajax({
                    url: '/api/getAdminStyle',
                    data:{q: h_factory_name},
                    success:function(data){
                        var options = '';
                        $.each(data, function(i, val) {  
                            options += "<option value='"+val['id']+"'>"+val['text']+"</option>";
                        });
                        $(".h_style_id").html(options);
                    }
                });
            }
        })

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