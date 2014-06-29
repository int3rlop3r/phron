<?php namespace Phron\Processor;

/**
 * Description of Scheduler
 *
 * @author jonathan
 */
class Scheduler
{
    private $expression;
    
    public function __construct()
    {
        $this->expression = '* * * * *';
    }
    
    public function get()
    {
        return $this->expression;
    }
    
    
}
