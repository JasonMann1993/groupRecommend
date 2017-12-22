<?php

namespace App\Api\TransFormers\Manage\Coupon;

use App\Api\TransFormers\Manage\BaseTransformer;
use App\Models\CouponRecode;

class RecordTransformer extends BaseTransformer
{
    public function trans(CouponRecode $record)
    {
        return [
            'id'          => $record->id,
            'user_name'   => $record->member ? $record->member->nickname : '-',
            'user_avatar' => $record->member ? $record->member->avatar : '',
            'coupon_name' => $record->coupon ? $record->coupon->name : '-',
            'created_at'  => $record->created_at . '',
            'type'        => $record->type
        ];
    }
}