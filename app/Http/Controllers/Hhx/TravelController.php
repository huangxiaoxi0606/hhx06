<?php
/**
 * Created by PhpStorm.
 * User: Hhx06
 * Date: 2020/4/15
 * Time: 10:50
 */

namespace App\Http\Controllers\Hhx;


use App\Http\Controllers\Controller;
use App\Models\HhxTravel;
use Illuminate\Support\Facades\Request;

class TravelController extends Controller
{
    public function getList(Request $request)
    {
        $data = HhxTravel::query()->paginate(20);
        return view('Home.Hhx.travel_list', ['data'=>$data]);
    }

    public function getIntro(Request $request, $id)
    {
        $data = HhxTravel::whereId($id)->first();
        return view('Home.Hhx.travel_intro', ['data'=>$data]);
    }
}
