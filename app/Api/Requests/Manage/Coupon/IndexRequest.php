<?php

namespace App\Api\Requests\Manage\Coupon;

use App\Api\Requests\Manage\BaseRequest;
use App\Models\Comment;
use App\Models\Coupon;
use Illuminate\Validation\Rule;

class IndexRequest extends BaseRequest
{
    public function getCommon()
    {

        $couponIns = new Coupon();

        return [
            'name'       => 'required|max:20',
            'type'       => [
                'required',
                Rule::in(array_keys($couponIns->typeText))
            ],
            'sale_type'  => [
                'required',
                Rule::in(array_keys($couponIns->preferText))
            ],
            'sale_value' => 'required|numeric|min:0',
            'total'      => 'required|integer|min:0',
            'limit'      => 'nullable|max:255',
            'phone'      => [
                'required',
                'regex:/^1[34578][0-9]{9}$/',
            ],
            'start'      => [
                'required',
                'date_format:Y-m-d'
            ],
            'end'        => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:start'
            ],
            'week'       => [
                'required',
                Rule::in(array_keys($couponIns->weekText))
            ],
            'time'       => [
                'required',
                Rule::in(array_keys($couponIns->timeText))
            ],
            'price'      => 'required|numeric|min:0',
            'keyword'    => 'nullable|max:255',
            'address'    => 'required|max:255',
            'img'        => 'required|max:255',
            'latitude'   => 'required',
            'longitude'  => 'required',
        ];
    }

    public function upStatusRules()
    {
        return [
            'status' => 'required|boolean',
        ];
    }

    public function upVerifyRules()
    {
        return [
            'verify' => [
                'required',
                Rule::in(array_keys(app(Coupon::class)->verifyText))
            ],
            'remark' => 'nullable|max:255'
        ];
    }

    public function storeRules()
    {
        return $this->getCommon();
    }

    public function updateRules()
    {
        return $this->getCommon();
    }

    public function messages()
    {
        return [
            'name.required'       => '请输入店名',
            'name.max'            => '店名长度在 20 个字符以内',
            'type.required'       => '请选择分类',
            'type.*'              => '错误的分类',
            'sale_type.required'  => '请选择优惠类型',
            'sale_type.*'         => '错误的优惠类型',
            'sale_value.required' => '请输入优惠值',
            'sale_value.*'        => '请输入合法的优惠值',
            'total.required'      => '请输入发放数量',
            'total.*'             => '请输入合法的发放数量',
            'limit.max'           => '使用范围长度在 255 个字符以内',
            'phone.required'      => '请输入手机号',
            'phone.*'             => '请输入合法的手机号',
            'start.required'      => '请选择开始时间',
            'start.*'             => '请选择合法的开始时间',
            'end.required'        => '请选择结束时间',
            'end.after'           => '结束时间需大于开始时间',
            'end.*'               => '请选择合法的结束时间',
            'week.required'       => '请选择周几可用',
            'week.*'              => '不合法的周几可用',
            'time.required'       => '请选择可用时间段',
            'time.*'              => '不合法的时间段',
            'price.required'      => '请输入价格',
            'price.*'             => '请输入合法的价格',
            'price.*'             => '请输入合法的价格',
            'keyword.max'         => '关键字长度在 255 个字符以内',
            'address.required'    => '请输入地址',
            'address.max'         => '地址长度在 255 个字符以内',
            'longitude.*'           => '错误的经度',
            'latitude.*'          => '错误的纬度',
            'img.*'               => '请上传店铺图片',
        ];
    }
}
