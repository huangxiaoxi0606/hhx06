<?php

namespace Tests\Feature;

use App\Handlers\InsHandlers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
//        $response = $this->get('/');
//        $response->assertStatus(200);
//        $a = [1, 2, 11, 15];
//        $b = [4, 12, 19, 23, 127, 235];
//        sort($a);
//        sort($b);
//        $alen = count($a);
//        $blen = count($b);
////        $flag = end($a) > end($b) ? end($a) : end($b);
//        for ($i = 0; $i < $alen; $i++) {
//            for ($j = 0; $j < $blen; $j++) {
//                if (abs($a[$i] - $b[$j]) < $flag) {
////                    $flag = abs($a[$i] - $b[$j]);
//                    Log::info($flag);
//                } else {
//                    $j = $blen;
//                }
//            }
//        }
//        dd($flag);
//        %7B%22id%22%3A%221264029702%22%2C%22first%22%3A12%2C%22after%22%3A%22QVFEYl9iMk1aOW1vN0VTLTZtRE0yVDd2ZElfdXpsOTQ3ekpZdkVRSUY3eXhmMzBDSXhITWdsWDBYbFVRbERKdjU5a3B4ekpody1lWEh2aEpUcHJkOWJncg%3D%3D%22%7D
//        $u ='{"id":"1264029702","first":12,"after":"QVFEYl9iMk1aOW1vN0VTLTZtRE0yVDd2ZElfdXpsOTQ3ekpZdkVRSUY3eXhmMzBDSXhITWdsWDBYbFVRbERKdjU5a3B4ekpody1lWEh2aEpUcHJkOWJncg=="}';
//        $h = urlencode($u);
//        dd($h);
        InsHandlers::getData();
    }
}
