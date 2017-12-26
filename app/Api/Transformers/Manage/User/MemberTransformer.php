<?php

namespace App\Api\TransFormers\Manage\User;

use App\Api\TransFormers\Manage\BaseTransformer;
use App\Models\Member;

class MemberTransformer extends BaseTransformer
{
    public function trans(Member $member)
    {
        return [
            'id'         => $member->id,
            'name'       => $member->name,
            'avatar'     => get_upload_url($member->avatar),
            'group'     =>$member->groups?$member->groups()->first()['name']:'',
            'address'   =>$member->address,
            'type'     => $member->typeText[$member->type],
        ];
    }

    public function transInfo(Member $member)
    {
        $groups = [];
        if($member->groups){
            foreach($member->groups as $group){
                $groups[$group['id']] = $group['name'];
            }
        }
        return [
            'id'                      => $member->id,
            'name'                    => $member->name,
            'type'                    => $member->type,
            'address'                    => $member->address,
            'latitude'                => $member->latitude,
            'longitude'                => $member->longitude,
            'group'                    => $groups,
            'active'                    => $member->active,
            'order'                    => $member->order,
            'block'                    => boolval($member->block),
        ];
    }


}