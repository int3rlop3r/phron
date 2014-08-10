<?php
/**
 * Description of GeneratorTest
 *
 * @author jonathan
 */

use Phron\Processor\Generator;
use Crontab\Job;

class GeneratorTest extends PHPUnit_Framework_TestCase
{
    private $generator;
    
    private $job;
    
    public function setUp()
    {
        $this->job       = new Job;
        $this->generator = new Generator($this->job);
    }
    
    public function testDefaultExpressionCount()
    {
        $fieldList = $this->generator->getFieldList();
        
        $this->assertCount(5, $fieldList);
    }
    
    public function testSettersAndGetters()
    {
        $fieldList = $this->generator->getFieldList();
        $defaultValue = '*';
        
        // Test cron expressions
        foreach ($fieldList as $field => $methodName) {
            
            // Make sure setters and getters are calling the right function (:
            $setterExists = method_exists($this->job, 'set' . $methodName);
            $getterExists = method_exists($this->job, 'get' . $methodName);
            
            $this->assertTrue($setterExists);
            $this->assertTrue($getterExists);
            
            // Test getters and setters
            $value = $this->generator
                          ->setFieldValue($field, $defaultValue)
                          ->getFieldValue($field);
            
            $this->assertEquals($defaultValue, $value);
        }
        
        // Test Command
        $this->assertEquals('ls -l', $this->generator->setCommand('ls -l')->getCommand());
        
        // Test Name
        $this->assertEquals('test comment', $this->generator->setName('test comment')->getName());
        
        // Test Log File
        $this->assertEquals('/tmp/logfile', $this->generator->setLogFile('/tmp/logfile')->getLogfile());
        
        // Test Error File
        $this->assertEquals('/tmp/errorfile', $this->generator->setLogFile('/tmp/errorfile')->getLogfile());
        
        // Test Job
        $this->assertInstanceOf('Crontab\Job', $this->generator->getJob());
    }
    
}
