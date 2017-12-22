<?php

namespace App\Api\Controllers\Manage\Home;

use App\Api\Controllers\Manage\BaseController;
use App\Api\TransFormers\Manage\Home\MenuTransformer;
use App\Models\Menu;

class MenuController extends BaseController
{

    public function lists()
    {
        $menus = Menu::query()
            ->latest('sort')->get();
        return $this->response->collection($menus, new MenuTransformer());
    }

}
