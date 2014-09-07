<?php

/**
 * @author Jonathan Fernandes <int3rlop3r@yahoo.in>
 */

use Crontab\Job;
use Crontab\Crontab;
use Phron\Processor\Entries;
use Phron\Processor\Generator;
use Crontab\CrontabFileHandler;

class EntriesTest extends PHPUnit_Framework_TestCase
{
    private $job;
    
    private $crontab;
    
    private $cronFileHandler;
    
    private $entries;
    
    private $generator;
    
    private $tmpFile = '/tmp/cron_file';
    
    private $logFile = '/tmp/cron__log_file';
    
    private $errorLogFile = '/tmp/cron_error_log_file';
    
    public function setUp()
    {
        touch($this->tmpFile);
        
        $this->job             = new Job;
        $this->crontab         = new Crontab;
        $this->cronFileHandler = new CrontabFileHandler;
        $this->generator       = new Generator($job);
        $this->entries         = new Entries($crontab, $cronFileHandler);
    }
    
    public function tearDown()
    {
//        unlink($this->tmpFile);
    }
    
    public function createJob($count)
    {
        $fields = $this->generator->getFieldList();
        
        // set values for fields
        foreach ($fields as $field)
        {
            $this->generator->setFieldValue($field, $count);
        }
        
        $this->generator
            ->setName('Test Task')
            ->setLogFile($this->logFile)
            ->setErrorFile($this->errorLogFile);
        
        $this->entries->add($this->generator->getJob(), $this->tmpFile);
    }
    
    public function testAddCronJob()
    {
        // create job 1
        $this->createJob(1);
        
        // create job 2
        $this->createJob(2);
        
        // create job 3
        $this->createJob(3);
        
        // create job 4
        $this->createJob(4);
        
        // create job 5
        $this->createJob(5);
    }
}