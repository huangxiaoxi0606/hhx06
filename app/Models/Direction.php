<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    protected $appends = [
        'this_year',
    ];

    public function getThisYearAttribute()
    {
        $l = DirectionLog::whereDirectionId($this->id)->where('created_at', '>', '2020-01-01');
        return $l->whereStatus(0)->sum('money') - $l->whereStatus(1)->sum('money');
    }
}
