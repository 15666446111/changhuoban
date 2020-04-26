<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequests extends FormRequest
{
    /**
     * 验证失败处理
     * 
     * @param object $validator
     * @throws Illuminate\Http\Exceptions\HttpResponseException
     */
    public function failedValidation($validator)
    {
        throw new HttpResponseException(response()->json(['error'=>['message' => $validator->errors()->first()]]));
    }
}