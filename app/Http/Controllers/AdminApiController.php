<?php

namespace App\Http\Controllers;

use App\MachinesFactory;
use App\MachinesStyle;
use App\Policy;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;

class AdminApiController extends Controller
{
    /**
     * @version [<vector>] [< 后台接口请求控制器>]
     * @author  [Pudding] <[< 755969423@qq.com>]>
     * @text    [ 后台数据接口返回 ， Select 联动查询等]
     */
    	



    /**
     * [getAdminFactory 返回符合类型的厂家 新增型号的时候使用]
     * @author Pudding
     * @DateTime 2020-04-21T14:08:05+0800
     * @return   [type]                   [description]
     */
    public function getAdminFactory(Request $request)
    {
    	return MachinesFactory::where('type_id', $request->q)->get(['factory_name as text', 'id']);
    }

    public function getAdminStyle(Request $request){
        return MachinesStyle::where('factory_id',$request->q)->get(['style_name as text','id']);
    }

    /**
     * [getAdminFactory 返回符合当前会员活动组的活动 发货配送的时候使用]
     * @author Pudding
     * @DateTime 2020-04-21T14:08:05+0800
     * @return   [type]                   [description]
     */
    public function getAdminUserGroup(Request $request){
        return Policy::where('policy_group_id',$request->q)
                    ->where('active',1)
                    ->where('operate',Admin::user()->operate)
                    ->get(['title as text','id']);
    }


}
