<?php

namespace App\Api\Requests\Manage\User;

use App\Api\Requests\Manage\BaseRequest;
use Illuminate\Validation\Rule;

class ShopRequest extends BaseRequest
{
    public function listsRules()
    {
        return [
            'type' => [
                'nullable',
                Rule::in([0, 1])
            ]
        ];
    }

    public function updateRules()
    {
        return [
            # 制券奖励
            'reward_make_for_re_shop' => 'nullable|numeric',    # 商家推荐人
            # 核销奖励
            'reward_use_for_re_shop'  => 'nullable|numeric',    # 商家推荐人
            'reward_use_for_user'     => 'nullable|numeric',    # 用户
            'reward_use_for_re_user'  => 'nullable|numeric',     # 用户推荐人
            # 制券扣款
            'cut_make_for_shop'       => 'nullable|numeric', # 商家
        ];
    }


    public function messages()
    {
        return [
            # 制券奖励
            'reward_make_for_re_shop.numeric' => '请输入合法的商家推荐人制券奖励',
            # 核销奖励
            'reward_use_for_re_shop.numeric'  => '请输入合法的商家推荐人核销奖励',
            'reward_use_for_user.numeric'     => '请输入合法的用户核销奖励',
            'reward_use_for_re_user.numeric'  => '请输入合法的用户推荐人核销奖励',
            # 制券扣款
            'cut_make_for_shop.numeric'       => '请输入合法的商家制券扣款',
        ];
    }

}
