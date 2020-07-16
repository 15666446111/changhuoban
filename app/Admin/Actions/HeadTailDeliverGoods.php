<?php

namespace App\Admin\Actions;

use Throwable;
use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Actions\Action;

class HeadTailDeliverGoods extends Action
{
    protected $selector = '.head-tail-deliver-goods';

    public function handle(Request $request)
    {
        // $request ...
        try { 
            
            if(!$request->head or !$request->tail or !$request->user  or !$request->policy){
                return $this->response()->error('参数无效!')->refresh();
            }

            //验证首位
            if(!is_numeric($request->head) or !is_numeric($request->tail)){
                return $this->response()->error('首尾终端需为整数!')->refresh();
            }

            if($request->tail < $request->head){
                return $this->response()->error('终端尾行不能低于首行')->refresh();
            }

            if(strlen($request->head) != strlen($request->tail)){
                return $this->response()->error('终端首尾长度不一样')->refresh();
            }

            $data = [];

            //
            $lenth = strlen($request->head);


            for($i = $request->head; $i<= $request->tail; $i++){

                $i =sprintf("%0".$lenth."d", $i);

                $data[] = $i;

            }
            

            \App\Machine::whereIn('sn', $data)->where('bind_status', '0')->whereNull('user_id')->update([
                'user_id'   =>  $request->user,
                'policy_id' =>  $request->policy,
                'active_end_time' =>  $request->active_end_time,
            ]);


            /*
                检查该会员在该政策下是否有结算激活等配置。如果没有 进行默认该政策配置
            
            $userPolicy  = \App\UserPolicy::where('user_id', $request->user)->where('policy_id', $request->policy)->first();

            if(!$userPolicy or empty($userPolicy)){

                $policy = \App\Policy::where('id', $request->policy)->first();
                
                $sett_price[] = $policy->settlements->set_price;
                
                $default_active_set = $policy['default_active_set'];
                $default_active_set['return_money'] = $default_active_set['default_money'];
                
                $vip_active_set = $policy['vip_active_set'];
                $vip_active_set['return_money'] = $vip_active_set['default_money'];
                
                $standard = $policy->default_standard_set;
                
                \App\UserPolicy::create([
                    'user_id'       =>  $request->user,
                    'policy_id'     =>  $request->policy,
                    'sett_price'    =>  $sett_price,
                    'default_active_set'    => $default_active_set,
                    'vip_active_set'        => $vip_active_set,
                    'standard'      =>  $standard
                ]);
            }*/

            return $this->response()->success('发货成功')->refresh();

        }catch (Throwable $throwable) {

            $this->response()->status = false;

            return $this->response()->swal()->error($throwable->getMessage());
        }

        return $this->response()->success('发货成功!')->refresh();
    }

    public function html()
    {
        if(Admin::user()->operate == 'All'){

        }else{

            return <<<HTML
        <a class="btn btn-sm btn-default head-tail-deliver-goods"><i class="fa fa-balance-scale" style="margin-right: 3px;"></i>首尾发货</a>
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
        if(Admin::user()->operate == 'All'){
            
        }else{

            $user = \App\User::where('operate', Admin::user()->operate)->pluck('nickname', 'id');
            $this->select('user', '配送会员')->options($user)->rules('required', ['required' => '请选择配送用户']);

            $policyGroups = \App\PolicyGroup::where('operate', Admin::user()->operate)->pluck('title','id');
            $this->select('title','活动组')->options($policyGroups)->load('policy','/api/getAdminUserGroup');
            
            $this->select('policy','活动')->required();

            $this->datetime('active_end_time', '激活截止时间')->format('YYYY-MM-DD HH:mm:ss');

            $this->text('head', '机具首行终端sn')->rules('required', ['required' => '首行不能为空']);

            $this->text('tail', '机具尾行终端sn')->rules('required', ['required' => '尾行不能为空']);

        }
        
    }

    /**
     * @return string
     * 上传效果
     */
    public function handleActionPromise()
    {
        $resolve = <<<'SCRIPT'

        $(".title").on('change',function(){
            var name = $(".title option:selected").val();
            console.log(name)
            if(name == ""){ 
                $(".policy").find("option").remove();
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
                        $(".policy").html(options);
                        $(".policy").change();
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