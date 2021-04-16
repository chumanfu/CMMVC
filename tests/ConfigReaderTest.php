<?php

use PHPUnit\Framework\TestCase;
use CMMVC\Config\ConfigReaderFactory;

class ConfigReaderTest extends TestCase
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