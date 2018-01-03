<?php

namespace App\Models;


use Illuminate\Http\Request;

trait Common
{

    /**
     * 获取 最近的群列表
     * @param $lng
     * @param $lat
     * @param array $where
     * @return bool
     */
    public function getNearLists($lng, $lat, $where = [] ,$distance = 3000)
    {
        $offsets = get_lng_and_lat_deviation($lng, $lat, $distance);

        if(\App::environment('local','staging')){
            $res = $this
                ->where($where)
                ->get();
        }else{
            $res = $this
                ->whereBetween('longitude', $offsets['lng'])
                ->whereBetween('latitude', $offsets['lat'])
                ->where($where)
                ->get();
        }

        if (!$res->count())
            return collect();
        $res->map(function ($item) use ($lng, $lat) {
            $tmpNum = get_lng_and_lat_distance($item->latitude, $item->longitude, $lat, $lng);
            $item->distanceNum = $tmpNum;
            $item->distance = get_distance_text($tmpNum);
        });
        return $res->sortBy('distanceNum');
    }

    public function getDistanceAttribute($val)
    {
        if(is_null($val)){
            $longitude = app(Request::class)->get('longitude');
            $latitude = app(Request::class)->get('latitude');
            if($longitude && $latitude){
                $val = get_distance_text(get_lng_and_lat_distance($latitude, $longitude, $this->longitude, $this->latitude));
            }
        }
        return $val;
    }

}
