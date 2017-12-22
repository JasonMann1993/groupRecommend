<?php

namespace App\Api\Requests\Manage\Coupon;

use App\Api\Requests\Manage\BaseRequest;
use App\Models\Comment;

class OrderRequest extends BaseRequest
{
    public function upStatusRules()
    {
        return [
            'status' => [
                'required',
                Rule::in(array_values(app(Comment::class)->statusText))
            ]
        ];
    }
}
