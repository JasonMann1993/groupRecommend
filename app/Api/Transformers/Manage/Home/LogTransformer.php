<?php

namespace App\Api\TransFormers\Manage\Home;

use App\Api\TransFormers\Manage\BaseTransformer;

class LogTransformer extends BaseTransformer
{
    public function trans($item)
    {
        return [
            'id'          => $item->id,
            'user_name'   => $item->member ? $item->member->nickname : '',
            'user_id'     => $item->member_id,
            'money'       => $item->money,
            'created_at'  => $item->created_at . '',
            'total_money' => isset($this->total) ? $this->total + 0 : 0,
            'type'        => $item->type
        ];
    }

    public function transAward($item)
    {
        return [
            'id'          => $item->id,
            'user_name'   => $item->merchant ? $item->merchant->nickname : '',
            'user_id'     => $item->origin_id,
            'money'       => $item->money,
            'created_at'  => $item->created_at . '',
            'total_money' => isset($this->total) ? $this->total + 0 : 0,
            'type'        => $item->type
        ];
    }

    public function transPartner($item)
    {
        return [
            'id'          => $item->id,
            'user_name'   => $item->merchant ? $item->merchant->nickname : '-',
            'user_id'     => $item->origin_id,
            'coupon_name' => $item->coupon ? $item->coupon->name : '-',
            'money'       => $item->money,
            'created_at'  => $item->created_at . '',
            'total_money' => isset($this->total) ? $this->total + 0 : 0,
            'type'        => $item->type
        ];
    }
}