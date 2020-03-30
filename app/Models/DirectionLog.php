<?php

namespace App\Models;

use App\Services\DailyService;
use App\Services\ServiceManager;
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
            self::getDailyService()->afterSaveDirectionLog($model);
            unset($model['travel_id']);
        });
    }

    static protected function getDailyService(): DailyService
    {
        return ServiceManager::getInstance()->dailyService(
            DailyService::class
        );
    }
}
