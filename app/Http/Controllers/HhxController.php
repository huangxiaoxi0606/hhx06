<?php
/**
 * Created by PhpStorm.
 * User: Hhx06
 * Date: 2020/4/29
 * Time: 11:08
 */

namespace App\Http\Controllers;


use App\Handlers\InsHandlers;

class HhxController extends Controller
{
    public function indexs()
    {
        dd('123');
        InsHandlers::getData();
    }
}
