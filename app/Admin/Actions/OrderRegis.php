<?php

namespace App\Admin\Actions;

use Throwable;
use Illuminate\Http\Request;
use Encore\Admin\Actions\RowAction;
use App\Services\Cj\RepayCjController;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Facades\Admin;
use Maatwebsite\Excel\Validators\ValidationException;

class OrderRegis extends RowAction
{
    public $name = '发货';

    public function handle(Model $model, Request $request)
    {
        // 处理错误
        try {
            
            if(!$request->tracking_num) return $this->response()->swal()->error('请填写物流编号');

            if(!$request->sn) return $this->response()->swal()->error('请选择终端号');

            if(!$request->tracking_name) return $this->response()->swal()->error('请填写物流名称');
            
            if($model->numbers != count($request->sn)){

                return $this->response()->error('请选择正确的机器数量')->refresh();

            }

            \App\Machine::whereIn('sn',$request->sn)->update(['user_id'=>$model->user_id,'tracking_status'=>1]);

            $model->tracking_num = $request->tracking_num;

            $model->tracking_name = $request->tracking_name;

            $model->save();

            return $this->response()->success('发货成功,成功发货'.$model->numbers.'台')->refresh();

        } catch (ValidationException $validationException) {

            return Response::withException($validationException);

        }catch (Throwable $throwable) {

            $this->response()->status = false;

            return $this->response()->swal()->error($throwable->getMessage());
        }
        
    }


    public function form(Model $model)
    {
         
        $this->text('tracking_name', '物流名称')->required()->help('请输入物流名称!');
        
        $this->text('tracking_num', '物流编号')->required()->help('请输入物流编号!');

        $Type = \App\MachinesStyle::where('id',$model->product->style_id)->get()->pluck('style_name','id');

        $this->select('style_name','机器型号')->options($Type)->load('sn','/api/getMachineSn');

        $this->multipleSelect('sn','终端SN号');
        
    }

    /**
     * @return string
     * 上传效果
     */
    public function handleActionPromise()
    {
        
        $resolve = <<<'SCRIPT'

        $(".style_name").on('change',function(){
            var name = $(".style_name option:selected").val();
            if(name == ""){ 
                $(".sn").find("option").remove();
            }else{
                $.ajax({
                    url: '/api/getMachineSn',
                    data:{q: name},
                    success:function(data){
                        var options = '';
                        $.each(data, function(i, val) {  
                            console.log(val['text'])
                            options += "<option value='"+val['id']+"'>"+val['text']+"</option>";
                        });
                        $(".sn").html(options);
                        $(".sn").change();
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