<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class NetEaseEasonController extends NetEaseController
{
    public function __construct()
    {
        $this->SingNo ='2116';
        $this->title  = "Eason";
    }
}
