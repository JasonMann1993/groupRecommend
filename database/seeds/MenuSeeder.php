<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Role;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * @Tips
         * 按照下面格式写
         *
         */
        $menus = [
            ['name' => '首页', 'url' => '/', 'icon' => 'fa-home'],
            ['name' => 'Banner管理', 'url' => '/home/banner', 'icon' => 'fa-picture-o'],
            ['name' => '用户管理','url' => '/user/member' ,'icon' => 'fa-user'],
            ['name' => '微信群管理','url' => '/user/group' ,'icon' => 'fa-users'],
            ['name' => '商家管理','url' => '/user/business' ,'icon' => 'fa-user-circle'],

        ];
        Menu::truncate();
        $this->saveMenus($menus);

    }
    /**
     * @param $menus
     */
    protected function saveMenus($menus, $parentId = 0)
    {
        foreach ($menus as $key => $item) {
            $menuIns = new Menu();
            foreach ($item as $field => $value) {
                    $menuIns->$field = $value;
            }
            $menuIns->parent_id = $parentId;
            $menuIns->save();
        }
    }

}

