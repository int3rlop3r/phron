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
    
    /**
     * Search for a job from a list of tasks
     * 
     * @param int $id
     * @return Job returns a job from the list
     */
    public function find($id)
    {
        //
    }
    
    /**
     * Returns a list of tasks
     * 
     * @return Crontab
     */
    public function all()
    {
        return $this->crontab->getJobs();
    }
}