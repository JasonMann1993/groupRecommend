<?php

namespace App\Api\Requests\Manage\User;

use App\Api\Requests\Manage\BaseRequest;
use Illuminate\Validation\Rule;

class MemberRequest extends BaseRequest
{
    public function listsRules()
    {
        return [

        ];
    }

    public function updateRules()
    {
        return [
            'name'=>'required',
            'type'=>['required',Rule::in(1,2)],
            'address'=>'required',
            'latitude'=>'required|numeric',
            'longitude'=>'required|numeric',
            'group'=>'required|array',
            'active'=>'required',
            'order'=>'required',
            'block'=>'required|boolean',
        ];
    }


    public function messages()
    {
        return [

        ];
    }

}
