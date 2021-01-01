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
        $data = Daily::query()->limit(10)->orderBy('id', 'desc')->pluck('date', 'id')
            ->map(function ($item, $key) {
                return $item;
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
        $value = Daily::whereId($key)->value('date');
        return $value ? $value : $value;
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
        $weekIds = Daily::where('date','>=',date("Y-m-d", strtotime("this week")))->pluck('id');
        $mouthIds = Daily::where('date','>=',date('Y-m-01', strtotime(date("Y-m-d"))))->pluck('id');
        $week = DirectionLog::whereIn('daily_id',$weekIds)->get();
        $mouth = DirectionLog::whereIn('daily_id',$mouthIds)->get();
        $data['week'] = $week->sum('money')-2*($week->where('status',1)->sum('money'));
        $data['mouth'] = $mouth->sum('money')-2*($mouth->where('status',1)->sum('money'));
        return $data;
    }

    public  function getSurplus()
    {
        $mouthIds = Daily::where('date','>=',date('Y-m-01', strtotime(date("Y-m-d"))))->pluck('id');
//dd(date('Y-m-01', strtotime(date("Y-m-d"))));
        return Direction::query()->select('id', 'name', 'stock')->get()->map(function ($item)use($mouthIds){
            $all = DirectionLog::whereIn('daily_id',$mouthIds)->where('direction_id', $item->id)->get();
            $sub = $all->where('status',0)->sum('money');
            $add = $all->where('status',1)->sum('money');
            $used = $sub-$add;
            $item->used = $used-(config('hhx.stock')[$item->id])>0?'<p style="color:red">'.$used.'</p>':$used;
            $surplus = $item->stock - $used;
            $item->surplus = $surplus<0?'<p style="color:yellowgreen">'.$surplus.'</p>':$surplus;
            $item->stovk = config('hhx.stock')[$item->id];
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
                $start = '2021-01-01';
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
            $item->stock = $item->stock - $used + config('hhx.stock')[$item->id];
            $item->save();
        });
        Log::channel('stock')->debug(date('Y-m-d') . 'stock its ok');
    }

}
