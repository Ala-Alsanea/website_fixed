<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    //
    public function users()
    {

        return $this->hasMany('App\Models\User', 'permissions_id');
    }
}
