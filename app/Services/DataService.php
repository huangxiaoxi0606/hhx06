<?php
/**
 * Created by PhpStorm.
 * User: Hhx06
 * Date: 2020/4/30
 * Time: 9:53
 */

namespace App\Services;


class DataService
{

    public function curl($ip, $port, $password, $requestUrl)
    {
        $ch = curl_init();
        $timeout = 30;
        curl_setopt($ch, CURLOPT_URL, $requestUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC); //代理认证模式
        curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:1080'); //代理服务器地址
        curl_setopt($ch, CURLOPT_PROXYPORT, $port); //代理服务器端口
        curl_setopt($ch, CURLOPT_PROXYPASSWORD, $password); //代理服务器端口
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); //使用http代理模式
        $file_contents = curl_exec($ch);
        curl_close($ch);
        dd($file_contents);
        return $file_contents;
    }




}
