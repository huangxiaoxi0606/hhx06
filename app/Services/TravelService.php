<?php
/**
 * Created by Hhx06.
 * User: Hhx06
 * Date: 2020/2/18
 * Time: 14:47
 * Desc: travel相关
 */

namespace App\Services;


use App\Models\DirectionLog;
use App\Models\HhxEquip;
use App\Models\HhxTravel;


class TravelService
{
    public function getThereTravel()
    {
        $arr = HhxTravel::where('status', '<', 4)->orderBy('id', 'desc')->limit(3)->pluck('name', 'id');
        $arr[0] = 0;
        return $arr;
    }

    public function getNameByTravelId($travel_id)
    {
        return HhxTravel::whereId($travel_id)->value('name');
    }

    public function saveToDirectionLog($data, $status = 0)
    {
        $directionLog = app('daily')->getDirectionLog($data->direction_id, $data->daily_id);
        if (!$directionLog) {
            $directionLog = new DirectionLog();
        }
        $directionLog->direction_id = $data->direction_id;
        $directionLog->daily_id = $data->daily_id;
        $directionLog->status = $status;
        $directionLog->ok = $data->ok;
        $directionLog->illustration = $data->illustration;
        $directionLog->week_day = app('daily')->getTodayWeek();
        $directionLog->note = $status == 1 ? "已删除" : "无";
        $directionLog->money = $data->money;
        $directionLog->travel_id = $data->hhx_travel_id;
        $directionLog->save();
    }

    public function updateEquip($travel_id)
    {
        return HhxEquip::where('hhx_travel_id', $travel_id)->update(['status' => 4]);
    }

    public function getTravelBillById($id)
    {

        $bill = DirectionLog::where('travel_id', $id)->get()->map(function ($item) {
            $item = $item->only(['illustration', 'status', 'money']);
            $item['status'] = $item['status'] == 0 ? '减少' : '增加';
            return $item;
        });
        return $bill->all();
    }


}
