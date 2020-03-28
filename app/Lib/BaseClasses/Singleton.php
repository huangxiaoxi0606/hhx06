<?php
/**
 * Created by PhpStorm.
 * User: Hongkui
 * Date: 2018/12/16
 * Time: 21:28
 */

namespace App\Lib\BaseClasses;

/**
 * Class Singleton
 * @package App\Common\BaseClasses
 */
abstract class Singleton
{
    /**
     * @var mixed
     */
    protected static $instances;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @return mixed
     */
    protected static function getInstance()
    {
        $callClassName = get_called_class();
        if (!isset(static::$instances[$callClassName])) {
            static::$instances[$callClassName] = new $callClassName;
        }
        return static::$instances[$callClassName];
    }
}
