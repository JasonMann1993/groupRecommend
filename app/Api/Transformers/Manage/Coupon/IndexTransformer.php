<?php

namespace App\Api\TransFormers\Manage\Coupon;

use App\Api\TransFormers\Manage\BaseTransformer;
use App\Models\Coupon;
use App\Models\CouponRecode;

class IndexTransformer extends BaseTransformer
{
    public function trans(Coupon $coupon)
    {
        return [
            'id'          => $coupon->id,
            'user_name'   => $coupon->member ? $coupon->member->nickname : '-',
            'coupon_name' => $coupon->real_name,
            'img'         => $coupon->img,
            'sale_value'  => $coupon->sale_value,
            'verify_text' => array_get($coupon->verifyText, $coupon->verify),
            'verify'      => $coupon->verify,
            'created_at'  => $coupon->created_at . '',
            'status'      => boolval($coupon->status)
        ];
    }

    public function transInfo(Coupon $coupon)
    {
        $couponStats = $coupon->stats;

        return [
            'id'              => $coupon->id,
            'user_name'       => $coupon->member ? $coupon->member->nickname : '-',
            'total'           => $coupon->total,  # 发放数量
            'times'           => $coupon->times,  # 最大领取数量
            'got_num'         => $coupon->total - $coupon->stock,  # 已领数量
            'limit'           => $coupon->limit,   # 使用范围
            'name'            => $coupon->name,   # 店名
            'keywords'        => $coupon->keyword_lists,   # 关键字
            'keyword'         => $coupon->keywords,   # 关键字
            'type_text'       => array_get($coupon->typeText, $coupon->type),# 行业分类
            'type'            => $coupon->type,  # 行业分类
            'start'           => $coupon->start,   # 优惠开始
            'address'         => $coupon->address,   # 地址
            'sale_value_text' => $coupon->sale_value, # 优惠金额
            'sale_value'      => $coupon->prefer_value, # 优惠金额
            'end'             => $coupon->end,   # 优惠结束
            'phone'           => $coupon->phone,   # 电话
            'sale_type_text'  => array_get($coupon->prefeText, $coupon->prefer_type),   # 优惠类型
            'sale_type'       => $coupon->prefer_type,   # 优惠类型
            'created_at'      => $coupon->created_at . '', # 添加时间
            'price'           => $coupon->price,   # 购券价格
            'verified_at'     => $coupon->verified_at ?: '-',   # 审核时间
            'verify_text'     => array_get($coupon->verifyText, $coupon->verify),
            'verify'          => $coupon->verify,
            'week'            => $coupon->week,   # 周几可用
            'time'            => $coupon->time,   # 可用时间
            'img'             => array_get($coupon->getAttributes(), 'img'), # 门店 Logo
            'img_url'         => get_upload_url(array_get($coupon->getAttributes(), 'img')), # 门店 Logo
            'last_check_msg'  => $coupon->auditLogs->count() ? $coupon->auditLogs->sortByDesc('id')->first()->remark : '', # 最后一次审核信息

            'latitude'   => $coupon->latitude,
            'longitude'  => $coupon->longitude,

            # 统计信息
            'stats'      => [
                'view' => $couponStats ? $this->collection($couponStats->where('type', 1), new IndexTransformer('stat')) : [],
                'get'  => $couponStats ? $this->collection($couponStats->where('type', 2), new IndexTransformer('stat')) : [],
                'use'  => $couponStats ? $this->collection($couponStats->where('type', 3), new IndexTransformer('stat')) : [],
            ],
            'stat_count' => [
                'view' => $couponStats ? $couponStats->where('type', 1)->count() : 0,
                'get'  => $couponStats ? $couponStats->where('type', 2)->count() : 0,
                'use'  => $couponStats ? $couponStats->where('type', 3)->count() : 0,
            ]
        ];

    }


    public function transStat(CouponRecode $log)
    {
        return [
            'user_avatar' => $log->member ? $log->member->avatar : '',
            'user_name'   => $log->member ? $log->member->nickname : '--',
            'created_at'  => $log->created_at . ''
        ];
    }
}