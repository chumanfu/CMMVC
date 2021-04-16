<?php

namespace CMMVC\Config;

use CMMVC\Exceptions\AppException;

class ConfigReaderFactory
{
    public static function createConfigReader($readerType = '')
    {
        $className = '';

        switch ($readerType) {
        case 'ini':
        {
            $className = 'CMMVC\\Config\\Readers\\IniConfigReader';
            break;
}
        case 'json':
        {
            $className = 'CMMVC\\Config\\Readers\\JSONConfigReader';
            break;
}
        default:
        {
            $className = '';
            break;
}
        }

        if (class_exists($className)) {
            return new $className();
        } else {
            throw new AppException("Unable to find Config Reader for: " . $className);
        }
    }
}
