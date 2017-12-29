<?php

namespace App\Api\Mobile\Requests;

use Dingo\Api\Http\FormRequest;

class MemberRequest extends FormRequest
{
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
        $commons = [

        ];
        return get_request_rules($this, $commons);
    }

    public function infoRules()
    {
        return [
            'code' => 'required',
            'longitude' => 'required',
            'latitude' => 'required'
        ];
    }

}
