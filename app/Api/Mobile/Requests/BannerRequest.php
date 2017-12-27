<?php

namespace App\Api\Mobile\Requests;

use Dingo\Api\Http\FormRequest;

class BannerRequest extends FormRequest
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

    public function indexRules()
    {
        return [

        ];
    }

    public function infoRules()
    {
        return [
            'id' => 'required|exists:banners,id'
        ];
    }

}
