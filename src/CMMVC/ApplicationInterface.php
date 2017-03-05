<?php

namespace CMMVC;

interface ApplicationInterface
{
	public function initialise($configFile);
	public function implementRouting();
	public function getConfigSetting($section, $key, $default);
	public function getSessionValue($key);
	public function setSessionValue($key, $value);
	public function view($page, $pageData = array());
	public function redirect($page);
	public function canRoute($route);
	public function getCSRF();
	public function getSessionCSRF();
}

?>