<?php

namespace CMMVC\HTTP;

class URIReader
{
	private $requestURI = "";
	private $urlParts = array();
	private $route = "";
	private $method = null;
	private $var = null;

	function __construct($requestURI)
	{
		$this->requestURI = $requestURI;

		$this->urlParts = explode('/', $this->requestURI);

		$this->route = $this->urlParts[1];

		if ((count($this->urlParts) > 2) && (($this->method = $this->urlParts[2]) != ''))
		{
			if (count($this->urlParts) == 4)
			{
				$this->var = $this->urlParts[3];
			}
		}
	}

	function getFullURI()
	{
		return $this->requestURI;
	}

	function getRoute()
	{
		return strtolower($this->route);
	}

	function getMethod()
	{
		return $this->method;
	}

	function getVar()
	{
		return $this->var;
	}
}

?>