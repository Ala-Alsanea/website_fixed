<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebmasterSectionField extends Model
{
    public function fields()
    {

        return $this->hasMany('App\Models\TopicField' , 'field_id')->orderby('id', 'asc');
    }
}
