<?php namespace Phron\Command;

/**
 * Description of ShowCommand
 *
 * @author jonathan
 */

use Cron\FieldFactory;
use Phron\Processor\Generator;
use Phron\Processor\Entries;
use Phron\Processor\Questions\QuestionFactory;
use Phron\Processor\Questions\Questionable;
use Symfony\Component\Console\Input\InputOption;

class ShowCommand extends AbstractCommand
{
    public function __construct(Entries $entries, Generator $generator, FieldFactory $fieldFactory)
    {
        parent::__construct($entries, $generator, $fieldFactory);
    }
    
    public function configure()
    {
        $this->setName('show')
             ->setDescription('Display tasks')
             ->setHelp('Display tasks')
             ->addOption(
                'limit', 
                '-l', 
                InputOption::VALUE_REQUIRED, 
                'Set limit of tasks to display', 
                0
            );
    }
    
    public function fire()
    {
        $jobs = $this->entries->all();
        
        var_dump($jobs);
    }
}
