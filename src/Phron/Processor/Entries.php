<?php namespace Phron\Processor;

/**
 * @author Jonathan Fernandes <int3rlop3r@yahoo.in>
 */

use Crontab\Job;
use Crontab\Crontab;
use Crontab\CrontabFileHandler;
use Symfony\Component\Process\Exception\InvalidArgumentException;

class Entries
{
    /**
     * @var Crontab
     */
    private $crontab;
    
    /**
     * @var CrontabFileHandler
     */
    private $crontabFileHandler;

    /**
     * @var crontab file
     */
    private $crontabFile;
    
    /**
     * @param Crontab $crontab
     * @param CrontabFileHandler $crontabFileHandler
     */
    public function __construct(
        Crontab $crontab, 
        CrontabFileHandler $crontabFileHandler,
        $crontabFile = null)
    {
        $this->crontab            = $crontab; 
        $this->crontabFileHandler = $crontabFileHandler;

        if (!is_null($crontabFile))
        {
            $this->setCrontabFile($crontabFile);
        }
    }

    /**
     * Sets the crontab file
     *
     * @param string path to file
     * @return $this
     */
    public function setCrontabFile($file)
    {
        $this->crontabFile = $file;

        return $this;
    }

    /**
     * Gets the crontab file
     * @return $this
     */
    public function getCrontabFile()
    {
        return $this->crontabFile;
    }

    /**
     * Loads cronjobs form file
     *
     * @param string path to file
     * @return $this
     */
    public function loadFromFile($file)
    {
        if (!file_exists($file))
        {
            throw new \InvalidArgumentException("File: $file not found");
        }

        $this->crontabFileHandler->parseFromFile($this->crontab, $file);

        return $this;
    }

    /**
     * Adds a cron
     * 
     * @param Job $job
     * @return $this false on failure
     */
    public function add(Job $job, $file = null)
    {
        $this->crontab->addJob($job);
        
        return $this;
    }
    
    /**
     * Save crons to file
     * 
     * @param string $file /path/to/file/
     */
    public function save()
    {
        $crontabFile = $this->getCrontabFile();

        if (!is_null($crontabFile))
        {
            $this->crontabFileHandler->writeToFile($this->crontab, $crontabFile);
        }
        else
        {
            $this->crontabFileHandler->write($this->crontab);
        }

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
        $jobs = $this->all();
        $jobs = array_values($jobs);
        
        return isset($jobs[$id]) ? $jobs[$id]: null;
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
     * Delete tasks by ids
     * 
     * @param array $ids ids of tasks to be deleted
     * @return $this
     */
    public function deleteByIds(array $ids)
    {
        foreach ($ids as $id)
        {
            $aJob = $this->find($id -1);
            
            if ($aJob instanceof Job) {
                $this->crontab->removeJob($aJob);
            }
        }
        
        $this->save();
        
        return $this;
    }
    
    /**
     * Deletes all cron jobs
     * 
     * @return Crontab
     */
    public function clear()
    {
        $this->crontab->removeAllJobs();
        
        $this->crontab->write();
        
        return $this;
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
}
