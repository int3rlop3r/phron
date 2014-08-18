<?php namespace Phron\Command;

/**
 * Description of ShowCommand
 *
 * @author jonathan
 */

use Cron\FieldFactory;
use Phron\Processor\Generator;
use Phron\Processor\Entries;
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
        $limit = $this->input->getOption('limit');
        
        if (strpos($limit, '-') !== false) {
            list($start, $length) = explode('-', $limit);
            $start--; // coz people are used to 1 being the first number! :p
        } else {
            $start = 0;
            $length = intval($limit);
        }
        
        $jobs = $this->entries->get($start, $length);
        
        var_dump($jobs);
    }
}
