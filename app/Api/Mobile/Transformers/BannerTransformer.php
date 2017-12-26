<?php

namespace App\Api\Mobile\Transformers;

use App\Models\Banner;
use League\Fractal\TransformerAbstract;

class BannerTransformer extends TransformerAbstract
{

    public function transform(Banner $item)
    {
        $info = [
            'id' => $item->id,
            'name' => $item->name,
            'imgurl' => getImgAttribute($item->picture),
            //'content' => $item->content,
        ];
        return $info;
    }
}