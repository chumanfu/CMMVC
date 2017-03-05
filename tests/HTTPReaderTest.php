<?php

use CMMVC\HTTP\HTTPReader;

class HTTPReaderTest extends PHPUnit_Framework_TestCase
{
    public function testGetPosts()
    {
    	$postItems = array('test'=>1, 'test2'=>'qwe');

    	$httpReader = new HTTPReader($postItems, array(), array());

    	$this->assertEquals($postItems, $httpReader->getPosts());

		$this->assertEquals(1, $httpReader->getPostVar('test'));
		$this->assertEquals('qwe', $httpReader->getPostVar('test2'));
		$this->assertEquals(null, $httpReader->getPostVar('test3'));

		$this->assertEquals(array(), $httpReader->getGets());
		$this->assertEquals(array(), $httpReader->getCookies());
	}

    public function testReadValue()
    {
    	$postItems = array('test'=>1, 'test2'=>'qwe');

    	$httpReader = new HTTPReader($postItems, array(), array());
		$this->assertEquals(1, $httpReader->readValue('test'));
		$this->assertEquals('qwe', $httpReader->readValue('test2'));
		$this->assertEquals(null, $httpReader->readValue('test3'));

    }

    public function testReadValueMulti()
    {
    	$postItems = array('test'=>1, 'test2'=>'qwe');
    	$getItems = array('test'=>2, 'test2'=>'asd', 'test3'=>'get');
    	$cookieItems = array('test'=>3, 'test2'=>'zxc', 'test3'=>'get', 'test4'=>'cookie');

    	$httpReader = new HTTPReader($postItems, $getItems, $cookieItems);
		$this->assertEquals(1, $httpReader->readValue('test'));
		$this->assertEquals('qwe', $httpReader->readValue('test2'));
		$this->assertEquals(null, $httpReader->readValue('test5'));
		$this->assertEquals('get', $httpReader->readValue('test3'));
		$this->assertEquals('cookie', $httpReader->readValue('test4'));

    }

}