<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'register_phone'    =>  'required|unique:busers,account|between:11,11',
            'register_code'     =>  'required|between:4,6',
            'register_password' =>  'required|between:6,20|alpha_num',
            'register_confirm_password' =>  'required|between:6,20|alpha_num',
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
            'register_phone.required'       =>  '请输入您的手机号码',
            'register_phone.unique'         =>  '该账号已存在',
            'register_phone.between'        =>  '账号不是有效的手机号',

            'register_code.required'        =>  '请输入验证码',
            'register_code.between'         =>  '验证码长度不正确',

            'register_password.required'    =>  '请输入您的密码',
            'register_password.between'     =>  '密码长度不正确',
            'register_password.alpha_num'   =>  '密码只能为字母和数字',


            'register_confirm_password.required'    =>  '两次密码不一致',
            'register_confirm_password.between'     =>  '密码长度不正确',
            'register_confirm_password.alpha_num'   =>  '密码只能为字母和数字',
        ];
    }
}
