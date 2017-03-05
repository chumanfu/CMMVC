<?php

use CMMVC\Config\ConfigReaderFactory;

class ConfigReaderTest extends PHPUnit_Framework_TestCase
{
    public function testConfigReaderFactoryJSON()
    {
        $configReader = ConfigReaderFactory::createConfigReader("json");

        $this->assertEquals(get_class($configReader), "CMMVC\Config\Readers\JSONConfigReader");
    }

    public function testConfigReaderFactoryINI()
    {
        $configReader = ConfigReaderFactory::createConfigReader("ini");

        $this->assertEquals(get_class($configReader), "CMMVC\Config\Readers\IniConfigReader");
    }

}