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

        # 群成员分布
        $d = ['a', 'b', 'c', 'd'];
        $plots = [];
        foreach($d as $k => $v){
            $name = 'district_' . $v;
            $value = 'ratio_' . $v;
            $plots[] = [
                'name' => $item->$name,
                'data' => $item->$value * 100
            ];
        }
        $info['plots'] = $plots;
        return $info;
    }
}