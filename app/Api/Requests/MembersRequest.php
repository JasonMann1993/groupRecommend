<?php

namespace App\Api\Requests;

use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\Rule;

class MembersRequest extends FormRequest
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


    public function handleRules()
    {
        return [
            'code'=>'required',
            'encryptedData'=>'required',
            'iv'=>'required'
        ];
    }
    public function getUserInfoRules()
    {
        return [
            'unique_id' => 'required|exists:members,unique_id',
        ];
    }
    public function AwardindexRules()
    {
        return [
            'unique_id' => 'required|exists:members,unique_id',
            'status' => 'required',
        ];
    }
    public function MyRecommendRules()
    {
        return [
            'unique_id' => 'required|exists:members,unique_id',
        ];

    }

    public function referrerRules()
    {
        return [
            'id' => 'required|exists:members,unique_id',
            'recommend_id' => 'required',
            'type'=>['required',Rule::in([1,2])]
        ];
    }

    public function recommendCodeRules()
    {
        return [
            'id' => 'required|exists:members,unique_id',
        ];
    }
}
