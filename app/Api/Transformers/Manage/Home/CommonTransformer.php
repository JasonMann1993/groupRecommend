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

    public function transArgu(Yingxiaosets $item)
    {
        return [
            'reward_make_for_partner' => $item->manufacture_partner_money,
            'reward_make_for_re_shop' => $item->manufacture_money,
            'reward_make_for_shop'    => $item->manufacture_shop_money,

            'reward_cut_use_for_shop' => $item->reward_cut_use_for_shop,

            'reward_use_for_partner' => $item->write_off_partner_money,
            'reward_use_for_re_shop' => $item->write_off_shop_recommend_money,
            'reward_use_for_shop'    => $item->shop_write_off_money,
            'reward_use_for_user'    => $item->member_recommend_money,
            'reward_use_for_re_user' => $item->write_off_member_recommend_money,

            'cut_make_for_shop' => $item->voucher_system_money,
        ];
    }

    public function transShopMenus($menu)
    {
        return [
            'name'      => $menu->name,
            'show_name' => $menu->show_name,
            'url'       => $menu->url,
            'icon'      => $menu->icon,
            'childs'    => $menu->childs ? $this->collection($menu->childs, $this) : []
        ];
    }

}