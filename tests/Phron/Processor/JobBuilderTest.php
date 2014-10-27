<?php
/**
 * Description of JobBuilderTest
 *
 * @author jonathan
 */

use Phron\Processor\JobBuilder;
use Crontab\Job;

class JobBuilderTest extends PHPUnit_Framework_TestCase
{
    private $jobBuilder;
    
    private $job;
    
    public function setUp()
    {
        $this->job       = new Job;
        $this->jobBuilder = new JobBuilder($this->job);
    }
    
    public function testDefaultExpressionCount()
    {
        $fieldList = $this->jobBuilder->getFieldList();
        
        $this->assertCount(5, $fieldList);
    }
    
    public function testSettersAndGetters()
    {
        $fieldList = $this->jobBuilder->getFieldList();
        $defaultValue = '*';
        
        // Test cron expressions
        foreach ($fieldList as $field => $methodName) {
            
            // Make sure setters and getters are calling the right function (:
            $setterExists = method_exists($this->job, 'set' . $methodName);
            $getterExists = method_exists($this->job, 'get' . $methodName);
            
            $this->assertTrue($setterExists);
            $this->assertTrue($getterExists);
            
            // Test getters and setters
            $value = $this->jobBuilder
                          ->setFieldValue($field, $defaultValue)
                          ->getFieldValue($field);
            
            $this->assertEquals($defaultValue, $value);
        }
        
        // Test Command
        $this->assertEquals('ls -l', $this->jobBuilder->setCommand('ls -l')->getCommand());
        
        // Test Name
        $this->assertEquals('test comment', $this->jobBuilder->setName('test comment')->getName());
        
        // Test Log File
        $this->assertEquals('/tmp/logfile', $this->jobBuilder->setLogFile('/tmp/logfile')->getLogfile());
        
        // Test Error File
        $this->assertEquals('/tmp/errorfile', $this->jobBuilder->setLogFile('/tmp/errorfile')->getLogfile());
        
        // Test Job
        $this->assertInstanceOf('Crontab\Job', $this->jobBuilder->getJob());
    }
    
}
