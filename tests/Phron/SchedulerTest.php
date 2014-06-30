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
    
	public function testAnswers()
	{
        $answersArray = $this->scheduler->getAnswers();
        $this->assertCount(6, $answersArray);

        // check each value
        foreach ($answersArray as $key => $answer) {
            if ($key == 'command') {
                $this->assertEquals('-', $answer);
            } else {
                $this->assertEquals('*', $answer);
            }
        }

        $this->scheduler->answerQuestion('');
	}
    
}