<?php
/**
 * Created by Hhx06.
 * User: Hhx06
 * Date: 2020/2/21
 * Time: 11:14
 */

namespace App\Handlers;


use App\Models\WeiboUser;
use Illuminate\Support\Facades\Log;

class WeiboHandler
{
    public static function getHtml($url)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $url);
        if ($res->getStatusCode() == '200') {
            return json_decode($res->getBody(), true);
        }
        return false;
    }


//    主程序
    public static function getData()
    {
        $weibo_users = WeiboUser::select('screen_name', 'weibo_id')->get();
        foreach ($weibo_users as $weibo_user) {
            $uid = $weibo_user->weibo_id;
            $luicode = '10000011';
            $all = '100103type= 1&q=' . $weibo_user->screen_name;
            $lfid = urlencode($all);
            $type = 'uid';
            $value = $uid;
            # 用户信息
            $containerid1 = '100505' . $uid;
            # 微博信息
            $containerid2 = '107603' . $uid;
            $url1 = 'https://m.weibo.cn/api/container/getIndex?uid=' . $uid . '&luicode=' . $luicode . '&lfid' . $lfid . '&type=' . $type . '&value=' . $value . '&containerid=' . $containerid1;
            $data1 = self::getHtml($url1)['data']['userInfo'];
            $flag = app('weibo')->saveWeiboUser($data1);
            $cou = ceil($data1['statuses_count'] / 10);
            for ($i = 1; $i <= $cou; $i++) {
                $url2 = 'https://m.weibo.cn/api/container/getIndex?uid=' . $uid . '&luicode=' . $luicode . '&lfid' . $lfid . '&type=' . $type . '&value=' . $value . '&containerid=' . $containerid2 . '&page=' . $i;
                $data_all = self::getHtml($url2)['data']['cards'];
                if ($data_all) {
                    app('weibo')->saveWeibo($data_all, $flag, $uid);
                }
                sleep(2);
            }
            WeiboUser::where('weibo_id',$uid)->update(['status' =>1]);
        }
        Log::info(date('Y-m-d') . 'weibo its ok');
        dd('结束');
    }
}
