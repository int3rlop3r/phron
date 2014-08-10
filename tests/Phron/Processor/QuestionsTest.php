<?php

/**
 * Description of QuestionsTest
 *
 * @author jonathan
 */

use Cron\FieldFactory;
use Phron\Processor\Questions\Questionable;
use Phron\Processor\Questions\Minute;
use Phron\Processor\Questions\Hour;
use Phron\Processor\Questions\DayOfMonth;
use Phron\Processor\Questions\Month;
use Phron\Processor\Questions\DayOfWeek;

class QuestionsTest extends PHPUnit_Framework_TestCase
{
    private $minute;
    
    private $hour;
    
    private $dayOfMonth;
    
    private $month;
    
    private $dayOfWeek;
    
    public function setUp()
    {
        $fieldFactory = new FieldFactory;
        
        $this->minute     = new Minute($fieldFactory);
        $this->hour       = new Hour($fieldFactory);
        $this->dayOfMonth = new DayOfMonth($fieldFactory);
        $this->month      = new Month($fieldFactory);
        $this->dayOfWeek  = new DayOfWeek($fieldFactory);
    }
    
    public function testPositions()
    {
        $this->assertEquals(0, $this->minute->getPosition());
        $this->assertEquals(1, $this->hour->getPosition());
        $this->assertEquals(2, $this->dayOfMonth->getPosition());
        $this->assertEquals(3, $this->month->getPosition());
        $this->assertEquals(4, $this->dayOfWeek->getPosition());    
    }
    
    public function testOptionsCount()
    {
        $this->assertCount(7, $this->minute->getOptions());
        $this->assertCount(6, $this->hour->getOptions());
        $this->assertCount(7, $this->dayOfMonth->getOptions());
        $this->assertCount(6, $this->month->getOptions());
        $this->assertCount(4, $this->dayOfWeek->getOptions());
    }
    
    public function testQuestionsNotNull()
    {
        $this->assertNotNull($this->minute->getQuestion());
        $this->assertNotNull($this->hour->getQuestion());
        $this->assertNotNull($this->dayOfMonth->getQuestion());
        $this->assertNotNull($this->month->getQuestion());
        $this->assertNotNull($this->dayOfWeek->getQuestion());
    }
    
    public function testCustomQuestionNotNull()
    {
        $this->assertNotNull($this->minute->getCustomValueQuestion());
        $this->assertNotNull($this->hour->getCustomValueQuestion());
        $this->assertNotNull($this->dayOfMonth->getCustomValueQuestion());
        $this->assertNotNull($this->month->getCustomValueQuestion());
        $this->assertNotNull($this->dayOfWeek->getCustomValueQuestion());
    }
    
    /**
     * 
     * Loops through the array of expected values for each selection for a field
     * and compares them to the values returned by the getBySelection method
     * 
     */
    public function loopSelection($items, Questionable $question)
    {
        foreach ($items as $key => $value) {
            $this->assertEquals($value, $question->getBySelection($key));
        }
    }
    
    public function testSelection()
    {
        /**
         * Test minute selection
         */
        $minuteValues = array(
            '*',
            '*/2',
            '1-59/2',
            '*/5',
            '*/15',
            '*/30',
            null,
        );
        
        $this->loopSelection($minuteValues, $this->minute);
        
        /**
         * Test hour selection
         */
        $hourValues = array(
            '*', 
            '*/2',
            '1-23/2',
            '*/6',
            '*/12',
        );
        
        $this->loopSelection($hourValues, $this->hour);
        
        /**
         * Test day of month selection
         */
        $dayOfMonthValues = array(
            '*', 
            '*/2', 
            '1-31/2', 
            '*/5', 
            '*/10', 
            '*/15', 
            null, 
        );
        
        $this->loopSelection($dayOfMonthValues, $this->dayOfMonth);
        
        /**
         * Test month selection
         */
        $monthValues = array(
            '*', 
            '*/2', 
            '1-11/2', 
            '*/4', 
            '*/6', 
            null, 
        );
        
        $this->loopSelection($monthValues, $this->month);
        
        /**
         * Test day of week selection
         */
        $dayOfWeek = array(
            '*', 
            '1-5', 
            '0,6', 
            null, 
        );
        
        $this->loopSelection($dayOfWeek, $this->dayOfWeek);
    }
}