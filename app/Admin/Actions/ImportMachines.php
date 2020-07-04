<?php

namespace App\Admin\Actions;

use Throwable;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Imports\ImportMachines as ImportMachine;
use Encore\Admin\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class ImportMachines extends Action
{
    protected $selector = '.import-machines';

    public function handle(Request $request)
    {
        try {
            $result = Excel::toArray(null, request()->file('file'));
            
            // 只取第一个Sheet
            if (count($result[0]) > 0) 
            {
                $rows = $result[0];

                $headings = [];

                if (count($rows) > 0) {
                    
                    foreach ($rows[0] as $key => $col) $headings[Str::snake($col)] = $key;
                }
                
                $data = [];

                foreach ($rows as $key => $row) 
                {
                    if ( $key > 0 && isset($row[$headings['s_n']]) ) $data[] = $row[$headings['s_n']];
                }
                
                $eplice = \App\Machine::whereIn('sn', $data)->pluck('sn')->toArray();
                // 交集
                $epliceRows = array_intersect($data, $eplice);
                // 差集
                $InsertData = array_diff($data, $eplice);

                foreach ($InsertData as $key => $value) {
                    \App\Machine::create([
                        'sn'        =>  $value,
                        'style_id'  =>  $request->style_id,
                        'user_id'   =>  Admin::user()->id
                    ]);
                }

                return $this->response()->success('入口成功, 入库'.count($InsertData).'台!')->refresh();

            } else  return $this->response()->success('无数据!')->refresh();

        } catch (ValidationException $validationException) {

            return Response::withException($validationException);

        } catch (Throwable $throwable) {

            $this->response()->status = false;
            return $this->response()->swal()->error($throwable->getMessage());
        }

        return $this->response()->success('导入成功!')->refresh();
    }

    /**
     * [html 展示的HTML]
     * @author Pudding
     * @DateTime 2020-04-21T15:58:43+0800
     * @return   [type]                   [description]
     */
    public function html()
    {
        if(Admin::user()->operate == 'All'){

        }else{

            return <<<HTML
        <a class="btn btn-sm btn-default import-machines" style="position:absolute;  right: 350px;"><i class="fa fa-upload" style="margin-right: 3px;"></i>导入仓库</a>
HTML;

        }
        
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

        $this->select('name','类型')->options($Type)->load('factory_name','/api/getAdminFactory');

        $this->select('factory_name','厂商')->load('style_id','/api/getAdminStyle');

        $this->select('style_id','型号')->required();

        $this->file('file', '上传简历');//->rules('required', ['required' => '文件不能为空']);
    }


    /**
     * @return string
     * 上传效果
     */
    public function handleActionPromise()
    {
        $resolve = <<<'SCRIPT'

        $(".name").on('change',function(){
            var name = $(".name option:selected").val();
            console.log(name)
            if(name == ""){ 
                $(".factory_name").find("option").remove();
                $(".style_id").find("option").remove();
            }else{
                
                $.ajax({
                    url: '/api/getAdminFactory',
                    data:{q: name},
                    success:function(data){
                        var options = '';
                        $.each(data, function(i, val) {  
                            console.log(val['text'])
                            options += "<option value='"+val['id']+"'>"+val['text']+"</option>";
                        });
                        $(".factory_name").html(options);
                        $(".factory_name").change();
                    }
                });
            }
        })

        $(".factory_name").on('change',function(){
            var factory_name = $(".factory_name option:selected").val();
            if(factory_name == ""){ $(".style_id").find("option").remove();
            }else{
                $.ajax({
                    url: '/api/getAdminStyle',
                    data:{q: factory_name},
                    success:function(data){
                        var options = '';
                        $.each(data, function(i, val) {  
                            console.log(val['text'])
                            options += "<option value='"+val['id']+"'>"+val['text']+"</option>";
                        });
                        $(".style_id").html(options);
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