<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    //
    use SoftDeletes;
    public $typeText = [
        1 => '用户',
        2 => '商家',
    ];

    public function businesses()
    {
        return $this->hasMany(Business::class);
    }

    public function destroyBusiness()
    {
        $businesses = $this->businesses;
        if(count($businesses)>0){
            foreach($businesses as $business){
                $business->groups()->sync([]);
                $business->delete();
            }
        }
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class,'member_groups','member_id','group_id');
    }
}
