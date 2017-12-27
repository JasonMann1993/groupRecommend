<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/12/26
 * Time: 9:38
 */

namespace App\Api\TransFormers\Manage\User;


use App\Api\TransFormers\Manage\BaseTransformer;
use App\Models\Business;

class BusinessTransformer extends BaseTransformer
{
    public function trans(Business $business)
    {
        return [
            'id'=>$business->id,
            'name'=>$business->name,
            'logo'=>get_upload_url($business->logo),
            'desc'=>$business->desc,
            'address'=>$business->address,
            'talk'=>$business->talk,
        ];
    }

    public function transInfo(Business $business)
    {
        return [
            'id'=>$business->id,
            'name'=>$business->name,
            'logo'=>$business->logo,
            'logo_url'=>get_upload_url($business->logo),
            'desc'=>$business->desc,
            'address'=>$business->address,
            'latitude'=>$business->latitude,
            'longitude'=>$business->longitude,
            'talk'=>$business->talk,
            'star'=>$business->star,
            'member_id'=>$business->member_id,
            'member_name'=>$business->member['name'],
            'order'=>$business->order,
        ];
    }

    public function transLists(Business $business)
    {
        return [
            'id'=>$business->id,
            'name'=>$business->name,
        ];
    }
}