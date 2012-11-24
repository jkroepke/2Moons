<?php

class InstallTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->connect	= new Browser();
	}

    public function testRedirect()
    {
        $answer = $this->connect->setUrl('index.php')->execute();
		$this->assertEquals($this->connect->getHttpCode(), 200);
		$this->assertTrue(strpos($answer, 'index.php?mode=install') !== false);
		$this->connect->reset();
    }

    public function testInstallStep1()
    {
        $answer = $this->connect->setUrl('install/index.php?mode=install&step=1')->execute();
		$this->assertEquals($this->connect->getHttpCode(), 200);
		$this->assertTrue(strpos($answer, '<h3>GNU GENERAL PUBLIC LICENSE</h3>') !== false);
		$this->connect->reset();
        $this->connect
			->setUrl('install/index.php?mode=install&step=1')
			->setMethod('POST')
			->setPostData(array('post' => 1, 'accept' => 1))
			->setFollowLocation(false)
			->execute();
		
		$this->assertEquals($this->connect->getHttpCode(), 302);
		$this->connect->reset();
    }

    public function testInstallStep2()
    {
        $answer = $this->connect->setUrl('install/index.php?mode=install&step=2')->execute();
		$this->connect->reset();
		$this->assertEquals($this->connect->getHttpCode(), 200);
		$this->assertEquals(substr_count($answer, '<span class="yes">'), 14);
		$this->assertTrue(strpos($answer, 'index.php?mode=install&step=3') !== false);
    }

    public function testInstallStep3()
    {
        $answer = $this->connect->setUrl('install/index.php?mode=install&step=3')->execute();
		$this->connect->reset();
		$this->assertEquals($this->connect->getHttpCode(), 200);
		$this->assertTrue(strpos($answer, 'index.php?mode=install&step=4') !== false);
    }

    public function testInstallStep4()
    {
		$answer = $this->connect
					  ->setUrl('install/index.php?mode=install&step=4')
					  ->setMethod('POST')
					  ->setPostData(array(
						'post' 		=> 1, 
						'host'		=> TEST_MYSQL_HOST,
						'port'		=> TEST_MYSQL_PORT,
						'user'		=> TEST_MYSQL_USER,
						'passwort'	=> TEST_MYSQL_PASSWORD,
						'dbname'	=> TEST_MYSQL_DATABASE,
						'prefix'	=> 'test_'
					  ))
					  ->execute();
					  
		$this->assertTrue(strpos($answer, '<div class="noerror">') !== false);
		$this->assertEquals($this->connect->getHttpCode(), 200);
    }

    public function testInstallStep5()
    {
        $answer = $this->connect->setUrl('install/index.php?mode=install&step=5')->execute();
		$this->connect->reset();
		$this->assertEquals($this->connect->getHttpCode(), 200);
    }
}
?>