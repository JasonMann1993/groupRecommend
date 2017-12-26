<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    //
    use SoftDeletes,Common;
    protected $guarded = [];
    public function businesses()
    {
        return $this->belongsToMany(Business::class,'business_groups','group_id','business_id');
    }

}
