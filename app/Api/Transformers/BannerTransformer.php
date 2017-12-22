<?php

namespace App\Api\Transformers;

use App\Models\Banner;
use League\Fractal\TransformerAbstract;

class BannerTransformer extends TransformerAbstract
{

    public function transform(Banner $item)
    {
        $info = [
            'name'=>$item->name,
            'imgurl'=>$item->picture,
            'coupon_id'=>$item->coupon_id,
            'carousel_time'=>$item->carousel_time*1000,
        ];
        return $info;
    }
}