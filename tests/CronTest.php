<?php

require_once __DIR__.'/../vendor/autoload.php';

class CronTest extends PHPUnit_Framework_TestCase
{

	public function setUp()
	{
		$this->crontab = new Crontab\Crontab;
	}

	public function testAddCronJob()
	{
		//
	}
}