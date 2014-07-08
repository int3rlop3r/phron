<?php
/**
 * Description of GeneratorTest
 *
 * @author jonathan
 */

use Phron\Processor\Generator;

class GeneratorTest extends PHPUnit_Framework_TestCase
{
    private $generator;
    
    public function setUp()
    {
        $this->generator = new Generator;
    }
    
    public function testDefaultExpressionCount()
    {
        $fieldList = $this->generator->getFieldList();
        
        $this->assertCount(5, $fieldList);
    }
    
    public function testCronFields()
    {
        $fieldList = $this->generator->getFieldList();
        
        $value = 1;
        
        foreach ($fieldList as $field => $defaultValue) {
            
            // default value should be '*'
            $this->assertEquals('*', $defaultValue);
            
            // change the value
            $this->generator->setFieldValue($field, $value);
            
            // check if value was changed
            $newValue = $this->generator->getFieldValue($field);
            $this->assertEquals($value, $newValue);
            
        }
    }
    
    public function testOtherParts()
    {
        $cronCommand      = 'cron_command';
        $cronComment      = 'Test comment';
        $cronLogFile      = '/tmp/cronlogfile';
        $cronErrorLogFile = '/tmp/cronerrorlogfile';
        
        // test command
        $this->generator->setCommand($cronCommand);
        $command = $this->generator->getCommand();
        $this->assertEquals($cronCommand, $command);
        
        // test log file
        $this->generator->setLogFile($cronLogFile);
        $logfile = $this->generator->getLogfile();
        $this->assertEquals($cronLogFile, $logfile);
        
        // test error log file
        $this->generator->setErrorFile($cronErrorLogFile);
        $errorlog = $this->generator->getErrorFile();
        $this->assertEquals($cronErrorLogFile, $errorlog);
        
        // test comment
        $this->generator->setComment($cronComment);
        $comment = $this->generator->getComment();
        $this->assertEquals($cronComment, $comment);
        
    }
}
