<?php

namespace CMMVC\Database;

use CMMVC\Model\ModelInt;
use CMMVC\Exceptions\AppException;

class FileDatabase implements ModelInt
{
	private $dbConnection;

	public function connect($dbhost, $dbname, $dbuser, $dbpassword)
	{

	}

	public function execute($sql, $datatypes=null, $values=null)
	{
		$returnArray = array('error'=>'');

		return $returnArray;
	}

	public function insert($sql, $values, $types)
	{
		$id = -1;

		return $id;
	}

	public function select($sql, $datatypes=null, $values=null)
	{
		$returnArray = array();

		$returnArray[] = array('id'=>1, 'title'=>'Test Title 1', 'post'=>'HELLO', 'createdby'=>'Chris M', 'createdon'=>'12-02-2017 12:00:00');
		$returnArray[] = array('id'=>2, 'title'=>'Test Title 2', 'post'=>'HELLO', 'createdby'=>'Chris M', 'createdon'=>'12-02-2017 12:00:00');

		return $returnArray;
	}
}
?>