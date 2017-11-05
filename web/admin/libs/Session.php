<?php

class Session
{
	public static function set($name, $value)
	{
		$_SESSION[$name] = $value;
	}

	public static function get($name)
	{
		if (self::exists($name))
		{
			return $_SESSION[$name];
		}
		return null;
	}

	public static function exists($name)
	{
		if (isset($_SESSION[$name]))
		{
			return true;
		}
		return false;
	}

	public static function remove()
	{
		session_unset();
		//$_SESSION[$name] = null;
	}
}

?>