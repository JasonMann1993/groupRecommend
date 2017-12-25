<?php

namespace App\Api\Requests\Manage\Home;

use App\Api\Requests\Manage\BaseRequest;

class BannerRequest extends BaseRequest
{
    public function getCommon($more)
    {
        $commons = [
            'name'          => 'required|max:20',
            'content'       => 'required',
        ];

        return array_merge($commons, $more);
    }

    public function storeRules()
    {
        return $this->getCommon([
            'picture'       => 'required|max:255',
        ]);
    }

    public function updateRules()
    {
        return $this->getCommon([
            'show' => 'required|boolean',
            'order' => 'required',
        ]);
    }

    public function messages()
    {
        return [
            'name.required'      => '请输入名称',
            'name.max'           => '名称长度在 20 个字符以内',
            'picture.*'          => '请上传图片',
            'is_show.*'          => '错误的参数',
            'phone.unique'       => '手机号已存在',
            'coupon_id.required' => '请输入优惠券ID',
            'coupon_id.exists'   => '未找到该优惠券',
            'carousel_time.'     => '错误的参数',
        ];
    }


}
