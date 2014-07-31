<?php namespace Phron\Processor;


/**
 * @author Jonathan Fernandes <int3rlop3r@yahoo.in>
 */

use Crontab\Crontab;
use Crontab\Job;

class Entries
{
    /**
     * @var Crontab
     */
    private $crontab;
    
    /**
     * @param Generator $generator
     * @param Crontab $crontab
     */
    public function __construct(Crontab $crontab)
    {
        $this->crontab   = $crontab;
    }
    
    /**
     * Adds a cron
     * 
     * @param Job $job
     * @return $this false on failure
     */
    public function add(Job $job)
    {
        if (is_null($job)) {
            return false;
        }
        
        $this->crontab->addJob($job)->write();
        
        return $this;
    }
}