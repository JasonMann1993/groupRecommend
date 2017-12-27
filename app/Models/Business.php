<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    //
    use SoftDeletes;
    protected $guarded = [];
    public function groups()
    {
        return $this->belongsToMany(Group::class,'business_groups','business_id','group_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
