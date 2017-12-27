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
            //'img' => getImgAttribute($item->picture),
            'img' => 'http://mpic.tiankong.com/2a6/5a9/2a65a986200592edfab6c19809479984/640.jpg', // TODO
            'content' => $item->content,
        ];
        return $info;
    }
}