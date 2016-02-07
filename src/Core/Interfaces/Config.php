<?php namespace App\Core\Interfaces;

/**
 * Just a shortcut to 'settings' key of $app->getContainer() id exists
 */
class Config extends SlimSugar
{
	public static function get($key)
	{
		return Container::get('settings')[$key];
	}

	public static function set($key, $value)
	{
		return Container::get('settings')[$key] = $value;
	}
}
