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
use Symfony\Component\Process\Exception\InvalidArgumentException;

class ShowCommand extends AbstractCommand
{
    /**
     * @param Entries $entries
     * @param Generator $generator
     * @param FieldFactory $fieldFactory
     */
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
                InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 
                'Set limit of tasks to display', 
                null
            );
    }
    
    public function fire()
    {
        $limit = $this->input->getOption('limit');
        
        if (count($limit) > 2) {
            throw new InvalidArgumentException("Limit accepts 2 arguments");
        }
        
        if (!empty($limit)) {
            $start  = isset($limit[0]) ? intval($limit[0]) : 0; # code smell
            $length = isset($limit[1]) ? intval($limit[1]) : null;
            
            $start--; // coz people being with 1  as the first number! :p
            
            $jobs = $this->entries->getByRange($start, $length);
        } else {
            // get all
            $jobs = $this->entries->all();
        }
        
        var_dump($jobs);
    }
}
