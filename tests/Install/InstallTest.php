<?php

use PHPUnit\Framework\TestCase;

class InstallTest extends TestCase
{
    private $http;

    protected function setUp()
    {
        $this->http = new GuzzleHttp\Client(['base_uri' => $_SERVER['TEST_BASE_URI']]);
    }

    public function tearDown() {
        $this->http = null;
    }

    public function testInstallRedirect()
    {
        $response = $this->http->request('GET', '/', ['allow_redirects' => false]);

        $this->assertEquals(302, $response->getStatusCode());

        $location = $response->getHeaders()["Location"][0];
        $this->assertRegexp('/install\/index.php/', $location);
    }

    public function testInstallHome()
    {
        $response = $this->http->request('GET', '/install/index.php');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testInstallStep2()
    {
        $response = $this->http->request('GET', '/index.php?mode=install&step=2');

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertRegexp('/<span class="yes">/', $response->getBody());
        $this->assertRegexp('/<a href="index.php?mode=install&step=3">/', $response->getBody());
    }

    public function testInstallStep3()
    {
        $response = $this->http->request('GET', 'index.php?mode=install&step=3');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testInstallSql()
    {
        $response = $this->http->request('POST', 'index.php?mode=install&step=3', [
            'form_params' => [
                'host' => $_SERVER['DB_HOST'],
                'user' => $_SERVER['DB_USER'],
                'passwort' => $_SERVER['DB_PASSWORD'],
                'dbname' => $_SERVER['DB_NAME'],
                'prefix' => '2moons_',
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }
}