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
        $user = auth()->user();
        $role = $user->getRoleNames();
        if(!$role->count())
            return $this->response->errorInternal();
        $menus = Menu::role($role)->where('status', 1)->latest('sort')->get();

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

        return [
            'file' => str_replace(config('filesystems.disks.oss.prefix') . '/', '', $file),
            'url'  => get_upload_url($file)
        ];
    }

    /**
     * 获取全局参数
     *
     * @param CommonRequest $request
     *
     * @return \Dingo\Api\Http\Response|void
     */
    public function getArgu(CommonRequest $request)
    {
        $info = Yingxiaosets::first();
        if(!$info) { # 新增一条
            $ins = new Yingxiaosets();
            try {
                $ins->save();
                $info = $ins;
            } catch (\Exception $exception) {
                return $this->response->errorInternal();
            }
        }

        return $this->response->item($info, new CommonTransformer('argu'));
    }

    /**
     * @param CommonRequest $request
     *
     * @return \Dingo\Api\Http\Response|void
     */
    public function setArgu(CommonRequest $request)
    {
        $ins = Yingxiaosets::first();
        # 制券奖励
        $ins->manufacture_partner_money = $request->get('reward_make_for_partner');
        $ins->manufacture_money = $request->get('reward_make_for_re_shop');
        $ins->manufacture_shop_money = $request->get('reward_make_for_shop');
        # 核销扣款
        $ins->reward_cut_use_for_shop = $request->get('reward_cut_use_for_shop');
        # 核销奖励
        $ins->write_off_partner_money = $request->get('reward_use_for_partner');
        $ins->write_off_shop_recommend_money = $request->get('reward_use_for_re_shop');
        $ins->shop_write_off_money = $request->get('reward_use_for_shop');
        $ins->member_recommend_money = $request->get('reward_use_for_user');
        $ins->write_off_member_recommend_money = $request->get('reward_use_for_re_user');
        # 制券扣款
        $ins->voucher_system_money = $request->get('cut_make_for_shop');
        try {
            $ins->save();
        } catch (\Exception $exception) {
            return $this->response->errorInternal();
        }

        return $this->response->noContent();
    }

    public function shopMenus()
    {
        $menus = config('menus.shop');

        return ['data' => $menus];
    }

    public function mapKey()
    {
        return ['data' => env('TX_MAP_KEY')];
    }
}
