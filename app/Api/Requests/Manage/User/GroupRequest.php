<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/12/26
 * Time: 9:34
 */

namespace App\Api\Requests\Manage\User;


use App\Api\Requests\Manage\BaseRequest;

class GroupRequest extends BaseRequest
{
    public function storeRules()
    {
        return [
            'master'=>'required',
            'name'=>'required',
            'desc'=>'required',
            'address'=>'required',
            'latitude'=>'required|numeric',
            'longitude'=>'required|numeric',
            'wx'=>'required',
            'logo'=>'required',
            'qr_code'=>'required',
            'order'=>'required|numeric',
            'business_ids'=>'required|array',
            'ratio_a'=>'numeric|min:0|max:1',
            'ratio_b'=>'numeric|min:0|max:1',
            'ratio_c'=>'numeric|min:0|max:1',
            'ratio_d'=>'numeric|min:0|max:1',
        ];
    }

    public function updateRules()
    {
        return [
            'master'=>'required',
            'name'=>'required',
            'desc'=>'required',
            'address'=>'required',
            'latitude'=>'required|numeric',
            'longitude'=>'required|numeric',
            'wx'=>'required',
            'logo'=>'required',
            'qr_code'=>'required',
            'order'=>'required|numeric',
            'business_ids'=>'required|array',
            'ratio_a'=>'numeric|min:0|max:1',
            'ratio_b'=>'numeric|min:0|max:1',
            'ratio_c'=>'numeric|min:0|max:1',
            'ratio_d'=>'numeric|min:0|max:1',
        ];
    }
}