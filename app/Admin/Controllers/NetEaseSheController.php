<?php

namespace App\Admin\Controllers;

use App\Models\NetEase;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class NetEaseSheController extends NetEaseController
{
    public function __construct()
    {
        $this->SingNo ='12709';
        $this->title  = "She";
    }
}
