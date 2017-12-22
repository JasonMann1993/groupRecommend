<?php

namespace App\Api\TransFormers\Manage\User;

use App\Api\TransFormers\Manage\BaseTransformer;
use App\Models\Member;
use App\Models\Menu;
use App\Models\User;

class PartnerTransformer extends BaseTransformer
{

    public function trans(User $user)
    {

        return [
            'id'                      => $user->id,
            'name'                    => $user->name,
            'phone'                   => $user->phone,
            'avatar'                  => $user->avatar,
            'qr_code'                 => $user->qr_code,
            'block'                   => boolval($user->defriend),
            'make_url'                => $user->make_url,

            # 制券奖励
            'reward_make_for_partner' => $user->real_reward_make_for_partner, # 商家合伙人
            # 核销奖励
            'reward_use_for_partner'  => $user->real_reward_use_for_partner, # 商家合伙人
        ];
    }
}