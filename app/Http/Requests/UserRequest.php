<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
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
            'name' => 'required|min:4|max:10|unique:bb_user,name',
            'sex' => 'required',
            'age' => 'required|min:10|max:100',
            'phone' => 'required|size:11|unique:bb_user,phone',
            'email' => 'required|email|unique:bb_user,email',
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
            'name.required' => '请填写昵称',
            'name.min' => '昵称过短，长度不得少于4',
            'name.max' => '昵称过长，长度不得超出10',
            'name.unique' => '昵称已存在',
            'sex.required' => '请填写性别',
            'age.required' => '请填写年龄',
            'age.min' => '年龄不能小于10',
            'age.max' => '年龄不能大于100',
            'phone.required' => '请填写手机号',
            'phone.size' => '国内的手机号码长度为11位',
            /*  'phone.mobile_phone' => '请填写合法的手机号码',*/
            'phone.unique' => '该手机号已存在',
            'email.required' => '请填写邮箱地址',
            'email.email' => '请填写正确合法的邮箱地址',
            'email.unique' => '该邮箱号已存在',
        ];
    }
}
