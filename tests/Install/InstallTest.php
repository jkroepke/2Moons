<?php

class InstallTest extends PHPUnit_Framework_TestCase
{
    private $http;

    protected function setUp()
    {
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://localhost:8888/']);
    }

    public function tearDown() {
        $this->http = null;
    }

    public function testInstallRedirect()
    {
        $response = $this->http->request('GET', '');

        $this->assertEquals(302, $response->getStatusCode());
    }
}