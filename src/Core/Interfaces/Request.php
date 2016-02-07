<?php namespace App\Core\Interfaces;

class Request extends SlimSugar
{
    public static function __callStatic($name, $args)
    {
    	return call_user_func_array(array(static::$slim->getContainer()['request'], $name), $args);
    }
}
