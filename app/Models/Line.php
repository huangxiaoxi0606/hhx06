<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Line extends Model
{
//    public static function boot()
//    {
//        parent::boot();
//        static::saved(function ($model) {
//            if ($model->status == '4') {
//                TravelBill::where('hhx_travel_id', $model->id)->update(['status' => 1]);
//                TravelEquip::where('hhx_travel_id', $model->id)->update(['status' => 4]);
//            }
//        });
//    }

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = Crypt::encryptString($value);
    }

    public function getContentAttribute($value)
    {
        return Crypt::decryptString($value);
    }

}
