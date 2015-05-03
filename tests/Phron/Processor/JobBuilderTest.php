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
    
    public function setUp()
    {
        $this->jobBuilder = new JobBuilder;
    }
    
    public function testDefaultExpressionCount()
    {
        $fieldList = $this->jobBuilder->getFieldList();
        
        $this->assertCount(5, $fieldList);
    }

    public function testBuilder()
    {
        $fieldValue = '*';
        $fieldList  = $this->jobBuilder->getFieldList();

        foreach ($fieldList as $field => $methodName)
        {
            $setter = 'set' . $methodName;
            $getter = 'get' . $methodName;

            $setterExists = method_exists($this->jobBuilder, $setter);
            $getterExists = method_exists($this->jobBuilder, $getter);


            $this->assertTrue($setterExists);
            $this->assertTrue($getterExists);

            $value = $this->jobBuilder
                ->$setter($fieldValue)
                ->$getter();

            $this->assertEquals($value, $fieldValue);
        }

        // Test Command
        $this->assertEquals('ls -l', $this->jobBuilder->setCommand('ls -l')->getCommand());

        // Test Comments
        $this->assertEquals('test comment', $this->jobBuilder->setComments('test comment')->getComments());

        // Test Log File
        $this->assertEquals('/tmp/logfile', $this->jobBuilder->setLogFile('/tmp/logfile')->getLogfile());

        // Test Error File
        $this->assertEquals('/tmp/errorfile', $this->jobBuilder->setErrorFile('/tmp/errorfile')->getErrorFile());

        // Check if job was created as expected
        $job = $this->jobBuilder->make()->getJob();
        $this->assertInstanceOf('Crontab\Job', $job);

        // Check fields
        foreach ($fieldList as $field => $methodName)
        {
            $getter = 'get' . $methodName;
            $this->assertEquals('*', $job->$getter());
        }

        // Check other parts
        $this->assertEquals('ls -l', $job->getCommand());
        $this->assertEquals('test comment', $job->getComments());
        $this->assertEquals('/tmp/logfile', $job->getLogfile());
        $this->assertEquals('/tmp/errorfile', $job->getErrorFile());

        // Clear everything
        $this->jobBuilder->clear();
        $this->assertEquals($this->jobBuilder->getJob(), new Job);
    }

}
