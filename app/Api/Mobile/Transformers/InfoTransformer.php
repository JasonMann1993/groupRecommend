<?php

namespace App\Api\Mobile\Transformers;

use App\Models\Group;
use League\Fractal\TransformerAbstract;

class InfoTransformer extends TransformerAbstract
{

    public function transform(Group $item)
    {
        $info = [
            'id' => $item->id,
            'name' => $item->name,
            'logo' => getImgAttribute($item->logo),
            'wx' => $item->wx,
            'qr_code' => getImgAttribute($item->qr_code),
        ];
        if($item->businesses){
            foreach ($item->businesses as $v){
                $info['business'][] = [
                    'logo' => getImgAttribute($v->logo)
                ];
            }
        }
        return $info;
    }
}