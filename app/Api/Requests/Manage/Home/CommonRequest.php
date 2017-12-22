<?php

namespace App\Api\Requests\Manage\Home;

use App\Api\Requests\Manage\BaseRequest;

class CommonRequest extends BaseRequest
{
    public function uploadRules()
    {
        return [
            'file' => 'required|file'
        ];
    }

    public function setArguRules()
    {
        return [
            # 制券奖励
            'reward_make_for_partner'    => 'required|numeric',    # 商家合伙人
            'reward_make_for_re_shop'    => 'required|numeric',    # 商家推荐人
            'reward_make_for_shop'       => 'required|numeric',   # 商家
            # 核销扣款
            'reward_cut_use_for_shop' => 'required|numeric', # 商家
            # 核销奖励
            'reward_use_for_partner'     => 'required|numeric', # 商家合伙人
            'reward_use_for_re_shop'     => 'required|numeric',    # 商家推荐人
            'reward_use_for_shop'        => 'required|numeric',    # 商家
            'reward_use_for_user'        => 'required|numeric',    # 用户
            'reward_use_for_re_user'     => 'required|numeric',     # 用户推荐人
            # 制券扣款
            'cut_make_for_shop'          => 'required|numeric', # 商家
        ];
    }

    public function messages()
    {
        return [
            'file.*'                           => '请选择要上传的文件',
            # 制券奖励
            'reward_make_for_partner.required' => '请输入商家合伙人制券奖励',
            'reward_make_for_partner.numeric'  => '请输入合法的商家合伙人制券奖励',

            'reward_make_for_re_shop.required' => '请输入商家推荐人制券奖励',
            'reward_make_for_re_shop.numeric'  => '请输入合法的商家推荐人制券奖励',

            'reward_make_for_shop.required'    => '请输入商家人制券奖励',
            'reward_make_for_shop.numeric'     => '请输入合法的商家制券奖励',
            # 核销扣款
            'reward_cut_use_for_shop.required' => '请输入商家核销扣款',
            'reward_cut_use_for_shop.numeric'  => '请输入合法的商家核销扣款',
            # 核销奖励
            'reward_use_for_partner.required'  => '请输入商家合伙人核销奖励',
            'reward_use_for_partner.numeric'   => '请输入合法的商家合伙人核销奖励',

            'reward_use_for_re_shop.required' => '请输入商家推荐人核销奖励',
            'reward_use_for_re_shop.numeric'  => '请输入合法的商家推荐人核销奖励',

            'reward_use_for_shop.required' => '请输入商家核销奖励',
            'reward_use_for_shop.numeric'  => '请输入合法的商家核销奖励',

            'reward_use_for_user.required' => '请输入用户核销奖励',
            'reward_use_for_user.numeric'  => '请输入合法的用户核销奖励',

            'reward_use_for_re_user.required' => '请输入用户推荐人核销奖励',
            'reward_use_for_re_user.numeric'  => '请输入合法的用户推荐人核销奖励',
            # 制券扣款
            'cut_make_for_shop.required'      => '请输入商家制券扣款',
            'cut_make_for_shop.numeric'       => '请输入合法的商家制券扣款',
        ];
    }


}
