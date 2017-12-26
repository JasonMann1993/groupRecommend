<?php

namespace App\Api\Mobile\Transformers;

use App\Models\Group;
use League\Fractal\TransformerAbstract;

class IndexTransformer extends TransformerAbstract
{

    public function transform(Group $item)
    {
        $info = [
            'id' => $item->id,
            'name' => $item->name,
            'desc' => $item->desc,
            'logo' => getImgAttribute($item->logo),
            'distance' => $item->distance,
        ];
        return $info;
    }
}