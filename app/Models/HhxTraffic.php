<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HhxTraffic extends Model
{
    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            app('travel')->saveToDirectionLog($model, 0);
        });
        static::deleted(function ($model) {
            app('travel')->saveToDirectionLog($model, 1);
        });
    }
}
