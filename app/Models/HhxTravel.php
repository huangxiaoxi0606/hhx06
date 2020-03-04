<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HhxTravel extends Model
{
    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            if($model->status == '4'){
                app('travel')->updateEquip($model->id);
            }

        });
    }
}
