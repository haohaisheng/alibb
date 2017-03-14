<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminRequest extends Request
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
     * 自定义验证规则rules
     *
     * @return array
     */
    public function rules($type = 'store')
    {
        $rules = [
            'username' => 'required|min:4|max:20|unique:bb_admin,username',
            'password' => 'required',
        ];
        return $rules;
    }

    /**
     * 自定义验证信息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => '请填写用户名',
            'password.required' => '请填写密码',
        ];
    }
}
