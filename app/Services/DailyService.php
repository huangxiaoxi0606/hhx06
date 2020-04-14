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
        if ($model->travel_id != 0) {
            HhxTravel::where('id', $model->travel_id)->increment('money', $now_money);
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

    public function getSummaryData()
    {
        $data['week'] = DirectionLog::whereBetween('created_at', [date("Y-m-d", strtotime("this week")), Carbon::now()])->sum('money');
        $data['mouth'] = DirectionLog::whereBetween('created_at', [date('Y-m-01', strtotime(date("Y-m-d"))), Carbon::now()])->sum('money');
        return $data;
    }

    public  function getSurplus()
    {
        $mouth_again = date('Y-m-01', strtotime(date("Y-m-d")));
        $now = Carbon::now();
        return Direction::query()->select('id', 'name', 'stock')->get()->map(function ($item)use($mouth_again, $now){
            $used = DirectionLog::whereBetween('created_at', [$mouth_again, $now])->where('direction_id', $item->id)->sum('money');
            $item->used = $used;
            $item->surplus = $item->stock - $used;
            return $item->toArray();
        })->all();

    }

    public function getData($type = 1)
    {
        $now = time();
        switch ($type) {
            case 1:
                $start = date("Y-m-d", strtotime("this week"));
                break;
            case 2:
                $start = date('Y-m-01', strtotime(date("Y-m-d")));
                break;
            case 3:
                $start = date('Y-m-d', mktime(0, 0, 0, 1, 1, date('Y', $now)));
                break;
            default:
                $start = '2019-01-01';
        }

        $directions = Direction::query()->select('name', 'id')->get();
        foreach ($directions as $direction) {
            $data[$direction->name] = DirectionLog::whereBetween('created_at', [$start, Carbon::now()])->where('direction_id', $direction->id)->sum('money');
        }
        return $data;
    }

    public function getHhx(){
        return 'hhx-06';
    }

    public function updateStock()
    {
        $last_month = strtotime("-1 month");
        $last_month_first = date("Y-m-01 00:00:00", $last_month);//上个月第一天`
        $now = Carbon::now();
        $direction_logs = DirectionLog::whereBetween('created_at', [$last_month_first, $now])->get();
        Direction::query()->get()->map(function ($item, $key) use ($direction_logs) {
            $used = $direction_logs->where('direction_id', $item->id)->sum('money');
            $item->stock = $item->stock - $used + config($item->name);
            $item->save();
        });
        Log::info(date('Y-m-d') . 'stock its ok');
    }

}
