<?php

namespace App\Api\TransFormers\Manage\Home;

use App\Api\TransFormers\Manage\BaseTransformer;
use App\Models\Menu;

class
MenuTransformer extends BaseTransformer
{
    public function trans(Menu $menu)
    {
        return [
            'id'     => $menu->id,
            'name'   => $menu->name,
            'url'    => $menu->url,
            'icon'   => $menu->icon,
            'sort'   => $menu->sort,
            'status' => [
                'bool'  => true,
                'value' => boolval($menu->status),
                'text'  => $menu->statusText
            ]
        ];
    }


}