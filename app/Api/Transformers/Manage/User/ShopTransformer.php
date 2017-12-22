<?php

namespace App\Api\TransFormers\Manage\User;

use App\Api\TransFormers\Manage\BaseTransformer;
use App\Models\Member;
use App\Models\Menu;
use App\Models\User;

class ShopTransformer extends BaseTransformer
{
    public function trans(Member $member)
    {
        return [
            'id'         => $member->id,
            'name'       => $member->nickname,
            'avatar'     => $member->avatar,
            'qr_code' =>  $member->qr_code,
        ];
    }

    public function transInfo(Member $member)
    {
        return [
            'id'         => $member->id,
            'name'       => $member->nickname,
            'avatar'     => $member->avatar,
            'qr_code' =>  $member->qr_code,
        ];
    }

}