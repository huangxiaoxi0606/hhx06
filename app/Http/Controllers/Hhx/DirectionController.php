<?php
/**
 * Created by PhpStorm.
 * User: Hhx06
 * Date: 2020/4/15
 * Time: 10:44
 */

namespace App\Http\Controllers\Hhx;

use App\Http\Controllers\Controller;
use App\Models\Direction;
use Illuminate\Support\Facades\Request;

class DirectionController extends Controller
{
    public function getDirection(Request $request)
    {
        $data = Direction::query()->get();
        return view('Home.Hhx.direction', ['data' => $data]);
    }
}
