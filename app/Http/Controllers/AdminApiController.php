<?php

namespace App\Http\Controllers;

use App\MachinesFactory;
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
}
