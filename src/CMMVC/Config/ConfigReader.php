<?php

namespace CMMVC\Config;

abstract class ConfigReader implements ConfigReaderInterface
{
    protected $config = array();
    protected $configFile = '';

    abstract public function readConfig($configfile);

    public function getConfigSetting($section, $key, $default=null)
    {
        if ($section == '') {
            if (!empty($this->config[$key])) {
                return $this->config[$key];
            } else {
                return $default;
            }
        } else {
            if (!empty($this->config[$section][$key])) {
                return $this->config[$section][$key];
            } else {
                return $default;
            }
        }
    }
}
