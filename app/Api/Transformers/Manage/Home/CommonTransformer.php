<?php

namespace App\Api\TransFormers\Manage\Home;

use App\Api\TransFormers\Manage\BaseTransformer;
use App\Models\Menu;
use App\Models\Yingxiaosets;

class CommonTransformer extends BaseTransformer
{
    public function transMenus(Menu $menu)
    {
        return [
            'id'     => $menu->id,
            'name'   => $menu->name,
            'url'    => $menu->url,
            'icon'   => $menu->icon,
            'childs' => $menu->childs ? $this->collection($menu->childs, $this) : []
        ];
    }
}