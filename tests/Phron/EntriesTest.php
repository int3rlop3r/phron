<?php require __DIR__.'..//../../vendor/autoload.php';

/**
 * @author Jonathan Fernandes <int3rlop3r@yahoo.in>
 */

use Phron\Processor\Entries;

class CronTest extends PHPUnit_Framework_TestCase
{

	public function setUp()
	{
		$this->entries = new Entries;
	}

	public function testAddCronJob()
	{
		//
	}
}