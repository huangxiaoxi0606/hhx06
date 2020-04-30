<?php
/**
 * Created by Hhx06.
 * User: Hhx06
 * Date: 2020/2/17
 * Time: 10:42
 */

namespace App\Handlers;


use Carbon\Carbon;

class FlightHandler
{

    public static function getData()
    {
        $now  = Carbon::now();
        $start = $now->toDateString();
        $end = $now->addDays(30)->toDateString();
        $code = "CGO";
        $url = "https://r.fliggy.com/rule/domestic?startDate=".$start."&endDate=".$end."&routes=".$code."-&_ksTS=0&callback=jsonp&ruleId=99&flag=1";
        $data_us = app('information')->curl_get($url);
        $data = json_decode(substr($data_us,6,-1),true)["data"]["flights"];
        app('information')->saveToFlight($data);
    }





}
