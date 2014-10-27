<?php namespace Phron\Command;

/**
 * Description of AbstractCommand
 *
 * @author jonathan
 */

use Cron\FieldFactory;
use Phron\Processor\JobBuilder;
use Phron\Processor\Entries;
use Symfony\Component\Console\Command\Command;

abstract class AbstractCommand extends Command
{
    use \Phron\Command\Command;
    
    /**
     * @var Entries
     */
    protected $entries;
    
    /**
     * @var FieldFactory
     */
    protected $fieldFactory;
    
    /**
     * @var JobBuilder
     */
    protected $jobBuilder;
    
    /**
     * @param Entries $entries
     * @param JobBuilder $jobBuilder
     * @param FieldFactory $fieldFactory
     */
    public function __construct(Entries $entries, JobBuilder $jobBuilder, FieldFactory $fieldFactory)
    {
        parent::__construct();
        
        $this->entries      = $entries;
        $this->jobBuilder   = $jobBuilder;
        $this->fieldFactory = $fieldFactory;
    }
    
    abstract public function fire();
}
