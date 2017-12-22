<?php

namespace App\Models;

class Role extends \Spatie\Permission\Models\Role
{

    public function menus()
    {
        return $this->morphedByMany(
            Menu::class,
            'model',
            config('permission.table_names.model_has_roles'),
            'role_id',
            'model_id'
        );
    }
    public function role($status){
        if($status==3){
            $role_list=Role::get();
        }else if($status==1){
            $role_list=Role::where([['name','!=','developer']])->get();
        }else if($status==2){
            $role_list=Role::where([['name','=','waiter']])->get();
        }else{
            $role_list=[];
        }
         return $role_list;
    }
}