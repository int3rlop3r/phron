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

        // check default values
        foreach ($answersArray as $key => $answer) {
            
            // testing the get answer function
            $funcAnswer = $this->scheduler->getAnswer($key);
            
            if ($key == 'command') {
                
                
                $this->assertEquals('-', $answer);
                $this->assertEquals('-', $funcAnswer);
                
            } else {
                
                $this->assertEquals('*', $answer);
                $this->assertEquals('*', $funcAnswer);
            }
        }

        $this->scheduler->answerQuestion('minutes', 0);
        $this->scheduler->answerQuestion('hours', 0);
        $this->scheduler->answerQuestion('days', 0);
        $this->scheduler->answerQuestion('months', 0);
        $this->scheduler->answerQuestion('weekdays', 0);
        $this->scheduler->answerQuestion('command', 'ls');
        
        $answersArray = $this->scheduler->getAnswers();
        $this->assertCount(6, $answersArray);
        // check recheck values
        foreach ($answersArray as $key => $answer) {
        
            // testing the get answer function
            $funcAnswer = $this->scheduler->getAnswer($key);
        
            if ($key == 'command') {
        
        
                $this->assertEquals('ls', $answer);
                $this->assertEquals('ls', $funcAnswer);
        
            } else {
        
                $this->assertEquals('0', $answer);
                $this->assertEquals('0', $funcAnswer);
            }
        }
        
	}
	
	public function testQuestions()
	{
	    $questions = $this->scheduler->getQuestions();
	    
	    $this->assertCount(6, $questions);
	}
	
	public function testSubQuestions()
	{
	    $subQuestions = $this->scheduler->getSubQuestions();
	    
	    $this->assertCount(6, $subQuestions);
	}
	
	public function testStack()
	{
	    $stack = $this->scheduler->getStack();
	    
	    $this->assertCount(6, $stack);
	    
	    foreach ($stack as $item) {
	        $question    = $this->scheduler->getQuestion($item);
	        $subQuestion = $this->scheduler->getSubQuestion($item);
	        $answer      = $this->scheduler->getAnswer($item);
	    }
	    
	}
	
}