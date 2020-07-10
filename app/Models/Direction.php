<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Direction extends Model
{
    protected $appends = [
        'this_year',
    ];

    public function getThisYearAttribute()
    {
        $l = DirectionLog::whereDirectionId($this->id)->where('created_at', '>', '2020-01-01')->get();
        return $l->where('status',0)->sum('money') - $l->where('status',1)->sum('money');
    }
}
