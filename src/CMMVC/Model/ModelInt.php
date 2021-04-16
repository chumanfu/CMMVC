<?php

namespace CMMVC\Model;

use CMMVC\Application;

interface ModelInt
{
    public function execute($sql, $datatypes, $values);
    public function insert($sql, $values, $types);
    public function select($sql, $datatypes=null, $values=null);
}
