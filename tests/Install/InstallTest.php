<?php

class InstallTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp()
    {
        $this->setHost('localhost');
        $this->setPort(4444);
        $this->setBrowser('chrome');
        $this->setBrowserUrl('http://localhost:8888/');
    }

    public function testTitle()
    {
        $this->url('/');
        $this->assertEquals('2Moons');
    }
}