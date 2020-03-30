<?php
/**
 * Created by PhpStorm.
 * UserDAO: Hongkui
 * Date: 2018/10/8
 * Time: 19:03
 */

namespace App\Services;

use App\Lib\BaseClasses\ResourceManager;


class ServiceManager extends ResourceManager
{

    public static function getInstance():ServiceManager
    {
        return parent::_getInstance(ServiceManager::class);
    }

}
