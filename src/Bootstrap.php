<?php

require __DIR__ . '/../vendor/autoload.php';

// http://crontab-generator.org/

/**
 * Class needs to be reworked!
 */
use Crontab\CrontabFileHandler;
use Crontab\Job;
use Crontab\Crontab;
use Cron\CronExpression;

class Bootstrap
{

    private $cronTab;
    private $cronFileHandler;
    private $cronExpressionParser;
    private $jobs = array();

    public function __construct($cronTab = null, $cronFileHandler = null, $cronExpressionParser = null)
    {
        $this->cronTab = !is_null($cronTab) ? $cronTab : new CronTab();
        $this->cronFileHandler = !is_null($cronFileHandler) ? $cronFileHandler : new CrontabFileHandler();
        $this->cronExpressionParser = !is_null($cronExpressionParser) ? $cronExpressionParser : null;
    }

    public function addJob($time, $command)
    {
        // adds a job to the crontab file
    }

    public function addJobs(array $jobArray)
    {
        // adds a list of jobs to the crontab file
    }

    public function removeJob($id)
    {
        // remove a job using the index for the array
    }

    public function removeJobs(array $jobs)
    {
        // remove list of jobs (not always in order)
    }

    public function removeAllJobs()
    {
        // removes all jobs from the crontab
    }

    public function editJob($id, $time, $command)
    {
        // deletes the job then adds a new one
    }

    public function getJobs()
    {
        // gets a list of jobs
    }

}
