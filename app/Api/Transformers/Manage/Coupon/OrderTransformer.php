<?php

namespace App\Api\TransFormers\Manage\Coupon;

use App\Api\TransFormers\Manage\BaseTransformer;
use App\Models\Order;

class OrderTransformer extends BaseTransformer
{
    public function trans(Order $order)
    {
        return [
            'id'          => $order->id,
            'user_name'   => $order->member ? $order->member->nickname : '-',
            'coupon_name' => $order->coupon ? $order->coupon->real_name : '-',
            'coupon_id'   => $order->coupon_id,
            'order_no'    => $order->order_no,
            'money'       => $order->money,
            'status_text' => array_get($order->statusText, $order->status),
            'status'      => $order->status
        ];
    }
}