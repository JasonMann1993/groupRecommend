<?php

namespace App\Api\Requests\Manage;


use Dingo\Api\Http\FormRequest;

class BaseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $commons = [
        ];
        return get_request_rules($this, $commons);
    }
}
