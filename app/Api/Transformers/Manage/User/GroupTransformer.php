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
        foreach($group->businesses as $business){
            $pivotBusinessId[] = $business->id;
        }
        return [
            'id'=>$group->id,
            'name'=>$group->name,
            'desc'=>$group->desc,
            'address'=>$group->address,
            'latitude'=>$group->latitude,
            'longitude'=>$group->longitude,
            'wx'=>$group->wx,
            'ids'=>$pivotBusinessId,
            'logo'=>$group->logo,
            'logo_url'=>get_upload_url($group->logo),
            'qr_code'=>$group->qr_code,
            'qr_code_url'=>get_upload_url($group->qr_code),
            'order'=>$group->order,
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