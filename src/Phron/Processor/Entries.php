<?php namespace Phron\Processor;

/**
 * @author Jonathan Fernandes <int3rlop3r@yahoo.in>
 */

use Crontab\Job;
use Crontab\Crontab;
use Crontab\CrontabFileHandler;
use Symfony\Component\Console\Output\OutputInterface;
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
        $file = realpath($file);
        
        if (!$file)
        {
            throw new \InvalidArgumentException("Could not find file: $file");
        }
        
        $this->crontabFile = $file;

        return $this;
    }

    /**
     * Gets the crontab file
     * 
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
        $file = realpath($file);
        
        if (!$file)
        {
            throw new \InvalidArgumentException("File: $file not found");
        }

        $this->crontabFileHandler->parseFromFile($this->crontab, $file);

        return $this;
    }

    /**
     * Parses the id expression string.
     * eg: 1-5 => array(1, 2, 3, 4, 5)
     *
     * @param array $ids
     * @return array
     */
    public function parseIds(array $ids)
    {
        $parsedIds = array();

        foreach ($ids as $id)
        {
            if (strpos($id, '-') !== false)
            {
                $idParts = explode('-', $id);

                if (count($idParts) != 2) { continue; }
                
                $idRange   = range(intval($idParts[0]), intval($idParts[1]));
                $parsedIds = array_merge($parsedIds, $idRange);
            }
            else
            {
                $parsedIds[] = intval($id);
            }
        }

        return array_unique($parsedIds);
    }

    /**
     * Adds a cron
     * 
     * @param Job $job
     * @return $this false on failure
     */
    public function add(Job $job)
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
        $realIndex = $id -1;
        $jobs = $this->all();
        $jobs = array_values($jobs);
        
        return isset($jobs[$realIndex]) ? $jobs[$realIndex]: null;
    }
    
    /**
     * Returns a list of tasks
     * 
     * @param int $start
     * @param int $length
     * @return array list of tasks
     */
    public function getByRange($start, $end)
    {
        $jobs  = $this->all();
        $total = count($jobs);
        
        if ($start > $total || $end > $total || $start > $end)
        {
            throw new InvalidArgumentException("Invalid 'start/end' provided.");
        }

        $start--;

        $length = $end - $start;

        return array_slice($jobs, $start, $length);
    }
    
    /**
     * Get tasks by ids
     * 
     * @param array $ids
     * @return array list of tasks
     */
    public function in(array $ids)
    {
        $result = array();
        $jobs   = $this->all();
        $keys   = array_keys($jobs);

        foreach ($ids as $id)
        {
            $hash = $keys[($id - 1)];
            $result[$hash] = $jobs[$hash];
        }
        
        return $result;
    }

    /**
     * Write filtered crons to output.
     *
     * @todo write test
     * @param string $filepath
     * @param array $ids 
     * @return bool
     */
    public function dump(array $ids = array(), OutputInterface $output)
    {
        $taskBuffer = '';

        if (empty($ids))
        {
            $jobs = $this->all();
        }
        else
        {
            $jobs = $this->in($ids);
        }

        if (empty($jobs))
        {
            return false;
        }

        foreach ($jobs as $job)
        {
            $output->writeln($job->render());
        }
    }

    /**
     * Get the hashes of jobs by the ids given.
     *
     * @todo write test
     * @param array $ids
     * @return array List of hashes
     */
    public function getJobHashes($ids, $jobs = null)
    {
        if (is_null($jobs))
        {
            $jobs = $this->in($ids);
        }

        return array_keys($jobs);
    }

    /**
     * Deletes a job by ids.
     *
     * @param array $ids
     * @return $this
     */
    public function deleteByIds($ids)
    {
        $jobs = $this->all();
        $hashes = array_keys($jobs);
        
        foreach ($ids as $id)
        {
            $id = $id - 1;
            $job = $hashes[$id];
            $this->crontab->removeJob($jobs[$job]);
        }
        
        return $this;
    }
    
    /**
     * Delete tasks by ids.
     * 
     * @param mixed $ids could either be an array of ids or a single id
     * @return $this
     */
    public function delete($ids)
    {
        if (is_array($ids))
        {
            $this->deleteByIds($ids);
        }
        else
        {
            $job = $this->find($ids);
            if ($job instanceof Job)
            {
                $this->crontab->removeJob($job);
            }
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
        $this->crontab->removeAllJobs();
        
        return $this;
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
