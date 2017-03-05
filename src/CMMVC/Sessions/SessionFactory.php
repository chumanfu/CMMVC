<?php

namespace CMMVC\Sessions;

use CMMVC\Exceptions\AppException;

class SessionFactory
{
	public static function createSessionHandler($handlerType = '')
	{
		$className = '';

		switch ($handlerType)
		{
			case '':
			case 'standard':
			{
				$className = 'CMMVC\\Sessions\\Handlers\\StandardSessionHandler';
				break;
			}
			case 'db':
			{
				$className = 'CMMVC\Sessions\\Handlers\\DBSessionHandler';
				break;
			}
			default:
			{
				$className = 'App\\Sessions\\Handlers\\' . $handlerType;
				break;
			}
		}

		if (class_exists($className))
		{
			$sessionObject = new $className();

			if (is_a($sessionObject, "CMMVC\\Sessions\\SessionHandler"))
			{
				return $sessionObject;
			}
			else
			{
				throw new AppException("Class " . $className . " does not derive from SessionHandler");
			}
		}
		else
		{
			throw new AppException("Unable to find Session Handler for: " . $className);
		}
	}

}

?>