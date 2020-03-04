<?php
/**
 * Created by Hhx06.
 * User: Hhx06
 * Date: 2020/2/16
 * Time: 12:35
 * Desc: information相关
 */

namespace App\Services;

use App\Models\Damai;
use App\Models\Flight;
use App\Models\Yongle;

class InformationService
{
    public function saveToDamai($data)
    {
        $damai = $this->searchDamai($data);
        $damai = !$damai ? new Damai() : $damai;
        $damai->actors = $data['actors'];
        $damai->cityname = $data['cityname'];
        $damai->nameNoHtml = $data['nameNoHtml'];
        $damai->price_str = $data['price_str'];
        $damai->showtime = $data['showtime'];
        $damai->venue = $data['venue'];
        $damai->showstatus = $data['showstatus'];
        $damai->save();
    }

    public function searchDamai($data)
    {
        $where = [
            'actors' => $data['actors'],
            'cityname' => $data['cityname'],
            'venue' => $data['venue']
        ];
        return Damai::where($where)->first();
    }

    public function saveToYongle($datas)
    {
        foreach ($datas as $data) {
            $yongle = $this->searchYongle($data);
            $yongle = !$yongle ? new Yongle() : $yongle;
            $yongle->vname = $data["vname"];
            $yongle->yname = $data["name"];
            $yongle->status = $data["status"];
            $yongle->performer = $data["performer"];
            $yongle->prices = $data["prices"];
            $yongle->cityname = $data["cityname"];
            $yongle->enddate = $data["enddate"];
            $yongle->save();
        }
    }

    public function searchYongle($data)
    {
        $where = [
            'yname' => $data["name"],
        ];
        return Yongle::where($where)->first();
    }

    public function saveToCtrip($datas, $ctrip)
    {
        $ctrip->minDate = array_search(min($datas), $datas);
        $ctrip->minPrice = min($datas);
        $ctrip->save();
    }

    public function curl_get($url)
    {

        $header = array(
            'Accept: application/json',
        );
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        // 超时设置,以秒为单位
        curl_setopt($curl, CURLOPT_TIMEOUT, 1);

        // 超时设置，以毫秒为单位
        // curl_setopt($curl, CURLOPT_TIMEOUT_MS, 500);

        // 设置请求头
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        //执行命令
        $data = curl_exec($curl);
        // 显示错误信息
        if (curl_error($curl)) {
            print "Error: " . curl_error($curl);
        } else {
            // 打印返回的内容
            curl_close($curl);
        }
        return $data;
    }

    public function saveToFlight($data)
    {
        foreach ($data as $item) {
            $flight = $this->searchFlight($item);
            $flight = $flight ? $flight : new Flight();
            $flight->depCode = $item['depCode'];
            $flight->priceDesc = $item['priceDesc'];
            $flight->depDate = $item['depDate'];
            $flight->depName = $item['depName'];
            $flight->arrName = $item['arrName'];
            $flight->discount = $item['discount'];
            $flight->arrCode = $item['arrCode'];
            $flight->price = $item['price'];
            $flight->save();
        }
    }

    public function searchFlight($data)
    {
        $where = [
            'arrCode' => $data["arrCode"],
            'depDate' => $data['depDate'],
            'depCode' => $data['depCode'],
        ];
        return Flight::where($where)->first();
    }

}
