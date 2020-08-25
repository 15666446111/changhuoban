<?php

namespace App\Admin\Actions;

use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class DeliverGoods extends RowAction
{
    public $name = '配送发货';

    public function handle(Model $model, Request $request)
    {
        // $request ...
        try {

            if(!$request->user or !$request->d_policy) return $this->response()->error('参数无效!')->refresh();
        
            $model->user_id = $request->user;

            $model->policy_id = $request->d_policy;

            $model->save();

            /*
            	检查该会员在该政策下是否有结算激活等配置。如果没有 进行默认该政策配置
             */
            /*$userPolicy  = \App\UserPolicy::where('user_id', $request->user)->where('policy_id', $request->policy)->first();

            if(!$userPolicy or empty($userPolicy)){

            	$policy = \App\Policy::where('id', $request->policy)->first();

                $sett_price = $policy['sett_price'];

                foreach ($sett_price as $key => $value) {
                    $sett_price[$key]['setprice'] = $value['defaultPrice'];
                }

                $default_active_set = $policy['default_active_set'];
                $default_active_set['return_money'] = $default_active_set['default_money'];

                $vip_active_set = $policy['vip_active_set'];
                $vip_active_set['return_money'] = $vip_active_set['default_money'];

                // 达标信息
                $standard = $policy->default_standard_set;
                //dd($standard);
            	\App\UserPolicy::create([
            		'user_id'		        =>	$request->user,
            		'policy_id'		        =>	$request->policy,
            		'sett_price'	        =>	$policy->sett_price,
                    'default_active_set'    =>  $default_active_set,
                    'vip_active_set'        =>  $vip_active_set,
                    'standard'              =>  $standard,
            	]);
            }*/

            return $this->response()->success('发货成功')->refresh();

        }catch (Throwable $throwable) {

            $this->response()->status = false;

            return $this->response()->swal()->error($throwable->getMessage());
        }

    }

    /* 发货按钮需要提交资料 */
	public function form()
	{
        /*$user = \App\User::where('operate', Admin::user()->operate)->pluck('nickname', 'id');
        $this->select('user', '配送会员')->options($user)->rules('required', ['required' => '请选择配送用户']);

        $policyGroups = \App\PolicyGroup::where('operate', Admin::user()->operate)->pluck('title', 'id');
        $this->select('d_title','活动组')->options($policyGroups)->load('d_policy','/api/getAdminUserGroup');
        
        $this->select('d_policy','活动')->required();*/
	}

    /**
     * @return string
     * 上传效果
     */
    public function handleActionPromise()
    {
        $resolve = <<<'SCRIPT'

        $(".d_title").on('change',function(){
            var name = $(".d_title option:selected").val();
            if(name == ""){ 
                $(".d_policy").find("option").remove();
            }else{
                
                $.ajax({
                    url: '/api/getAdminUserGroup',
                    data:{q: name},
                    success:function(data){
                        var options = '';
                        $.each(data, function(i, val) {  
                            options += "<option value='"+val['id']+"'>"+val['text']+"</option>";
                        });
                        $(".d_policy").html(options);
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
         let html = `<div class='tips' style='color: red;font-size: 18px;'>正在执行配送发货，请耐心等待结果不要关闭窗口！<img src="data:image/gif;base64,R0lGODlhEAAQAPQAAP///1VVVfr6+np6eqysrFhYWG5ubuPj48TExGNjY6Ojo5iYmOzs7Lq6utjY2ISEhI6OjgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCgAAACwAAAAAEAAQAAAFUCAgjmRpnqUwFGwhKoRgqq2YFMaRGjWA8AbZiIBbjQQ8AmmFUJEQhQGJhaKOrCksgEla+KIkYvC6SJKQOISoNSYdeIk1ayA8ExTyeR3F749CACH5BAkKAAAALAAAAAAQABAAAAVoICCKR9KMaCoaxeCoqEAkRX3AwMHWxQIIjJSAZWgUEgzBwCBAEQpMwIDwY1FHgwJCtOW2UDWYIDyqNVVkUbYr6CK+o2eUMKgWrqKhj0FrEM8jQQALPFA3MAc8CQSAMA5ZBjgqDQmHIyEAIfkECQoAAAAsAAAAABAAEAAABWAgII4j85Ao2hRIKgrEUBQJLaSHMe8zgQo6Q8sxS7RIhILhBkgumCTZsXkACBC+0cwF2GoLLoFXREDcDlkAojBICRaFLDCOQtQKjmsQSubtDFU/NXcDBHwkaw1cKQ8MiyEAIfkECQoAAAAsAAAAABAAEAAABVIgII5kaZ6AIJQCMRTFQKiDQx4GrBfGa4uCnAEhQuRgPwCBtwK+kCNFgjh6QlFYgGO7baJ2CxIioSDpwqNggWCGDVVGphly3BkOpXDrKfNm/4AhACH5BAkKAAAALAAAAAAQABAAAAVgICCOZGmeqEAMRTEQwskYbV0Yx7kYSIzQhtgoBxCKBDQCIOcoLBimRiFhSABYU5gIgW01pLUBYkRItAYAqrlhYiwKjiWAcDMWY8QjsCf4DewiBzQ2N1AmKlgvgCiMjSQhACH5BAkKAAAALAAAAAAQABAAAAVfICCOZGmeqEgUxUAIpkA0AMKyxkEiSZEIsJqhYAg+boUFSTAkiBiNHks3sg1ILAfBiS10gyqCg0UaFBCkwy3RYKiIYMAC+RAxiQgYsJdAjw5DN2gILzEEZgVcKYuMJiEAOwAAAAAAAAAAAA=="><\/div>`
         $('.modal-header').append(html)
process.then(actionResolverss).catch(actionCatcherss);
SCRIPT;
    }
}