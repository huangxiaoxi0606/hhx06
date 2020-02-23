<?php
/**
 * Created by Hhx06.
 * User: Hhx06
 * Date: 2020/2/6
 * Time: 16:28
 * Desc: daily相关
 */

namespace App\Services;

use App\Models\Daily;
use App\Models\Direction;
use App\Models\DirectionLog;
use App\Models\HhxTravel;
use App\Models\Interest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DailyService
{

    public function getInterestArray()
    {
        return Interest::query()->orderBy('order_num')->pluck('name', 'id');
    }

    public function getDirectionArray()
    {
        return Direction::query()->orderBy('order_num')->pluck('name', 'id');
    }

    public function getDailyArray()
    {
        $data = Daily::query()->limit(7)->orderBy('id', 'desc')->pluck('created_at', 'id')
            ->map(function ($item, $key) {
                return $item->toDateString();
            });
        return $data->all();
    }

    public function getTodayWeek()
    {
        return date("w", time());
    }

    public function afterSaveDirectionLog($model)
    {
        $now_money = $model->status == 0 ? $model->money : -$model->money;
        if ($model->id) {
            $old = DirectionLog::where('id', $model->id)->select('status', 'money')->first();
            $now_money = $old->status == 0 ? $now_money - $old->money : $now_money + $old->money;
        }
        Daily::whereId($model->daily_id)->increment('money', $now_money);
        Direction::whereId($model->direction_id)->increment('all_num', $now_money);
        if ($model->travel->id != 0) {
            HhxTravel::where('id', $model->travel->id)->increment('money', $now_money);
        }
    }

    public function getDirectionName($key)
    {
        return Direction::whereId($key)->value('name');
    }

    public function getDailyToDate($key)
    {
        $value = Daily::whereId($key)->value('created_at');
        return $value ? $value->toDateString() : $value;
    }

    public function getInterestName($key)
    {
        return Interest::whereId($key)->value('name');
    }

    public function getDirectionLog($direction_id, $daily_id)
    {
        $where = [
            'direction_id' => $direction_id,
            'daily_id' => $daily_id,
        ];
        return DirectionLog::where($where)->first();

    }

    public function getDirectionLogName($directionlog_id)
    {
        return DirectionLog::where('id', $directionlog_id)->value('name');
    }

}
