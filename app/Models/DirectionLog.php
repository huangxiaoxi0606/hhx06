<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DirectionLog extends Model
{
    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            app('daily')->afterSaveDirectionLog($model);
            unset($model['travel_id']);
        });
    }
}
