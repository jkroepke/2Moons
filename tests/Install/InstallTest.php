<?php

class InstallTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp()
    {
        $this->setBrowser('chrome');
        $this->setBrowserUrl('http://localhost:8888/');
    }

    public function testTitle()
    {
        $this->url('http://localhost:8888/');
        $this->assertEquals('2Moons');
    }
}