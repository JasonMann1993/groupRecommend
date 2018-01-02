<?php

namespace App\Api\Mobile\Transformers;

use App\Models\Group;
use App\Models\MemberPlotGroup;
use function foo\func;
use League\Fractal\TransformerAbstract;

class InfoTransformer extends TransformerAbstract
{

    public function transform(Group $item)
    {
        $lng = request()->get('longitude');
        $lat = request()->get('latitude');
        $info = [
            'id' => $item->id,
            'name' => $item->name,
            'desc' => $item->desc,
            'logo' => getImgAttribute($item->logo),
            //'wx' => $item->wx, # 群主微信
            //'wxname' => $item->master, # 群主昵称
            //'qr_code' => getImgAttribute($item->qr_code), # 群二维码
        ];

        ## 入驻商户
        $info['business'] = [];
        if($item->businesses){
            $businesses = $item->businesses;
            $businesses->map(function ($v) use ($lat, $lng) {
                $tmpNum = get_lng_and_lat_distance($v->latitude, $v->longitude, $lat, $lng);
                $v->distanceNum = $tmpNum;
                $v->distance = get_distance_text($tmpNum);
            });
            $business = $businesses->sortBy('distanceNum');
            foreach ($business as $v){
                $info['business'][] = [
                    'logo' => getImgAttribute($v->logo),
                    'distance' => $v->distance
                ];
            }
        }

        # 群成员分布
        $d = ['a', 'b', 'c', 'd'];
        $plots = [];
        foreach($d as $k => $v){
            $name = 'district_' . $v;
            //$value = 'ratio_' . $v;
            $lngflag = 'longitude_' . $v;
            $latflag = 'latitude_' . $v;
            $plots[] = [
                'name' => $item->$name . ' (' . (($v == 'd') ? (rand(20,30)/10) . 'km' : get_distance_text(get_lng_and_lat_distance($item->$latflag, $item->$lngflag, $lat, $lng))) . ')',
                //'data' => $item->$value * 100, # 群各小区人数分布
                'data' => floatval(app(MemberPlotGroup::class)->plotDistribute($item->id, $v)), # 群各小区人数分布
                //'distance' => ($v == 'd') ? (rand(20,30)/10) . 'km' : get_distance_text(get_lng_and_lat_distance($item->$latflag, $item->$lngflag, $lat, $lng))
            ];
        }
        $info['plots'] = $plots;

        ## 群成员列表
        $info['members'] = [];
        if($item->members){
            $members = $item->members;
            $members->map(function ($v) use ($lng, $lat) {
                $tmpNum = get_lng_and_lat_distance($v->latitude, $v->longitude, $lat, $lng);
                $v->distanceNum = $tmpNum;
                $v->distance = $v->distance($tmpNum);
            });
            $m = $members->sortBy('distanceNum');
            foreach ($m as $v) {
                $info['members'][] = [
                    'nickname' => $v->name,
                    'avatar' => $v->avatar,
                    'gender' => $v->gender, # 性别 1:男,2:女
                    'created_at' => $v->formatTime($v->created_at),
                    'distance' => $v->distance
                ];
            }
        }
        $info['memberNum'] = $item->members->count();

        return $info;
    }
}