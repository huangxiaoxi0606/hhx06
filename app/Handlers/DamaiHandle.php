<?php
/**
 * Created by Hhx06.
 * User: Hhx06
 * Date: 2020/2/16
 * Time: 12:32
 * Desc: 获取大麦数据
 */

namespace App\Handlers;


use Illuminate\Support\Facades\Log;

class DamaiHandle
{
    public static $Common_Url = "https://search.damai.cn/searchajax.html?keyword=";
    public static $Midd_Common = "&currPage=1&pageSize=";
    public static $Default_PageSize = 30;

    /**
     * 获取html
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
     * 获取总个数
     * @param $url
     * @return int
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getDataCount($url)
    {
        if (self::getHtml($url)) {
            return self::getHtml($url)["pageData"]["maxTotalResults"];
        }
        return 0;
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
            return self::getHtml($url)["pageData"]["resultData"];
        }
    }

    /**
     * 获取数据请求
     * @param string $name
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getUrl($name = "田馥甄")
    {
        $url = self::$Common_Url . $name . self::$Midd_Common . self::$Default_PageSize;
        $count = self::getDataCount($url);
        if ($count == 0) {
            return '';
        }
        $url_data = self::$Common_Url . $name . self::$Midd_Common . $count;
        return self::getDataAll($url_data);
    }


    /**
     * 保存数据库
     * @param $datas
     */
    public static function saveMysql($data)
    {
        app('information')->saveToDamai($data);
    }

    /**
     * 定时任务
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function carbonGet()
    {

        $names = ["田馥甄", "戴佩妮", "杨千嬅", "吴青峰"];
        foreach ($names as $name) {
            $datas = self::getUrl($name);
            if ($datas) {
                foreach ($datas as $data) {
                    $data['actors'] = $name;
                    self::saveMysql($data);
                    unset($data);
                }
                unset($datas);
            }
        }
        unset($names);
        Log::info(date('Y-m-d') . 'damai its ok');
    }
}
