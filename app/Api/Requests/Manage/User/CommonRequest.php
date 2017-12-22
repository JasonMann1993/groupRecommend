<?php

namespace App\Api\Requests\Manage\User;

use App\Api\Requests\Manage\BaseRequest;

class CommonRequest extends BaseRequest
{

    public function loginRules()
    {
        return [
            'name' => 'required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.*'=>'请输入手机号',
            'password.*'=>'请输入密码'
        ];
    }
}
