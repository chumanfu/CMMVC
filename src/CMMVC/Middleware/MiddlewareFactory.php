<?php

namespace CMMVC\Middleware;

use CMMVC\Exceptions\AppException;

class MiddlewareFactory
{
	public static function createMiddleware(\CMMVC\Application $app, $middlewareType = '')
	{
		$className = '';
		$middlewareObject;

		// switch ($middlewareType)
		// {
		// 	case 'auth':
		// 	{
		// 		$className = 'Middleware\\' . ucwords($middlewareType) . 'Middleware';

		// 		break;
		// 	}
		// 	default:
		// 	{
		// 		$className = '';
		// 		break;
		// 	}
		// }

		$className = 'Middleware\\' . ucwords($middlewareType) . 'Middleware';

		if ($className != '')
		{

			if (class_exists($className))
			{
				$middlewareObject = new $className($app);
			}

			if ($middlewareObject)
			{
				if (is_a($middlewareObject, "CMMVC\\Middleware\\MiddlewareInterface"))
				{
					return $middlewareObject;
				}
				else
				{
					throw new AppException("Class " . $className . " does not derive from MiddlewareInterface");
				}
			}
			else
			{
				throw new AppException("Unable to find Middleware for: " . $className);
			}
		}
		else
		{
			throw new AppException("Invalid middleware type: " . $middlewareType);
		}
	}

}

?>