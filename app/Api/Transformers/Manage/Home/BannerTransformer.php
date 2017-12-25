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
            'show'       => boolval($banner->show),
            'created_at' => $banner->created_at . '',
        ];
    }

    public function transInfo(Banner $banner)
    {
        return [
            'id'            => $banner->id,
            'name'          => $banner->name,
            'content'       => $banner->content,
            'order'       => $banner->order,
            'picture'       => $banner->picture,
            'picture_url'   => get_upload_url($banner->picture),
            'show'          => boolval($banner->show),
        ];
    }


}