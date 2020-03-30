<?php

namespace App\Models;

use App\Services\ServiceManager;
use App\Services\TravelService;
use Illuminate\Database\Eloquent\Model;

class HhxTraffic extends Model
{
    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            self::getTravelService()->saveToDirectionLog($model, 0);
        });
        static::deleted(function ($model) {
            self::getTravelService()->saveToDirectionLog($model, 1);
        });
    }

    static protected function getTravelService(): TravelService
    {
        return ServiceManager::getInstance()->travelService(
            TravelService::class
        );
    }
}
