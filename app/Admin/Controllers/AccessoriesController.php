<?php

namespace App\Admin\Controllers;


class AccessoriesController extends AssetController
{

    public function __construct()
    {
        $this->title = 'Accessories';
        $this->str = 'accessories';
    }
}
