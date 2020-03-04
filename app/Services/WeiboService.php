<?php
/**
 * Created by Hhx06.
 * User: Hhx06
 * Date: 2020/2/21
 * Time: 11:17
 */

namespace App\Services;


use App\Jobs\WeiboPic;
use App\Jobs\WeiboUserPic;
use App\Models\Weibo;

use App\Models\WeiboUser;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WeiboService
{
    public function saveWeiboUser($data)
    {
        $weibo_user = $this->searchWeiboUser($data['id']);
        if (!$weibo_user) {
            $weibo_user = new WeiboUser();
            $weibo_user->avatar_hd_url = '';
            $weibo_user->cover_image_phone = '';
        }
        $weibo_user->avatar_hd = $weibo_user->avatar_hd_url == $data['avatar_hd'] ? $weibo_user->avatar_hd : $data['avatar_hd'];
        $weibo_user->cover_image_phone = $weibo_user->cover_image_phone_url == $data['cover_image_phone'] ? $weibo_user->cover_image_phone : $data['cover_image_phone'];
        $weibo_user->avatar_hd_url = $data['avatar_hd'];
        $weibo_user->cover_image_phone_url = $data['cover_image_phone'];
        $weibo_user->description = $data['description'];
        $weibo_user->follow_count = $data['follow_count'];
        $weibo_user->followers_count = $data['followers_count'];
        $weibo_user->gender = $data['gender'];
        $weibo_user->weibo_id = $data['id'];
        $weibo_user->mbrank = $data['mbrank'];
        $weibo_user->mbtype = $data['mbtype'];
        $weibo_user->screen_name = $data['screen_name'];
        $weibo_user->statuses_count = $data['statuses_count'];
        $weibo_user->save();
        dispatch(new WeiboUserPic());
        return $weibo_user->status;
    }

    public function searchWeiboUser($id)
    {
        return WeiboUser::where('weibo_id', $id)->first();
    }

    public function parseWeiboUserPic()
    {
        $arr = [];
        //用户头像以及封面
        $weiboUsers = WeiboUser::select('id', 'screen_name', 'avatar_hd', 'cover_image_phone')->get();
        foreach ($weiboUsers as $user) {
            if ($user->avatar_hd && strpos($user->avatar_hd, 'https') !== false) {
                $url = $user->avatar_hd;
                $e = time() . '_' . $user->id . '.jpg';
                $storage = 'storage/';
                $mk = 'weibo_user_avatar/' . $user->screen_name;
                $this->mkdirs($storage . 'app/public/' . $mk);
                $filename = $storage . $mk . '/' . $e;
                $client = new Client(['verify' => false]);  //忽略SSL错误
                $client->get($url, ['save_to' => public_path($filename)]);
                $url2 = $user->cover_image_phone;
                $mc = 'weibo_user_cover/' . $user->screen_name;
                $this->mkdirs($storage . 'app/public/' . $mc);
                $filename2 = $storage . $mc . '/' . $e;
                $client = new Client(['verify' => false]);  //忽略SSL错误
                $client->get($url2, ['save_to' => public_path($filename2)]);
                $user->avatar_hd = $mk . '/' . $e;
                $user->cover_image_phone = $mc . '/' . $e;
                $user->save();
                $arr[] = $mk . '/' . $e;
                $arr[] = $mc . '/' . $e;
            }
        }
//        if (count($arr) > 0) {
//            //存入七牛云
//            $disk = Storage::disk('qiniu');
//            $arrs = array_chunk($arr, 20);
//            foreach ($arrs as $ar) {
//                foreach ($ar as $pic) {
//                    $p = Storage::get($pic);
//                    $disk->put($pic, $p);
//                }
//            }
//        }
    }

    public function saveWeibo($data, $flag, $uid)
    {
        $data_all = [];
        $pic_all = [];
        $max = 0;
        if ($flag == 1) {
            //微博现存最大发布时间
            $max = Weibo::where('weibo_id', $uid)->max('weibo_created_at');
        }
        foreach ($data as $value) {
            $data_two = $this->parseData($value['mblog'], $max, $f = 1);
            if (!$data_two) {
                break;
            }
            if (Weibo::where('weibo_info_id', $data_two['weibo_info_id'])->first()) {
                continue;
            }
            if (isset($value['mblog']['retweeted_status'])) {
                $data_one = $this->parseData($value['mblog']['retweeted_status'], 0, 0);
                $data_one['is_flag'] = 1;
                $new_id = DB::table('weibos')->insertGetId($data_one);
            }
            $data_two['repost_id'] = isset($new_id) ? $new_id : 0;
            $data_two['scheme'] = $value['scheme'];
            $data_all[] = $data_two;
            if ($value['mblog']['pic_num'] > 1) {
                foreach ($value['mblog']['pics'] as $pic) {
                    $pic_us['weibo_info_id'] = $value['mblog']['id'];
                    $pic_us['url'] = $pic['url'];
                    $pic_us['screen_name'] = $data_two['screen_name'];
                    $pic_us['created_at'] = Carbon::now();
                    $pic_all[] = $pic_us;
                }
            }
        }
        if (count($pic_all) > 0 || count($data_all) > 0) {
            if (count($pic_all) > 0) {
                DB::table('weibo_pics')->insert($pic_all);
            }
            if ($data_all > 0) {
                DB::table('weibos')->insert($data_all);
            }
            unset($data_all);
            unset($pic_all);
            dispatch(new WeiboPic());
        }
    }

    public function parseData($data, $max = 0, $f = 0)
    {
        $len = substr_count($data['created_at'], '-');
        if ($len == 1) {
            $wb_created_at = date('Y') . '-' . $data['created_at'];
        } elseif ($len == 0) {
            $wb_created_at = date("Y-m-d");
        } else {
            $wb_created_at = $data['created_at'];
        }
        if ($max != 0 && $f == 1 && $max > $wb_created_at) {
            //如果有最大时间且是主
            return false;
        }
        if (!isset($data['user']) || !isset($data['id']) || !isset($data['text'])) {
            return false;
        }
        return [
            'thumbnail_pic' => isset($data['thumbnail_pic']) ? $data['thumbnail_pic'] : '',
            'original_pic' => isset($data['original_pic']) ? $data['original_pic'] : '',
            'source' => isset($data['source']) ? $data['source'] : '',
            'weibo_created_at' => $wb_created_at,
            'text' => isset($data['text']) ? $data['text'] : 'wu',
            'comments_count' => isset($data['comments_count']) ? $data['comments_count'] : 0,
            'attitudes_count' => isset($data['attitudes_count']) ? $data['attitudes_count'] : 0,
            'reposts_count' => isset($data['reposts_count']) ? $data['reposts_count'] : 0,
            'screen_name' => $data['user']['screen_name'],
            'repost_id' => 0,
            'is_flag' => 0,
            'weibo_info_id' => $data['id'],
            'weibo_id' => $data['user']['id'],
            'pic_num' => isset($data['pic_num']) ? $data['pic_num'] : 0,
            'created_at' => Carbon::now(),
        ];
    }

    public function parseWeiboPic()
    {
        $num = 0;
        $arr = [];
        Weibo::whereNull('updated_at')->whereNotNull('thumbnail_pic')->select('id', 'thumbnail_pic', 'screen_name')->chunk(100, function ($weibos) use ($num, $arr) {
            foreach ($weibos as $weibo) {
                if ($weibo->thumbnail_pic) {
                    $url = $weibo->thumbnail_pic;
                    $num = $num + 1;
                    $e = time() . $num . '.jpg';
                    $storage = 'storage/';
                    $mc = 'weibo_pic/' . $weibo->screen_name;
                    $this->mkdirs($storage . 'app/public/' . $mc);
                    $filename = $storage . $mc . '/' . $e;
                    $client = new Client(['verify' => false]);  //忽略SSL错误
                    $data[$weibo->id] = $mc . '/' . $e;
                    $client->get($url, ['save_to' => public_path($filename)]);
                    $arr[] = $data[$weibo->id];
                }
            }
            if (!empty($data)) {
                foreach ($data as $k => $v) {
                    $we = Weibo::where('id', $k)->first();
                    $we->thumbnail_pic = $v;
                    $we->save();
                }
            }
        });
        \App\Models\WeiboPic::whereNull('updated_at')->select('id', 'url', 'screen_name')->chunk(100, function ($weiboPic) use ($num, $arr) {
            foreach ($weiboPic as $pic) {
                if ($pic->url) {
                    $num = $num + 1;
                    $e = time() . $num . '.jpg';
                    $storage = 'storage/';
                    $mk = 'weibo_pic/' . $pic->screen_name;
                    $this->mkdirs($storage . 'app/public/' . $mk);
                    $filename = $storage . $mk . '/' . $e;
                    $client = new Client(['verify' => false]);  //忽略SSL错误
                    $client->get($pic->url, ['save_to' => public_path($filename)]);
                    $pic->url = $mk . '/' . $e;
                    $arr[] = $pic->url;
                    $pic->save();
                }
            }
        });
//        if (count($arr) > 0) {
//            $disk = Storage::disk('qiniu');
//            $arrs = array_chunk($arr, 20);
//            foreach ($arrs as $ar) {
//                foreach ($ar as $pic) {
//                    $p = Storage::get($pic);
//                    $disk->put($pic, $p);
//                }
//            }
//            Log::info("weibopic end");
//            //存入七牛云
//        }
    }

    public function mkdirs($dir, $mode = 0777)
    {
        if (is_dir($dir) || @mkdir($dir, $mode)) return TRUE;
        if (!mkdir(dirname($dir), $mode)) return FALSE;
        return @mkdir($dir, $mode);
    }


    public function parseReport($repost_id)
    {
        $weibo = Weibo::where('id', $repost_id)->first();
        if ($weibo) {
            return [
                'id' => $weibo->id,
                trans('hhx.screen_name') => $weibo->screen_name,
                trans('hhx.text') => $weibo->text,
                trans('hhx.weibo_created_at') => $weibo->weibo_created_at,
                trans('hhx.comments_count') => $weibo->comments_count,
                trans('hhx.attitudes_count') => $weibo->attitudes_count,
                trans('hhx.reposts_count') => $weibo->reposts_count,
                trans('hhx.thumbnail_pic') => isset($weibo->thumbnail_pic) ? "<img src =" . config('hhx.img_url') . $weibo->thumbnail_pic . ">" : "wu",
            ];
        }
        return false;
    }

    public function parsePicNum($model)
    {
        $base_url = config('hhx.img_url');
        if ($model->pic_num > 1) {
            unset($data_u);
            $num = 0;
            $pics = \App\Models\WeiboPic::where('weibo_info_id', $model->weibo_info_id)->select('url')->get();
            foreach ($pics as $pic) {
                $num++;
                $data_u[$num] = '<img src=" ' . $base_url .  $pic->url . '">';
            }
        } elseif ($model->pic_num == 1) {
            $data_u['1'] = '<img src=" ' . $base_url . $model->thumbnail_pic . '">';
        } else {
            $data_u['pic'] = '一张图片都没有';
        }
        return $data_u;
    }
}
