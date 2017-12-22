<?php

namespace App\Api\Requests\Manage\Coupon;

use App\Api\Requests\Manage\BaseRequest;
use App\Models\Comment;
use Illuminate\Validation\Rule;

class CommentRequest extends BaseRequest
{
    public function upStatusRules()
    {
        return [
            'status' => [
                'required',
                Rule::in(array_keys(app(Comment::class)->statusText))
            ]
        ];
    }
}
