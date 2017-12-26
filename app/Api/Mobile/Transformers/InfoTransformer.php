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
            'desc' => $item->desc,
            'logo' => getImgAttribute($item->logo),
            'wx' => $item->wx,
            'wxname' => $item->master,
            'qr_code' => getImgAttribute($item->qr_code),
        ];
        ## 入驻商户
        $info['business'] = [];
        if($item->businesses){
            foreach ($item->businesses as $v){
                $info['business'][] = [
                    'logo' => getImgAttribute($v->logo)
                ];
            }
        }
        ## 群组成员
        $info['members'] = [];
        if($item->members){
            foreach ($item->members as $v) {
                $info['members'][] = [
                    'nickname' => $v->name
                ];
            }
        }
        $info['memberNum'] = $item->members->count();
        return $info;
    }
}