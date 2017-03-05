<?php

namespace CMMVC\Database;

use CMMVC\Exceptions\AppException;

class DatabaseFactory
{
	public static function getDatabase($type, $dbhost, $dbname, $dbuser, $dbpassword)
	{
		if (strtolower($type) == "mysql")
		{
			$connection = new MySQLDatabase();
		}
		else if (strtolower($type) == "file")
		{
			$connection = new FileDatabase();
		}

		$connection->connect($dbhost, $dbname, $dbuser, $dbpassword);

		return $connection;
	}
}

?>