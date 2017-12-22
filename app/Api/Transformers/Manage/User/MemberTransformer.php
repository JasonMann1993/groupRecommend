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
        $recommendInfo = $member->parentUser();

        return [
            'id'         => $member->id,
            'name'       => $member->nickname,
            'avatar'     => $member->avatar,
            'status'     => ['bool'  => true,
                             'value' => boolval($member->status),
                             'text'  => $member->statusText
            ],
            'block'      => boolval($member->defriend),
            'recommends' => [
                'name' => $recommendInfo ? $recommendInfo->nickname ?: $recommendInfo->name : '-',
                'id'   => $recommendInfo ? $recommendInfo->id : '-',
            ]
        ];
    }

    public function transInfo(Member $member)
    {
        return [
            'id'                      => $member->id,
            'name'                    => $member->nickname,

            # 制券奖励
            'reward_make_for_re_shop' => $member->real_reward_make_for_re_shop, # 商家推荐人
            'reward_make_for_shop'    => $member->real_reward_make_for_shop, # 商家
            # 核销扣款
            'reward_cut_use_for_shop'  => $member->real_reward_cut_use_for_shop, # 商家
            # 核销奖励
            'reward_use_for_re_user'  => $member->real_reward_use_for_re_user, # 用户推荐人
            'reward_use_for_re_shop'  => $member->real_reward_use_for_re_shop, # 商家推荐人
            'reward_use_for_user'     => $member->real_reward_use_for_user, # 用户
            'reward_use_for_shop'     => $member->real_reward_use_for_shop, # 商家
            # 制券扣款
            'cut_make_for_shop'       => $member->real_cut_make_for_shop, # 商家
        ];
    }


}