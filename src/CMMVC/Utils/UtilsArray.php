<?php

namespace CMMVC\Utils;

class UtilsArray
{
	public static function readArrayParam($array, $key, $default = null)
	{
		if (array_key_exists($key, $array))
		{
			return $array[$key];
		}
		else
		{
			return $default;
		}
	}

}

?>