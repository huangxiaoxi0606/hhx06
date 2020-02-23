<?php
/**
 * Created by Hhx06.
 * User: Hhx06
 * Date: 2020/2/16
 * Time: 16:40
 */

namespace App\Handlers;

use App\Models\Ctrip;
use Illuminate\Support\Facades\Log;

class CtripHandler
{
    /**
     * 获取html
     * @param $url
     * @param $data
     * @param $c
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getHtml($url, $data)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', $url, ['form_params' => $data]);
        if ($res->getStatusCode() == '200') {
            return json_decode($res->getBody(), true);
        }
        return false;
    }

    /**
     * 获取页面数据
     * @param $url
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getDataAll($url, $data)
    {
        if (self::getHtml($url, $data)) {
            return self::getHtml($url, $data)["data"]["oneWayPrice"][0];
        }
    }

    public static function mysqlRequest()
    {
        $all = Ctrip::where('status', 1)->get();
        $url = 'https://flights.ctrip.com/itinerary/api/12808/lowestPrice';
        foreach ($all as $value) {
            $data = [
                'flightWay' => "Oneway",
                'dcity' => $value->depAirportCode,
                'acity' => $value->arrAirportCode,
                'army' => "false"
            ];
            $datas = self::getDataAll($url, $data);
            app('information')->saveToCtrip($datas,$value);
        }
    }

    /**
     * 主入口
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    //php artisan command:ctrip
    public static function getData()
    {
        self::mysqlRequest();
        Log::info(date('Y-m-d') . 'ctrip its ok');
    }

}
