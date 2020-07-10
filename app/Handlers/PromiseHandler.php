<?php
/**
 * Created by PhpStorm.
 * User: Hhx06
 * Date: 2020/5/12
 * Time: 14:15
 */

namespace App\Handlers;


use App\Models\Ins;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;

class PromiseHandler
{
    public function getIns()
    {
        $ins = Ins::whereNotNull('display_url')->select('display_url','id')->limit(20)->get()->toArray();
        $client = new Client();
        $requests = function ($total) {
            $uri = 'http://lz.com/test';
            for ($i = 0; $i < $total; $i++) {
                yield new Request('GET', $uri);
            }
        };
        $ret = [];
        $pool = new Pool($client, $requests(10), [
            'concurrency' => 5,
            'fulfilled' => function ($response, $index) use (&$ret) {
                $contents = $response->getBody()->getContents();
                $contents = json_decode($contents, true);
                $ret[$index] = $contents;
                // this is delivered each successful response
            },
            'rejected' => function ($reason, $index) {
                // this is delivered each failed request
            },
        ]);
        // Initiate the transfers and create a promise
        $promise = $pool->promise();
        // Force the pool of requests to complete.
        $promise->wait();
        dd($ret);
    }

}
