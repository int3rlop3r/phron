<?php

/**
 * @author Jonathan Fernandes <int3rlop3r@yahoo.in>
 */

use Crontab\Job;
use Crontab\Crontab;
use Phron\Processor\Entries;
use Phron\Processor\JobBuilder;
use Crontab\CrontabFileHandler;

class EntriesTest extends PHPUnit_Framework_TestCase
{
    private $crontabFile;

    private $crontabData;

    private $entries;

    private $crontab;

    private $crontabFileHandler;

    public function setUp()
    {
        $pathToFixture = __DIR__.'/../../fixture';

        $this->crontabFile     = $pathToFixture . '/crontabFile';
        $this->crontabDataFile = $pathToFixture . '/crontabDataFile';

        $this->resetFile();

        $this->crontabFileHandler = new CrontabFileHandler;

        $this->crontab = new Crontab;
        $this->entries = new Entries($this->crontab, $this->crontabFileHandler);
    }

    public function resetFile()
    {
        file_put_contents($this->crontabFile, '');
    }
    
    public function tearDown()
    {
        $this->resetFile();
    }

    public function testFileGetterAndSetter()
    {
        $this->assertNull($this->entries->getCrontabFile());

        $filename = $this->entries
                        ->setCrontabFile($this->crontabFile)
                        ->getCrontabFile();

        $this->assertEquals($this->crontabFile, $filename);
    }

    public function testLoadFromFile()
    {
        $this->entries->loadFromFile($this->crontabDataFile);

        $this->assertEquals(4, count($this->entries->all()));

        $this->entries->clear(); // remove all cronjobs
    }

    /**
     * @dataProvider crontabProvider
     */
    public function testAdd($crontabs)
    {
        $crontab1 = $crontabs[0];
        $crontab2 = $crontabs[1];
        $crontab3 = $crontabs[2];
        $crontab4 = $crontabs[3];
        $crontab5 = $crontabs[4];

        $job1 = new Job;

        $job1->setMonth($crontab1['minute'])
            ->setHour($crontab1['hour'])
            ->setDayOfMonth($crontab1['dayOfMonth'])
            ->setMonth($crontab1['month'])
            ->setDayOfWeek($crontab1['dayOfWeek'])
            ->setCommand($crontab1['command'])
            ->setLogFile($crontab1['logFile'])
            ->setErrorFile($crontab1['errorFile'])
            ->setComments($crontab1['comment']);

        $this->entries->add($job1);
        $this->assertEquals(1, count($this->entries->all()));

        $job2 = new Job;

        $job2->setMonth($crontab2['minute'])
            ->setHour($crontab2['hour'])
            ->setDayOfMonth($crontab2['dayOfMonth'])
            ->setMonth($crontab2['month'])
            ->setDayOfWeek($crontab2['dayOfWeek'])
            ->setCommand($crontab2['command'])
            ->setLogFile($crontab2['logFile'])
            ->setErrorFile($crontab2['errorFile'])
            ->setComments($crontab2['comment']);

        $this->entries->add($job2);
        $this->assertEquals(2, count($this->entries->all()));

        $job3 = new Job;

        $job3->setMonth($crontab3['minute'])
            ->setHour($crontab3['hour'])
            ->setDayOfMonth($crontab3['dayOfMonth'])
            ->setMonth($crontab3['month'])
            ->setDayOfWeek($crontab3['dayOfWeek'])
            ->setCommand($crontab3['command'])
            ->setLogFile($crontab3['logFile'])
            ->setErrorFile($crontab3['errorFile'])
            ->setComments($crontab3['comment']);

        $this->entries->add($job3);
        $this->assertEquals(3, count($this->entries->all()));

        $job4 = new Job;

        $job4->setMonth($crontab4['minute'])
            ->setHour($crontab4['hour'])
            ->setDayOfMonth($crontab4['dayOfMonth'])
            ->setMonth($crontab4['month'])
            ->setDayOfWeek($crontab4['dayOfWeek'])
            ->setCommand($crontab4['command'])
            ->setLogFile($crontab4['logFile'])
            ->setErrorFile($crontab4['errorFile'])
            ->setComments($crontab4['comment']);

        $this->entries->add($job4);
        $this->assertEquals(4, count($this->entries->all()));

        $job5 = new Job;

        $job5->setMonth($crontab5['minute'])
            ->setHour($crontab5['hour'])
            ->setDayOfMonth($crontab5['dayOfMonth'])
            ->setMonth($crontab5['month'])
            ->setDayOfWeek($crontab5['dayOfWeek'])
            ->setCommand($crontab5['command'])
            ->setLogFile($crontab5['logFile'])
            ->setErrorFile($crontab5['errorFile'])
            ->setComments($crontab5['comment']);

        $this->entries->add($job5);
        $this->assertEquals(5, count($this->entries->all()));
    }

    public function crontabProvider()
    {
        return array(
            array(
                array(
                    array(
                        'minute' => '*', 
                        'hour' => '*', 
                        'dayOfMonth' => '*', 
                        'month' => '*', 
                        'dayOfWeek' => '*', 
                        'command' => 'cmd1', 
                        'logFile' => '/tmp/file1.log', 
                        'errorFile' => '/tmp/file1.err.log', 
                        'comment' => 'test1',
                    ),
                    array(
                        'minute' => '*', 
                        'hour' => '*', 
                        'dayOfMonth' => '*', 
                        'month' => '*', 
                        'dayOfWeek' => '*', 
                        'command' => 'cmd2', 
                        'logFile' => '/tmp/file2.log', 
                        'errorFile' => '/tmp/file2.err.log', 
                        'comment' => 'test2',
                    ),
                    array(
                        'minute' => '*', 
                        'hour' => '*', 
                        'dayOfMonth' => '*', 
                        'month' => '*', 
                        'dayOfWeek' => '*', 
                        'command' => 'cmd3', 
                        'logFile' => '/tmp/file3.log', 
                        'errorFile' => '/tmp/file3.err.log', 
                        'comment' => 'test3',
                    ),
                    array(
                        'minute' => '*', 
                        'hour' => '*', 
                        'dayOfMonth' => '*', 
                        'month' => '*', 
                        'dayOfWeek' => '*', 
                        'command' => 'cmd4', 
                        'logFile' => '/tmp/file4.log', 
                        'errorFile' => '/tmp/file4.err.log', 
                        'comment' => 'test4',
                    ),
                    array(
                        'minute' => '*', 
                        'hour' => '*', 
                        'dayOfMonth' => '*', 
                        'month' => '*', 
                        'dayOfWeek' => '*', 
                        'command' => 'cmd5', 
                        'logFile' => '/tmp/file5.log', 
                        'errorFile' => '/tmp/file5.err.log', 
                        'comment' => 'test5',
                    ),
                )
            )
        );
    }
}
