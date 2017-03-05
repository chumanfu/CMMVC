<?php

namespace CMMVC\Config\Readers;

use CMMVC\Config\ConfigReader;

class JSONConfigReader extends ConfigReader
{
	public function readConfig($configfile)
	{
		$this->configFile = $configfile;

		$configFileData = file_get_contents($this->configFile);

		$this->config = json_decode($configFileData, true);
	}
}

?>