<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticsVisitor extends Model
{
    //Relation to AnalyticsPage
    public function vPages()
    {

        return $this->hasMany('App\Models\AnalyticsPage',"visitor_id");
    }
}
