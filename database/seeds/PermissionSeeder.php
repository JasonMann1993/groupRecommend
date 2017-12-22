<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;


class PermissionSeeder extends Seeder
{
    public $permissions = [




    ];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = collect($this->permissions);
        $permissions->each(function ($item) {
            if(!Permission::where('name', $item['name'])->first()) {
                $ins = new Permission();
                foreach ($item as $field => $value) {
                    $ins->$field = $value;
                }
                $ins->save();
            }
        });
        //
    }
}
