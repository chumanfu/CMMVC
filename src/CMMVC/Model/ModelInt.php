<?php

namespace CMMVC\Model;

use CMMVC\Application;

interface ModelInt
{

	function execute($sql, $datatypes, $values);
	function insert($sql, $values, $types);
	function select($sql, $datatypes=null, $values=null);

}