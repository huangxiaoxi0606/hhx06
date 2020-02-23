<?php

namespace App\Admin\Controllers;

use App\Models\Weibo;
use App\Models\WeiboPic;
use App\Models\WeiboPics;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;
use Illuminate\Support\Str;
use function test\Mockery\Fixtures\HHVMString;

class WeiboYejinController extends WeiboController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    public function __construct()
    {
        $this->title = '孙艺珍';
        $this->wei_id = '2812864912';
    }
}
