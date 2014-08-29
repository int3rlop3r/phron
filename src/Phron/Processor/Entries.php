<?php namespace Phron\Processor;

/**
 * @author Jonathan Fernandes <int3rlop3r@yahoo.in>
 */

use Crontab\Job;
use Crontab\Crontab;
use Symfony\Component\Process\Exception\InvalidArgumentException;

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
        $this->crontab = $crontab;
    }
    
    /**
     * Adds a cron
     * 
     * @param Job $job
     * @return $this false on failure
     */
    public function add(Job $job)
    {
        if (is_null($job))
        {
            return false;
        }
        
        $this->crontab->addJob($job)->write();
        
        return $this;
    }
    
    /**
     * Fetches all the tasks
     * 
     * @return array list of tasks
     */
    public function all()
    {
        return $this->crontab->getJobs();
    }
    
    /**
     * Search for a job from a list of tasks
     * 
     * @param int $id
     * @return Job returns a job from the list
     */
    public function find($id)
    {
//        $id++;
        
        $jobs = $this->all();
        
        return isset($jobs[$id]) ? $jobs[$id]: null;
    }
    
    /**
     * Get tasks by ids
     * 
     * @param array $ids
     * @return array list of tasks
     */
    public function inIds(array $ids)
    {
        $jobs = $this->all();
        
        $result = array();
        
        foreach ($ids as $id)
        {
            $tmpJob = isset($jobs[$id]) ? $jobs[$id]: null;
            
            if (is_null($tmpJob)) { continue; }
            
            $result[] = $tmpJob;
        }
        
        return $result;
    }
    
    /**
     * Returns a list of tasks
     * 
     * @param int $start
     * @param int $length
     * @return array list of tasks
     */
    public function getByRange($start, $length = null)
    {
        $jobs = $this->all();
        
        $total = count($jobs);
        
        if ($start > $total || ($start + $length) > $total)
        {
            throw new InvalidArgumentException('"start" value cannot be greater than "length"');
        }
        
        //die("Start: $start, Length: $length");
        return array_slice($jobs, $start, $length);
    }
    
    /**
     * Update job by id
     * 
     * @param int $id
     * @param Job $job
     * @return Crontab
     */
    public function update($id, Job $job)
    {
        // do something about this
    }
    
    /**
     * Delete tasks by ids
     * 
     * @param array $ids ids of tasks to be deleted
     * @return $this
     */
    public function deleteByIds(array $ids)
    {
        foreach ($ids as $id)
        {
            $job = $this->find($id);
            var_dump($job);
//            die(PHP_EOL);
//            $this->crontab->removeJob($job);
        }
        
        return $this;
    }
    
    /**
     * Deletes all cron jobs
     * 
     * @return Crontab
     */
    public function clear()
    {
        return $this->crontab->removeAllJobs();
    }
}