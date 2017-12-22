<?php

namespace App\Api\Transformers;
use App\Models\Member;
use League\Fractal\TransformerAbstract;
class MembersTransformer extends TransformerAbstract
{
    public function transform(Member $item)
        {
            return [
                'id' => $item->id,
                'avatar' => $item->avatar,
                'nickname' => $item->nickname,
                'city' => $item->city,
                'status'=>$item->status,
                'cbqrcode'=>$item->cbqrcode,
                // 'is_manger' => (bool)$item->coupons->count()
            ];
        }

}