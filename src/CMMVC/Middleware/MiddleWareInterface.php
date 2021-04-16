<?php

namespace CMMVC\Middleware;

use CMMVC\Sessions\SessionHandler;
use CMMVC\Config\ConfigReader;

interface MiddlewareInterface
{
    public function handle($route);
}
