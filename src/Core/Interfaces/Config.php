<?php namespace App\Core\Interfaces;

/**
 * Just a shortcut to 'settings' key of $app->getContainer() if exists
 */
class Config extends SlimSugar
{
	public static function get($key)
	{
		return static::$slim->getContainer()['settings'][$key];
	}

	public static function set($key, $value)
	{
		return static::$slim->getContainer()['settings'][$key] = $value;
	}
}
