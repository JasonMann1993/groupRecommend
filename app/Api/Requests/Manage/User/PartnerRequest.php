<?php

namespace App\Api\Requests\Manage\User;

use App\Api\Requests\Manage\BaseRequest;

class PartnerRequest extends BaseRequest
{

    public function getCommon($more)
    {
        $commons = [
            'name'  => 'required|min:2,max:15',
            'phone' => [
                'required',
                'regex:/^1[34578][0-9]{9}$/',
                'unique:users,phone,' . array_first($this->route()->parameters())
            ],
        ];

        return array_merge($commons, $more);
    }

    public function storeRules()
    {
        return $this->getCommon([
            'password' => 'required|min:6,max:20',
        ]);
    }

    public function updateRules()
    {
        return $this->getCommon([
            'password' => 'nullable|min:6,max:20',
        ]);
    }

    public function messages()
    {
        return [
            'name.required'     => '请输入用户名',
            'name.min'          => '用户名长度在 2 到 15 个字符',
            'name.max'          => '用户名长度在 2 到 15 个字符',
            'phone.required'    => '请输入手机号',
            'phone.regex'       => '请输入正确的手机号',
            'phone.unique'      => '手机号已存在',
            'password.required' => '请输入手机号密码',
            'password.min'      => '密码长度在 6 到 20 个字符',
            'password.max'      => '密码长度在 6 到 20 个字符',
        ];
    }

}
