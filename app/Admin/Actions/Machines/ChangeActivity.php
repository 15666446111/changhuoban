<?php

namespace App\Admin\Actions\Machines;

use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;

class ChangeActivity extends BatchAction
{
    public $name = '活动变更';

    public function handle(Collection $collection, Request $request)
    {

        try { 
            
            if(!$request->c_policy) return $this->response()->error('请选择转移目标活动!')->refresh();
            
            $error = array();
            // 获取目标活动信息
            $policy = \App\Policy::where('id', $request->c_policy)->first();
            if(empty($policy)) return $this->response()->error('目标活动不存在!')->refresh();

			foreach ($collection as $model) {
	            if($model->operate != $policy->operate){
	            	$error[] = $model->sn;
	            	continue;
	            }
	            $model->policy_id = $policy->id;
	            $model->save();
	        }

            return $this->response()->success('活动变更成功')->refresh();

        }catch (Throwable $throwable) {

            $this->response()->status = false;

            return $this->response()->swal()->error($throwable->getMessage());
        }
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-08-20
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 选择提交到的活动 ]
     * @return    [type]      [description]
     */
	public function form()
	{
		$Type = \App\AdminSetting::pluck('company as title', 'operate_number as id');

		$this->select('c_merchant','操盘方')->options($Type)->load('c_title','/api/getPolicyGroups');

        $this->select('c_title','活动组');

        $this->select('c_policy','活动')->required();
	}


    /**
     * @return string
     * 上传效果
     */
    public function handleActionPromise()
    {
        $resolve = <<<'SCRIPT'

        $(".c_merchant").on('change',function(){
            var c_merchant = $(".c_merchant option:selected").val();
            if(c_merchant == ""){ 
                $(".c_title").find("option").remove();
                $(".c_policy").find("option").remove();
            }else{
                $.ajax({
                    url: '/api/getPolicyGroups',
                    data:{q: c_merchant},
                    success:function(data){
                        var options = "<option value=''></option>";
                        $.each(data, function(i, val) {  
                            options += "<option value='"+val['id']+"'>"+val['text']+"</option>";
                        });
                        $(".c_title").html(options);
                        $(".c_policy").change();
                    }
                });
            }
        })

        $(".c_title").on('change',function(){
            var c_title = $(".c_title option:selected").val();
            if(c_title == ""){ 
            	$(".c_policy").find("option").remove();
            }else{
                $.ajax({
                    url: '/api/getPolicys',
                    data:{q: c_title},
                    success:function(data){
                        var options = '';
                        $.each(data, function(i, val) {  
                            options += "<option value='"+val['id']+"'>"+val['text']+"</option>";
                        });
                        $(".c_policy").html(options);
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
         let html = `<div class='tips' style='color: red;font-size: 18px;'>正在变更活动，请耐心等待结果不要关闭窗口！<img src="data:image/gif;base64,R0lGODlhEAAQAPQAAP///1VVVfr6+np6eqysrFhYWG5ubuPj48TExGNjY6Ojo5iYmOzs7Lq6utjY2ISEhI6OjgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCgAAACwAAAAAEAAQAAAFUCAgjmRpnqUwFGwhKoRgqq2YFMaRGjWA8AbZiIBbjQQ8AmmFUJEQhQGJhaKOrCksgEla+KIkYvC6SJKQOISoNSYdeIk1ayA8ExTyeR3F749CACH5BAkKAAAALAAAAAAQABAAAAVoICCKR9KMaCoaxeCoqEAkRX3AwMHWxQIIjJSAZWgUEgzBwCBAEQpMwIDwY1FHgwJCtOW2UDWYIDyqNVVkUbYr6CK+o2eUMKgWrqKhj0FrEM8jQQALPFA3MAc8CQSAMA5ZBjgqDQmHIyEAIfkECQoAAAAsAAAAABAAEAAABWAgII4j85Ao2hRIKgrEUBQJLaSHMe8zgQo6Q8sxS7RIhILhBkgumCTZsXkACBC+0cwF2GoLLoFXREDcDlkAojBICRaFLDCOQtQKjmsQSubtDFU/NXcDBHwkaw1cKQ8MiyEAIfkECQoAAAAsAAAAABAAEAAABVIgII5kaZ6AIJQCMRTFQKiDQx4GrBfGa4uCnAEhQuRgPwCBtwK+kCNFgjh6QlFYgGO7baJ2CxIioSDpwqNggWCGDVVGphly3BkOpXDrKfNm/4AhACH5BAkKAAAALAAAAAAQABAAAAVgICCOZGmeqEAMRTEQwskYbV0Yx7kYSIzQhtgoBxCKBDQCIOcoLBimRiFhSABYU5gIgW01pLUBYkRItAYAqrlhYiwKjiWAcDMWY8QjsCf4DewiBzQ2N1AmKlgvgCiMjSQhACH5BAkKAAAALAAAAAAQABAAAAVfICCOZGmeqEgUxUAIpkA0AMKyxkEiSZEIsJqhYAg+boUFSTAkiBiNHks3sg1ILAfBiS10gyqCg0UaFBCkwy3RYKiIYMAC+RAxiQgYsJdAjw5DN2gILzEEZgVcKYuMJiEAOwAAAAAAAAAAAA=="><\/div>`
         $('.modal-header').append(html)
process.then(actionResolverss).catch(actionCatcherss);
SCRIPT;
    }
}