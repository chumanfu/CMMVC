<?php

namespace CMMVC;

use CMMVC\ControllerInterface;
use CMMVC\ControllerTrait;

class Controller implements ControllerInterface
{
	function __construct(ApplicationInterface $application)
	{
		$this->app = $application;
	}

	public function index($var)
	{
		echo $var;
	}

	use ControllerTrait;
}

?>