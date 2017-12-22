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
            ['name' => '用户管理', 'icon' => 'fa-user', 'url' => '/user'],
            ['name' => 'Banner管理', 'url' => '/home/banner', 'icon' => 'fa-picture-o'],
        ];
        Menu::truncate();
        $this->cleanRoleMenus();
        $this->saveMenus($menus);
//        $this->giveDeveloperRoleAllMenu();

    }

    protected function cleanRoleMenus()
    {
        foreach (Role::all() as $role)
            $role->menus()->sync([]);
    }

    /**
     * @param $menus
     */
    protected function saveMenus($menus, $parentId = 0)
    {
        foreach ($menus as $key => $item) {
            $menuIns = new Menu();
            foreach ($item as $field => $value) {
                if($field != 'child' && $field != 'role')
                    $menuIns->$field = $value;
            }
            $menuIns->parent_id = $parentId;
            $menuIns->save();
            if($role = array_get($item, 'role'))
                $this->addRole($menuIns, $role);
            else
                $this->addRole($menuIns, 'developer');

            if(isset($item['child']) && !empty($item['child']))
                $this->saveMenus($item['child'], $menuIns->id);
        }
    }

    protected function giveDeveloperRoleAllMenu()
    {
        # add Developer
        $developer = Role::where('name', 'developer')->first();
        if($developer) {
            $developer->menus()->sync(Menu::all()->pluck('id'));
        }
    }

    protected function addRole(Menu $menu, $role)
    {
        $role = Role::findByName($role);
        $role->menus()->attach($menu->id);
    }

}

