<?php

namespace CMMVC\Database;

use CMMVC\Model\ModelInt;
use CMMVC\Exceptions\AppException;

class MySQLDatabase implements ModelInt
{
	private $dbConnection;

	public function connect($dbhost, $dbname, $dbuser, $dbpassword)
	{
		$this->dbConnection = mysqli_connect($dbhost,$dbuser,$dbpassword,$dbname);

		if (mysqli_connect_errno())
		{
			throw new AppException("Unable to connect to database: " . mysqli_connect_errno());
		}
	}

	public function execute($sql, $datatypes=null, $values=null)
	{
		$returnArray = array('error'=>'');

		$stmt = $this->dbConnection->prepare($sql);

		if ($stmt)
		{

			$bindOK = true;

			if ($datatypes)
			{
				$bindOK = $this->bindParams($stmt, $datatypes, $values);
			}

			if ($bindOK)
			{
				$results = array();

				$this->stmt_bind_assoc($stmt, $results);

				if (!$stmt->execute())
				{
					$returnArray['error'] = 'Error deleting';
				}
			}

		}

		return $returnArray;
	}

	public function insert($sql, $values, $types)
	{
		$id = -1;
		$bindParamAttr = array();
		$bindParamAttr[] = $types;

		foreach ($values as $value)
		{
			$bindParamAttr[] = $value;
		}

		$stmt = $this->dbConnection->prepare($sql);

		if ($stmt)
		{
			$bindOK = call_user_func_array(array(&$stmt, 'bind_param'), $this->makeValuesReferenced($bindParamAttr));

            if ($bindOK)
            {
                if ($stmt->execute())
                {
                    $id = $this->dbConnection->insert_id;
                }
            }
		}

		return $id;

	}

	public function select($sql, $datatypes=null, $values=null)
	{
		$returnArray = array();

		$stmt = $this->dbConnection->prepare($sql);

		if ($stmt)
		{

			$bindOK = true;

			if ($datatypes)
			{
				$bindOK = $this->bindParams($stmt, $datatypes, $values);
			}

			if ($bindOK)
			{
				$results = array();

				$this->stmt_bind_assoc($stmt, $results);

				if ($stmt->execute())
				{
					while ($stmt->fetch())
					{
						$itemRecord = array();

						foreach($results as $key => $value)
						{
							$itemRecord[$key] = $value;
						}
						
						array_push($returnArray, $itemRecord);
					}
				}
			}

		}

		return $returnArray;
	}

	private function makeValuesReferenced($arr)
    {
        $refs = array();
        foreach ($arr as $key => $value)
        {
            $refs[$key] = &$arr[$key];
        }
        return $refs;
    }

    private function bindParams(&$stmt, $dataTypes, $valuesArray)
    {
        if (is_array($dataTypes))
        {
            $dataTypes = join('', $dataTypes);
        }

        if (count($valuesArray) > 0)
        {
            $params = array_merge(Array($dataTypes), $valuesArray);
            $tmp = array();
            foreach ($params as $key => $value)
            {
                $tmp[$key] = &$params[$key];
            }
            $bindOK = call_user_func_array(Array($stmt, 'bind_param'), $tmp);
        }
        else
        {
            $bindOK = true;
        }

        return $bindOK;
    }

    private function stmt_bind_assoc(&$stmt, &$out)
    {
        // bind the results to an associative array
        $data = mysqli_stmt_result_metadata($stmt);

        $fields = Array();
        $out = Array();

        $fields[0] = $stmt;
        $count = 1;

        while ($field = mysqli_fetch_field($data))
        {
            $fields[$count] = &$out[$field->name];
            $count++;
        }

        call_user_func_array('mysqli_stmt_bind_result', $fields);
    }
}

?>