<?php

namespace App\Api\TransFormers\Manage\User;

use App\Api\TransFormers\Manage\BaseTransformer;
use App\Models\Member;
use App\Models\User;

class CommonTransformer extends BaseTransformer
{
    public function transInfo(User $member)
    {
        return [
            'phone'  => $member->phone,
            'avatar' => get_upload_url($member->avatar),
            'name'   => $member->name,
        ];
    }

    public function transMemberInfo(Member $member)
    {
        return [
            'id'            => $member->id,
            'avatar'        => $member->avatar,
            'name'          => $member->nickname,
            'total_balance' => $member->sumBalance(),
            'total_award'   => $member->sumAward(),
            'unique_id'     => $member->unique_id
        ];
    }

}