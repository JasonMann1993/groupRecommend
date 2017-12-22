<?php

use Illuminate\Database\Seeder;
use App\Models\Role;


class RoleSeeder extends Seeder
{
    public $roles = [
        ['name' => 'developer', 'display_name' => '开发者'],
//        ['name' => 'admin', 'display_name' => '管理员'],
//        ['name' => 'shop', 'display_name' => '商家'],
//        ['name' => 'partner', 'display_name' => '合伙人'],

    ];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = collect($this->roles);
        $roles->each(function ($item) {
            if(!Role::where('name', $item['name'])->first()) {
                $ins = new Role();
                foreach ($item as $field => $value) {
                    $ins->$field = $value;
                }
                $ins->save();
            }
        });
        //
    }
}

