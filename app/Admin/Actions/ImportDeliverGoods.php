<?php

namespace App\Admin\Actions;

use Throwable;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Imports\ImportDeliverGoods as ImportDeliverGood;
use Encore\Admin\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class ImportDeliverGoods extends Action
{
    protected $selector = '.import-deliver-goods';

    public function handle(Request $request)
    {
        try {

            if(!$request->h_policy) return $this->response()->swal()->error('请选择活动政策');

            if(!$request->user) return $this->response()->swal()->error('请选择配送用户');

            $result = Excel::toArray(null, request()->file('file1'));

            // 只取第一个Sheet
            if (count($result[0]) > 0) 
            {
                $rows = $result[0];

                $headings = [];

                if (count($rows) > 0){
                    foreach ($rows[0] as $key => $col) $headings[Str::snake($col)] = $key;
                }

                $data = [];

                foreach ($rows as $key => $row){
                    if ( $key > 0 && isset($row[$headings['s_n']]) ) $data[] = (string)$row[$headings['s_n']];
                }

                $eplice = \App\Machine::whereIn('sn', $data)->pluck('sn')->toArray();
                // 交集
                $epliceRows = array_intersect($data, $eplice);
                // 差集
                $InsertData = array_diff($data, $eplice);

                \App\Machine::whereIn('sn', $epliceRows)->whereNull('user_id')->update([
                    'user_id'   => $request->user,
                    'policy_id' => $request->h_policy,
                    'active_end_time' =>  $request->active_end_time,
                ]);

                /*
                    检查该会员在该政策下是否有结算激活等配置。如果没有 进行默认该政策配置
                */
               
                /*
                
                $userPolicy  = \App\UserPolicy::where('user_id', $request->user)->where('policy_id', $request->h_policy)->first();

                if(!$userPolicy or empty($userPolicy)){

                    $policy = \App\Policy::where('id', $request->h_policy)->first();
                    
                    $sett_price[] = $policy->settlements->set_price;
                    
                    $default_active_set = $policy['default_active_set'];
                    $default_active_set['return_money'] = $default_active_set['default_money'];
                    
                    $vip_active_set = $policy['vip_active_set'];
                    $vip_active_set['return_money'] = $vip_active_set['default_money'];
                    
                    $standard = $policy->default_standard_set;
                    
                    \App\UserPolicy::create([
                        'user_id'       =>  $request->user,
                        'policy_id'     =>  $request->h_policy,
                        'sett_price'    =>  $sett_price,
                        'default_active_set'    => $default_active_set,
                        'vip_active_set'        => $vip_active_set,
                        'standard'      =>  $standard
                    ]);
                }*/


                return $this->response()->success('配送成功, 配送'.count($epliceRows).'台!')->refresh();

            } else  return $this->response()->success('无数据!')->refresh();

        } catch (ValidationException $validationException) {

            return Response::withException($validationException);

        } catch (Throwable $throwable) {

            $this->response()->status = false;

            return $this->response()->swal()->error($throwable->getMessage());
        }
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
        <a class="btn btn-sm btn-default import-deliver-goods"><i class="fa fa-upload" style="margin-right: 3px;"></i>导入发货</a>
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
        if(Admin::user()->operate == 'All' or Admin::user()->type == '2'){


        }else{

            $user = \App\User::where('operate', Admin::user()->operate)->pluck('nickname', 'id');
            $this->select('user', '配送会员')->options($user)->rules('required', ['required' => '请选择配送用户']);

            
            $policyGroups = \App\PolicyGroup::where('operate', Admin::user()->operate)->pluck('title', 'id');
            $this->select('h_title','活动组')->options($policyGroups)->load('h_policy','/api/getAdminUserGroup');
            
            $this->select('h_policy','活动')->required();

            $this->datetime('active_end_time', '激活截止时间')->format('YYYY-MM-DD HH:mm:ss');

            $this->file('file1', '上传导入模版')->rules('required', ['required' => '文件不能为空']);

        }
        
    }


    /**
     * @return string
     * 上传效果
     */
    public function handleActionPromise()
    {
        $resolve = <<<'SCRIPT'

        $(".h_title").on('change',function(){
            var name = $(".h_title option:selected").val();
            console.log(name)
            if(name == ""){ 
                $(".h_policy").find("option").remove();
            }else{
                
                $.ajax({
                    url: '/api/getAdminUserGroup',
                    data:{q: name},
                    success:function(data){
                        var options = '';
                        $.each(data, function(i, val) {  
                            console.log(val['text'])
                            options += "<option value='"+val['id']+"'>"+val['text']+"</option>";
                        });
                        $(".h_policy").html(options);
                        $(".h_policy").change();
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