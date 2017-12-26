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
            'business_id'=>'exists:business,id',
            'logo'=>'required',
            'qr_code'=>'required',
            'order'=>'required|numeric',
            'business_ids'=>'required|array',
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
            'business_id'=>'exists:business,id',
            'logo'=>'required',
            'qr_code'=>'required',
            'order'=>'required|numeric',
            'business_ids'=>'required|array',
        ];
    }
}