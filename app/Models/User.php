<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    //
    use HasRoles;
    use SoftDeletes;

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = encrypt($password);
    }

}
