<?php

namespace CMMVC\Database;

use CMMVC\Exceptions\AppException;

class DatabaseFactory
{
    public static function getDatabase($type, $dbhost, $dbname, $dbuser, $dbpassword)
    {
        $connection = null;

        if (strtolower($type) == "mysql") {
            $connection = new MySQLDatabase();
        } elseif (strtolower($type) == "file") {
            $connection = new FileDatabase();
        }

        if ($connection) {
            $connection->connect($dbhost, $dbname, $dbuser, $dbpassword);
        } else {
            throw new AppException("Invalid connection type: " . $type);
        }

        return $connection;
    }
}
