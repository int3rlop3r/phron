<?php namespace Phron\Command;

/**
 * Description of AbstractCommand
 *
 * @author jonathan
 */

use Cron\FieldFactory;
use Phron\Processor\Generator;
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
     * @var Generator
     */
    protected $generator;
    
    /**
     * @param Entries $entries
     * @param Generator $generator
     * @param FieldFactory $fieldFactory
     */
    public function __construct(Entries $entries, Generator $generator, FieldFactory $fieldFactory)
    {
        parent::__construct();
        
        $this->entries      = $entries;
        $this->generator    = $generator;
        $this->fieldFactory = $fieldFactory;
    }
    
    abstract public function fire();
}
