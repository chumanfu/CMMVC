<?php

namespace CMMVC\Exceptions;

class AppException extends \Exception
{
	
	public function __construct($message, $code = 0, Exception $previous = null) 
	{
        // some code
    	$message = "ApplicationException: "  . $message . "\n";

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

}