<?php

use PHPUnit\Framework\TestCase;
use CMMVC\Controller;
use CMMVC\Application;
use CMMVC\HTTP\URIReader;

class ControllerTest extends TestCase
{
    public function testValidCSRF()
    {
        $stub = $this->createMock(Application::class);

        $stub->method('getCSRF')->willReturn('123');
        $stub->method('getSessionCSRF')->willReturn('123');

        $controller = new Controller($stub);

        $this->assertTrue($controller->checkCSRF());

    }

    public function testInValidCSRF()
    {
        $stub = $this->createMock(Application::class);

        $stub->method('getCSRF')->willReturn('123');
        $stub->method('getSessionCSRF')->willReturn('abc');

        $controller = new Controller($stub);

        $this->assertFalse($controller->checkCSRF());

    }

    public function testIndex()
    {
        $stub = $this->createMock(Application::class);

        $controller = new Controller($stub);

        $var = '123';

        $this->expectOutputString($var);

        $controller->index($var);
    }

    public function testMissingRouting()
    {
        $app = $this->createMock(Application::class);
        $uriReader = new URIReader("/route/method/var");

        $controller = new Controller($app);

        $this->expectOutputString("method");

        $controller->_index($uriReader);
    }


}