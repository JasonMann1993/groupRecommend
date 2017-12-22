<?php

namespace App\Api\TransFormers\Manage\Home;

use App\Api\TransFormers\Manage\BaseTransformer;
use App\Models\Banner;

class BannerTransformer extends BaseTransformer
{
    public function trans(Banner $banner)
    {
        return [
            'id'         => $banner->id,
            'name'       => $banner->name,
            'picture'    => get_upload_url(array_get($banner->getAttributes(), 'picture')),
            'show'       => boolval($banner->is_show),
            'created_at' => $banner->created_at . '',
        ];
    }

    public function transInfo(Banner $banner)
    {
        return [
            'id'            => $banner->id,
            'name'          => $banner->name,
            'picture'       => array_get($banner->getAttributes(), 'picture'),
            'picture_url'   => get_upload_url(array_get($banner->getAttributes(), 'picture')),
            'show'          => boolval($banner->is_show),
            'coupon_id'     => $banner->coupon_id,
            'carousel_time' => $banner->carousel_time,
        ];
    }


}