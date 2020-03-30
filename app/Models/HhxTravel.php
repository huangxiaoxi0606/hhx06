<?php

namespace App\Models;

use App\Services\ServiceManager;
use App\Services\TravelService;
use Illuminate\Database\Eloquent\Model;

class HhxTravel extends Model
{
    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            if($model->status == '4'){
                self::getTravelService()->updateEquip($model->id);
            }

        });
    }

    static protected function getTravelService(): TravelService
    {
        return ServiceManager::getInstance()->travelService(
            TravelService::class
        );
    }
}
