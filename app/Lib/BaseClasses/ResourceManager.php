<?php

namespace App\Lib\BaseClasses;

use Illuminate\Support\Facades\Log;

interface _ResourceManagerInterface
{
    /**
     * 每个子类实现这个方法，用于设置返回的具体Manager实例，具体可参考FormatterManager
     * @return ResourceManager
     */
    public static function getInstance();
}

abstract class ResourceManager implements _ResourceManagerInterface
{
    /**
     * @var null
     */
    private static $_instanceArray = [];

    /**
     * 返回的是ResourceManager的子类，这里为了智能提示正确，所以不条件@return
     * @throws \ReflectionException
     */
    protected static function _getInstance(string $fullClassName)
    {
        if (!array_key_exists($fullClassName, ResourceManager::$_instanceArray)) {
            $reflent_instance = new \ReflectionClass($fullClassName);
            ResourceManager::$_instanceArray[$fullClassName] = $reflent_instance->newInstance();
        }
        return ResourceManager::$_instanceArray[$fullClassName];
    }

    /**
     * @var array
     */
    private $normalInstanceArray = array();

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        $className = ucfirst($name);
        try {
            if (!strstr($arguments[0], $className)) {
                Log::error('Wrong function name', compact('name', 'arguments'));
                throw new \Exception('Wrong function name');
            }

            if (!array_key_exists($className, $this->normalInstanceArray)) {
                $reflent_instance = new \ReflectionClass($arguments[0]);
                $this->normalInstanceArray[$className] = $reflent_instance->newInstance();
            }

            return $this->normalInstanceArray[$className];
        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            throw new \Exception($className);
        }
    }
}
