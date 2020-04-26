<?php

namespace App\Http\Requests;

class LoginRequest extends BaseRequests
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account'   =>  'required|exists:users,account',
            'password'  =>  'required|min:6|max:16'
        ];
    }

    /**
     * 获取已定义验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'account.required'      =>  '请输入您的账号',
            'account.exists'        =>  '账号不存在',
            'password.required'     =>  '请输入您的密码',
            'password.min'          =>  '密码最小为6位',
            'password.max'          =>  '密码最大为16位',
        ];
    }



}
