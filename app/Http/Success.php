<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2019/8/1
 * Time: 14:41
 */

namespace App\Http;


use Illuminate\Support\Facades\Log;

class Success
{
    const info = 202;
    const code_success = 200;
    const code_sign_error = 201;        // 未登陆

    const success = 200;
    const auth = 201;
    const params = 215;
    const id = 1301;
    const add = 1302;
    const update = 1303;
    const delete = 1304;

    private static $msg_data = [
        self::success       => '成功',
        self::auth          => '授权异常',
        self::params        => '参数异常',

        self::info          => '无权限',
        self::id            => 'id不能为空',
        self::add           => '添加异常',
        self::update        => '修改异常',
        self::delete        => '删除异常',
    ];

    /**
     * 获取状态msg
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/20
     * Time: 11:57
     * @param $k
     * @return mixed|string
     */
    static function get_msg($k)
    {
        $data = self::$msg_data;
        if(isset($data[$k]))
        {
            return $data[$k];
        }
        else
        {
            return '异常';
        }
    }

    /**
     * 返回方法，第二版
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/20
     * Time: 14:00
     * @param int $code
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    static function success_v2($code = 200,$data = [])
    {
        return response()->json([
            'code' => $code,
            'msg' => self::get_msg($code),
            'data' => $data,
        ]);
    }


    /**
     * 返回方法
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/1
     * Time: 14:41
     * @param array $data
     * @param string $msg
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    static function success($data = [],$msg = '成功',$code = success::code_success)
    {
        return response()->json([
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ]);
    }
}