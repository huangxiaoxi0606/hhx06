<?php
/**
 * Created by Hhx06.
 * User: Hhx06
 * Date: 2020/2/16
 * Time: 13:00
 */

namespace App\Handlers;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class YongleHandle
{
    public static $URL_PRE = "https://www.228.com.cn/s/";
    public static $URL_END = "/?j=1&p=1";

    /**
     * @param $url
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getHtml($url)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $url);
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
    public static function getDataAll($url)
    {
        if (self::getHtml($url)) {
            return self::getHtml($url)["products"];
        }
    }

    /**
     * 发送数据请求
     * @param string $name
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function sendUrl($name = "田馥甄")
    {
        $url = self::$URL_PRE . $name . self::$URL_END;
        return self::getDataAll($url);
    }

    /**
     * 保存到redis
     * @param $datas
     * @param $name
     */
    public static function saveRedis($data, $name)
    {
        $redis = app('redis');
        $key = 'yl:' . $name . ':' . $data["cityname"];
        $data_u = array('vname' => $data["vname"],
            'yname' => $data["name"],
            'status' => $data["status"],
            'performer' => $data["performer"],
            'prices' => $data["prices"],
            'cityname' => $data["cityname"],
            'enddate' => $data["enddate"]
        );
        $redis->hmset($key, $data_u);
    }

    /**
     * 保存数据库
     * @param $datas
     */
    public static function saveMysql($datas)
    {
        app('information')->saveToYongle($datas);
    }


    /**
     * 获取数据
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getData()
    {
        $names = ['田馥甄', '吴青峰', '焦安溥', '戴佩妮', '林俊杰', '杨千嬅', '杨乃文'];
        foreach ($names as $name) {
            $data = self::sendUrl($name);
            if ($data) {
                foreach ($data as $da) {
                    self::saveRedis($da, $name);
                }
                self::saveMysql($data);
            }
        }
        Log::info(date('Y-m-d') . 'yongle its ok');

    }

}
