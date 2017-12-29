<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/12/26
 * Time: 9:38
 */

namespace App\Api\TransFormers\Manage\User;


use App\Api\TransFormers\Manage\BaseTransformer;
use App\Models\Group;

class GroupTransformer extends BaseTransformer
{
    public function trans(Group $group)
    {
        return [
          'id'=>$group->id,
          'name'=>$group->name,
          'logo'=>get_upload_url($group->logo),
          'desc'=>$group->desc,
          'address'=>$group->address,
        ];
    }

    public function transInfo(Group $group)
    {
        $pivotBusinessId = [];
        $businessInfo = [];
        if($group->businesses){
            foreach($group->businesses as $business){
                $pivotBusinessId[] = $business->id;
                $businessInfo[] = [
                    'name' => $business['name'],
                    'id'   => $business['id']
                ];
            }
        }
        return [
            'id'=>$group->id,
            'master'=>$group->master,
            'name'=>$group->name,
            'desc'=>$group->desc,
            'address'=>$group->address,
            'latitude'=>$group->latitude,
            'longitude'=>$group->longitude,
            'wx'=>$group->wx,
            'business_ids'=>$pivotBusinessId,
            'businesses'=>$businessInfo,
            'logo'=>$group->logo,
            'logo_url'=>get_upload_url($group->logo),
            'qr_code'=>$group->qr_code,
            'qr_code_url'=>get_upload_url($group->qr_code),
            'order'=>$group->order,
            'district_a'=>$group->district_a,
            'district_b'=>$group->district_b,
            'district_c'=>$group->district_c,
            'district_d'=>$group->district_d,
            'ratio_a'=>$group->ratio_a,
            'ratio_b'=>$group->ratio_b,
            'ratio_c'=>$group->ratio_c,
            'ratio_d'=>$group->ratio_d,
            'latitude_a'=>$group->latitude_a,
            'longitude_a'=>$group->longitude_a,
            'latitude_b'=>$group->latitude_b,
            'longitude_b'=>$group->longitude_b,
            'latitude_c'=>$group->latitude_c,
            'longitude_c'=>$group->longitude_c,
            ];
    }

    public function transLists(Group $group)
    {
        return [
            'id'=>$group->id,
            'name'=>$group->name,
        ];
    }
}