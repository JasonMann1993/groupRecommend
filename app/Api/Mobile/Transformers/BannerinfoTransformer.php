<?php

namespace App\Api\Mobile\Transformers;

use App\Models\Banner;
use League\Fractal\TransformerAbstract;

class BannerinfoTransformer extends TransformerAbstract
{

    public function transform(Banner $item)
    {
        $info = [
            'id' => $item->id,
            'name' => $item->name,
            'img' => getImgAttribute($item->picture),
            'content' => $item->content,
        ];
        return $info;
    }
}