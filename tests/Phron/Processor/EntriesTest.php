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
    }
}
