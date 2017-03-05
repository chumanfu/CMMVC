<?php

namespace CMMVC\Model;

use CMMVC\Application;

class Model implements ModelInt
{
	private $dbConnection;

	function __construct()
	{
		$this->dbConnection = Application::getInstance()->databaseconnection;
	}

	public function execute($sql, $datatypes=null, $values=null)
	{
		return $this->dbConnection->execute($sql, $datatypes, $values);
	}

	public function insert($sql, $values, $types)
	{
		return $this->dbConnection->insert($sql, $values, $types);
	}

	public function select($sql, $datatypes=null, $values=null)
	{
		return $this->dbConnection->select($sql, $datatypes, $values);
	}

}

?>