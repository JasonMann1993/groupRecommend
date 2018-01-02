<?php

namespace App\Api\Mobile\Requests;

use Dingo\Api\Http\FormRequest;

class IndexRequest extends FormRequest
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
    ## 首页列表
    public function indexRules()
    {
        return [
            'longitude' => 'required',
            'latitude' => 'required'
        ];
    }
    ## 群推荐页
    public function infoRules()
    {
        return [
            'longitude' => 'required',
            'latitude' => 'required'
        ];
    }

    ## 将用户归类小区
    public function plotMembersRules()
    {
        return [
            'id' => 'required|exists:groups,id',
            'member_id' => 'required|exists:members,id',
            'longitude' => 'required',
            'latitude' => 'required',
        ];
    }
}
