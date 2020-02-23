<?php

namespace App\Admin\Controllers;

use App\Models\Asset;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ShoesController extends AssetController
{
    public function __construct()
    {
        $this->title = 'Shoes';
        $this->str = 'shoes';
    }
}
