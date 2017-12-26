<?php

namespace App\Api\TransFormers\Manage\User;

use App\Api\TransFormers\Manage\BaseTransformer;
use App\Models\Member;
use App\Models\Menu;
use App\Models\User;

class MemberTransformer extends BaseTransformer
{
    public function trans(Member $member)
    {
        return [
            'id'         => $member->id,
            'name'       => $member->name,
            'avatar'     => get_upload_url($member->avatar),
            'group'     =>explode(',',$member->group)[0],
            'address'   =>$member->address,
            'type'     => $member->typeText[$member->type],
        ];
    }

    public function transInfo(Member $member)
    {
        return [
            'id'                      => $member->id,
            'name'                    => $member->name,
            'type'                    => $member->type,
            'address'                    => $member->address,
            'group'                    => $member->group,
            'active'                    => $member->active,
            'order'                    => $member->order,
            'block'                    => boolval($member->block),
        ];
    }


}