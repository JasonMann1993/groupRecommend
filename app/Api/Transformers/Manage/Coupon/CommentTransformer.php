<?php

namespace App\Api\TransFormers\Manage\Coupon;

use App\Api\TransFormers\Manage\BaseTransformer;
use App\Models\Comment;

class CommentTransformer extends BaseTransformer
{
    public function trans(Comment $comment)
    {
        return [
            'id'          => $comment->id,
            'user_name'   => $comment->member ? $comment->member->nickname : '-',
            'coupon_name' => $comment->coupon ? $comment->coupon->real_name : '-',
            'content'     => $comment->content,
            'status_text' => array_get($comment->statusText, $comment->status),
            'created_at'  => $comment->created_at . '',
            'status'      => $comment->status
        ];
    }
}