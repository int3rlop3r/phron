<?php

/**
 * @author Jonathan Fernandes <int3rlop3r@yahoo.in>
 */

use Phron\Processor\Scheduler;

class SchedulerTest extends PHPUnit_Framework_TestCase
{
    private $scheduler;
    
	public function setUp()
	{
		$this->scheduler = new Scheduler;
	}
    
	public function testAddCronJob()
	{
        $cronExp = $this->scheduler->get();
        
        $this->assertEquals('* * * * *', $cronExp);
	}
    
}