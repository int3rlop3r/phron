<?php namespace Phron\Processor;


/**
 * @author Jonathan Fernandes <int3rlop3r@yahoo.in>
 */

use Crontab\Job;

class Entries
{
    private $job;

    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    public function add()
    {
        //
    }
    
}