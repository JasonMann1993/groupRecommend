<?php

namespace App\Api\Controllers\Manage\Home;

use App\Api\Controllers\Manage\BaseController;
use App\Api\Requests\Manage\Home\CommonRequest;
use App\Api\TransFormers\Manage\Home\CommonTransformer;
use App\Models\Menu;
use App\Models\Yingxiaosets;

class CommonController extends BaseController
{

    public function menus()
    {
        $menus = Menu::where('status', 1)->latest('sort')->get();

        $menus = $this->convertMenus($menus);

        return $this->response->collection($menus, new CommonTransformer('menus'));
    }

    protected function convertMenus($menus)
    {

        $newMenus = $menus->where('parent_id', 0);
        $newMenus->each(function ($item) use ($menus) {
            $item->childs = $menus->where('parent_id', $item->id);
        });

        return $newMenus;
    }


    public function upload(CommonRequest $request)
    {
        $storage = \Storage::disk('oss');
        try {
            $file = $storage->putFile(config('filesystems.disks.oss.prefix'), $request->file('file'));
        } catch (\Exception $exception) {
            return $this->response->errorInternal();
        }
        $file = str_replace(config('filesystems.disks.oss.prefix') . '/', '', $file);
        return [
            'file' => $file,
            'url'  => get_upload_url($file)
        ];
    }

    public function mapKey()
    {
        return ['data' => env('TX_MAP_KEY')];
    }
}
