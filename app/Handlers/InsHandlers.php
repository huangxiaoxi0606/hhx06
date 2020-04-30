<?php
/**
 * Created by PhpStorm.
 * User: Hhx06
 * Date: 2020/4/29
 * Time: 10:30
 */

namespace App\Handlers;


class InsHandlers
{
    public static function getHtml($url)
    {
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $da = [
            'headers' => [
                'accept-encoding' => 'gzip, deflate, br',
                'accept-language' => 'zh-CN,zh;q=0.9',
                'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.122 Safari/537.36',
            ],
            'proxy' => [
                'http' => 'http://127.0.0.1:1080', // Use this proxy with "http"
                'https' => 'http://127.0.0.1:1080', // Use this proxy with "https",
            ]
        ];
        $res = $client->request('GET', $url, $da);
        if ($res->getStatusCode() == '200') {
            return json_decode($res->getBody(), true);
        }
        return false;
    }

    public static function getData()
    {
        $query_hash = '9dcf6e1a98bc7f6e92953d5a61027b98';
//        $id = '1264029702';
//        $after = 'QVFEYl9iMk1aOW1vN0VTLTZtRE0yVDd2ZElfdXpsOTQ3ekpZdkVRSUY3eXhmMzBDSXhITWdsWDBYbFVRbERKdjU5a3B4ekpody1lWEh2aEpUcHJkOWJncg==';
//        $data = [
//            "id" => $id,
//            "first" => 12,
//            "after" => $after
//        ];
        $id = '8159219726';
        $after = 'QVFBc0F3cW84SExLVE9raE1vNVVjajhPTTlLczFFYTFCTFVXRkFNT3VWSWJhbm1WLUxNZmFzdjVaWWhxRU4tYlg1NzI5VXE4Ul9MWTFrMFpJLVV6UmMwWQ==';
        $data = [
            "id" => $id,
            "first" => 12,
            "after" => $after
        ];

        $variables = urlencode(json_encode($data));
        $url = 'https://www.instagram.com/graphql/query/?query_hash=' . $query_hash . '&variables=' . $variables;
        $data = self::getHtml($url);
        dd($data);
    }
}
