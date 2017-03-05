<?php

namespace CMMVC\Config;

interface ConfigReaderInterface
{
	public function readConfig($configfile);
	public function getConfigSetting($section, $key, $default=null);
}

?>