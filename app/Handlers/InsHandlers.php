<?php
/**
 * Created by PhpStorm.
 * User: Hhx06
 * Date: 2020/4/29
 * Time: 10:30
 */

namespace App\Handlers;


use App\Models\Ins;
use App\Models\InsPic;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            $filename = public_path('data/' . time() . '.json');
            file_put_contents($filename, $res->getBody());
            return json_decode($res->getBody(), true);
        }
        return false;
    }


    public static function getData($after)
    {
        while (isset($after)) {
            $query_hash = '9dcf6e1a98bc7f6e92953d5a61027b98';
            $id = '1264029702';
            $data = [
                "id" => $id,
                "first" => 50,
                "after" => $after
            ];
            $variables = urlencode(json_encode($data));
            $url = 'https://www.instagram.com/graphql/query/?query_hash=' . $query_hash . '&variables=' . $variables;
            $data = self::getHtml($url);
            if (count($data) > 0) {
                $uu = $data['data']['user']['edge_owner_to_timeline_media'];
                self::parseData($uu['edges']);
                if ($uu['page_info']['has_next_page'] == true && isset($uu['page_info']['end_cursor'])) {
                    Log::info($uu['page_info']);
                    self::getData($uu['page_info']['end_cursor']);
                }
                return false;
            }
        }
        return false;
    }

    /**
     * 初始
     */
    public static function main()
    {
        $after = 'QVFDdmRncm9FNERSSkNxbl9CT012SzBaMml2OE1LWE1DaGxMZTNVTDQ1UV84aUFMM2JZVVI2Q3EyNEs2OXVhbWFVLTQ1TmR3bEFkNFd0NUc1UTcyQmdEUA==';
        self::getData($after);
    }

    /**
     * 保存列表数据
     * @param $data
     */
    public static function parseData($data)
    {
        foreach ($data as $datum) {
            $data_u['name'] = $datum['node']['owner']['username'];
            $data_u['ins_id'] = $datum['node']['owner']['id'];
            $data_u['publish_at'] = isset($datum['node']['taken_at_timestamp']) ? date('Y-m-d h:i:s', $datum['node']['taken_at_timestamp']) : '';
            $data_u['display_url'] = $datum['node']['display_url'];
            $data_u['text'] = !empty($datum['node']['edge_media_to_caption']) && count($datum['node']['edge_media_to_caption']['edges']) > 0 ? $datum['node']['edge_media_to_caption']['edges'][0]['node']['text'] : '';
            $data_u['edge_sidecar_to_children_count'] = isset($datum['node']['edge_sidecar_to_children']['edges']) ? count($datum['node']['edge_sidecar_to_children']['edges']) : 0;
            $data_u['video_url'] = isset($datum['node']['video_url']) ? $datum['node']['video_url'] : '';
            $Ins = new Ins($data_u);
            $Ins->save();
            $ins_id = $Ins->id;
            if ($data_u['edge_sidecar_to_children_count'] > 0) {
                self::savePic($datum['node']['edge_sidecar_to_children']['edges'], $ins_id);
            }
            unset($data_u);
        }
    }

    /**
     * 保存图片链接
     * @param $pics
     * @param $ins_id
     */
    public static function savePic($pics, $ins_id)
    {
        $now = Carbon::now();
        foreach ($pics as $pic) {
            $picv[] = [
                'ins_id' => $ins_id,
                'ins_url' => $pic['node']['display_url'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('ins_pics')->insert($picv);

    }


    public static function getAllData()
    {
        $url = 'https://www.instagram.com/graphql/query/?query_hash=9dcf6e1a98bc7f6e92953d5a61027b98&variables=%7B%22id%22%3A%221264029702%22%2C%22first%22%3A
527%2C%22after%22%3A%22QVFDdmRncm9FNERSSkNxbl9CT012SzBaMml2OE1LWE1DaGxMZTNVTDQ1UV84aUFMM2JZVVI2Q3EyNEs2OXVhbWFVLTQ1TmR3bEFkNFd0NUc1UTcyQmdEUA%3
D%3D%22%7D';
        $data = self::getHtml($url);
        $uu = $data['data']['user']['edge_owner_to_timeline_media'];
        self::parseData($uu['edges']);
    }


    public static function parseJson()
    {
        $fileName = public_path('data/hhx.json');
        $string = file_get_contents($fileName);
        $arrs = json_decode($string, true);
        $uu = $arrs['data']['user']['edge_owner_to_timeline_media'];
        self::parseData($uu['edges']);
    }

    public static function parsePicUrl()
    {
        $num = 0;
        InsPic::where('local_url', '')->select('id', 'ins_url')->chunk(50, function ($insPic) use ($num) {
            foreach ($insPic as $pic) {
                if ($pic->ins_url) {
                    $num++;
                    $e = time() . $num . '.jpg';
                    $storage = 'storage/';
                    $mk = 'ins/Hhx_06';
                    self::mkdirs($storage . 'app/public/' . $mk);
                    $filename = $storage . $mk . '/' . $e;
                    $client = new Client(['verify' => false]);  //忽略SSL错误
                    $client->get($pic->ins_url, ['save_to' => public_path($filename)]);
                    $pic->local_url = $mk . '/' . $e;
                    $arr[] = $pic->local_url;
                    $pic->save();
                }
            }
        });
    }

    public static function mkdirs($dir, $mode = 0777)
    {
        if (is_dir($dir) || @mkdir($dir, $mode)) return TRUE;
        if (!mkdir(dirname($dir), $mode)) return FALSE;
        return @mkdir($dir, $mode);
    }

}
